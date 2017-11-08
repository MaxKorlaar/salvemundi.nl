<?php

    namespace App\Http\Controllers;

        use App\Http\Requests\Signup;
        use Illuminate\Http\Request;

        /**
         * Class SignupController
         *
         * @package App\Http\Controllers
         */
        class SignupController extends Controller {

            /**
             * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
             */
            public function index() {
                return view('signup');
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
             */
            public function signup(Request $request) {
                if($request->old('pcn') === null) return back(); // Stuur de gebruiker weg als er geen inschrijfgegevens in de sessie zitten



                dd($request->old(), $request->all());
            }
        }
