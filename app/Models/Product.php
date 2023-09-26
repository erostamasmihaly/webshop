<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Product extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'summary',
        'body',
        'active',
        'shop_id'
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

    // Egy termékhez tartozó moderált értékelések
    public function ratingsModerated(): HasMany {
        return $this->ratingsAll()->where('moderated',1);
    }

    // Egy termékhez tartozó bolt
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

    // Egy termékhez tartozó méretek - Név
    public function size_names() {

        // Árak és méretek betöltése
        $this->load('prices','prices.size');

        // Üres tömb létrehozása
        $array = [];

        // Lekérdezni ezen árakat
        $prices = $this->prices;

        // Végigmenni minden egyes áron
        foreach ($prices AS $price) {

            // Méret behelyezése a tömbbe
            $array[] = $price->size->name;
        }

        // Visszatérés ezen tömbbel
        return array_values(array_unique($array));
    }

}
