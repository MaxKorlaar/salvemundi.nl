<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    /**
     * Class IntroSignup
     *
     * @package App\Http\Requests
     */
    class IntroSignup extends FormRequest {
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
                'pcn'              => 'nullable|integer',
                'first_name'       => 'required|string|max:150',
                'last_name'        => 'required|string|max:150',
                'phone'            => 'required|max:15',
                'contact_phone'    => 'required|max:15',
                'email'            => 'required|email|confirmed',
                'birthday'         => 'required|date|before:-15 years',
                'shirt_size'       => 'required|in:' . join(",", trans('intro.signup.shirt_sizes')),
                'alcohol'          => 'boolean',
                'extra_shirt'      => 'boolean',
                'same_sex_rooms'   => 'boolean',
                'remarks'          => 'nullable|string|max:1500',
                'gender'           => 'required|in:' . join(",", trans('intro.signup.genders')),
                'address' => 'required|min:3|max:150',
                'city'    => 'required|min:3|max:150',
                'postal'  => 'required|string|size:6|regex:/^[0-9]{4}[A-Za-z]{2}$/',
                'agree_salvemundi' => 'required|boolean',
                'agree_buitenjan'  => 'required|boolean'
            ];
        }

        /**
         * Get custom messages for validator errors.
         *
         * @return array
         */
        public function messages() {
            return [
                'agree_salvemundi.required' => trans('camping.signup.errors.agree_salvemundi'),
                'agree_buitenjan.required'  => trans('camping.signup.errors.agree_buitenjan'),
            ];
        }

        /**
         * Get custom attributes for validator errors.
         *
         * @return array
         */
        public function attributes() {
            return [
                'agree_salvemundi' => trans('intro.signup.terms'),
                'agree_buitenjan'  => trans('intro.signup.terms'),
                'remarks'          => trans('intro.signup.remarks'),
                'contact_phone'    => trans('intro.signup.contact_phone')
            ];
        }
    }
