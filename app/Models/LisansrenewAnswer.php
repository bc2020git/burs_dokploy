<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class LisansrenewAnswer extends Authenticatable
{
    use HasFactory;

    public $timestamps = true;

    protected $guarded = [];

    public $table = 'lisansrenew_answers';

    public function form()
    {
        return $this->hasOne(LisansrenewForm::class, 'id', 'form_id');
    }

    public function scholar()
    {
        return $this->hasOne(Lisansscholar::class, 'tc_no', 'tc_no');
    }
}
