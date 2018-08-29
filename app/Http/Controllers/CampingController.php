<?php

    namespace App\Http\Controllers;

    use App\CampingApplication;
    use App\Helpers\PaymentHelper;
    use App\Http\Requests\CampingSignup;
    use App\Mail\CampingApplicationPaymentConfirmation;
    use App\Mail\NewCampingApplication;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Mail;

    /**
     * Class CampingController
     *
     * @package App\Http\Controllers
     */
    class CampingController extends Controller {


        /**
         * @return \Illuminate\Http\RedirectResponse
         */
        public function index() {
            return redirect()->route('committees/camping');
        }

        /**
         * @param Request $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getSignupForm(Request $request) {
            return view('camping.signup',
                [
                    'signup_count' => CampingApplication::where('transaction_status', '=', 'paid')->count()
                ]
            );
        }

        /**
         * @param CampingSignup $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
         * @throws \Throwable
         */
        public function signup(CampingSignup $request) {
            $application                           = new CampingApplication($request->all());
            $application->ip_address               = $request->ip();
            $application->email_confirmation_token = str_random(200);
            $application->transaction_id           = '';
            $application->transaction_status       = '';
            $application->transaction_amount       = 0;
            if ($application->member_id === null) {
                $application->member_id = '(onbekend)';
            }

            $application->saveOrFail();
            $mollie  = new PaymentHelper();
            $payment = $mollie->payments->create([
                "amount"      => config('mollie.camping_costs'),
                "description" => trans('camping.signup.payment.description', ['first_name' => $application->first_name, 'last_name' => $application->last_name]),
                "redirectUrl" => route('camping.signup.confirm_payment'),
                "webhookUrl"  => route('webhook.payment.camping', ['application' => $application]),
                'metadata'    => [
                    'id' => $application->id
                ]
            ]);
            if (app()->environment() !== 'production') $request->flash();

            $application->transaction_id     = $payment->id;
            $application->transaction_status = $payment->status;
            $application->transaction_amount = $payment->amount;
            $application->saveOrFail();
            $request->session()->put('camping.application', $application);
            $request->session()->save();
            return view('camping.payment_redirect', [
                'links' => $payment->links
            ]);
        }


        /**
         * @param CampingApplication $application
         * @param Request            $request
         *
         * @return string
         * @throws \Mollie_API_Exception
         * @throws \Mollie_API_Exception_IncompatiblePlatform
         * @throws \Throwable
         */
        public function confirmPaymentWebhook(CampingApplication $application, Request $request) {

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
                        $application->status = CampingApplication::STATUS_NEW;

                        // Stuur een bevestiging naar de kampcommissie

                        $mail = new NewCampingApplication($application);
                        $mail->to(config('mail.camping_to.address'), config('mail.camping_to.name'));

                        Mail::queue($mail);

                        // Stuur een bevestiging naar de gebruiker zelf

                        $mail = new CampingApplicationPaymentConfirmation($application);
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
         * @param Request $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * @throws \Mollie_API_Exception
         * @throws \Mollie_API_Exception_IncompatiblePlatform
         */
        public function confirmPayment(Request $request) {
            if (!$request->session()->has('camping.application')) abort(404);
            /** @var CampingApplication $application */
            $application = $request->session()->get('camping.application');

            $mollie  = new PaymentHelper();
            $payment = $mollie->payments->get($application->transaction_id);
            if (!$payment->isOpen() && !$payment->isPaid()) {
                return redirect()->route('camping.signup')->withErrors(['signup' => trans('camping.signup.payment.failed')]);
            }
            return view('camping.signup_confirmation', [
                'application' => $application
            ]);
        }


        /**
         * @param CampingApplication $application
         * @param                    $token
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * @throws \Throwable
         */
        public function confirmEmail(CampingApplication $application, $token) {
            if ($application->email_confirmation_token !== $token) {
                return view('signup.email_token_invalid');
            }

            $application->status                   = CampingApplication::STATUS_NEW;
            $application->email_confirmation_token = null;
            $application->saveOrFail();

            $mail = new NewCampingApplication($application);
            $mail->to(config('mail.camping_to.address'), config('mail.camping_to.name'));

            Mail::queue($mail);

            return view('camping.email_confirmation', [
                'application' => $application
            ]);

        }
    }
