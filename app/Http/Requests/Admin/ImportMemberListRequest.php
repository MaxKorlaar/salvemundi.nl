<?php

    namespace App\Http\Requests\Admin;

    use Illuminate\Foundation\Http\FormRequest;

    /**
     * Class ImportMemberListRequest
     *
     * @package App\Http\Requests\Admin
     */
    class ImportMemberListRequest extends FormRequest {
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
                'member-list' => 'required|file'
            ];
        }
    }
