<?php

// MÁR NEM HASZÁLT! HELYETTE: UserPosition

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class UserShop extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'user_id',
        'position_id'
    ];

    // Naplózás beállítása
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }
}
