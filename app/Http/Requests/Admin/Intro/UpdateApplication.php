<?php

    namespace App\Http\Requests\Admin\Intro;

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;

    /**
     * Class UpdateApplication
     *
     * @package App\Http\Requests\Admin\Intro
     */
    class UpdateApplication extends FormRequest {
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
                'pcn'              => 'nullable|integer',
                'first_name'       => 'required|string|max:150',
                'last_name'        => 'required|string|max:150',
                'phone'            => 'required|max:15|different:contact_phone',
                'contact_name'     => 'required|max:150',
                'contact_relation' => 'required|max:150',
                'contact_phone'    => 'required|max:15|different:phone',
                'email'            => 'required|email',
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
            ];
        }
    }
