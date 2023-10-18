<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

// Termékek adatai
class Product extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name', // Termék neve
        'summary', // Termék rövid leírása
        'body', // Termék részletes leírása
        'active', // Ha 1, akkor a termék publikus, így meg lehet vásárolni
        'shop_id' // Terméket forgalmazó üzlet azonosítója
    ];

    // Naplózás beállítása
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    // Egy termék mértékegysége
    public function unit(): HasOne {
        return $this->hasOne(ProductCategory::class)->where('category_group_id', get_category_group_id('Mértékegységek'));
    }

    // Egy termék csoportja
    public function group(): HasOne {
        return $this->hasOne(ProductCategory::class)->where('category_group_id', get_category_group_id('Termékcsoportok'));
    }

    // Egy termék nemei
    public function gender(): HasOne {
        return $this->hasOne(ProductCategory::class)->where('category_group_id', get_category_group_id('Nemek'));
    }

    // Egy termék korosztálya
    public function age(): HasOne {
        return $this->hasOne(ProductCategory::class)->where('category_group_id', get_category_group_id('Korosztályok'));
    }

    // Egy termékhez tartozó összes értékelések
    public function ratingsAll(): HasMany {
        return $this->hasMany(Rating::class)->orderBy('updated_at','desc');
    }

    // Egy termékhez tartozó moderált értékelések vagy az adott felhasználó értékelései
    public function ratingsModerated(): HasMany {
        return $this->ratingsAll()->where(function ($q) {
            $q->where('moderated',1)->orWhere('user_id', Auth::id());
        });
    }

    // Egy termékhez tartozó üzlet
    public function shop(): BelongsTo {
        return $this->belongsTo(Shop::class);
    }

    // Egy termékhez tartozó árak
    public function prices(): HasMany {
        return $this->hasMany(ProductPrice::class);
    }

    // Egy termékhez tartozó méretek - ID
    public function sizes() {
        $this->load('prices');
        return $this->prices->pluck('size_id');
    }

    // Egy termékhez tartozó méretek - Tömb
    public function sizes_array() {

        // Árak és méretek betöltése
        $this->load('prices','prices.size');

        // Üres tömb létrehozása
        $array = [];

        // Lekérdezni ezen árakat
        $prices = $this->prices->where('quantity','>',0);

        // Végigmenni minden egyes áron
        foreach ($prices AS $price) {

            // Mennyiség behelyezése a mérethez
            $price->size->quantity = $price->quantity;

            // Méret behelyezése a tömbbe
            $array[] = $price->size;
        }

        // Visszatérés ezen tömbbel
        return $array;
    }

    // Egy termékhez tartozó méretek - Lista
    public function sizes_list() {

        // Tömb létrehozása
        $name = [];

        // Végigmenni minden egyes méreten
        foreach ($this->sizes_array() AS $size) {

            // Méret nevének elmentése a tömbbe
            $name[] = $size->name;
        }

        // Visszatérés a tömbből létrehozott listával
        return implode(", ", $name);
    }

    // Egy termékhez tartozó méretek és árak
    public function sizes_prices() {
                
        // Tömb létrehozása
        $array = [];

        // Végigmenni minden egyes méreten
        foreach ($this->sizes_array() AS $size) {

            // Méret nevének elmentése a tömbbe
            $array[$size->name] = product_prices($this->id, $size->id);
        }

        // Visszatérés a tömbből létrehozott listával
        return $array;
    }

    // Termékhez tartozó kedvelése
    public function favourites(): HasMany {
        return $this->hasMany(Favourite::class);
    }

    // Terméket kedvelő felhasználók
    public function favourite_users() {
        $this->load('favourites.user');
        return $this->favourites->pluck('user');
    }

    // Kifizetett kosarak
    public function payed_carts(): HasMany {
        return $this->hasMany(Cart::class)->whereNotNull('payment_id')->orderBy('updated_at','desc');
    }

}
