<?php

    namespace App\Http\Controllers;
    use Illuminate\Http\Request;

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

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getPartyPage() {
            return view('committees.party');
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getMediaPage() {
            return view('committees.media');
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getCampingPage() {
            return view('committees.camping');
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getWomenPage() {
            return view('committees.women');
        }

    }
