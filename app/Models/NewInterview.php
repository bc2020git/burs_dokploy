<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Work;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Coderflex\LaravelTicket\Concerns\HasTickets;
use Coderflex\LaravelTicket\Contracts\CanUseTickets;
use App\Notifications\ResetPasswordNotification;

class NewInterview extends Model

{
    use HasApiTokens, HasFactory, Notifiable;
    use HasTickets;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
    public $timestamps = false;

    protected $casts = [
        'interviewer_participation' => 'array',
        'bildirim_gonderildi_mi' => 'string',
    ];

    public function aday()
    {
        return $this->belongsTo(NewAnswer::class,'tc_no','tc_no');
    }
    public function group()
    {
        return $this->belongsTo(InterviewGroup::class,'interview_person','id');
    }

}
