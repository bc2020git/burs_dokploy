<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    protected $fillable = [
        'frontend_version',
        'frontend_date',
        'backend_version',
        'backend_date',
        'description'
    ];

    protected $casts = [
        'frontend_date' => 'datetime',
        'backend_date' => 'datetime'
    ];
}
