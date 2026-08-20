<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function types()
    {
        return $this->hasMany(PeriodEducationTypes::class, 'period_id', 'id');
    }
    public function documents()
    {
        return $this->hasMany(PeriodDocument::class, 'period_id', 'id');
    }
}
