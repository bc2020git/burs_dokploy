<?php

namespace App\Models;

use Coderflex\LaravelTicket\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class NewAnswer extends Authenticatable
{
    use HasFactory;
    public $timestamps = true;

    protected $guarded =[];
    protected static function booted()
    {
        static::deleted(function ($newAnswer) {
            $newAnswer->interviews()->delete();
        });
    }

    public function kardesler()
    {
        return $this->hasMany(NewSiblingDetails::class, 'tc_no','tc_no');
    }
    public function interviews()
    {
        return $this->hasMany(NewInterview::class, 'tc_no','tc_no');
    }
    public function documents()
    {
        return $this->hasOne(NewDocuments::class, 'tc_no','tc_no');
    }
    public function docverify()
    {
        return $this->hasMany(VerifyDocument::class, 'tc_no','tc_no');
    }
    public function scholars()
    {
        return $this->hasMany(NewOtherScholarshipDetails::class, 'tc_no','tc_no');
    }
    public function logs()
    {
        return $this->hasMany(NewTimeline::class, 'tc_no','tc_no')
            ->orderBy('created_at', 'desc');

    }
    public function notes()
    {
        return $this->hasMany(ScholarNote::class, 'tc_no','tc_no')
            ->orderBy('created_at', 'desc');
    }

    public function period()
    {
        return $this->hasOne(Period::class, 'id','period_id');
    }
    public function points()
    {
        return $this->hasMany(AdayPoint::class, 'tc_no','tc_no');
    }

    public function bursTipi(): BelongsTo
    {
        return $this->belongsTo(TanimBursTipi::class, 'burs_tipi_id');
    }
}
