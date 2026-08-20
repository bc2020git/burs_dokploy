<?php

namespace App\Models;

use Coderflex\LaravelTicket\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class RenewAnswer extends Authenticatable
{
    use HasFactory;
    public $timestamps = true;

    protected $guarded =[];

    public function kardesler()
    {
        return $this->hasMany(ActiveSiblingDetails::class, 'tc_no','tc_no');
    }
    public function interviews()
    {
        return $this->hasMany(ActiveInterview::class, 'tc_no','tc_no');
    }

    public function logs()
    {
        return $this->hasMany(ActiveTimeline::class, 'tc_no','tc_no');
    } public function notes()
    {
        return $this->hasMany(ScholarNote::class, 'tc_no','tc_no');
    }
    public function form()
    {
        return $this->hasOne(RenewForm::class, 'id','form_id');
    }
    public function scholar()
    {
        return $this->hasOne(Scholar::class, 'tc_no','tc_no');
    }
    public function otherScholarships()
    {
        return $this->hasMany(NewOtherScholarshipDetails::class, 'tc_no','tc_no');
    }

    public function bursTipi(): BelongsTo
    {
        return $this->belongsTo(TanimBursTipi::class, 'burs_tipi_id');
    }

}
