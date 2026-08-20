<?php

// app/Models/Student.php

namespace App\Models;

use Coderflex\LaravelTicket\Concerns\HasTickets;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class LisansscholarForm extends Model
{
    protected $guarded = [];

    use HasApiTokens, HasFactory, Notifiable;
    use HasTickets;

    public $table = 'lisansscholar_forms';

    public function documents()
    {
        return $this->hasOne(ActiveDocuments::class, 'form_id', 'id');
    }

    public function infos()
    {
        return $this->hasOne(LisansactiveAnswer::class, 'form_id', 'id');
    }

    public function answers()
    {
        return $this->hasOne(LisansactiveAnswer::class, 'form_id', 'id');
    }

    public function educinfo()
    {
        return $this->hasOne(ActiveEducationalInfo::class, 'form_id', 'id');
    }

    public function scholar()
    {
        return $this->hasOne(Scholar::class, 'id', 'scholar_id');
    }

    public function period()
    {
        return $this->hasOne(Period::class, 'id', 'period_id');
    }

    public function Activeeducinfo()
    {
        return $this->hasOne(ActiveEducationalInfo::class, 'form_id', 'id');

    }

    public function family()
    {
        return $this->hasOne(ActiveFamilyInfos::class, 'form_id', 'id');
    }

    public function housing()
    {
        return $this->hasOne(ActiveHousingInformation::class, 'form_id', 'id');

    }

    public function income()
    {
        return $this->hasOne(ActiveIncomeInfos::class, 'form_id', 'id');

    }

    public function parent()
    {
        return $this->hasOne(ActiveParentInfo::class, 'form_id', 'id');
    }

    public function personal()
    {
        return $this->hasOne(ActivePersonalnfo::class, 'form_id', 'id');
    }

    public function disabled()
    {
        return $this->hasOne(ActiveObstacledInfos::class, 'form_id', 'id');
    }

    public function scholars()
    {
        return $this->hasMany(ActiveOtherScholarshipDetails::class, 'form_id', 'id');
    }

    public function interviews()
    {
        return $this->hasMany(ActiveInterview::class, 'form_id', 'id');
    }

    public function digerBursInfo()
    {
        return $this->hasOne(ActiveOtherScholarshipInfos::class, 'form_id', 'id');
    }

    public function sibling()
    {
        return $this->hasMany(ActiveSiblingDetails::class, 'form_id', 'id');
    }

    public function job()
    {
        return $this->hasOne(ActiveJobInfos::class, 'form_id', 'id');
    }

    public function social()
    {
        return $this->hasOne(ActiveSocialInfos::class, 'form_id', 'id');
    }

    public function bank()
    {
        return $this->hasOne(ActiveBankInfos::class, 'form_id', 'id');
    }

    public function kardesler()
    {
        return $this->hasMany(ActiveSiblingDetails::class, 'form_id', 'id');
    }

    public function logs()
    {
        return $this->hasMany(ActiveTimeline::class, 'form_id', 'id')
            ->orderBy('created_at', 'desc');
    }
}
