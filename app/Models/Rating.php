<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

// Egy termék értékelése a vásárló által
class Rating extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'user_id', // Értékelést végrehajtó felhasználó azonosítója
        'product_id', // Értékelt termék azonosítója
        'stars', // Hány csillagra lett a termék értékelve
        'title', // Értékelés címe
        'body', // Értékelés szövege
        'moderated' // Ha 1, akkor az értékelés publikus
    ];

    // Naplózás beállítása
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    // Értékeléshez tartozó felhasználó
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    // Értékeléshez tartozó termék
    public function product(): BelongsTo {
        return $this->belongsTo(Product::class);
    }
}