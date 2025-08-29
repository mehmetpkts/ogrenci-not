<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ogrenci extends Model
{
    use HasFactory;

    protected $table = 'ogrenciler';

    protected $fillable = [
        'ad_soyad',
    ];

    public function notlar(): HasMany
    {
        return $this->hasMany(Not::class, 'ogrenci_id');
    }
}
