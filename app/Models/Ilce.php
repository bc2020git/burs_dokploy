<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ilce extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function il()
    {
        return $this->HasOne(Il::class, 'il_no','il_no');
    }
}
