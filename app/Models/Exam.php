<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function subject(){

        return $this->belongsTo(Subject::class);
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    
    public function passageQuestions()
    {
        return $this->hasMany(Question::class)->where('type', 'passage');
    }
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
    public function students()
    {
        return $this->belongsToMany(Student::class, 'grades', 'exam_id', 'student_id')
                    ->withPivot('degree', 'difficulty')
                    ->withTimestamps();
    }
    
}
