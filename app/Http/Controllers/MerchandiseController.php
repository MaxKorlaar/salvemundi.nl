<?php
    /**
     * Created by PhpStorm.
     * User: Niek van Gogh
     * Date: 11/7/2018
     * Time: 11:13 PM
     */

    namespace App\Http\Controllers;

    use Illuminate\Contracts\View\Factory;
    use Illuminate\View\View;

    /**
     * Class MerchandiseController
     *
     * @deprecated
     *
     * @package App\Http\Controllers
     */
    class MerchandiseController extends Controller {


        /**
         * @return Factory|View
         */
        public static function getMerchandise() {
            return view('merchandise');
        }

        /**
         * @return Factory|View
         */
        public static function getVests() {
            return view('merchandise', [
                "product" => "vest",
                "data"    => [
                    "translation_url" => "merchandise.items.vests",
                    "image_url"       => "images/merch/vest.png"
                ]
            ]);
        }

        /**
         * @return Factory|View
         */
        public static function getShirts() {
            return view('merchandise', [
                "product" => "shirts",
                "data"    => [
                    "translation_url" => "merchandise.items.shirts",
                    "image_url"       => "images/merch/shirt.png"
                ]
            ]);
        }

    }