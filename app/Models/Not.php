<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Not extends Model
{
    use HasFactory;

    protected $table = 'notlar';

    protected $fillable = [
        'ogrenci_id',
        'ders_id',
        'not',
    ];

    public function ogrenci(): BelongsTo
    {
        return $this->belongsTo(Ogrenci::class, 'ogrenci_id');
    }

    public function ders(): BelongsTo
    {
        return $this->belongsTo(Ders::class, 'ders_id');
    }
}
