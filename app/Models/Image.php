<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

// Azon képek, amelyek egy termékhez tartoznak
class Image extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'filename', // Fájl neve
        'sequence', // Adott terméken belül tartozó képek esetén a sorrend
        'is_main', // Ha 1, akkor ezen kép van beállítva, mint vezérkép
        'product_id' // Melyik termékhez tartozó kép
    ];

    // Naplózás beállítása
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }
}
