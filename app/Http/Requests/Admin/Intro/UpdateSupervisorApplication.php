<?php

    namespace App\Http\Requests\Admin\Intro;

    use Illuminate\Foundation\Http\FormRequest;

    /**
     * Class UpdateSupervisorApplication
     *
     * @package App\Http\Requests\Admin\Intro
     */
    class UpdateSupervisorApplication extends FormRequest {
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
                'company_first_response_license' => 'required|in:' . join(",", trans('intro.supervisor.signup.first_response')),
                'route_type'                     => 'required|in:' . join(",", trans('intro.supervisor.signup.routes')),
                'previously_participated_as'     => 'required|in:' . join(",", trans('intro.supervisor.signup.previous_years')),
                'active_in_association'          => 'required|string|max:150',
                'motivation'                     => 'required|string|max:500',
                'remarks'                        => 'nullable|string|max:1500',
            ];
        }
    }
