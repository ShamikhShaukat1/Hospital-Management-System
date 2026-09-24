<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Discharge extends Model
{
    use HasFactory;

    protected $fillable = [
        'discharge_id',
        'admission_id',
        'patient_id',
        'doctor_id',
        'discharge_date',
        'discharge_time',
        'diagnosis',
        'treatment_summary',
        'instructions',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'discharge_date' => 'date',
        ];
    }

    public function admission(): BelongsTo
    {
        return $this->belongsTo(Admission::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
