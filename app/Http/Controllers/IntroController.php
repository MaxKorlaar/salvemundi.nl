<?php

    namespace App\Http\Controllers;

    use App\Helpers\PaymentHelper;
    use App\Http\Requests\IntroSignup;
    use App\Http\Requests\IntroSupervisorSignup;
    use App\IntroApplication;
    use App\IntroSupervisorApplication;
    use App\Mail\ConfirmIntroSupervisorApplication;
    use App\Mail\IntroApplicationPaymentConfirmation;
    use App\Mail\IntroApplicationPaymentRequest;
    use App\Mail\NewIntroApplication;
    use App\Mail\NewIntroSupervisorApplication;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Mail;

    /**
     * Class IntroController
     *
     * @package App\Http\Controllers
     */
    class IntroController extends Controller {
        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getSignupForm() {
            return view('intro.signup');
        }

        /**
         * @param IntroSignup $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
         * @throws \Throwable
         */
        public function signup(IntroSignup $request) {
            $application                 = new IntroApplication($request->all());
            $application->same_sex_rooms = $request->has('same_sex_rooms');
            $application->alcohol        = $request->has('alcohol');
            $application->extra_shirt    = $request->has('extra_shirt');
            $application->ip_address     = $request->ip();
            //$application->email_confirmation_token = str_random(200);
            $application->transaction_id     = 'n.v.t.';
            $application->transaction_status = '';
            $application->transaction_amount = 0;
            $application->status             = IntroApplication::STATUS_OPEN;

            $application->saveOrFail();
            $mollie                          = new PaymentHelper();
            $payment                         = $mollie->payments->create([
                "amount" => [
                    'currency' => 'EUR',
                    'value'    => $application->calculateIntroCosts()
                ],
                "description" => trans($application->extra_shirt ? 'intro.signup.payment.description_extra_shirt' : 'intro.signup.payment.description', ['first_name' => $application->first_name, 'last_name' => $application->last_name]),
                "redirectUrl" => route('intro.signup.confirm_payment'),
                "webhookUrl"  => route('webhook.payment.intro', ['application' => $application]),
                'metadata'    => [
                    'id' => $application->id
                ]
            ]);
            $application->transaction_id     = $payment->id;
            $application->transaction_status = $payment->status;
            $application->transaction_amount = $payment->amount->value;

            if (app()->environment() !== 'production') $request->flash();

            $application->saveOrFail();
            $request->session()->put('intro.application', $application);
            $request->session()->save();
            return view('intro.payment_redirect', [
                'links' => $payment->_links
            ]);

            //            $mail = new ConfirmIntroApplication($application);
            //            $mail->to($application->email, $application->first_name . ' ' . $application->last_name);
            //            Mail::queue($mail);

            //            return view('intro.signup_confirmation');
        }

        /**
         * @param Request $request
         *
         * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * @throws \Mollie_API_Exception
         * @throws \Mollie_API_Exception_IncompatiblePlatform
         */
        public function confirmPayment(Request $request) {
            if (!$request->session()->has('intro.application')) abort(404);
            /** @var IntroApplication $application */
            $application = $request->session()->get('intro.application');

            $mollie  = new PaymentHelper();
            $payment = $mollie->payments->get($application->transaction_id);
            if (!$payment->isOpen() && !$payment->isPaid()) {
                if ($application->email_confirmation_token === null) {
                    return redirect()->route('intro.signup')->withErrors(['signup' => trans('intro.signup.payment.failed')]);
                } else {
                    return redirect()->route('intro.signup')->withErrors(['signup' => trans('intro.signup.payment.failed_from_mail')]);
                }
            }
            return view('intro.signup_confirmation', [
                'application' => $application
            ]);
        }

        /**
         * @param IntroApplication $application
         * @param Request          $request
         *
         * @return string
         * @throws \Exception
         * @throws \Mollie_API_Exception
         * @throws \Mollie_API_Exception_IncompatiblePlatform
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

                if ($payment->isPaid() && !$payment->isRefunded()) {
                    if ($application->transaction_status != $payment->status) {
                        // De status is pas net bijgewerkt naar betaald.
                        $application->status = IntroApplication::STATUS_PAID;

                        // Stuur een bevestiging naar het bestuur

                        $mail = new NewIntroApplication($application);
                        $mail->to(config('mail.intro_to.address'), config('mail.intro_to.name'));

                        Mail::queue($mail);

                        // Stuur een bevestiging naar de gebruiker zelf

                        $mail = new IntroApplicationPaymentConfirmation($application);
                        $mail->to($application->email, $application->first_name . ' ' . $application->last_name);
                        Mail::queue($mail);

                    }
                }
                if ($payment->isRefunded()) {
                    $application->status = IntroApplication::STATUS_REFUNDED;
                }
                $application->transaction_id     = $payment->id;
                $application->transaction_status = $payment->status;
                $application->transaction_amount = $payment->amount->value;
                $application->saveOrFail();

                if ($payment->isCancelled() || $payment->isExpired() || $payment->isFailed() || (!$payment->isPaid() && !$payment->isOpen())) {
                    // Verwijder geannuleerde en verlopen inschrijvingen uit de database.

                    // Verwijder alleen als de betaling _niet_ is gestart vanuit de email
                    if ($application->email_confirmation_token === null) {
                        $application->delete();
                    }
                }

            } catch (\Mollie_API_Exception $exception) {
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
                //abort(404);
            }

            $application->status                   = IntroApplication::STATUS_NEW;
            $application->email_confirmation_token = null;
            $application->saveOrFail();
            // Sla mail naar introcommissie over
            //            $mail = new NewIntroApplication($application);
            //            $mail->to(config('mail.intro_to.address'), config('mail.intro_to.name'));
            //
            //            Mail::queue($mail);

            $application->email_confirmation_token = str_random(64);
            $mail                                  = new IntroApplicationPaymentRequest($application);
            $mail->to($application->email, $application->first_name . ' ' . $application->last_name);
            Mail::send($mail);
            $application->saveOrFail();

            return view('intro.email_confirmation', [
                'application' => $application
            ]);

        }

        /**
         * @param IntroApplication $application
         * @param                  $token
         *
         * @param Request          $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * @throws \Mollie_API_Exception
         * @throws \Mollie_API_Exception_IncompatiblePlatform
         * @throws \Throwable
         */
        public function getPaymentPage(IntroApplication $application, $token, Request $request) {
            if ($application->email_confirmation_token !== $token || $application->status !== IntroApplication::STATUS_NEW) {
                abort(404);
            }

            return view('intro.signups_closed', [
            ]);

            $mollie = new PaymentHelper();
            $new    = false;
            if ($application->transaction_id === 'n.v.t.') {
                $new = true;
            } else {
                $payment = $mollie->payments->get($application->transaction_id);
                if (!$payment->isOpen()) $new = true;
            }
            if ($new) {
                $payment = $mollie->payments->create([
                    "amount" => [
                        'currency' => 'EUR',
                        'value'    => $application->calculateIntroCosts()
                    ],
                    "description" => trans($application->extra_shirt ? 'intro.signup.payment.description_extra_shirt' : 'intro.signup.payment.description', ['first_name' => $application->first_name, 'last_name' => $application->last_name]),
                    "redirectUrl" => route('intro.signup.confirm_payment'),
                    "webhookUrl"  => route('webhook.payment.intro', ['application' => $application]),
                    'metadata'    => [
                        'id' => $application->id
                    ]
                ]);
            }

            $application->transaction_id     = $payment->id;
            $application->transaction_status = $payment->status;
            $application->transaction_amount = $payment->amount->value;

            if (app()->environment() !== 'production') $request->flash();

            $application->saveOrFail();
            $request->session()->put('intro.application', $application);
            //Log::info('Sessie opgeslagen', [$request->session()->isStarted(), $request->session()->getId()]);
            $request->session()->save();
            return view('intro.payment_redirect', [
                'links' => $payment->_links
            ]);
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getInfo() {
            return view('intro.info');
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getSupervisorInfo() {
            return view('intro.supervisor.info');
        }

        /**
         * @return string
         */
        public function getSupervisorSignupForm() {
            return view('intro.supervisor.signup');
        }

        /**
         * @param IntroSupervisorSignup $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * @throws \Throwable
         */
        public function supervisorSignup(IntroSupervisorSignup $request) {
            $application                                 = new IntroSupervisorApplication($request->all());
            $application->ip_address                     = $request->ip();
            $application->email_confirmation_token       = str_random(200);
            $application->remain_sober                   = $request->has('remain_sober');
            $application->drivers_license                = $request->has('drivers_license');
            $application->first_aid_license              = $request->has('first_aid_license');
            $application->company_first_response_license = $request->has('company_first_response_license');
            if (app()->environment() !== 'production') $request->flash();

            $application->saveOrFail();

            $mail = new ConfirmIntroSupervisorApplication($application);
            $mail->to($application->email, $application->first_name . ' ' . $application->last_name);
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

            $application->status                   = IntroApplication::STATUS_NEW;
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
