<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewGroup extends Model
{
    protected $fillable = ['name', 'members'];

    protected $casts = [
        'members' => 'array'
    ];
} 