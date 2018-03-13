<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\IntroSignup;
    use App\IntroApplication;
    use App\Mail\ConfirmIntroApplication;
    use App\Mail\NewIntroApplication;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Mail;

    /**
     * Class IntroController
     *
     * @package App\Http\Controllers
     */
    class IntroController extends Controller {
        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getSignupForm() {
            return view('intro.signup');
        }

        /**
         * @param IntroSignup $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
         * @throws \Throwable
         */
        public function signup(IntroSignup $request) {
            $application                           = new IntroApplication($request->all());
            $application->same_sex_rooms           = $request->has('same_sex_rooms');
            $application->alcohol                  = $request->has('alcohol');
            $application->extra_shirt              = $request->has('extra_shirt');
            $application->ip_address               = $request->ip();
            $application->email_confirmation_token = str_random(200);
            $application->saveOrFail();
            if (app()->environment() !== 'production') $request->flash();

            $mail = new ConfirmIntroApplication($application);
            $mail->to($application->email, $application->first_name . ' ' . $application->last_name);
            Mail::queue($mail);

            return view('intro.signup_confirmation');
        }

        /**
         * @param IntroApplication   $application
         * @param                    $token
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * @throws \Throwable
         */
        public function confirmEmail(IntroApplication $application, $token) {
            if ($application->email_confirmation_token !== $token) {
                abort(404);
            }

            $application->status                   = IntroApplication::STATUS_NEW;
            $application->email_confirmation_token = null;
            $application->saveOrFail();

            $mail = new NewIntroApplication($application);
            $mail->to(config('mail.application_to.address'), config('mail.application_to.name'));

            Mail::queue($mail);

            return view('intro.email_confirmation', [
                'application' => $application
            ]);

        }


        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getSupervisorInfo() {
            return view('intro.supervisor.info');
        }

        /**
         * @return string
         */
        public function getSupervisorSignupForm() {
            return view('intro.supervisor.signup');
        }
    }
