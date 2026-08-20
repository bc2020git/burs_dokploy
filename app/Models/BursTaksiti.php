<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BursTaksiti extends Model
{
    protected $table = 'burs_taksitleri';

    protected $fillable = [
        'burs_tipi_id',
        'donem',
        'burs_tutari',
        'taksit_sayisi',
        'baslangic_tarihi',
    ];

    protected function casts(): array
    {
        return [
            'baslangic_tarihi' => 'date:Y-m-d',
            'burs_tutari' => 'decimal:2',
        ];
    }

    public function bursTipi(): BelongsTo
    {
        return $this->belongsTo(TanimBursTipi::class, 'burs_tipi_id');
    }
}
