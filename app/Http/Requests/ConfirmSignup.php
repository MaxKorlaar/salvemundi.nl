<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    /**
     * Class ConfirmSignup
     *
     * @package App\Http\Requests
     */
    class ConfirmSignup extends FormRequest {
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
                'picture' => 'file|image|required|max:5000|dimensions:min_width=200,min_height=300'
            ];
        }

        /**
         * Get custom attributes for validator errors.
         *
         * @return array
         */
        public function attributes() {
            return [
                'picture' => trans('signup.picture')
            ];
        }
    }
