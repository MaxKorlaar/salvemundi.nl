<?php
    /**
     * Created by PhpStorm.
     * User: Niek
     * Date: 29-11-2018
     * Time: 01:11
     */

    namespace App\Http\Controllers;

    use Illuminate\Contracts\View\Factory;
    use Illuminate\View\View;

    /**
     * Class DiscountController
     *
     * @package App\Http\Controllers
     */
    class DiscountController extends Controller {

        /**
         * @return Factory|View
         */
        public static function getDefaultView() {
            return view('discounts');
        }

        /**
         * @return Factory|View
         */
        public static function getHappiView() {
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
         * @return Factory|View
         */
        public static function getVillaView() {
            return view('discounts',
                [
                    'title'     => trans('discounts.villa_fiesta.title'),
                    'image_url' => "images/promo/villa.svg",
                    'text'      => trans('discounts.villa_fiesta.text')
                ]
            );
        }

    }