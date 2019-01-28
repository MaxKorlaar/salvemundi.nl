<?php

    namespace App\Http\Controllers\Admin\Intro;

    use App\Http\Controllers\Controller;
    use App\IntroApplication;
    use App\Introduction;
    use Illuminate\Http\Request;

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
            abort(404);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param Introduction              $intro
         * @param IntroApplication          $application
         */
        public function store(Request $request, Introduction $intro, IntroApplication $application) {
            dd($intro, $application);
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
         * @return \Illuminate\Http\Response
         */
        public function edit($id) {
            //
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  int                      $id
         *
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $id) {
            //
        }

        /**
         * @param IntroApplication $application
         *
         * @return \Illuminate\Http\RedirectResponse
         */
        public function getDeleteConfirmation(IntroApplication $application) {
            if ($application->status == IntroApplication::STATUS_PAID || $application->status == IntroApplication::STATUS_SEE_TRANSACTION) {
                return back();
            }
            return view('admin.intro.delete', ['application' => $application]);
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
         * @param IntroApplication $intro
         *
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Exception
         */
        public function destroy(IntroApplication $intro) {
            if ($intro->status == IntroApplication::STATUS_PAID || $intro->status == IntroApplication::STATUS_SEE_TRANSACTION) {
                return back();
            }
            $intro->delete();
            return redirect()->route('admin.intro.index')->with('success', trans('admin.intro.delete.deleted'));
        }
    }
