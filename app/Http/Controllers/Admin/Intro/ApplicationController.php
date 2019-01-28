<?php

    namespace App\Http\Controllers\Admin\Intro;

    use App\Http\Controllers\Controller;
    use App\IntroApplication;
    use App\Introduction;
    use App\Mail\ConfirmIntroApplication;
    use App\Mail\IntroApplicationPaymentRequest;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\Mail;

    /**
     * Class ApplicationController
     *
     * @package App\Http\Controllers\Admin\Intro
     */
    class ApplicationController extends Controller {


        public function __construct() {
            $this->middleware('auth.admin');
        }

        /**
         * @param Introduction $intro
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function index(Introduction $intro) {
            return redirect()->route('admin.intro.show', [$intro]);
        }

        /**
         * Show the form for creating a new resource.
         *
         */
        public function create() {
            abort(501);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param Introduction              $intro
         * @param IntroApplication          $application
         */
        public function store(Request $request, Introduction $intro, IntroApplication $application) {
            abort(501);
        }

        /**
         * @param Introduction     $intro
         *
         * @param IntroApplication $aanmeldingen
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function show(Introduction $intro, IntroApplication $aanmeldingen) {
            return view('admin.intro.applications.show', [
                'application'  => $aanmeldingen,
                'introduction' => $intro
            ]);
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int $id
         *
         */
        public function edit($id) {
            abort(501);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  int                      $id
         *
         */
        public function update(Request $request, $id) {
            abort(501);
        }

        /**
         * @param Introduction     $intro
         * @param IntroApplication $application
         * @param Request          $request
         *
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Psr\SimpleCache\InvalidArgumentException
         */
        public function sendEmailConfirmationReminder(Introduction $intro, IntroApplication $application, Request $request) {
            if ($application->isAnonymised()) abort(400);
            $key = 'admin.intro.throttle.email_reminder.' . $application->id . ':' . $request->user()->id;
            if (Cache::has($key)) {
                return back()->withErrors(['mail' => trans('admin.intro.applications.reminder_throttle')]);
            }
            $mail = new ConfirmIntroApplication($application);
            $mail->to($application->email, $application->first_name . ' ' . $application->last_name);
            Mail::queue($mail);
            Cache::set($key, time(), 120);
            return back()->with('success', trans('admin.intro.applications.email_confirmation_reminder_sent'));
        }


        /**
         * @param Introduction     $intro
         * @param IntroApplication $application
         * @param Request          $request
         *
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Psr\SimpleCache\InvalidArgumentException
         * @throws \Throwable
         */
        public function sendPaymentReminder(Introduction $intro, IntroApplication $application, Request $request) {
            if ($application->isAnonymised()) abort(400);
            $key = 'admin.intro.throttle.payment_reminder.' . $application->id . ':' . $request->user()->id;
            if (Cache::has($key)) {
                return back()->withErrors(['mail' => trans('admin.intro.applications.reminder_throttle')]);
            }
            if ($application->email_confirmation_token === null) {
                $application->email_confirmation_token = str_random(64);
                $application->saveOrFail();
            }
            $mail = new IntroApplicationPaymentRequest($application);
            $mail->subject(trans('email.intro.payment_request_reminder.subject', ['name' => $application->first_name . ' ' . $application->last_name]));
            $mail->to($application->email, $application->first_name . ' ' . $application->last_name);
            Mail::queue($mail);
            Cache::set($key, time(), 120);
            return back()->with('success', trans('admin.intro.applications.payment_reminder_sent'));
        }

        /**
         * @param Introduction     $intro
         * @param IntroApplication $application
         *
         * @return \Illuminate\Http\RedirectResponse
         */
        public function getDeleteConfirmation(Introduction $intro, IntroApplication $application) {
            if ($application->isAnonymised() ||
                ($application->status != IntroApplication::STATUS_PAID &&
                    $application->status != IntroApplication::STATUS_SEE_TRANSACTION)) {
                return view('admin.intro.applications.delete', [
                    'application'  => $application,
                    'introduction' => $intro
                ]);
            }
            return back();

        }


        /**
         * @param Introduction $intro
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function spreadsheet(Introduction $intro) {
            return view('admin.intro.applications.spreadsheet', [
                'introduction'            => $intro,
                'confirmed_count'         => $intro->applications()->where('status', '=', IntroApplication::STATUS_PAID)->count(),
                'reservations_count'      => $intro->applications()->where('status', '=', IntroApplication::STATUS_RESERVED)->count(),
                'email_unconfirmed_count' => $intro->applications()->where('status', '=', IntroApplication::STATUS_EMAIL_UNCONFIRMED)->count()
            ]);
        }

        /**
         * @param Introduction     $intro
         *
         * @param IntroApplication $aanmeldingen
         *
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Exception
         */
        public function destroy(Introduction $intro, IntroApplication $aanmeldingen) {
            if ($aanmeldingen->isAnonymised() ||
                ($aanmeldingen->status != IntroApplication::STATUS_PAID ||
                    $aanmeldingen->status != IntroApplication::STATUS_SEE_TRANSACTION)) {
                $aanmeldingen->delete();
                return redirect()->route('admin.intro.show', ['intro' => $intro])->with('success', trans('admin.intro.applications.delete.deleted'));
            }
            return back();
        }

        // De volgende functies zijn buiten gebruik omdat de functies nu individueel uitgevoerd kunnen worden per aanmelding.

        /**
         * @deprecated
         *
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
         * @deprecated
         *
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
         * @deprecated
         *
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
