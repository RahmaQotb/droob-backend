<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubQuestion extends Model
{
    use HasFactory;
    protected $fillable = [
        "question_id","head_question_text","head_question_image","correct_answer"
    ];
    public function question(){
        return $this->belongsTo(Question::class);
    }
}
