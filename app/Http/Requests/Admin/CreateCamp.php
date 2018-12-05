<?php

    namespace App\Http\Requests\Admin;

    use Illuminate\Foundation\Http\FormRequest;

    /**
     * Class CreateCamp
     *
     * @package App\Http\Requests\Admin
     */
    class CreateCamp extends FormRequest {
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
                'signup_open'  => 'required|date',
                'signup_close' => 'required|date',
                'year_id'      => 'required|exists:years,id',
                'price'        => 'required|numeric|min:0|max:200',
            ];
        }
    }
