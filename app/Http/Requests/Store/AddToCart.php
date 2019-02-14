<?php

    namespace App\Http\Requests\Store;

    use Illuminate\Foundation\Http\FormRequest;

    /**
     * Class AddToCart
     *
     * @package App\Http\Requests\Store
     */
    class AddToCart extends FormRequest {
        /**
         * Determine if the user is authorized to make this request.
         *
         * @return bool
         */
        public static function authorize() {
            return true;
        }

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public static function rules() {
            return [
                'item'          => 'required|exists:store_items,id',
                'stock_variant' => 'required|exists:store_stock,id',
                'amount'        => 'required|integer|min:1|max:100',
            ];
        }
    }
