<?php

    namespace App\Http\Requests\Member;

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;

    /**
     * Class UpdateOwnInfo
     *
     * @package App\Http\Requests\Member
     */
    class UpdateOwnInfo extends FormRequest {
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
                'country' => [
                    Rule::in(array_keys(trans('address.country')))
                ],
            ];
        }
    }
