<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Il extends Model
{
    use HasFactory;
    protected $guarded  = [];
    public $timestamps = true;

    public function districts()
    {
        return $this->hasMany(Ilce::class, 'il_no','id');
    }
}
