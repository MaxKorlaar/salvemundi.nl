<?php

    namespace App\Http\Controllers;

    use App\CampingApplication;
    use App\Http\Requests\CampingSignup;
    use App\Mail\ConfirmCampingApplication;
    use App\Mail\NewCampingApplication;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Mail;

    /**
     * Class CampingController
     *
     * @package App\Http\Controllers
     */
    class CampingController extends Controller {
        /**
         * @param Request $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getSignupForm(Request $request) {
            return view('camping.signup');
        }

        /**
         * @param CampingSignup $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
         * @throws \Throwable
         */
        public function signup(CampingSignup $request) {
            $application = new CampingApplication($request->all());

            $current = CampingApplication::where('application_hash', '=', $application->getApplicationHash())->count();

            if ($current > 0) {
                // Er is al een inschrijving met dezelfde PCN
                return back()->withErrors(['signup' => trans('camping.signup.errors.existing_application')]);
            }

            $application->ip_address               = $request->ip();
            $application->email_confirmation_token = str_random(200);
            $application->saveOrFail();
            if (app()->environment() !== 'production') $request->flash();

            $mail = new ConfirmCampingApplication($application);
            $mail->to($application->email, $application->first_name . ' ' . $application->last_name);
            Mail::queue($mail);

            return view('camping.signup_confirmation');
        }

        /**
         * @param CampingApplication $application
         * @param                    $token
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * @throws \Throwable
         */
        public function confirmEmail(CampingApplication $application, $token) {
            if ($application->email_confirmation_token !== $token) {
                abort(404);
            }

            //dd($application);

            $application->status                   = CampingApplication::STATUS_NEW;
            $application->email_confirmation_token = null;
            $application->saveOrFail();

            $mail = new NewCampingApplication($application);
            $mail->to(config('mail.camping_to.address'), config('mail.camping_to.name'));

            Mail::queue($mail);

            //dd($application);

            return view('camping.email_confirmation', [
                'application' => $application
            ]);

        }
    }
