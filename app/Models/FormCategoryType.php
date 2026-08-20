<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormCategoryType extends Model
{
    use HasFactory;
    public $timestamps = true;
    public $table = 'soru_kategori_formlari';
    public function soru()
    {
        return $this->belongsTo(SoruKategori::class, 'id','category_id');
    }
}
