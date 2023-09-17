<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ProductCategory extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'product_id',
        'category_group_id',
        'category_id'
    ];

    // Naplózás beállítása
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    // Kategóriák lekérdezése
    public function category():BelongsTo {
        return $this->belongsTo(Category::class);
    } 
}
