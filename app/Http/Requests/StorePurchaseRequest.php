<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => ['required','exists:clients,id'],
            'product_id' => ['required','exists:products,id'],
            'quantity' => ['required','integer','min:1','max:100'],
            'purchased_at' => ['required','date'],
            'notes' => ['nullable','string','max:255','regex:/^[^<>]*$/'],
        ];
    }
}
