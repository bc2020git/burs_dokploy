<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TanimBursTipi extends Model
{
    use HasFactory;

    protected $fillable = [
        'burs_tipi',
        'ogrenim_tipi',
    ];

    public function bursTaksitleri(): HasMany
    {
        return $this->hasMany(BursTaksiti::class, 'burs_tipi_id');
    }
}
