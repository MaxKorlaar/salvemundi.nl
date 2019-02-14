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
                'gender'                         => 'required|in:' . join(",", trans('intro.supervisor.signup.genders')),
                'age_at_intro'                   => 'required|integer|min:18',
                'shirt_size'                     => 'required|in:' . join(",", trans('intro.signup.shirt_sizes')),
                'preferred_partner_id'           => 'nullable|integer',
                'remain_sober'                   => 'boolean',
                'drivers_license'                => 'boolean',
                //                'first_aid_license'              => 'boolean',
                'company_first_response_license' => 'required|in:' . join(",", trans('intro.supervisor.signup.first_response')),
                'route_type'                     => 'required|in:' . join(",", trans('intro.supervisor.signup.routes')),
                'previously_participated_as'     => 'required|in:' . join(",", trans('intro.supervisor.signup.previous_years')),
                'active_in_association'          => 'required|in:' . join(",", trans('intro.supervisor.signup.active_as')),
                'active_as_other'                => 'nullable|string|max:150|required_if:active_in_association,' . array_last(trans('intro.supervisor.signup.active_as')),
                'motivation'                     => 'required|string|max:500',
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
                'member_id'                      => trans('intro.supervisor.signup.member_id'),
                'age_at_intro'                   => trans('intro.supervisor.signup.age_at_intro'),
                'motivation'                     => trans('intro.supervisor.signup.motivation'),
                'route_type'                     => trans('intro.supervisor.signup.route_type'),
                'previously_participated_as'     => trans('intro.supervisor.signup.previously_participated_as'),
                'company_first_response_license' => trans('intro.supervisor.signup.company_first_response_license'),
                'active_as_other'                => trans('intro.supervisor.signup.active_as_other'),
                'active_in_association'          => trans('intro.supervisor.signup.active_in_association')
            ];
        }
    }
