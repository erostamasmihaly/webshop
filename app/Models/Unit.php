<?php

namespace App\Models;

// MÁR NEM HASZÁLT! HELYETTE: CategoryGroup és Category

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

// Termékhez rendelhető mértékegység
// !! MÁR NEM HASZNÁLT, HELYETTE: külön kategória csoport és a hozzá tartozó kategóriák alkalmazása
class Unit extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name' // Méret neve
    ];

    // Naplózás beállítása
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }
}
