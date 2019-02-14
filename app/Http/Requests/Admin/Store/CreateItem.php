<?php

    namespace App\Http\Requests\Admin\Store;

    use Illuminate\Foundation\Http\FormRequest;

    /**
     * Class CreateItem
     *
     * @package App\Http\Requests\Admin\Store
     */
    class CreateItem extends FormRequest {
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
                'name'        => 'required|string|max:150',
                'description' => 'nullable|string|max:6000',
            ];
        }
    }
