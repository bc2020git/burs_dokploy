<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewTimeline extends Model
{
    protected $table = 'interview_timelines';

    protected $fillable = [
        'interview_id',
        'topTitle',
        'title',
        'text'
    ];

    public function interview()
    {
        return $this->belongsTo(NewInterview::class, 'interview_id');
    }
}
