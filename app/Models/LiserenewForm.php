<?php

// app/Models/Student.php

namespace App\Models;

use Coderflex\LaravelTicket\Concerns\HasTickets;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class LiserenewForm extends Model
{
    protected $guarded = [];

    use HasApiTokens, HasFactory, Notifiable;
    use HasTickets;

    public $table = 'liserenew_forms';

    public function scholar()
    {
        return $this->hasOne(Lisescholar::class, 'id', 'scholar_id');
    }

    public function infos()
    {
        return $this->hasOne(LiserenewAnswer::class, 'form_id', 'id');
    }

    public function Reneweducinfo()
    {
        return $this->hasOne(RenewEducationalInfo::class, 'form_id', 'id');

    }

    public function period()
    {
        return $this->hasOne(Period::class, 'id', 'period_id');
    }

    public function family()
    {
        return $this->hasOne(RenewFamilyInfos::class, 'form_id', 'id');
    }

    public function documents()
    {
        return $this->hasMany(RenewDocuments::class, 'form_id', 'id');
    }

    public function housing()
    {
        return $this->hasOne(RenewHousingInformation::class, 'form_id', 'id');

    }

    public function income()
    {
        return $this->hasOne(RenewIncomeInfos::class, 'form_id', 'id');

    }

    public function educinfo()
    {
        return $this->hasOne(RenewEducationalInfo::class, 'form_id', 'id');
    }

    public function parent()
    {
        return $this->hasOne(RenewParentInfo::class, 'form_id', 'id');
    }

    public function personal()
    {
        return $this->hasOne(RenewPersonalnfo::class, 'form_id', 'id');
    }

    public function disabled()
    {
        return $this->hasOne(RenewObstacledInfos::class, 'form_id', 'id');
    }

    public function scholars()
    {
        return $this->hasMany(RenewOtherScholarshipDetails::class, 'form_id', 'id');
    }

    public function digerBursInfo()
    {
        return $this->hasOne(RenewOtherScholarshipInfos::class, 'form_id', 'id');
    }

    public function sibling()
    {
        return $this->hasMany(RenewSiblingInfos::class, 'form_id', 'id');
    }

    public function job()
    {
        return $this->hasOne(RenewJobInfos::class, 'form_id', 'id');
    }

    public function social()
    {
        return $this->hasOne(RenewSocialInfos::class, 'form_id', 'id');
    }

    public function bank()
    {
        return $this->hasOne(RenewBankInfos::class, 'form_id', 'id');
    }

    public function kardesler()
    {
        return $this->hasMany(RenewSiblingDetails::class, 'form_id', 'id');
    }
}
