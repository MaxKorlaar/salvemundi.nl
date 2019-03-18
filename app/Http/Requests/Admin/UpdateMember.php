<?php

    namespace App\Http\Requests\Admin;

    use App\Member;
    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;

    /**
     * Class UpdateMember
     *
     * @package App\Http\Requests\Admin
     */
    class UpdateMember extends FormRequest {
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
                'pcn'           => 'required|integer',
                'member_id'     => 'required|integer',
                'first_name'    => 'required|string|max:150',
                'last_name'     => 'required|string|max:150',
                'address'       => 'required|min:5|max:150',
                'city'          => 'required|min:3|max:150',
                'postal'        => 'required|string',
                'country'       => [
                    'required',
                    Rule::in(array_keys(trans('address.country')))
                ],
                'birthday'      => 'required|date|before:-14 years',
                'phone'         => 'required|max:15',
                'email'         => 'required|email',
                'card_status'   => [
                    'required',
                    Rule::in([Member::CARD_PROCESSED, Member::CARD_UNPROCESSED, Member::CARD_NOT_PICKED_UP, Member::CARD_RECEIVED, Member::NO_CARD])
                ],
                'card_id'       => 'integer|nullable',
                'picture'       => 'file|image|max:5000|dimensions:min_width=200,min_height=300',
                'permissions'   => 'array',
                'permissions.*' => 'boolean'
            ];
        }
    }
