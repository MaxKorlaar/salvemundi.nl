<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Admin\Intro\CreateIntro;
    use App\IntroApplication;
    use App\Introduction;
    use App\Mail\ConfirmIntroApplication;
    use App\Mail\IntroApplicationPaymentRequest;
    use App\Year;
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
                'introductions' => Introduction::with(['year', 'applications'])->get()
            ]);
        }

        /**
         * @param Introduction $intro
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function show(Introduction $intro) {
            return view('admin.intro.show', [
                'introduction'            => $intro,
                'confirmed_count'         => $intro->applications()->where('status', '=', IntroApplication::STATUS_PAID)->count(),
                'reservations_count'      => $intro->applications()->where('status', '=', IntroApplication::STATUS_RESERVED)->count(),
                'email_unconfirmed_count' => $intro->applications()->where('status', '=', IntroApplication::STATUS_EMAIL_UNCONFIRMED)->count()
            ]);
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function create() {
            return view('admin.intro.create', [
                'years'             => Year::all(),
                'reservations_open' => Carbon::now(),
                'signup_open'       => Carbon::now()->addMonth(),
                'signup_close'      => Carbon::now()->addMonths(2)
            ]);
        }

        /**
         * @param CreateIntro $request
         *
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Throwable
         */
        public function store(CreateIntro $request) {
            $intro = new Introduction($request->all());
            if ($request->has('mail_reservations')) {
                $intro->mail_reservations_at = $request->get('signup_open');
            }
            $intro->saveOrFail();
            return redirect()->route('admin.intro.show', [$intro])->with('success', trans('admin.intro.create.created'));
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

    }
