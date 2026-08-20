<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    protected $table = 'user_notifications';

    protected $fillable = [
        'message_id',
        'user_email',
        'is_checked'
    ];

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'message_id');
    }
}
