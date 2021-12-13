<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreVCardRequest extends FormRequest
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
            'phone_number' => 'required|string|max:9',
            'name' => 'required|string|max:50',
            'email' => 'required|email',
            'photo_url' => 'nullable|string|file',
            'password' => 'required|string',
            'confirmation_code' => 'required|string|max:50',
            'blocked' => 'required|numeric',
            'balance' => 'required|numeric',
            'max_debit' => 'required|numeric',
<<<<<<< HEAD
            'custom_data' => 'nullable|json'
=======
                        'custom_data' => 'nullable|json'

>>>>>>> TAES21GU-23-savings
        ];
    }
}