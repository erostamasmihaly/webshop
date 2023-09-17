<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'discount'
    ];

    // Naplózás beállítása
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    // Egy termék mértékegysége
    public function product_unit(): HasOne {
        $category_group_id = CategoryGroup::where('name','Mértékegységek')->first()->id;
        return $this->hasOne(ProductCategory::class)->where('category_group_id', $category_group_id);
    }

    // Egy termékhez tartozó összes értékelések
    public function ratingsAll(): HasMany {
        return $this->hasMany(Rating::class)->orderBy('updated_at','desc');
    }

    // Egy termékhez tartozó moderált értékelések
    public function ratingsModerated(): HasMany {
        return $this->hasMany(Rating::class)->where('moderated',1)->orderBy('updated_at','desc');
    }

}
