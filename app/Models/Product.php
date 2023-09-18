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
        'price',
        'quantity',
        'active',
        'vat',
        'discount',
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

    // Egy termék mérete
    public function size(): HasOne {
        return $this->hasOne(ProductCategory::class)->where('category_group_id', get_category_group_id('Méretek'));
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

}
