<?php

    namespace App\Http\Requests\Admin;

    use Illuminate\Foundation\Http\FormRequest;

    /**
     * Class SendMailToMembers
     *
     * @package App\Http\Requests\Admin
     */
    class SendMailToMembers extends FormRequest {
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
                'message_content' => 'required|string|min:50|max:5000',
                'subject'         => 'required|min:5|max:40|string'
            ];
        }
    }
