<?php

namespace App\Models;

use Coderflex\LaravelTicket\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soru extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $guarded = [];
    public function  category(){
        return $this->belongsTo(SoruKategori::class, 'category_id','id');
    }
    public static function getBankNames()
    {
        $options = self::where('db_key', 'bank_name')->first()->options;
        return json_decode($options, true);
    }
}
