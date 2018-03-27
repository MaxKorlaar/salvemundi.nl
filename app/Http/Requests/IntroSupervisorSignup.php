<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    /**
     * Class IntroSupervisorSignup
     *
     * @package App\Http\Requests
     */
    class IntroSupervisorSignup extends FormRequest {
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
                'member_id'                      => 'required|integer',
                'first_name'                     => 'required|string|max:150',
                'last_name'                      => 'required|string|max:150',
                'phone'                          => 'required|max:15',
                'email'                          => 'required|email|confirmed',
                'age_at_intro'                   => 'required|integer|min:18',
                'shirt_size'                     => 'required|in:' . join(",", trans('intro.signup.shirt_sizes')),
                'preferred_partner_id'           => 'nullable|integer',
                'remain_sober'                   => 'boolean',
                'drivers_license'                => 'boolean',
                'first_aid_license'              => 'boolean',
                'company_first_response_license' => 'boolean',
                'route_type'                     => 'required|in:' . join(",", trans('intro.supervisor.signup.routes')),
                'remarks'                        => 'nullable|string|max:1500',
                'agree_salvemundi'               => 'accepted',
                'agree_intro_terms'              => 'accepted',
            ];
        }

        /**
         * Get custom attributes for validator errors.
         *
         * @return array
         */
        public function attributes() {
            return [
                'member_id'    => trans('intro.supervisor.signup.member_id'),
                'age_at_intro' => trans('intro.supervisor.signup.age_at_intro')
            ];
        }
    }
