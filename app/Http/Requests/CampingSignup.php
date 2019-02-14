<?php

    namespace App\Http\Requests;

    use Auth;
    use Illuminate\Foundation\Http\FormRequest;

    /**
     * Class CampingSignup
     *
     * @package App\Http\Requests
     */
    class CampingSignup extends FormRequest {
        /**
         * Determine if the user is authorized to make this request.
         *
         * @return bool
         */
        public static function authorize() {
            if (Auth::check()) {
                $member = Auth::user()->member;
                return $member->isCurrentlyMember();
            }
            return false;
        }

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public static function rules() {
            return [
                'remarks' => 'nullable|string|max:1500',
                //'agree_salvemundi' => 'accepted',
            ];
            /*
             return [
                'member_id'  => 'required|integer',
                'first_name' => 'required|string|max:150',
                'last_name'  => 'required|string|max:150',
                'phone'      => 'required|max:15',
                'email'      => 'required|email|confirmed',
                //                'agree_salvemundi' => 'required|boolean',
                //                'agree_buitenjan' => 'required|boolean'
                'address'    => 'required|min:3|max:150',
                'city'       => 'required|min:3|max:150',
                'postal'     => 'required|string|size:6|regex:/^[0-9]{4}[A-Za-z]{2}$/',
                'remarks'    => 'nullable|string|max:1500',
                'birthday'   => 'required|date|before:-16 years',
                'agree_salvemundi' => 'accepted',
            ];
             */

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
                'birthday.before'           => trans('camping.signup.errors.minimum_age_not_met')
            ];
        }

        /**
         * Get custom attributes for validator errors.
         *
         * @return array
         */
        public function attributes() {
            return [
                'agree_salvemundi' => trans('camping.signup.terms'),
                'agree_buitenjan'  => trans('camping.signup.terms'),
                'member_id'        => trans('camping.signup.member_id')
            ];
        }
    }
