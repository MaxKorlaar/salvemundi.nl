<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;

    /**
     * Class Signup
     *
     * @package App\Http\Requests
     */
    class Signup extends FormRequest {
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
                'pcn'        => 'required|integer',
                'first_name' => 'required|string|max:150',
                'last_name'  => 'required|string|max:150',
                'address'    => 'required|min:5|max:150',
                'city'       => 'required|min:3|max:150',
                'postal'     => 'required|string',
                'country'    => [
                    'required',
                    Rule::in(array_keys(trans('address.country')))
                ],
                'birthday'   => 'required|date|before:-16 years',
                'phone'      => 'required|max:15',
                'email'      => 'required|email|confirmed',
            ];
        }

        /**
         * Get custom messages for validator errors.
         *
         * @return array
         */
        public function messages() {
            return [
                'birthday.before' => trans('signup.errors.minimum_age_not_met'),
            ];
        }

        /**
         * Get custom attributes for validator errors.
         *
         * @return array
         */
        public function attributes() {
            return [
                'agree_salvemundi' => trans('signup.terms')
            ];
        }


    }
