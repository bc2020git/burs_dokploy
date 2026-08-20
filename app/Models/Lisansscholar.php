<?php

// app/Models/Student.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Lisansscholar extends Authenticatable
{
    // Eloquent modelinizi buraya ekleyebilirsiniz.
    protected $fillable = [
        'name', 'surname', 'email', 'password', 'tc_no', 'aday_id', 'tel_no', 'status',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public $table = 'lisansscholars';

    public function form()
    {
        return $this->hasMany(LisansscholarForm::class, 'scholar_id', 'id');
    }

    public function renewform()
    {
        return $this->hasMany(LisansrenewForm::class, 'scholar_id', 'id');

    }

    public function interviews()
    {
        return $this->hasMany(NewInterview::class, 'tc_no', 'tc_no');

    }

    public function docverify()
    {
        return $this->hasMany(VerifyDocument::class, 'tc_no', 'tc_no');
    }

    public function logs()
    {
        return $this->hasMany(NewTimeline::class, 'tc_no', 'tc_no')->orderBy('created_at', 'desc');
    }

    public function activeAnswers()
    {
        return $this->hasMany(ActiveAnswer::class, 'tc_no', 'tc_no');
    }

    public function kardesler()
    {
        return $this->hasMany(NewSiblingDetails::class, 'tc_no', 'tc_no');
    }

    public function latestPhoto()
    {
        $photo = ScholarForm::where('scholar_id', $this->id)
            ->join('active_answers', 'scholar_forms.id', '=', 'active_answers.form_id')
            ->whereNotNull('active_answers.doc_fotograf')
            ->where('active_answers.doc_fotograf', '!=', '')
            ->orderBy('scholar_forms.created_at', 'desc')
            ->select('active_answers.doc_fotograf')
            ->first();

        return $photo ? $photo->doc_fotograf : null;
    }
}
