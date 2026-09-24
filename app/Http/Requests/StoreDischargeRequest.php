<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDischargeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'admission_id' => 'required|exists:admissions,id',
            'discharge_date' => 'required|date',
            'discharge_time' => 'required',
            'diagnosis' => 'required|string',
            'treatment_summary' => 'required|string',
            'instructions' => 'required|string',
        ];
    }
}
