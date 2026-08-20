<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bursveren extends Model
{
    use HasFactory;

    protected $table = 'bursverenler';
    protected $fillable = ['name', 'surname'];
}