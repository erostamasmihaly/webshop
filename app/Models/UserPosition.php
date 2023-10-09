<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

// Felhasználókhoz rendelt munkakörök
class UserPosition extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'user_id', // Felhasználó azonosítója
        'position_id' // Felhasználóhoz rendelt munkakör azonosítója
    ];

    // Naplózás beállítása
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    // Munkakörhöz tartozó felhasználó
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
