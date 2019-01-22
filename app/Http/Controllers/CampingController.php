<?php

    namespace App\Http\Controllers;

    use App\Camp;
    use App\CampingApplication;
    use App\Helpers\PaymentHelper;
    use App\Http\Requests\CampingSignup;
    use App\Mail\CampingApplicationPaymentConfirmation;
    use App\Mail\NewCampingApplication;
    use App\Transaction;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Mail;
    use Mollie\Api\Exceptions\ApiException;

    /**
     * Class CampingController
     *
     * @package App\Http\Controllers
     */
    class CampingController extends Controller {


        public function __construct() {
            $this->middleware('auth')->only(['getSignupForm', 'signup', 'confirmPayment']);
        }

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
                    'signup_count' => CampingApplication::where('transaction_status', '=', 'paid')->count(),
                    'member'       => Auth::user()->member,
                    'camp'         => Camp::getCampWithOpenSignup()
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
            $member = Auth::user()->member;
            $camp   = Camp::getCampWithOpenSignup();
            if ($camp === null) abort(403);
            $application                           = new CampingApplication([
                'first_name' => $member->first_name,
                'last_name'  => $member->last_name,
                'phone'      => $member->phone,
                'email'      => $member->email,
                'birthday'   => $member->birthday,
                'address'    => $member->address,
                'city'       => $member->city,
                'postal'     => $member->postal,
                'remarks'    => $request->get('remarks'),
            ]);
            $application->ip_address               = $request->ip();
            $application->email_confirmation_token = str_random(200);
            $application->transaction_status       = '';
            $application->transaction_amount       = 0;
            $application->member()->associate($member);
            $application->camp()->associate($camp);
            $transaction = new Transaction();
            $transaction->save();
            /** @var Transaction $transaction */
            $application->transaction()->associate($transaction);
            $application->saveOrFail();
            $transaction->member()->associate($member);

            $mollie = new PaymentHelper();

            $payment = $mollie->payments->create([
                "amount"      => [
                    'currency' => 'EUR',
                    'value'    => (string) number_format($camp->price, 2)
                ],
                "description" => trans('camping.signup.payment.description', ['first_name' => $application->first_name, 'last_name' => $application->last_name]),
                "redirectUrl" => route('camping.signup.confirm_payment'),
                "webhookUrl"  => route('webhook.payment.camping', ['application' => $application]),
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

            $application->transaction_status = $payment->status;
            $application->transaction_amount = $payment->amount->value;
            $application->saveOrFail();
            $request->session()->put('camping.application', $application);
            $request->session()->save();
            return view('camping.payment_redirect', [
                'links' => $payment->_links
            ]);
        }


        /**
         * @param CampingApplication $application
         * @param Request            $request
         *
         * @return string
         * @throws \Mollie\Api\Exceptions\ApiException
         * @throws \Mollie\Api\Exceptions\IncompatiblePlatform
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
                        $application->status = CampingApplication::STATUS_NEW;

                        // Stuur een bevestiging naar de kampcommissie

                        $mail = new NewCampingApplication($application);
                        $mail->to(config('mail.camping_to.address'), config('mail.camping_to.name'));

                        Mail::queue($mail);

                        // Stuur een bevestiging naar de gebruiker zelf

                        $mail = new CampingApplicationPaymentConfirmation($application);
                        $mail->to($application->email, $application->first_name . ' ' . $application->last_name);
                        Mail::queue($mail);

                        // Verander de aanmelding naar een werkelijk lid van de vereniging
                        $application->transaction()->associate($transaction);
                    }
                } else {
                    if ($payment->hasRefunds()) {
                        $application->status             = CampingApplication::STATUS_REFUNDED;
                    }
                    $application->transaction_status = $payment->status;
                    $application->transaction_amount = $payment->amount->value;
                    $application->saveOrFail();

                    if ($payment->isCanceled() || $payment->hasRefunds() || $payment->isExpired() || $payment->isFailed() || (!$payment->isPaid() && !$payment->isOpen())) {
                        Log::debug('De betaling is geannuleerd of is verlopen en de kamp-inschrijving zal worden verwijderd', ['payment' => $payment]);
                        // Verwijder geannuleerde of verlopen kamp-inschrijvingen uit de database.
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
         * @param Request $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * @throws ApiException
         * @throws \Mollie\Api\Exceptions\IncompatiblePlatform
         */
        public function confirmPayment(Request $request) {
            //if (!$request->session()->has('camping.application')) abort(404);
            /** @var CampingApplication $application */
            $application = $request->session()->get('camping.application');
            if ($application !== null) {
                $mollie  = new PaymentHelper();
                $payment = $mollie->payments->get($application->transaction->transaction_id);
                if (!$payment->isOpen() && !$payment->isPaid()) {
                    return redirect()->route('camping.signup')->withErrors(['signup' => trans('camping.signup.payment.failed')]);
                }
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
