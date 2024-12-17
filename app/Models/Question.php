<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        "exam_id","head_question_text","head_question_image","correct_answer"
    ];
    public function exam(){
        return $this->belongsTo(Exam::class);
    }
    public function sub_questions(){
        return $this->hasMany(SubQuestion::class);
    }
}
