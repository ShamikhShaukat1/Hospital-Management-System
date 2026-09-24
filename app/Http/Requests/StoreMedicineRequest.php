<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'generic_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'unit_price' => 'required|numeric|min:0.01',
            'stock_quantity' => 'required|integer|min:0',
            'expiry_date' => 'required|date|after:today',
            'status' => 'required|in:active,inactive',
        ];
    }
}
