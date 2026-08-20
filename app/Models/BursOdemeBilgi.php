<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BursOdemeBilgi extends Model
{
    use HasFactory;

    protected $table = 'burs_odeme_bilgileri';

    protected $guarded = [];


    // İlişkiler
    public function ogrenci()
    {
        return $this->belongsTo(ActiveAnswer::class, 'tc_kimlik_no', 'tc_no');
    }



    // Ek metodlar
    public function getOdemeDurumuRenkAttribute()
    {
        return [
            'Ödendi' => 'success',
            'Beklemede' => 'warning',
            'İptal Edildi' => 'danger',
        ][$this->odeme_durumu] ?? 'secondary';
    }
}
