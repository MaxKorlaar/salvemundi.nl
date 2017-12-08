<?php

    namespace App\Http\Controllers;

        use App\Http\Requests\ConfirmSignup;
        use App\Http\Requests\Signup;
        use App\Mail\ConfirmApplication;
        use App\MemberApplication;
        use Illuminate\Http\Request;
        use Illuminate\Support\Facades\Crypt;
        use Illuminate\Support\Facades\File;
        use Illuminate\Support\Facades\Mail;
        use Illuminate\Support\Facades\Storage;

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
             * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
             */
            public function getConfirmationPage(Signup $request) {
                $request->session()->put('signup_data', $request->all());
                return view('confirm_signup');
            }

            /**
             * @param Request $request
             *
             * @return \Illuminate\Http\RedirectResponse
             */
            public function getConfirmationPageWithoutSignup(Request $request) {
                if ($request->session()->get('signup_data') === null) {
                    dd($request->session());
                    return $this->redirectToIndex();
                }
                return view('confirm_signup');
            }

            /**
             * @param ConfirmSignup $request
             *
             * @return \Illuminate\Http\RedirectResponse
             * @throws \Throwable
             */
            public function signup(ConfirmSignup $request) {
                if ($request->session()->get('signup_data') === null) return back(); // Stuur de gebruiker weg als er geen inschrijfgegevens in de sessie zitten


                $application = new MemberApplication($request->session()->get('signup_data'));

                $current = MemberApplication::where('application_hash', '=', $application->getApplicationHash())->count();

                if ($current > 0) {
                    // Er is al een inschrijving met dezelfde PCN
                    return redirect(route('signup'))->withErrors(['signup' => trans('signup.errors.existing_application')]);
                }
                $picture  = $request->file('picture');
                $filename = $request->session()->get('signup_data')['pcn'] . '-' . time() . '.' . $picture->extension();;
                $picture->storeAs('member_photos', $filename);

                $application->ip_address               = $request->ip();
                $application->email_confirmation_token = str_random(200);
                $application->picture_name = $filename;
                $application->saveOrFail();
                if (app()->environment() === 'production') $request->session()->pull('signup_data');

                $mail = new ConfirmApplication($application);
                $mail->to($application->email, $application->name);
                Mail::queue($mail);

                return view('signup_confirmation');
            }

            /**
             * @param MemberApplication $application
             * @param string            $token
             *
             * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
             * @throws \Throwable
             */
            public function confirmEmail(MemberApplication $application, $token) {
                if ($application->email_confirmation_token !== $token) {
                    abort(404);
                }

                $application->status                   = MemberApplication::STATUS_NEW;
                $application->email_confirmation_token = null;
                $application->saveOrFail();
                //dd($application);

                return view('signup.email_confirmation', [
                    'application' => $application
                ]);

            }

            /**
             * @param MemberApplication $application
             *
             * @return mixed
             */
            public function afbeelding(MemberApplication $application) {
                //dd($application->picture_name);
                return $application->getPicture();
            }

        }
