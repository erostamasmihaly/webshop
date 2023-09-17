<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Rating extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'user_id',
        'product_id',
        'stars',
        'title',
        'body',
        'moderated'
    ];

    // Naplózás beállítása
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    // Értékeléshez tartozó felhasználó
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}