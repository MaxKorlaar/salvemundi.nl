<?php

    namespace App\Http\Controllers;

    use App\Helpers\PaymentHelper;
    use App\Http\Requests\IntroSignup;
    use App\Http\Requests\IntroSupervisorSignup;
    use App\IntroApplication;
    use App\Introduction;
    use App\IntroSupervisorApplication;
    use App\Mail\ConfirmIntroApplication;
    use App\Mail\ConfirmIntroSupervisorApplication;
    use App\Mail\IntroApplicationPaymentConfirmation;
    use App\Mail\IntroApplicationPaymentRequest;
    use App\Mail\NewIntroApplication;
    use App\Mail\NewIntroSupervisorApplication;
    use App\Transaction;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Mail;
    use Mollie\Api\Exceptions\ApiException;
    use Mollie\Api\Resources\Payment;

    /**
     * Class IntroController
     *
     * @package App\Http\Controllers
     */
    class IntroController extends Controller {

        public function __construct() {
            $this->middleware('auth')->only(['getSupervisorSignupFormByYearAndId', 'supervisorSignupByYearAndId']);
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * @throws \Throwable
         */
        public function getSignupForm() {
            $currentIntro = Introduction::getIntroductionForCurrentYear();
            if ($currentIntro === null) abort(404);
            return redirect()->route('intro.by_id.signup', ['year' => $currentIntro->year->year, 'id' => $currentIntro->id]);
        }

        /**
         * @param Introduction $introduction
         * @param IntroSignup  $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
         * @throws ApiException
         * @throws \Mollie\Api\Exceptions\IncompatiblePlatform
         * @throws \Throwable
         */
        public function signup(Introduction $introduction, IntroSignup $request) {
            $application                 = new IntroApplication($request->all());
            $application->same_sex_rooms = $request->has('same_sex_rooms');
            $application->alcohol        = $request->has('alcohol');
            $application->extra_shirt    = $request->has('extra_shirt');
            $application->ip_address     = $request->ip();
            $application->status         = IntroApplication::STATUS_SEE_TRANSACTION;
            $application->type           = IntroApplication::TYPE_SIGNUP;
            $application->saveOrFail();
            $introduction->applications()->save($application);

            if (app()->environment() !== 'production') $request->flash();
            $request->session()->put('intro.application', $application);
            $request->session()->save();

            $mollie      = new PaymentHelper();
            $transaction = new Transaction();
            $transaction->save();

            $payment = $mollie->payments->create([
                "amount"      => [
                    'currency' => 'EUR',
                    'value'    => (string)number_format($application->calculateIntroCosts(), 2)
                ],
                "description" => trans($application->extra_shirt ? 'intro.signup.payment.description_extra_shirt' : 'intro.signup.payment.description',
                    ['first_name' => $application->first_name, 'last_name' => $application->last_name, 'year' => $introduction->year->year]),
                "redirectUrl" => route('intro.signup.confirm_payment'),
                "webhookUrl"  => route('webhook.payment.intro', ['application' => $application]),
                'metadata'    => [
                    'id'             => $application->id,
                    'transaction_id' => $transaction->id
                ]
            ]);
            $transaction->update([
                'transaction_id'     => $payment->id,
                'transaction_status' => $payment->status,
                'transaction_amount' => $payment->amount->value
            ]);
            $application->transaction()->associate($transaction);
            $application->saveOrFail();
            if (app()->environment() !== 'production') $request->flash();

            $request->session()->put('intro.application', $application);
            $request->session()->save();
            return view('intro.payment_redirect', [
                'links'        => $payment->_links,
                'introduction' => $introduction
            ]);
        }

        /**
         * @param Request $request
         *
         * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * @throws \Mollie\Api\Exceptions\ApiException
         * @throws \Mollie\Api\Exceptions\IncompatiblePlatform
         */
        public function confirmPayment(Request $request) {
            if (!$request->session()->has('intro.application')) abort(404);
            /** @var IntroApplication $application */
            $application = $request->session()->get('intro.application');

            $payment = $application->transaction->getMollieTransaction();

            if (!$payment->isOpen() && !$payment->isPaid()) {
                if ($application->type === IntroApplication::TYPE_SIGNUP) { // TODO Foutmeldingen worden niet getoond
                    return redirect()->route('intro.by_id.signup', [$application->introduction, $application->introduction->year->year])
                        ->withErrors(['signup' => trans('intro.signup.payment.failed')]);
                } else {
                    return redirect()->route('intro.by_id.signup', [$application->introduction, $application->introduction->year->year])
                        ->withErrors(['signup' => trans('intro.signup.payment.failed_from_mail')]);
                }
            }
            return view('intro.signup_confirmation', [
                'application'  => $application,
                'introduction' => $application->introduction,
                'type'         => 'signup'
            ]);
        }

        /**
         * @param IntroApplication $application
         * @param Request          $request
         *
         * @return string
         * @throws \Exception
         * @throws \Throwable
         */
        public function confirmPaymentWebhook(IntroApplication $application, Request $request) {

            if (!$request->has('id')) abort(400);

            $mollie = new PaymentHelper();
            try {
                $payment = $mollie->payments->get($request->get('id'));
                if ($payment->metadata->id != $application->id) {
                    abort(400);
                }
                /** @var Transaction $transaction */
                $transaction = Transaction::findOrFail($payment->metadata->transaction_id);
                $transaction->update([
                    'transaction_id'     => $payment->id,
                    'transaction_status' => $payment->hasRefunds() ? 'refunded' : $payment->status,
                    'transaction_amount' => $payment->amount->value
                ]);

                if ($payment->isPaid() && !$payment->hasRefunds()) {
                    if ($application->status != IntroApplication::STATUS_PAID) {
                        // De status is pas net bijgewerkt naar betaald.
                        $application->status = IntroApplication::STATUS_PAID;

                        // Stuur een bevestiging naar de introcommissie
                        $mail = new NewIntroApplication($application);
                        $mail->to(config('mail.intro_to.address'), config('mail.intro_to.name'));

                        Mail::queue($mail);

                        //Stuur een bevestiging naar de gebruiker zelf

                        $mail = new IntroApplicationPaymentConfirmation($application);
                        $mail->to($application->email, $application->first_name . ' ' . $application->last_name);
                        Mail::queue($mail);

                    }
                }
                if ($payment->hasRefunds()) {
                    $application->status = IntroApplication::STATUS_REFUNDED;
                }

                $application->saveOrFail();

                if (!$payment->hasRefunds() &&
                    ($payment->isCanceled() || $payment->isExpired() || $payment->isFailed() ||
                        (!$payment->isPaid() && !$payment->isOpen()))) {
                    // Verwijder geannuleerde en verlopen inschrijvingen uit de database.
                    Log::debug('Er gaat iets niet goed met een betaling', [$payment->id, $payment->status, $application->status]);
                    // Verwijder alleen als de betaling _niet_ is gestart vanuit de email
                    if ($application->type === IntroApplication::TYPE_SIGNUP) {
                        $application->delete();
                    } else {
                        $application->status = IntroApplication::STATUS_RESERVED;
                        $application->saveOrFail();
                    }
                }

            } catch (ApiException $exception) {
                Log::error($exception);
                abort(400);
            }
            return 'OK';
        }

        /**
         *
         * @param IntroApplication   $application
         * @param                    $token
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * @throws \Throwable
         */
        public function confirmEmail(IntroApplication $application, $token) {
            if ($application->email_confirmation_token !== $token) {
                return view('signup.email_token_invalid');
            }

            $application->status                   = IntroApplication::STATUS_RESERVED;
            $application->email_confirmation_token = null;
            $introduction                          = $application->introduction;

            // Controleer of het inmiddels al mogelijk is om te betalen & of er nog plek is voor betaalde inschrijvingen
            if ($introduction->signupsAreOpen() && $introduction->allowSignups()) {
                $application->email_confirmation_token = str_random(64);
                $mail                                  = new IntroApplicationPaymentRequest($application);
                $mail->to($application->email, $application->first_name . ' ' . $application->last_name);
                Mail::send($mail);
                $applicationKey = 'admin.intro.throttle.payment_reminder:' . $application->id;
                Cache::set($applicationKey, time(), 10080); // Zorg ervoor dat de gebruiker niet nog een herinnering kan ontvangen binnen 7 dagen
            }
            $application->saveOrFail();

            return view('intro.email_confirmation', [
                'application' => $application
            ]);

        }

        /**
         * Krijg de Mollie-betaalpagina wanneer de link in de e-mail wordt aangevraagd
         *
         * @param IntroApplication $application
         * @param                  $token
         *
         * @param Request          $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * @throws \Throwable
         */
        public function getPaymentPage(IntroApplication $application, $token, Request $request) {
            if ($application->email_confirmation_token !== $token ||
                ($application->status !== IntroApplication::STATUS_RESERVED && $application->status !== IntroApplication::STATUS_SEE_TRANSACTION) ||
                !$application->introduction->signupsAreOpen()) {
                abort(404);
            }
            /** @var Transaction $transaction */
            /** @var Payment $payment */
            $mollie = new PaymentHelper();
            $new    = false;
            if ($application->transaction_id === null) {
                $new = true;
            } else {
                $transaction = $application->transaction;
                $payment     = $transaction->getMollieTransaction();
                if (!$payment->isOpen()) $new = true;
            }
            $introduction = $application->introduction;
            if ($new) {

                // Check of het nog wel mogelijk is om in te schrijven
                if (!$introduction->allowSignups()) {
                    return view('intro.email_signups_not_allowed');
                }

                $transaction = new Transaction();
                $transaction->save();
                $payment = $mollie->payments->create([
                    "amount"      => [
                        'currency' => 'EUR',
                        'value'    => (string)number_format($application->calculateIntroCosts(), 2)
                    ],
                    "description" => trans($application->extra_shirt ? 'intro.signup.payment.description_extra_shirt' : 'intro.signup.payment.description',
                        ['first_name' => $application->first_name, 'last_name' => $application->last_name, 'year' => $introduction->year->year]),
                    "redirectUrl" => route('intro.signup.confirm_payment'),
                    "webhookUrl"  => route('webhook.payment.intro', ['application' => $application]),
                    'metadata'    => [
                        'id'             => $application->id,
                        'transaction_id' => $transaction->id
                    ]
                ]);
            }
            $transaction->update([
                'transaction_id'     => $payment->id,
                'transaction_status' => $payment->status,
                'transaction_amount' => $payment->amount->value
            ]);
            $application->status = IntroApplication::STATUS_SEE_TRANSACTION;
            $application->transaction()->associate($transaction);
            $application->saveOrFail();
            if (app()->environment() !== 'production') $request->flash();

            $request->session()->put('intro.application', $application);
            //Log::info('Sessie opgeslagen', [$request->session()->isStarted(), $request->session()->getId()]);
            $request->session()->save();
            return view('intro.payment_redirect', [
                'links'        => $payment->_links,
                'introduction' => $introduction
            ]);
        }


        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * @throws \Throwable
         */
        public function getInfo() {
            $currentIntro = Introduction::getIntroductionForCurrentYear();
            if ($currentIntro === null) abort(404);
            return redirect()->route('intro.by_id.info', ['year' => $currentIntro->year->year, 'id' => $currentIntro->id]);
        }

        /**
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Throwable
         */
        public function getSchedule() {
            $currentIntro = Introduction::getIntroductionForCurrentYear();
            if ($currentIntro === null) abort(404);
            return redirect()->route('intro.by_id.schedule', ['year' => $currentIntro->year->year, 'id' => $currentIntro->id]);
        }

        /**
         * @param              $year
         * @param Introduction $introduction
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getIntroByYearAndId(Introduction $introduction, $year) {
            return view('intro.2019.info', [
                'introduction' => $introduction,
                'year'         => $year
            ]);
        }

        /**
         * @param Introduction $introduction
         * @param              $year
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getScheduleByYearAndId(Introduction $introduction, $year) {
            return view('intro.2019.schedule', [
                'introduction' => $introduction,
                'year'         => $year
            ]);
        }

        /**
         * @param Introduction $introduction
         * @param              $year
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getSignupFormByYearAndId(Introduction $introduction, $year) {
            return view('intro.signup', [
                'introduction' => $introduction,
                'year'         => $year
            ]);
        }

        /**
         * @param Introduction $introduction
         * @param              $year
         * @param IntroSignup  $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * @throws ApiException
         * @throws \Mollie\Api\Exceptions\IncompatiblePlatform
         * @throws \Throwable
         */
        public function signupByYearAndId(Introduction $introduction, $year, IntroSignup $request) {

            if (!$introduction->reservationsAreOpen() && !$introduction->signupsAreOpen()) abort(403);
            if ($introduction->signupsAreOpen() && $introduction->allowSignups()) {
                // Maak een aanmelding aan
                return $this->signup($introduction, $request);
            } elseif ($introduction->allowReservations()) {
                // Maak een reservering aan
                return $this->makeReservation($introduction, $request);
            }
            return back()->withErrors(['signup' => trans('intro.signup.errors.all_spots_taken_no_reservations')]);

        }

        /**
         * @param Introduction $introduction
         * @param IntroSignup  $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * @throws \Throwable
         */
        public function makeReservation(Introduction $introduction, IntroSignup $request) {
            $application                           = new IntroApplication($request->all());
            $application->same_sex_rooms           = $request->has('same_sex_rooms');
            $application->alcohol                  = $request->has('alcohol');
            $application->extra_shirt              = $request->has('extra_shirt');
            $application->ip_address               = $request->ip();
            $application->email_confirmation_token = str_random(200);
            $application->status                   = IntroApplication::STATUS_EMAIL_UNCONFIRMED;
            $application->saveOrFail();
            $introduction->applications()->save($application);

            if (app()->environment() !== 'production') $request->flash();
            $request->session()->put('intro.application', $application);
            $request->session()->save();

            $mail = new ConfirmIntroApplication($application);
            $mail->to($application->email, $application->first_name . ' ' . $application->last_name);
            Mail::queue($mail);

            return view('intro.signup_confirmation', [
                'introduction' => $introduction,
                'type'         => 'reservation'
            ]);
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function get2019Schedule() {
            return view('intro.2019.schedule');
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * @throws \Throwable
         */
        public function getSupervisorInfo() {
            $currentIntro = Introduction::getIntroductionForCurrentYear();
            if ($currentIntro === null) abort(404);
            return redirect()->route('intro.by_id.supervisor.info', ['year' => $currentIntro->year->year, 'id' => $currentIntro->id]);
        }

        /**
         * @return string
         * @throws \Throwable
         */
        public function getSupervisorSignupForm() {
            $currentIntro = Introduction::getIntroductionForCurrentYear();
            if ($currentIntro === null) abort(404);
            return redirect()->route('intro.by_id.supervisor.signup', ['year' => $currentIntro->year->year, 'id' => $currentIntro->id]);
        }

        /**
         * @param Introduction $introduction
         * @param              $year
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getSupervisorInfoByYearAndId(Introduction $introduction, $year) {
            return view('intro.supervisor.info', [
                'introduction' => $introduction,
                'year'         => $year
            ]);
        }

        /**
         * @param Introduction $introduction
         * @param              $year
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getSupervisorSignupFormByYearAndId(Introduction $introduction, $year) {
            return view('intro.supervisor.signup', [
                'introduction' => $introduction,
                'year'         => $year,
                'member'       => Auth::user()->member
            ]);
        }

        /**
         * @param Introduction          $introduction
         * @param                       $year
         * @param IntroSupervisorSignup $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * @throws \Throwable
         */
        public function supervisorSignupByYearAndId(Introduction $introduction, $year, IntroSupervisorSignup $request) {
            if (!$introduction->reservationsAreOpen() && !$introduction->signupsAreOpen()) abort(403);
            $member = Auth::user()->member;
            if (!$member->isCurrentlyMember()) abort(403);
            $application                                 = new IntroSupervisorApplication($request->all());
            $application->ip_address                     = $request->ip();
            $application->email_confirmation_token       = str_random(200);
            $application->remain_sober                   = $request->has('remain_sober');
            $application->drivers_license                = $request->has('drivers_license');
            $application->first_aid_license              = $request->has('first_aid_license');

            if($request->get('active_in_association') === array_last(trans('intro.supervisor.signup.active_as'))) {
                $application->active_in_association = $request->get('active_as_other');
            }

            $application->member()->associate($member);
            $application->introduction()->associate($introduction);
            if (app()->environment() !== 'production') $request->flash();

            $application->saveOrFail();

            $mail = new ConfirmIntroSupervisorApplication($application);
            $mail->to($application->member->email, $application->member->first_name . ' ' . $application->member->last_name);
            Mail::queue($mail);

            return view('intro.supervisor.signup_confirmation');
        }

        /**
         * @param IntroSupervisorApplication $application
         * @param                            $token
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * @throws \Throwable
         */
        public function confirmSupervisorEmail(IntroSupervisorApplication $application, $token) {
            if ($application->email_confirmation_token !== $token) {
                return view('signup.email_token_invalid');
            }

            $application->status                   = IntroSupervisorApplication::STATUS_SIGNED_UP;
            $application->email_confirmation_token = null;
            $application->saveOrFail();

            $mail = new NewIntroSupervisorApplication($application);
            $mail->to(config('mail.intro_to.address'), config('mail.intro_to.name'));
            Mail::queue($mail);

            return view('intro.supervisor.email_confirmation', [
                'application' => $application
            ]);

        }
    }
