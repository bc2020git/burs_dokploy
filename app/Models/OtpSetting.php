<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'otp_status',
        'crm_otp_status',
        'portal_otp_status',
        'admin_otp_status',
        'sms_status',
        'email_status'
    ];

    protected $casts = [
        'otp_status' => 'boolean',
        'crm_otp_status' => 'boolean',
        'portal_otp_status' => 'boolean',
        'admin_otp_status' => 'boolean',
        'sms_status' => 'boolean',
        'email_status' => 'boolean',
    ];
}
