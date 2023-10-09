<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

// Azon kategória csoportok, amelyek olyan kategóriákat tartalmaznak, amiket hozzá lehet rendelni a termékekhez és az adott terméket jellemzik, továbbá ezek által a termékeket például szűrni is lehet
class CategoryGroup extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name' // Kategória csoport neve
    ];

    // Naplózás beállítása
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    // Lekérdezni a hozzá tartozó kategóriákat
    public function categories(): HasMany {
        return $this->hasMany(Category::class)->orderBy('sequence');
    } 
}
