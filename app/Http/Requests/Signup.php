<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

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
                'pcn'        => 'required|integer',
                'first_name' => 'required|string|max:150',
                'last_name'  => 'required|string|max:150',
                'address'    => 'required|min:5|max:150',
                'city'       => 'required|min:3|max:150',
                'postal'     => 'required|string|size:6|regex:/^[0-9]{4}[A-Za-z]{2}$/',
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


    }
