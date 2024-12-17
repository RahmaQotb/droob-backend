<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $fillable = [
        "question_id","sub_question_id","answer_text","answer_image","order","is_correct"
    ];
    public function question(){
        return $this->belongsTo(Question::class);
    }
    public function sub_question(){
        return $this->belongsTo(SubQuestion::class);
    }
}
