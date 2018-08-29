<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\IntroApplication;
    use App\Mail\ConfirmIntroApplication;
    use App\Mail\IntroApplicationPaymentRequest;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Mail;
    use Log;

    /**
     * Class IntroController
     *
     * @package App\Http\Controllers\Admin
     */
    class IntroController extends Controller {

        public function __construct() {
            $this->middleware('auth.admin');
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function index() {
            return view('admin.intro.index', [
                'applications'            => IntroApplication::all(),
                'confirmed_count'         => IntroApplication::where('status', '=', IntroApplication::STATUS_PAID)->count(),
                'email_unconfirmed_count' => IntroApplication::where('status', '=', IntroApplication::STATUS_EMAIL_UNCONFIRMED)->count()
            ]);
        }


        /**
         * @param IntroApplication $application
         *
         * @return \Illuminate\Http\RedirectResponse
         */
        public function getDeleteConfirmation(IntroApplication $application) {
            if ($application->status == IntroApplication::STATUS_PAID || $application->status == IntroApplication::STATUS_OPEN) {
                return back();
            }
            return view('admin.intro.delete', ['application' => $application]);
        }

        /**
         * @param IntroApplication $intro
         *
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Exception
         */
        public function destroy(IntroApplication $intro) {
            if ($intro->status == IntroApplication::STATUS_PAID || $intro->status == IntroApplication::STATUS_OPEN) {
                return back();
            }
            $intro->delete();
            return redirect()->route('admin.intro.index')->with('success', trans('admin.intro.delete.deleted'));
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function spreadsheetIndex() {
            return view('admin.intro.spreadsheet', [
                'applications'            => IntroApplication::all(),
                'confirmed_count'         => IntroApplication::where('status', '=', IntroApplication::STATUS_PAID)->count(),
                'email_unconfirmed_count' => IntroApplication::where('status', '=', IntroApplication::STATUS_EMAIL_UNCONFIRMED)->count()
            ]);
        }

        /**
         * @param IntroApplication $intro
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function show(IntroApplication $intro) {
            return view('admin.intro.show', ['application' => $intro]);
        }

        /**
         * @param Request $request
         *
         * @return IntroApplication
         */
        public function sendConfirmEmailReminders(Request $request) {
            $unconfirmedCount = IntroApplication::where('status', '=', IntroApplication::STATUS_EMAIL_UNCONFIRMED)->count();
            $yesterday        = Carbon::yesterday()->format('Y-m-d H:i:s');
            $signups          = IntroApplication::where('status', '=', IntroApplication::STATUS_EMAIL_UNCONFIRMED)->where('updated_at', '<', $yesterday)->get();

            $signups->each(function (IntroApplication $application) {
                $mail = new ConfirmIntroApplication($application);
                $mail->to($application->email, $application->first_name . ' ' . $application->last_name);
                $application->updated_at = Carbon::now();
                $application->saveOrFail();
                Mail::queue($mail);
            });
            Log::info(trans('admin.intro.reminders_sent', [
                'count'             => $signups->count(),
                'unconfirmed_count' => $unconfirmedCount,
                'date'              => $yesterday
            ]), ['user' => $request->user()->official_name, 'ip' => $request->ip()]);
            return back()->with('success', trans('admin.intro.reminders_sent', [
                'count'             => $signups->count(),
                'unconfirmed_count' => $unconfirmedCount,
                'date'              => $yesterday
            ]));
        }

        /**
         * @param Request $request
         *
         * @return \Illuminate\Http\RedirectResponse
         */
        public function sendPaymentReminders(Request $request) {
            $yesterday    = Carbon::yesterday()->format('Y-m-d H:i:s');
            $signupsCount = IntroApplication::where('status', '=', IntroApplication::STATUS_NEW)->whereNotNull('email_confirmation_token')->count();
            $signups      = IntroApplication::where('status', '=', IntroApplication::STATUS_NEW)->whereNotNull('email_confirmation_token')->where('updated_at', '<', $yesterday)->get();
            $signups->each(function (IntroApplication $application) {
                $mail = new IntroApplicationPaymentRequest($application);
                $mail->subject(trans('email.intro.payment_request_reminder.subject', ['name' => $application->first_name . ' ' . $application->last_name]));
                $mail->to($application->email, $application->first_name . ' ' . $application->last_name);
                Mail::send($mail);
                $application->updated_at = Carbon::now();
                $application->saveOrFail();
            });
            Log::info(trans('admin.intro.payment_reminders_sent', [
                'count'        => $signupsCount,
                'actual_count' => $signups->count(),
                'date'         => $yesterday
            ]), ['user' => $request->user()->official_name, 'ip' => $request->ip()]);
            return back()->with('success', trans('admin.intro.payment_reminders_sent', [
                'count'        => $signupsCount,
                'actual_count' => $signups->count(),
                'date'         => $yesterday
            ]));
        }

        /**
         * @param Request $request
         *
         * @return \Illuminate\Http\RedirectResponse
         */
        public function generateTokensForUnpaidSignups(Request $request) {

            //return 'denk het niet job -wilders, ooit';

            $signups = IntroApplication::getUnpaidApplicationsWithoutToken();
            $signups->each(function (IntroApplication $application) {
                $application->email_confirmation_token = str_random(64);
                $mail                                  = new IntroApplicationPaymentRequest($application);
                $mail->to($application->email, $application->first_name . ' ' . $application->last_name);
                Mail::send($mail);
                $application->saveOrFail();
            });
            Log::info(trans('admin.intro.tokens_generated', ['count' => $signups->count()]),
                ['user' => $request->user()->official_name, 'ip' => $request->ip()]);
            return back()->with('success', trans('admin.intro.tokens_generated', ['count' => $signups->count()]));
        }

        /**
         * @return array
         */
        public function getUnconfirmedSignups() {
            abort(403);
            $signups = IntroApplication::where('status', '=', IntroApplication::STATUS_EMAIL_UNCONFIRMED)->get();

            $return = [];

            $signups->each(function (IntroApplication $application) use (&$return) {

                $fields = ['last_name', 'first_name', 'birthday', 'address', 'city', 'postal', 'phone', 'contact_phone', 'email', 'pcn', 'shirt_size', 'gender', 'remarks', 'transaction_id', 'transaction_amount'];
                $intro  = [];
                foreach ($fields as $field) {
                    if ($field == 'birthday') {
                        $intro[trans('intro.signup.' . $field)] = $application->birthday->format(trans('datetime.format.date'));
                    } else {
                        $intro[trans('intro.signup.' . $field)] = $application->getAttribute($field);
                    }
                }

                $return[] = $intro;
            });

            return $return;
        }
    }
