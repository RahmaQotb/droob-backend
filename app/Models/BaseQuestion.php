<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseQuestion extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function BaseExam(){
        return $this->belongsTo(BaseExam::class);
    }

    
}
