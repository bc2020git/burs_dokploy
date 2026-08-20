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

class Bildirim extends Model

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
    public function work()
    {
        return $this->belongsTo(Work::class,'work_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
