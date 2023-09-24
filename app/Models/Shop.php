<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Shop extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'summary',
        'body',
        'address',
        'url',
        'email',
        'telephone',
        'latitude',
        'longitude'
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

}
