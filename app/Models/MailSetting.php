<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'is_active', 'host', 'port', 'username', 'password',
        'encryption', 'from_address', 'from_name', 'api_key', 'useinbox_api_key'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
