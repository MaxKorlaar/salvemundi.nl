<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Admin\Intro\CreateIntro;
    use App\Http\Requests\Admin\Intro\UpdateIntro;
    use App\IntroApplication;
    use App\Introduction;
    use App\Mail\ConfirmIntroApplication;
    use App\Mail\IntroApplicationPaymentRequest;
    use App\Year;
    use Carbon\Carbon;
    use Exception;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Mail;
    use Illuminate\View\View;
    use Psr\SimpleCache\InvalidArgumentException;
    use Throwable;

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
         * @return Factory|View
         */
        public static function index() {
            return view('admin.intro.index', [
                'introductions' => Introduction::with(['year', 'applications'])->get()
            ]);
        }

        /**
         * @param Introduction $intro
         *
         * @return Factory|View
         */
        public function show(Introduction $intro) {
            return view('admin.intro.show', [
                'introduction'            => $intro,
                'script_data'             => [
                    'applications' => $intro->getApplicationsJSON()
                ],
                'confirmed_count'         => $intro->applications()->where('status', '=', IntroApplication::STATUS_PAID)->count(),
                'reservations_count'      => $intro->applications()->where('status', '=', IntroApplication::STATUS_RESERVED)->count(),
                'email_unconfirmed_count' => $intro->applications()->where('status', '=', IntroApplication::STATUS_EMAIL_UNCONFIRMED)->count()
            ]);
        }

        /**
         * @return Factory|View
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
         * @return RedirectResponse
         * @throws Throwable
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
         * @param Introduction $intro
         *
         * @return Factory|View
         */
        public static function edit(Introduction $intro) {
            return view('admin.intro.edit', [
                'years'        => Year::all(),
                'introduction' => $intro
            ]);
        }

        /**
         * @param UpdateIntro  $request
         * @param Introduction $intro
         *
         * @return RedirectResponse
         * @throws Throwable
         */
        public function update(UpdateIntro $request, Introduction $intro) {
            $intro->fill($request->all());
            if ($request->has('mail_reservations')) {
                $intro->mail_reservations_at = $request->get('signup_open');
            } else {
                $intro->mail_reservations_at = null;
            }
            $intro->saveOrFail();
            return redirect()->back()->with('success', trans('admin.intro.edit.saved'));
        }

        /**
         * @param Introduction $intro
         *
         * @return Factory|RedirectResponse|View
         */
        public function getDeleteConfirmation(Introduction $intro) {
            if ($intro->isAnonymised()) {
                return view('admin.intro.delete', [
                    'introduction' => $intro
                ]);
            }
            return back();
        }

        /**
         * @param Introduction $intro
         *
         * @return RedirectResponse
         * @throws Exception
         */
        public function destroy(Introduction $intro) {
            if ($intro->isAnonymised()) {
                $intro->delete();
                return redirect()->route('admin.intro.index')->with('success', trans('admin.intro.delete.deleted'));
            }
            return back();
        }


        /**
         *
         * @param Introduction $intro
         * @param Request      $request
         *
         * @return IntroApplication
         * @throws InvalidArgumentException
         */
        public function sendEmailConfirmationReminders(Introduction $intro, Request $request) {
            $key = 'admin.intro.throttle.email_confirmation_reminders:' . $intro->id;
            if (Cache::has($key)) {
                return back()->withErrors(['mail' => trans('admin.intro.reminder_throttle')]);
            }
            $unconfirmedCount = $intro->applications()->where('status', '=', IntroApplication::STATUS_EMAIL_UNCONFIRMED)
                ->where('type', '!=', IntroApplication::TYPE_ANONYMISED)->count();
            $signups          = $intro->applications()->where('status', '=', IntroApplication::STATUS_EMAIL_UNCONFIRMED)
                ->where('type', '!=', IntroApplication::TYPE_ANONYMISED)->get();
            $count            = 0;
            $signups->each(function (IntroApplication $application) use (&$count) {
                $applicationKey = 'admin.intro.throttle.email_reminder:' . $application->id;
                if (!Cache::has($applicationKey)) {
                    $mail = new ConfirmIntroApplication($application);
                    $mail->to($application->email, $application->first_name . ' ' . $application->last_name);
                    Mail::queue($mail);
                    Cache::set($applicationKey, time(), 10080);
                    $count++;
                }
            });

            Cache::set($key, time(), 10080); // 10.080 minuten = 7 dagen

            Log::info(trans('admin.intro.reminders_sent', [
                'count'             => $count,
                'unconfirmed_count' => $unconfirmedCount
            ]), ['user' => $request->user()->official_name, 'ip' => $request->ip()]);
            return back()->with('success', trans('admin.intro.reminders_sent', [
                'count'             => $count,
                'unconfirmed_count' => $unconfirmedCount,
            ]));
        }

        /**
         * @param Introduction $intro
         * @param Request      $request
         *
         * @return RedirectResponse
         * @throws InvalidArgumentException
         */
        public function sendPaymentReminders(Introduction $intro, Request $request) {
            $key = 'admin.intro.throttle.payment_reminders:' . $intro->id;
            if (Cache::has($key)) {
                return back()->withErrors(['mail' => trans('admin.intro.reminder_throttle')]);
            }
            $totalCount = $intro->applications()->where('status', '=', IntroApplication::STATUS_RESERVED)
                ->where('type', '!=', IntroApplication::TYPE_ANONYMISED)->count();
            $signups    = $intro->applications()->where('status', '=', IntroApplication::STATUS_RESERVED)
                ->where('type', '!=', IntroApplication::TYPE_ANONYMISED)->get();
            $count      = 0;
            $signups->each(function (IntroApplication $application) use (&$count) {
                $applicationKey = 'admin.intro.throttle.payment_reminder:' . $application->id;
                if (!Cache::has($applicationKey)) {
                    $mail = new IntroApplicationPaymentRequest($application);
                    if ($application->email_confirmation_token === null) {
                        $application->email_confirmation_token = str_random(64);
                        $application->saveOrFail();
                    } else {
                        $mail->subject(trans('email.intro.payment_request_reminder.subject', ['name' => $application->first_name . ' ' . $application->last_name]));
                    }
                    $mail->to($application->email, $application->first_name . ' ' . $application->last_name);
                    Mail::queue($mail);
                    Cache::set($applicationKey, time(), 10080);
                    $count++;
                }
            });

            Cache::set($key, time(), 10080); // 10.080 minuten = 7 dagen

            Log::info(trans('admin.intro.payment_reminders_sent', [
                'count'       => $count,
                'total_count' => $totalCount
            ]), ['user' => $request->user()->official_name, 'ip' => $request->ip()]);
            return back()->with('success', trans('admin.intro.payment_reminders_sent', [
                'count'       => $count,
                'total_count' => $totalCount,
            ]));
        }


    }
