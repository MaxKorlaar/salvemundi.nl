<?php

    namespace App\Http\Controllers;

    /**
     * Class CommitteeController
     *
     * @package App\Http\Controllers
     */
    class CommitteeController extends Controller {
        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getAdministrationPage() {
            return view('committees.administration');
        }
    }
