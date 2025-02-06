<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $guarded =[];
    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'grades', 'student_id', 'exam_id')
                    ->withPivot('degree', 'difficulty')
                    ->withTimestamps();
    }
    

}
