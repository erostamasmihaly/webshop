<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

// Szerepkör, amit a felhasználóhoz hozzá lehet rendelni
class Role extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name' // Szerepkör neve
    ];

    // Naplózás beállítása
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }
}
