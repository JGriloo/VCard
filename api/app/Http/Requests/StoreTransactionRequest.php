<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
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
            'vcard' => 'required|string|max:9|exists:vcards,phone_number',
            'date' => 'required|date',
            'datetime' => 'required|date',
            'type' => 'required|in:C,D',
            'value' => 'required|numeric',
            'old_balance' => 'required|numeric',
            'new_balance' => 'required|numeric',
            'payment_type' => 'required|string|exists:payment_types,code',
            'payment_reference' => 'required|string',
            'pair_transaction' => 'nullable|numeric|exists:transactions,id',
            'pair_vcard' => 'nullable|string|max:9|exists:vcards,phone_number',
            'category_id' => 'nullable|integer|exists:categories,id',
            'description' => 'nullable|string|max:50',
<<<<<<< HEAD
            'custom_data' => 'nullable|json'
=======
            'custom_data' => 'nullable|json',
>>>>>>> 2b051026b75e280f09607fa3e9db532d3067424a
        ];
    }
}
