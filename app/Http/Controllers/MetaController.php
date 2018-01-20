<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;

    /**
     * Class MetaController
     *
     * @package App\Http\Controllers
     */
    class MetaController extends Controller {
        /**
         * @param Request $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getPrivacyPage(Request $request) {
            return view('privacy');
        }
    }
