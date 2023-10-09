<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

// Kategóriák, amelyek különféle kategória csoportok tartoznak
class Category extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name', // Kategória neve
        'category_id', // Ha van szülő, akkor a szülő kategória azonosítója
        'category_group_id', // Melyik kategória csoporthoz tartozik
        'sequence' // Adott kategória csoporton belüli sorrendje
    ];

    // Naplózás beállítása
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }
}
