<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

// Felhasználóhoz rendelt szerepkör
class UserRole extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'user_id', // Felhasználó azonosítója
        'role_id' // Felhasználóhoz rendelt szerepkör azonosítója
    ];

    // Naplózás beállítása
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }
}
