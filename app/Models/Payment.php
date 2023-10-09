<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

// Egy vásárló által történt fizetés vagy annak kísérlete
class Payment extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'user_id', // Melyik vásárló fizetett
        'total', // Összesen mennyit kellett fizetnie
        'items', // Mely termékeket vásárolta meg
        'invoice', // Vásárló személyes adatai, ami a vásárlás azonosításához szükséges
        'order_ref', // Egy olyan egyedi azonosító, ami az OTP rendszerében is egyedi
        'transaction_id', // OTP által visszaküldött tranzakció azonosító
        'error', // Tranzakció során történő hibák esetén ezen hibák azonosítója
        'result', // Fizetés eredménye (SUCCESS, ERROR, TIMEOUT, CANCEL)
        'finished' // Ha véglegesen lezárult a fizetés és sikeres volt, akkor 1 az eredménye
    ];

    // Naplózás beállítása
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    // Vásárláshoz tartozó kosarak
    public function carts(): HasMany {
        return $this->hasMany(Cart::class);
    }
}