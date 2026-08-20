<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class LisansactiveAnswer extends Authenticatable
{
    use HasFactory;

    public $timestamps = true;

    protected $guarded = [];

    public $table = 'lisansactive_answers';

    public function scholar()
    {
        return $this->belongsTo(Scholar::class, 'tc_no', 'tc_no');
    }

    public function form()
    {
        return $this->belongsTo(LisanscholarForm::class, 'form_id', 'id');
    }
}
