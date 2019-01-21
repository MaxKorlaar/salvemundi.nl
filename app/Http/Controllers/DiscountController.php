<?php
    /**
     * Created by PhpStorm.
     * User: Niek
     * Date: 29-11-2018
     * Time: 01:11
     */

    namespace App\Http\Controllers;

    /**
     * Class DiscountController
     *
     * @package App\Http\Controllers
     */
    class DiscountController extends Controller {

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getDefaultView() {
            return view('discounts');
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getHappiView() {
            return view('discounts',
                [
                    'title'     => trans('discounts.happii.title'),
                    'image_url' => "images/promo/happii.svg",
                    'discounts' => trans('discounts.happii.discounts'),
                    'text'      => trans('discounts.happii.text')
                ]
            );
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getVillaView() {
            return view('discounts',
                [
                    'title'     => trans('discounts.villa_fiesta.title'),
                    'image_url' => "images/promo/villa.svg",
                    'text'      => trans('discounts.villa_fiesta.text')
                ]
            );
        }

    }