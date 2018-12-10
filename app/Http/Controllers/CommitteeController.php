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

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function get2017() {
            return view('committees.administration',
                [
                    'administration_title' => trans('committee.administration.administration_versions.2017.title'),
                    'administration_text' => trans('committee.administration.administration_versions.2017.text'),
                    'administration_image' => 'images/bestuur_2017.jpg',
                    'administration_caption' => trans('committee.administration.administration_versions.2017.caption')
                ]);
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function get2018() {
            return view('committees.administration',
                [
                    'administration_title' => trans('committee.administration.administration_versions.2018.title'),
                    'administration_text' => trans('committee.administration.administration_versions.2018.text'),
                    'administration_image' => 'images/bestuur_2018.jpg',
                    'administration_caption' => trans('committee.administration.administration_versions.2018.caption')
                ]);
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
        public function getActivityPage() {
            return view('committees.activity');
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getStudyPage() {
            return view('committees.study');
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getInternalAffairsPage() {
            return view('committees.internal_affairs');
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getExternalAffairsPage() {
            return view('committees.external_affairs');
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getAlphaCentauriPage() {
            return view('committees.alpha_centauri');
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getTreasurePage() {
            return view('committees.treasure');
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getVacanciesPage() {
            return view('committees.vacancies');
        }

    }
