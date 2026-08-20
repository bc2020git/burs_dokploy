<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Photo;

class Files extends Model
{
    public $timestamps = false;
    public $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
