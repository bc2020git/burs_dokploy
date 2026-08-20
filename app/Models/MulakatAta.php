<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MulakatAta extends Model
{
    use HasFactory;
    
    protected $fillable = ['aday_id', 'user_id'];
    
    public function interviewGroup()
    {
        return $this->belongsTo(InterviewGroup::class, 'user_id', 'id');
    }
    
    public function aday()
    {
        return $this->belongsTo(NewAnswer::class, 'aday_id', 'id');
    }
}
