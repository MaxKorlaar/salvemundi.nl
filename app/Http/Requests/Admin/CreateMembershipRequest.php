<?php

    namespace App\Http\Requests\Admin;

    use Illuminate\Foundation\Http\FormRequest;

    /**
     * Class CreateMembershipRequest
     *
     * @package App\Http\Requests\Admin
     */
    class CreateMembershipRequest extends FormRequest {
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
                'valid_from'  => 'required|date',
                'valid_until' => 'required|date',
            ];
        }
    }
