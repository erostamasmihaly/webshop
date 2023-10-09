<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

// Az adott termék milyen méretben és mennyibe is kerül, valamint milyen mennyiségben érhető el
class ProductPrice extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'product_id', //Termék azonosítója
        'size_id', // Termél méretének azonosítója
        'quantity', // Ezen termék a megadott méretben milyen mennyiségben érhető el
        'price', // Termék nettó ára
        'vat', // ÁFA
        'discount', // Kedvezmény nagysága
        'brutto_price', // Bruttó ár (Számolt érték)
        'discount_price' // Kedfvezményes ár (Számolt érték - ez kerül publikálásra és lesz felhasználva fizetés esetén is)
    ];

    // Naplózás beállítása
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    // Mérethez tartozó kategória (pl: ruhaméret > L, XL, ...; cipőméret > 34, 35, ...)
    public function size(): BelongsTo {
        return $this->belongsTo(Category::class);
    }
}
