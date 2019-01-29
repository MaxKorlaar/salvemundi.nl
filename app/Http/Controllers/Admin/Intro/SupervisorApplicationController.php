<?php

    namespace App\Http\Controllers\Admin\Intro;

    use App\Http\Controllers\Controller;
    use App\Introduction;
    use App\IntroSupervisorApplication;
    use Illuminate\Http\Request;

    /**
     * Class SupervisorApplicationController
     *
     * @package App\Http\Controllers\Admin\Intro
     */
    class SupervisorApplicationController extends Controller {
        /**
         * Display a listing of the resource.
         *
         * @param Introduction $intro
         *
         * @return \Illuminate\Http\Response
         */
        public function index(Introduction $intro) {
            return view('admin.intro.supervisor_applications.index', [
                'introduction'            => $intro,
                'confirmed_count'         => $intro->supervisorApplications()
                    ->where('status', '=', IntroSupervisorApplication::STATUS_SIGNED_UP)->count(),
                'email_unconfirmed_count' => $intro->supervisorApplications()
                    ->where('status', '=', IntroSupervisorApplication::STATUS_EMAIL_UNCONFIRMED)->count()
            ]);
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create() {
            abort(501);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request) {
            abort(501);
        }

        /**
         * Display the specified resource.
         *
         * @param Introduction               $intro
         * @param IntroSupervisorApplication $ouderAanmeldingen
         *
         * @return \Illuminate\Http\Response
         */
        public function show(Introduction $intro, IntroSupervisorApplication $ouderAanmeldingen) {
            return view('admin.intro.supervisor_applications.show', [
                'application'  => $ouderAanmeldingen,
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
            abort(501);
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
            abort(501);
        }

        /**
         * @param Introduction               $intro
         * @param IntroSupervisorApplication $application
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
         */
        public function getDeleteConfirmation(Introduction $intro, IntroSupervisorApplication $application) {
            if ($application->isAnonymised() || $application->status === IntroSupervisorApplication::STATUS_EMAIL_UNCONFIRMED) {
                return view('admin.intro.supervisor_applications.delete', [
                    'application'  => $application,
                    'introduction' => $intro
                ]);
            }
            return back();

        }

        /**
         * Remove the specified resource from storage.
         *
         * @param Introduction               $intro
         * @param IntroSupervisorApplication $ouderAanmeldingen
         *
         * @return \Illuminate\Http\Response
         * @throws \Exception
         */
        public function destroy(Introduction $intro, IntroSupervisorApplication $ouderAanmeldingen) {
            if ($ouderAanmeldingen->isAnonymised() || $ouderAanmeldingen->status === IntroSupervisorApplication::STATUS_EMAIL_UNCONFIRMED) {
                $ouderAanmeldingen->delete();
                return redirect()->route('admin.intro.supervisor_applications.index', ['intro' => $intro])->with('success', trans('admin.intro.supervisor_applications.delete.deleted'));
            }
            return back();
        }
    }
