<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

// Kosár bejegyzések
class Cart extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'user_id', // Azon felhasználó azonosítója, akihez a kosár tartozik
        'product_id', // Azon termék azonosítója, amit a vásárló meg akar venni 
        'payment_id', // Ha kifizette ezen terméket, akkor annak az azonosítója, különben pedig NULL
        'size_id', // Milyen méretben szeretné a vásárló megvenni a terméket
        'quantity', // Azon mennyiség, amennyit a vásárló meg akar venni
        'price' // Amikor kifizette a terméket a vásárló, akkor a termék mennyibe került
    ];

    // Naplózás beállítása
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    // Kosár terméke
    public function product(): BelongsTo {
        return $this->belongsTo(Product::class);
    }

    // Kosárhoz tartozó fizetés
    public function payment(): BelongsTo {
        return $this->belongsTo(Payment::class);
    }

    // Kosárhoz tatozó vásárló
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
