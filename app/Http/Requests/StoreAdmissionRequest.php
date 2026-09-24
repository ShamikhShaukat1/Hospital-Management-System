<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'room_id' => 'required|exists:rooms,id',
            'bed_id' => 'required|exists:beds,id',
            'admission_date' => 'required|date',
            'admission_time' => 'required',
            'reason' => 'required|string|max:255',
            'diagnosis' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ];
    }
}
