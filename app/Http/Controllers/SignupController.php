<?php

    namespace App\Http\Controllers;

    use App\Helpers\PaymentHelper;
    use App\Http\Requests\ConfirmSignup;
    use App\Http\Requests\Signup;
    use App\Mail\ConfirmApplication;
    use App\Mail\MemberApplicationPaymentConfirmation;
    use App\Mail\NewMemberApplication;
    use App\MemberApplication;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Mail;

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
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
         */
        public function redirectToIndex() {
            return redirect(route('signup.signup'));
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
         * @param ConfirmSignup $request
         *
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Throwable
         */
        public function signup(ConfirmSignup $request) {
            if ($request->session()->get('signup_data') === null) return back(); // Stuur de gebruiker weg als er geen inschrijfgegevens in de sessie zitten

            $application = new MemberApplication($request->session()->get('signup_data'));

            $picture  = $request->file('picture');
            $filename = $request->session()->get('signup_data')['pcn'] . '-' . time() . '.' . $picture->extension();;
            $picture->storeAs('member_photos', $filename);

            $application->ip_address               = $request->ip();
            $application->email_confirmation_token = str_random(200);
            $application->picture_name             = $filename;
            $application->transaction_id = '';
            $application->transaction_status = '';
            $application->transaction_amount = 0;

            $application->saveOrFail();

            $mollie  = new PaymentHelper();
            $payment = $mollie->payments->create([
                "amount"      => 25.00,
                "description" => trans('signup.payment.description', ['first_name' => $application->first_name, 'last_name' => $application->last_name]),
                "redirectUrl" => route('signup.confirm_payment'),
                "webhookUrl"  => route('webhook.payment.signup', ['application' => $application]),
                'metadata'    => [
                    'id' => $application->id
                ]
            ]);
            if (app()->environment() !== 'production') $request->flash();

            $application->transaction_id     = $payment->id;
            $application->transaction_status = $payment->status;
            $application->transaction_amount = $payment->amount;
            $application->saveOrFail();
            $request->session()->put('signup.application', $application);
            if (app()->environment() === 'production') $request->session()->pull('signup_data');
            $request->session()->save();


            return view('signup.payment_redirect', [
                'links' => $payment->links
            ]);
        }


        /**
         * @param Request $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * @throws \Mollie_API_Exception
         * @throws \Mollie_API_Exception_IncompatiblePlatform
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
         * @throws \Exception
         * @throws \Mollie_API_Exception
         * @throws \Mollie_API_Exception_IncompatiblePlatform
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
                if ($payment->isPaid()) {
                    if ($application->transaction_status != $payment->status) {
                        // De status is pas net bijgewerkt naar betaald.
                        $application->status = MemberApplication::STATUS_NEW;

                        // Stuur een bevestiging naar de kampcommissie

                        $mail = new NewMemberApplication($application);
                        $mail->to(config('mail.application_to.address'), config('mail.application_to.name'));

                        Mail::queue($mail);

                        // Stuur een bevestiging naar de gebruiker zelf

                        $mail = new MemberApplicationPaymentConfirmation($application);
                        $mail->to($application->email, $application->first_name . ' ' . $application->last_name);
                        Mail::queue($mail);

                    }
                }
                $application->transaction_id     = $payment->id;
                $application->transaction_status = $payment->status;
                $application->transaction_amount = $payment->amount;
                $application->saveOrFail();

                if ($payment->isCancelled() || $payment->isExpired() || $payment->isFailed() || (!$payment->isPaid() && !$payment->isOpen())) {
                    Log::debug('De betaling is geannuleerd of is verlopen en de inschrijving zal worden verwijderd', ['payment' => $payment]);
                    // Verwijder geannuleerde of verlopen inschrijvingen uit de database.
                    $application->delete();
                }

            } catch (\Mollie_API_Exception $exception) {
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
                abort(404);
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
            //dd($application->picture_name);
            return $application->getPicture();
        }

    }
