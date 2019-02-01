<?php

    namespace App\Http\Controllers;

    use App\Helpers\PaymentHelper;
    use App\Http\Requests\ConfirmSignup;
    use App\Http\Requests\Signup;
    use App\Mail\MemberApplicationPaymentConfirmation;
    use App\Mail\NewMemberApplication;
    use App\Member;
    use App\MemberApplication;
    use App\Membership;
    use App\Transaction;
    use App\Year;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Mail;
    use Mollie\Api\Exceptions\ApiException;

    /**
     * Class SignupController
     *
     * @package App\Http\Controllers
     */
    class SignupController extends Controller {

        /**
         * @param Request $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function index(Request $request) {
            return view('signup');
        }

        /**
         * @param Signup $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
         */
        public function getConfirmationPage(Signup $request) {
            $request->session()->put('signup_data', $request->all());
            return view('confirm_signup');
        }

        /**
         * @param Request $request
         *
         * @return \Illuminate\Http\RedirectResponse
         */
        public function getConfirmationPageWithoutSignup(Request $request) {
            if ($request->session()->get('signup_data') === null) {
                return $this->redirectToIndex();
            }
            return view('confirm_signup');
        }

        /**
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
         */
        public function redirectToIndex() {
            return redirect(route('signup.signup'));
        }

        /**
         * @param ConfirmSignup $request
         *
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Throwable
         */
        public function signup(ConfirmSignup $request) {
            if ($request->session()->get('signup_data') === null) return back(); // Stuur de gebruiker weg als er geen inschrijfgegevens in de sessie zitten

            $application = new MemberApplication($request->session()->get('signup_data'));

            $picture  = $request->file('picture');
            $filename = $request->session()->get('signup_data')['pcn'] . '-' . time() . '.' . $picture->extension();
            $picture->storeAs('member_photos', $filename);
            // todo Intervention gebruiken om afbeeldingen tot maximaal 4k bij 4k te verkleinen en verificatie

            $application->ip_address               = $request->ip();
            $application->email_confirmation_token = str_random(200);
            $application->picture_name             = $filename;
            $application->transaction_id           = '';
            $application->transaction_status       = '';
            $application->transaction_amount       = 0;

            $application->saveOrFail();

            $transaction = new Transaction();
            $transaction->save();

            $mollie  = new PaymentHelper();
            $payment = $mollie->payments->create([
                "amount" => [
                    'currency' => 'EUR',
                    'value'    => config('mollie.signup_costs')
                ],
                "description" => trans('signup.payment.description', ['first_name' => $application->first_name, 'last_name' => $application->last_name]),
                "redirectUrl" => route('signup.confirm_payment'),
                "webhookUrl"  => route('webhook.payment.signup', ['application' => $application]),
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

            if (app()->environment() !== 'production') $request->flash();

            $application->transaction_id     = $payment->id;
            $application->transaction_status = $payment->status;
            $application->transaction_amount = $payment->amount->value;
            $application->saveOrFail();
            $request->session()->put('signup.application', $application);
            if (app()->environment() === 'production') $request->session()->pull('signup_data');
            $request->session()->save();

            return view('signup.payment_redirect', [
                'links' => $payment->_links
            ]);
        }


        /**
         * @param Request $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * @throws \Mollie\Api\Exceptions\ApiException
         * @throws \Mollie\Api\Exceptions\IncompatiblePlatform
         */
        public function confirmPayment(Request $request) {
            if (!$request->session()->has('signup.application')) abort(404);
            /** @var MemberApplication $application */
            $application = $request->session()->get('signup.application');

            $mollie  = new PaymentHelper();
            $payment = $mollie->payments->get($application->transaction_id);
            \Log::debug('Teruggestuurd van de betaling', ['payment' => $payment]);
            if (!$payment->isOpen() && !$payment->isPaid()) {
                return redirect()->route('signup.signup')->withErrors(['signup' => trans('signup.payment.failed')]);
            }
            return view('signup.signup_confirmation', [
                'application' => $application
            ]);
        }

        /**
         * @param MemberApplication $application
         * @param Request           $request
         *
         * @return string
         * @throws \Mollie\Api\Exceptions\ApiException
         * @throws \Mollie\Api\Exceptions\IncompatiblePlatform
         * @throws \Throwable
         */
        public function confirmPaymentWebhook(MemberApplication $application, Request $request) {

            if (!$request->has('id')) abort(400);

            $mollie = new PaymentHelper();
            try {
                $payment = $mollie->payments->get($request->get('id'));
                if ($payment->metadata->id != $application->id) {
                    abort(400);
                }
                \Log::debug('Webhook aangeroepen', ['payment' => $payment]);

                /** @var Transaction $transaction */
                $transaction = Transaction::findOrFail($payment->metadata->transaction_id);
                $transaction->update([
                    'transaction_id'     => $payment->id,
                    'transaction_status' => $payment->hasRefunds() ? 'refunded' : $payment->status,
                    'transaction_amount' => $payment->amount->value
                ]);

                if ($payment->isPaid() && !$payment->hasRefunds()) {
                    if ($application->transaction_status != $payment->status) {
                        // De status is pas net bijgewerkt naar betaald.
                        $application->status = MemberApplication::STATUS_NEW;

                        // Stuur een bevestiging naar de administratie

                        $mail = new NewMemberApplication($application);
                        $mail->to(config('mail.application_to.address'), config('mail.application_to.name'));

                        Mail::queue($mail);

                        // Stuur een bevestiging naar de gebruiker zelf

                        $mail = new MemberApplicationPaymentConfirmation($application);
                        $mail->to($application->email, $application->first_name . ' ' . $application->last_name);
                        Mail::queue($mail);

                        // Verander de aanmelding naar een werkelijk lid van de vereniging
                        $member      = Member::createFromApplication($application);
                        $transaction = $member->transactions()->save($transaction);

                        $membership                 = Membership::createNewMembership();
                        $membership->year_id        = Year::getCurrentYear()->id;
                        $membership->transaction_id = $transaction->id;
                        $member->memberships()->save($membership);

                        Log::debug("Member aangemaakt", [$member]);
                        $application->delete(false); // Aanmelding verwijderen, afbeelding behouden
                    }
                } else {
                    if ($payment->hasRefunds()) {
                        $application->status = MemberApplication::STATUS_REFUNDED;
                    }
                    $application->transaction_id     = $payment->id;
                    $application->transaction_status = $payment->status;
                    $application->transaction_amount = $payment->amount->value;
                    $application->saveOrFail();

                    if ($payment->isCanceled() || $payment->isExpired() || $payment->isFailed() || (!$payment->isPaid() && !$payment->isOpen())) {
                        Log::debug('De betaling is geannuleerd of is verlopen en de inschrijving zal worden verwijderd', ['payment' => $payment]);
                        // Verwijder geannuleerde of verlopen inschrijvingen uit de database.
                        $application->delete();
                    }
                }

            } catch (ApiException $exception) {
                Log::error($exception);
                abort(400);
            }
            return 'OK';
        }


        /**
         * @param MemberApplication $application
         * @param string            $token
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * @throws \Throwable
         */
        public function confirmEmail(MemberApplication $application, $token) {
            if ($application->email_confirmation_token !== $token) {
                return view('signup.email_token_invalid');
            }

            $application->status                   = MemberApplication::STATUS_NEW;
            $application->email_confirmation_token = null;
            $application->saveOrFail();

            $mail = new NewMemberApplication($application);
            $mail->to(config('mail.application_to.address'), config('mail.application_to.name'));

            Mail::queue($mail);

            //dd($application);

            return view('signup.email_confirmation', [
                'application' => $application
            ]);

        }

        /**
         * @param MemberApplication $application
         *
         * @return mixed
         */
        public function afbeelding(MemberApplication $application) {
            return $application->getPicture();
        }

    }
