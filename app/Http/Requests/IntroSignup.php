<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;

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
                'phone'            => 'required|max:15|different:contact_phone',
                'contact_name'     => 'required|max:150',
                'contact_relation' => 'required|max:150',
                'contact_phone'    => 'required|max:15|different:phone',
                'email'            => 'required|email|confirmed',
                'birthday'         => 'required|date|before:-15 years',
                'shirt_size'       => 'required|in:' . join(",", trans('intro.signup.shirt_sizes')),
                'alcohol'          => 'boolean',
                'extra_shirt'      => 'boolean',
                'same_sex_rooms'   => 'boolean',
                'remarks'          => 'nullable|string|max:1500',
                'gender'           => 'required|in:' . join(",", trans('intro.signup.genders')),
                'address'          => 'required|min:3|max:150',
                'city'             => 'required|min:3|max:150',
                'postal'           => 'required|string',
                'country'          => [
                    'required',
                    Rule::in(array_keys(trans('address.country')))
                ],
                'agree_salvemundi' => 'accepted',
                //                'agree_buitenjan'  => 'required|boolean'
            ];
        }

        /**
         * Get custom messages for validator errors.
         *
         * @return array
         */
        public function messages() {
            return [
                'agree_salvemundi.required' => trans('intro.signup.errors.agree_salvemundi'),
                'agree_buitenjan.required'  => trans('intro.signup.errors.agree_buitenjan'),
                'birthday.before'           => trans('intro.signup.errors.minimum_age_not_met')
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
                'contact_phone'    => trans('intro.signup.contact_phone'),
                'contact_name'     => trans('intro.signup.contact_name'),
                'contact_relation' => trans('intro.signup.contact_relation')
            ];
        }
    }
