<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Coderflex\LaravelTicket\Concerns\HasTickets;
use Coderflex\LaravelTicket\Contracts\CanUseTickets;
use App\Notifications\ResetPasswordNotification;
use App\Models\Departmant;

class User extends Authenticatable implements CanUseTickets

{
    use HasApiTokens, HasFactory, Notifiable;
    use HasTickets;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'role_id',
        'gorev',
        'tel_no',
        'accepted_ip',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function departman()
    {
        return $this->belongsTo(Departmant::class, 'departman_id');
    }
    public function ekipUyeleri()
    {
        return $this->hasMany(EkipUyeleri::class, 'user_id');
    }
    public function isSahiplikleri()
    {
        return $this->hasMany(IsSahipligi::class, 'user_id');
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function role()
    {
        return $this->belongsTo(Role::class,'role_id','id');
    }

    /**
     * Kullanıcının belirli bir yetkiye sahip olup olmadığını kontrol eder
     */
    public function hasPermission($permission)
    {
        if (!$this->role) {
            return false;
        }

        return $this->role->permissions->pluck('name')->contains($permission);
    }
}
