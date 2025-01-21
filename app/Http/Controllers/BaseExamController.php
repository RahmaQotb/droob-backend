<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseExamResource;
use App\Models\BaseExam;
use Illuminate\Http\Request;

class BaseExamController extends Controller
{
    public function GetBaseExam(){
        $base_exams = BaseExam::all();
        if(!$base_exams) return response()->json(["message"=>"no base exam exists","data"=>null],404);
        return response()->json([
            "message"=>"base exam retrived",
            "data"=>BaseExamResource::collection($base_exams),
        ],200);
    }
    public function BaseExamCorrection(Request $request){

    }
}
