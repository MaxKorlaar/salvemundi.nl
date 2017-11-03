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
             */
            public function signup(Signup $request) {
                dd($request->all());
            }
        }
