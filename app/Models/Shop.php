<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

// Üzlet adatai
class Shop extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name', // Üzlet neve
        'summary', // Üzlet rövid jellemzése
        'body', // Üzlet bővebb jellemzése
        'address', // Üzlet földrajzi címe
        'url', // Üzlet URL címe
        'email', // Üzlet e-mail címe
        'telephone', // Üzlet telefonszáma
        'latitude', // Földrajzi szélesség
        'longitude' // Földrajzi hosszúság
    ];

    // Naplózás beállítása
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    // Bolthoz tartozó állások
    public function positions(): HasMany {
        return $this->hasMany(Position::class);
    }

    // Bolthoz tartozó felhasználók
    public function users() {
        $this->load('positions.users');
        return $this->positions->pluck('users')->collapse();
    }

    // Bolthoz tartozó termékek
    public function products(): HasMany {
        return $this->hasMany(Product::class);
    }

    // Bolthoz tartozó kifizetett kosarak
    public function payed_carts() {
        $collection = collect();
        foreach ($this->products AS $product) {
            $payed_carts = $product->payed_carts;
            $payed_carts->load('product');
            $payed_carts->load('payment');
            $payed_carts->load('user');
            $collection->push($payed_carts);
        }
        return $collection;
    }

}
