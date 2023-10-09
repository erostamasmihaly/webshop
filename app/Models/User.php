<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

// Felhasználók adatai
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, LogsActivity;

    protected $fillable = [
        'name', // Felhasználói név
        'email', // E-mail cím
        'password', // Jelszó
        'surname', // Vezetéknév
        'forename', // Keresztnév
        'active', // Ha 1, akkor aktív a felhasználó
        'country', // Ország
        'state', // Területi egység
        'zip', // Irányítószám
        'city', // Város
        'address' // Cím továbi részei pl: utca, házszám, stb...
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Naplózás beállítása
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    // Felhasználó kosár elemei
    public function carts(): HasMany {
        return $this->hasMany(Cart::class)->whereNull('payment_id');
    }

    // Felhasználó kifizetett elemei
    public function payed(): HasMany {
        return $this->hasMany(Cart::class)->whereNotNull('payment_id')->orderBy('updated_at','desc');
    }

    // Felhasználóhoz tartozó munkakörök lekérdezése
    public function positions(): BelongsToMany {
        return $this->belongsToMany(Position::class,'user_positions');
    }

    // Felhasználóhoz tartozó üzletek lekérdezése
    public function shops() {

        // Kollekció létrehozása
        $collection = collect();

        // Végigmenni a felhasználó minden egyes munkakörén és berakni a kollekcióba
        foreach ($this->positions AS $position) {
            $collection->push(Shop::find($position->shop_id));
        }

        // Visszatérni ezen üzletekkel
        return $collection;
 
    } 

    // Felhasználóhoz rendelhető munkakörök lekérdezése
    public function possible_positions() {

        // Kollekció létrehozása
        $collection = collect();

        // Végigmenni a felhasználóhoz rendelt összes üzleten
        foreach ($this->shops() AS $shop) {

            // Végigmenni az üzlethez rendelhető összes munkakörön és berakni a kollekcióba
            foreach ($shop->positions AS $position) {
                $collection->push($position);
            }
        }

        // Visszatérni ezen munkakörrel
        return $collection;
    }

}
