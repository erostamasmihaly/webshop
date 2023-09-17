<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Cart extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'user_id',
        'product_id',
        'payment_id',
        'quantity',
        'price'
    ];

    // Naplózás beállítása
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    // Kosár terméke
    public function product(): BelongsTo {
        return $this->belongsTo(Product::class);
    }
}
