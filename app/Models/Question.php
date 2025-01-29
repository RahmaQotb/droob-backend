<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = ['text'];
    
    public function exam(){
        return $this->belongsTo(Exam::class);
    }
    public function answers()
{
    return $this->hasMany(Answer::class);
}

public function subQuestions()
{
    return $this->hasMany(Question::class, 'parent_question_id');
}

public function parentQuestion()
{
    return $this->belongsTo(Question::class, 'parent_question_id');
}
}
