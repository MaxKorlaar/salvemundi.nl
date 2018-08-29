<?php

    namespace App\Http\Requests\Admin;

    use Illuminate\Foundation\Http\FormRequest;

    /**
     * Class CreateMember
     *
     * @package App\Http\Requests\Admin
     */
    class CreateMember extends FormRequest {
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
                'member_id'        => 'integer',
                'first_name' => 'required|string|max:150',
                'last_name'  => 'required|string|max:150',
                'address'    => 'required|min:5|max:150',
                'city'       => 'required|min:3|max:150',
                'postal'     => 'required|string|size:6|regex:/^[0-9]{4}[A-Za-z]{2}$/',
                'birthday'   => 'required|date|before:-14 years',
                'phone'      => 'required|max:15',
                'email'      => 'required|email',
                'picture'    => 'file|image|required|max:5000|dimensions:min_width=200,min_height=300'
            ];
        }
    }
