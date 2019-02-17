<?php

    namespace App\Http\Controllers\Admin\Intro;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Admin\Intro\UpdateSupervisorApplication;
    use App\Introduction;
    use App\IntroSupervisorApplication;
    use Exception;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\View\View;

    /**
     * Class SupervisorApplicationController
     *
     * @package App\Http\Controllers\Admin\Intro
     */
    class SupervisorApplicationController extends Controller {

        public function __construct() {
            $this->middleware('auth.admin');
        }

        /**
         * Display a listing of the resource.
         *
         * @param Introduction $intro
         *
         * @param Request      $request
         *
         * @return array|Response
         */
        public function index(Introduction $intro, Request $request) {
            if ($request->ajax()) {
                return [
                    'success'      => true,
                    'applications' => $intro->getSupervisorApplicationsJSON()
                ];
            }
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
         * @return void
         */
        public static function create() {
            abort(501);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  Request $request
         *
         * @return void
         */
        public static function store(Request $request) {
            abort(501);
        }

        /**
         * Display the specified resource.
         *
         * @param Introduction               $intro
         * @param IntroSupervisorApplication $ouderAanmeldingen
         *
         * @return Response
         */
        public static function show(Introduction $intro, IntroSupervisorApplication $ouderAanmeldingen) {
            return view('admin.intro.supervisor_applications.show', [
                'application'  => $ouderAanmeldingen,
                'introduction' => $intro
            ]);
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param Introduction               $intro
         * @param IntroSupervisorApplication $ouderAanmeldingen
         *
         * @return void
         */
        public static function edit(Introduction $intro, IntroSupervisorApplication $ouderAanmeldingen) {
            if ($ouderAanmeldingen->isAnonymised()) return back();
            return view('admin.intro.supervisor_applications.edit', [
                'application'  => $ouderAanmeldingen,
                'introduction' => $intro
            ]);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param Introduction                $intro
         * @param IntroSupervisorApplication  $ouderAanmeldingen
         * @param UpdateSupervisorApplication $request
         *
         * @return void
         */
        public static function update(Introduction $intro, IntroSupervisorApplication $ouderAanmeldingen, UpdateSupervisorApplication $request) {
            if ($ouderAanmeldingen->isAnonymised()) return back();
            $ouderAanmeldingen->update($request->all());
            return back()->with('success', trans('admin.intro.supervisor_applications.edit.success'));
        }

        /**
         * @param Introduction               $intro
         * @param IntroSupervisorApplication $application
         *
         * @return Factory|RedirectResponse|View
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
         * @param Introduction $intro
         *
         * @return Factory|View
         */
        public function spreadsheet(Introduction $intro) {
            return view('admin.intro.supervisor_applications.spreadsheet', [
                'introduction'            => $intro,
                'confirmed_count'         => $intro->supervisorApplications()
                    ->where('status', '=', IntroSupervisorApplication::STATUS_SIGNED_UP)->count(),
                'email_unconfirmed_count' => $intro->supervisorApplications()
                    ->where('status', '=', IntroSupervisorApplication::STATUS_EMAIL_UNCONFIRMED)->count()
            ]);
        }


        /**
         * Remove the specified resource from storage.
         *
         * @param Introduction               $intro
         * @param IntroSupervisorApplication $ouderAanmeldingen
         *
         * @return Response
         * @throws Exception
         */
        public function destroy(Introduction $intro, IntroSupervisorApplication $ouderAanmeldingen) {
            if ($ouderAanmeldingen->isAnonymised() || $ouderAanmeldingen->status === IntroSupervisorApplication::STATUS_EMAIL_UNCONFIRMED) {
                $ouderAanmeldingen->delete();
                return redirect()->route('admin.intro.supervisor_applications.index', ['intro' => $intro])->with('success', trans('admin.intro.supervisor_applications.delete.deleted'));
            }
            return back();
        }
    }
