<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'name',
        'generic_name',
        'category',
        'manufacturer',
        'unit_price',
        'stock_quantity',
        'expiry_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'stock_quantity' => 'integer',
            'expiry_date' => 'date',
        ];
    }

    public function prescriptionItems(): HasMany
    {
        return $this->hasMany(PrescriptionItem::class);
    }

    public function isLowStock(int $threshold = 20): bool
    {
        return $this->stock_quantity <= $threshold;
    }

    public function isExpired(): bool
    {
        return $this->expiry_date->isPast();
    }
}
