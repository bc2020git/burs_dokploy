<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class LiseactiveAnswer extends Authenticatable
{
    use HasFactory;

    public $timestamps = true;

    protected $guarded = [];

    public $table = 'liseactive_answers';

    public function scholar()
    {
        return $this->belongsTo(Lisescholar::class, 'tc_no', 'tc_no');
    }

    public function form()
    {
        return $this->belongsTo(LisecholarForm::class, 'form_id', 'id');
    }

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
        return $this->hasMany(ActiveTimeline::class, 'tc_no', 'tc_no')
            ->orderBy('created_at', 'desc');
    }

    public function otherScholarships()
    {
        return $this->hasMany(NewOtherScholarshipDetails::class, 'tc_no', 'tc_no');
    }
}
