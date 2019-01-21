<?php

namespace App\Http\Requests\Store;

use App\Http\Controllers\StoreController;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PayCart
 *
 * @package App\Http\Requests\Store
 */
class PayCart extends FormRequest
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

        $banks = StoreController::getIdealBanks();
        return [
            'ideal_bank' => 'required|string|in:' . $banks->implode('id', ',')
        ];
    }
}
