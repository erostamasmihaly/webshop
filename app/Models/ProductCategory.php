<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

// Termék hozzárendelése különféle kategóriákhoz
class ProductCategory extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'product_id', // Termék azonosítója
        'category_id', // Termékhez rendelt kategória azonosítója
        'category_group_id' // Azon kategória csoport, ami a kategóriához tartozik (Ez inkább a könnyebb keresés és gyorsabb lekérdezés miatt van itt eltárolva)
    ];

    // Naplózás beállítása
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    // Kategóriák lekérdezése, ami a termékhez tartozik
    public function category():BelongsTo {
        return $this->belongsTo(Category::class);
    } 

    // Termék lekérdezése
    public function product():BelongsTo {
        return $this->belongsTo(Product::class);
    } 
}
