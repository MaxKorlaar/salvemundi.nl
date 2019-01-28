<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Admin\Intro\CreateIntro;
    use App\Http\Requests\Admin\Intro\UpdateIntro;
    use App\IntroApplication;
    use App\Introduction;
    use App\Year;
    use Carbon\Carbon;

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
         * @param Introduction $intro
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function edit(Introduction $intro) {
            return view('admin.intro.edit', [
                'years'        => Year::all(),
                'introduction' => $intro
            ]);
        }

        /**
         * @param UpdateIntro  $request
         * @param Introduction $intro
         *
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Throwable
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
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
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
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Exception
         */
        public function destroy(Introduction $intro) {
            if ($intro->isAnonymised()) {
                $intro->delete();
                return redirect()->route('admin.intro.index')->with('success', trans('admin.intro.delete.deleted'));
            }
            return back();
        }

    }
