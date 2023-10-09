<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

// OTP tranzakció hibák - az OTP dokumentációjából kimásolva!
class SimplePayError extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'message' // Tranzakciós hibakódhoz tartozó üzenet
    ];

    // Naplózás beállítása
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }
}
