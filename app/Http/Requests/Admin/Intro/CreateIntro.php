<?php

    namespace App\Http\Requests\Admin\Intro;

    use Illuminate\Foundation\Http\FormRequest;

    /**
     * Class CreateIntro
     *
     * @package App\Http\Requests\Admin\Intro
     */
    class CreateIntro extends FormRequest {
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
                'reservations_open'              => 'required|date|after:-3 months',
                'mail_reservations'              => 'boolean',
                'allow_reservations_after_limit' => 'boolean',
                'signup_open'                    => 'required|date|after:-2 months',
                'signup_close'                   => 'required|date|after:-1 month',
                'year_id'                        => 'required|exists:years,id',
                'price'                          => 'required|numeric|min:0|max:500',
                'max_signups'                    => 'required|integer|min:1',
            ];
        }
    }
