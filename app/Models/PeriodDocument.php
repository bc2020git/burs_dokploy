<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodDocument extends Model
{
    use HasFactory;
    protected $fillable = ['period_id', 'school_type', 'documents'];
}
