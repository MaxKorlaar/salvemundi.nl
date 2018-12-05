<?php
    /**
     * Created by PhpStorm.
     * User: Niek van Gogh
     * Date: 11/7/2018
     * Time: 11:13 PM
     */

    namespace App\Http\Controllers;

    /**
     * Class MerchandiseController
     *
     * @package App\Http\Controllers
     */
    class MerchandiseController extends Controller {


        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getMerchandise() {
            return view('merchandise');
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getVests() {
            return view('merchandise', [
                "product" => "vest",
                "data"    => [
                    "translation_url" => "merchandise.items.vests",
                    "image_url"       => "images/merch/vest.png"
                ]
            ]);
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getShirts() {
            return view('merchandise', [
                "product" => "shirts",
                "data"    => [
                    "translation_url" => "merchandise.items.shirts",
                    "image_url"       => "images/merch/shirt.png"
                ]
            ]);
        }

    }