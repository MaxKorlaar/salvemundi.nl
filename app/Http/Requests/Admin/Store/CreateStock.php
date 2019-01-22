<?php

    namespace App\Http\Requests\Admin\Store;

    use Illuminate\Foundation\Http\FormRequest;

    /**
     * Class CreateStock
     *
     * @package App\Http\Requests\Admin\Store
     */
    class CreateStock extends FormRequest {
        /**
         * Determine if the user is authorized to make this request.
         *
         * @return bool
         */
        public function authorize() {
            return true;
        }

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules() {
            return [
                'name'        => 'required|string|max:150',
                'description' => 'nullable|string|max:6000',
                'price'       => 'required|numeric|min:0.30|max:500',
                'images'      => 'required|array',
                'images.*'    => 'file|image|required|max:10000|dimensions:min_width=200,min_height=300'
            ];
        }
    }
