<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aday extends Authenticatable
{
    use HasFactory;

    protected $table = 'new_general_infos';
    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
        'password',
    ];

    protected $rememberTokenName = 'remember_token';

    public function family()
    {
        return $this->hasOne(NewFamilyInfos::class, 'tc_no','tc_no');
    }
    public function housing(){
        return $this->hasOne(NewHousingInformation::class, 'tc_no','tc_no');

    }
    public function income(){
        return $this->hasOne(NewIncomeInfos::class, 'tc_no','tc_no');

    }
    public function educinfo()
    {
        return $this->hasOne(NewEducationalInfo::class, 'tc_no','tc_no');
    }
    public function parent()
    {
        return $this->hasOne(NewParentInfo::class, 'tc_no','tc_no');
    }
    public function personal()
    {
        return $this->hasOne(NewPersonalnfo::class, 'tc_no','tc_no');
    }
    public function period()
    {
        return $this->hasOne(Period::class, 'id','periodId');
    }
    public function scholar()
    {
        return $this->hasOne(NewOtherScholarshipInfos::class, 'tc_no','tc_no');
    }
    public function disabled()
    {
        return $this->hasOne(NewObstacledInfos::class, 'tc_no','tc_no');
    }
    public function scholars()
    {
        return $this->hasMany(NewOtherScholarshipDetails::class, 'tc_no','tc_no');
    }

    public function sibling()
    {
        return $this->hasOne(NewSiblingInfos::class, 'tc_no','tc_no');
    }

    public function job()
    {
        return $this->hasOne(NewJobInfos::class, 'tc_no','tc_no');
    }

    public function social()
    {
        return $this->hasOne(NewSocialInfos::class, 'tc_no','tc_no');
    }
    public function bank()
    {
        return $this->hasOne(NewBankInfos::class, 'tc_no','tc_no');
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
        return $this->hasMany(NewDocuments::class, 'tc_no','tc_no');
    }
    public function logs()
    {
        return $this->hasMany(NewTimeline::class, 'tc_no','tc_no');
    }

}
