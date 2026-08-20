<?php

namespace App\Models;

use Coderflex\LaravelTicket\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ActiveAnswer extends Authenticatable
{
    use HasFactory;
    public $timestamps = true;

    protected $guarded =[];

    public function scholar()
    {
        return $this->belongsTo(Scholar::class, 'tc_no','tc_no');
    }
    public function kardesler()
    {
        return $this->hasMany(ActiveSiblingDetails::class, 'tc_no','tc_no');
    }
    public function interviews()
    {
        return $this->hasMany(ActiveInterview::class, 'tc_no','tc_no');
    }
    public function form()
    {
        return $this->belongsTo(ScholarForm::class, 'form_id','id');
    }

    public function logs()
    {
        return $this->hasMany(ActiveTimeline::class, 'tc_no','tc_no')
            ->orderBy('created_at', 'desc');
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
