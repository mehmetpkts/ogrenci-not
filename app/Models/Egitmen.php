<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Egitmen extends Model
{
    use HasFactory;

    protected $table = 'egitmenler';

    protected $fillable = [
        'ad_soyad',
        'egitmen_no',
        'telefon_numarasi',
        'okul_email',
    ];

    public function dersler(): HasMany
    {
        return $this->hasMany(Ders::class, 'egitmen_id');
    }
}
