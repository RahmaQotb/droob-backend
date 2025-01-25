<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseExam extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function BaseQuestions(){
        return $this->hasMany(BaseQuestion::class);
    }
}
