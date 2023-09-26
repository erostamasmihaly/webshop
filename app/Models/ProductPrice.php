<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ProductPrice extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'product_id',
        'size_id',
        'quantity',
        'price',
        'vat',
        'discount'
    ];

    // Naplózás beállítása
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    // Mérethez tartozó kategória
    public function size(): BelongsTo {
        return $this->belongsTo(Category::class);
    }
}
