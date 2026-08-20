<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Coderflex\LaravelTicket\Concerns\HasTickets;

class ActiveBankInfos extends Model

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
    protected $table= 'active_bank_infos';
    public function form()
    {
        return $this->belongsTo(ScholarForm::class,'id','form_id');
    }

}
