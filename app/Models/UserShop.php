<?php

// MÁR NEM HASZÁLT! HELYETTE: UserPosition

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

// Felhasználóhoz rendelt üzlet
// !! MÁR NEM HASZNÁLT, HELYETTE: egy munkakör egy üzlethez tartozik és ezen munkakör van hozzárendelve a felhasználóhoz 
class UserShop extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'user_id', // Felhasználó azonosítója 
        'shop_id' // Azon üzlet azonosítója, amihez a felhasználó tartozik
    ];

    // Naplózás beállítása
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }
}
