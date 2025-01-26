<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseExamResource;
use App\Models\BaseExam;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BaseExamController extends Controller
{
    public function GetBaseExam($id){
        $student = Student::where("id",$id)->first();
        if(!$student) return response()->json(["message"=>"student not exist","data"=>null],404);
        $base_exams = BaseExam::all();
        if(!$base_exams) return response()->json(["message"=>"no base exam exists","data"=>null],404);
        return response()->json([
            "message"=>"base exam retrived",
            "data"=>BaseExamResource::collection($base_exams),
        ],200);
    }
    public function BaseExamCorrection($id,Request $request){
        $student = Student::where("id",$id)->first();
        if(!$student) return response()->json(["message"=>"student not exist","data"=>null],404);
        $validator = Validator::make($request->all(),
        [
            "answers.*.base_exam_id"=>"required|exists:base_exams,id",
            "answers.*.answer"=>"required|boolean"
        ]);

            if($validator->fails()){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'data' => $validator->errors(),
                ], 422);
            }
        $data = $request->input('answers');
        $correctedAnswers=[
            "base_exam" => []
        ];
        foreach($data as $answer){
            if($answer['answer'] == false ){
                array_push($correctedAnswers['base_exam'],$answer['base_exam_id']);
            }
        }
        return response()->json([
            'status' => 'success',
            'message' => 'correction done',
            'data' => $correctedAnswers,
        ], 200);
        

        
    }
    
}
