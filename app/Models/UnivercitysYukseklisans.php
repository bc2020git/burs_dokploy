<?php

// app/Models/Student.php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Coderflex\LaravelTicket\Concerns\HasTickets;

class UnivercitysYukseklisans extends Model


{
    public $table = "univercitys_yukseklisans";
    // Eloquent modelinizi buraya ekleyebilirsiniz.
    protected $guarded = [    ];

}
