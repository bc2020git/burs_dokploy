<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class LiserenewAnswer extends Authenticatable
{
    use HasFactory;

    public $timestamps = true;

    protected $guarded = [];

    public $table = 'liserenew_answers';

    public function kardesler()
    {
        return $this->hasMany(ActiveSiblingDetails::class, 'tc_no', 'tc_no');
    }

    public function interviews()
    {
        return $this->hasMany(ActiveInterview::class, 'tc_no', 'tc_no');
    }

    public function logs()
    {
        return $this->hasMany(ActiveTimeline::class, 'tc_no', 'tc_no');
    }

    public function notes()
    {
        return $this->hasMany(ScholarNote::class, 'tc_no', 'tc_no');
    }

    public function form()
    {
        return $this->hasOne(LiseRenewForm::class, 'id', 'form_id');
    }

    public function scholar()
    {
        return $this->hasOne(LiseScholar::class, 'tc_no', 'tc_no');
    }

    public function otherScholarships()
    {
        return $this->hasMany(NewOtherScholarshipDetails::class, 'tc_no', 'tc_no');
    }
}
