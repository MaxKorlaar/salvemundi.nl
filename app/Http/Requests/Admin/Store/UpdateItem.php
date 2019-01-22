<?php

namespace App\Http\Requests\Admin\Store;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateItem
 *
 * @package App\Http\Requests\Admin\Store
 */
class UpdateItem extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required|string|max:150',
            'description' => 'nullable|string|max:6000',
        ];
    }
}
