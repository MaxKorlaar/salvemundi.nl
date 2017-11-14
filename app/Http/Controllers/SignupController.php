<?php

    namespace App\Http\Controllers;

        use App\Http\Requests\Signup;
        use App\Mail\ConfirmApplication;
        use App\MemberApplication;
        use Illuminate\Http\Request;
        use Illuminate\Support\Facades\Mail;

        /**
         * Class SignupController
         *
         * @package App\Http\Controllers
         */
        class SignupController extends Controller {

            /**
             * @param Request $request
             *
             * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
             */
            public function index(Request $request) {
                $request->session()->reflash();

                return view('signup');
            }

            /**
             * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
             */
            public function redirectToIndex() {
                return redirect(route('signup'));
            }

            /**
             * @param Signup $request
             *
             * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
             */
            public function getConfirmationPage(Signup $request) {
                $request->flash();
                return view('confirm_signup');
            }

            /**
             * @param Request $request
             *
             * @return \Illuminate\Http\RedirectResponse
             * @throws \Throwable
             */
            public function signup(Request $request) {
                if ($request->old('pcn') === null) return back(); // Stuur de gebruiker weg als er geen inschrijfgegevens in de sessie zitten

                $application = new MemberApplication($request->old());

                $current = MemberApplication::where('pcn', '=', $application->pcn)->count();

                if ($current > 0) {
                    // Er is al een inschrijving met dezelfde PCN
                    $request->session()->reflash();
                    return redirect(route('signup'))->withErrors(['signup' => trans('signup.errors.existing_application')]);
                }

                $application->ip_address               = $request->ip();
                $application->email_confirmation_token = str_random(200);
                $application->saveOrFail();

                $mail = new ConfirmApplication($application);
                $mail->to($application->email, $application->name);
                Mail::queue($mail);

                return view('signup_confirmation');
            }
        }
