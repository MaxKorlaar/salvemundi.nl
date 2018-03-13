<?php

    namespace App\Http\Controllers;

    use App\Helpers\PaymentHelper;
    use App\Http\Requests\IntroSignup;
    use App\IntroApplication;
    use App\Mail\ConfirmIntroApplication;
    use App\Mail\IntroApplicationPaymentConfirmation;
    use App\Mail\NewIntroApplication;
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
            $application                           = new IntroApplication($request->all());
            $application->same_sex_rooms           = $request->has('same_sex_rooms');
            $application->alcohol                  = $request->has('alcohol');
            $application->extra_shirt              = $request->has('extra_shirt');
            $application->ip_address               = $request->ip();
            $application->email_confirmation_token = str_random(200);

            $application->transaction_id     = 'n.v.t.';
            $application->transaction_status = '';
            $application->transaction_amount = 0;
            /*
            $application->saveOrFail();
            $mollie  = new PaymentHelper();
            $payment = $mollie->payments->create([
                "amount"      => $application->calculateIntroCosts(),
                "description" => trans($application->extra_shirt ? 'intro.signup.payment.description_extra_shirt' : 'intro.signup.payment.description', ['first_name' => $application->first_name, 'last_name' => $application->last_name]),
                "redirectUrl" => route('intro.signup.confirm_payment'),
                "webhookUrl"  => route('webhook.payment.intro', ['application' => $application]),
                'metadata'    => [
                    'id' => $application->id
                ]
            ]);
            $application->transaction_id     = $payment->id;
            $application->transaction_status = $payment->status;
            $application->transaction_amount = $payment->amount;
            */
            if (app()->environment() !== 'production') $request->flash();

            $application->saveOrFail();
            $request->session()->put('intro.application', $application);
            $request->session()->save();

            //            return view('intro.payment_redirect', [
            //                'links' => $payment->links
            //            ]);

            $mail = new ConfirmIntroApplication($application);
            $mail->to($application->email, $application->first_name . ' ' . $application->last_name);
            Mail::queue($mail);

            return view('intro.signup_confirmation');
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
                return redirect()->route('intro.signup')->withErrors(['signup' => trans('intro.signup.payment.failed')]);
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

                if ($payment->isPaid()) {
                    if ($application->transaction_status != $payment->status) {
                        // De status is pas net bijgewerkt naar betaald.
                        $application->status = IntroApplication::STATUS_NEW;

                        // Stuur een bevestiging naar het bestuur

                        $mail = new NewIntroApplication($application);
                        $mail->to(config('mail.application_to.address'), config('mail.application_to.name'));

                        Mail::queue($mail);

                        // Stuur een bevestiging naar de gebruiker zelf

                        $mail = new IntroApplicationPaymentConfirmation($application);
                        $mail->to($application->email, $application->first_name . ' ' . $application->last_name);
                        Mail::queue($mail);

                    }
                }
                $application->transaction_id     = $payment->id;
                $application->transaction_status = $payment->status;
                $application->transaction_amount = $payment->amount;
                $application->saveOrFail();

                if ($payment->isCancelled() || $payment->isExpired() || $payment->isFailed() || (!$payment->isPaid() && !$payment->isOpen())) {
                    // Verwijder geannuleerde en verlopen inschrijvingen uit de database.
                    $application->delete();
                }

            } catch (\Mollie_API_Exception $exception) {
                Log::error($exception);
                abort(400);
            }
            return 'OK';
        }

        /**
         * @deprecated
         *
         * @param IntroApplication   $application
         * @param                    $token
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * @throws \Throwable
         */
        public function confirmEmail(IntroApplication $application, $token) {
            if ($application->email_confirmation_token !== $token) {
                abort(404);
            }

            $application->status                   = IntroApplication::STATUS_NEW;
            $application->email_confirmation_token = null;
            $application->saveOrFail();

            $mail = new NewIntroApplication($application);
            $mail->to(config('mail.application_to.address'), config('mail.application_to.name'));

            Mail::queue($mail);

            return view('intro.email_confirmation', [
                'application' => $application
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
    }
