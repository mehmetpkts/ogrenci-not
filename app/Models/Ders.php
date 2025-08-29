<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ders extends Model
{
    use HasFactory;

    protected $table = 'dersler';

    protected $fillable = [
        'ad',
        'egitmen_id',
    ];

    public function egitmen(): BelongsTo
    {
        return $this->belongsTo(Egitmen::class, 'egitmen_id');
    }

    public function notlar(): HasMany
    {
        return $this->hasMany(Not::class, 'ders_id');
    }
}
