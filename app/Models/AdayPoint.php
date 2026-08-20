<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\NewAnswer;

class AdayPoint extends Model
{
    protected $fillable = ['puan', 'soru', 'tc_no', 'cevap'];
    public $timestamps = false;
    protected $table = 'aday_points';
    public function aday()
    {
        return $this->belongsTo(NewAnswer::class, 'tc_no', 'tc_no');
    }
}
