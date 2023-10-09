<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

// Munkakör, állás
class Position extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'shop_id', // Munkakört létrehozó üzlet azonosítója
        'name', // Munkakör neve
        'summary', // Munkakör rövid leírása
        'body' // Munkakör részletes leírása
    ];

    // Naplózás beállítása
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    // Munkakört betöltő felhasználók
    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class,'user_positions');
    }
}
