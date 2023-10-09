<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

// Azon termékek, amelyeket a vásárló kedvencnek jelölt. Ezen termékek külön megjelennek a Vásárló oldalán.
class Favourite extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'user_id', // Azon vásárló, aki létrehozta a kedvelést
        'product_id' // Azon termék, amelyet a vásárló kedvencnek jelölt
    ];

    // Naplózás beállítása
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    // Terméket kedvelő vásárló
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    // Vásálró által kedvelt termék
    public function product(): BelongsTo {
        return $this->belongsTo(Product::class);
    }
}
