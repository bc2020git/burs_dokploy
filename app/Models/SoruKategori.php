<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoruKategori extends Model
{
    use HasFactory;
    public $timestamps = true;

    public function soru()
    {
        return $this->hasMany(Soru::class, 'category_id','id');
    }
    public function forms()
    {
        return $this->hasMany(FormCategoryType::class, 'category_id','id');
    }

}
