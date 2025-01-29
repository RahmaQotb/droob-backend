<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseExamResource;
use App\Models\BaseExam;
use App\Models\Exam;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ExamResource;


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
        // check if if the there is no faults 
        if(empty($correctedAnswers['base_exam'])) return response()->json(["success"=>false,"message"=>"student does't have to take exams","data"=> null],200);
        
        return response()->json([
            'status' => 'success',
            'message' => 'correction done',
            'data' => $correctedAnswers,
        ], 200);
        

        
    }

    public function ExamRedirection($id , $examsArray){
        
        // check if student added
        $student = Student::where("id",$id)->first();
        if(!$student) return response()->json(["success"=>false,"message"=>"student not exist","data"=>null],404);
        // check if the array of faults is empty
        if(!$examsArray) return response()->json(["success"=>false,"message"=>"student does't have to take exams","data"=> null],300);
        
        // remove duplicates and implement flags to make a decision back to them
        $exams = array_unique($examsArray);
            $arabicOnly=0;
            $mathOnly=0;
            $arabic_math=0;
                for($i = 0 ; $i < count($exams) ; $i++ )
                {
                        if($exams[$i]==1){
                            $arabicOnly = $arabicOnly +1 ;
                        }
                        if($exams[$i]==2){
                            if($exams[$i]==2){
                                $mathOnly = $mathOnly +1 ;
                            }
                        }
                        if($exams[$i]>1){
                            $arabic_math = 1 ;
                        }
                }

        // check if there is faults in general topics , or both of arabic and math questions to => to retrive all exams  
        if($arabic_math >0 || ($arabicOnly =1 && $mathOnly=1))
        {
            $exam = Exam::with(['subject', 'questions.answers'])->get();
            
            if(!$exam) 
                {
                    return response()->json([
                        'success'=>false,
                        'message'=>"can't retrive exam",
                        'exam'=> null
                    ],404);
                }

            return response()->json([
                'success'=>true,
                'message'=>'arabic and math exam retrived successfully',
                'exam'=> ExamResource::collection($exam)
            ],200);

        }

        // if the faults in only math questions
        if($mathOnly=1){
            $subject = Subject::where('name','Math')->first();
            $exam = Exam::with(['subject', 'questions.answers'])->where('subject_id',$subject->id)->get();
            if(!$exam)
            {
                return response()->json([
                    "success"=>false,
                    "message"=>"exam not found",
                ],status: 404);
            }

            return response()->json([
                "success"=>true,
                "message"=>"math exam retrived successfully",
                "data"=> new ExamResource($exam),
            ],200);

        }


        // if the faults in only arabic questions
        if($arabicOnly=1){
            $subject = Subject::where('name','Arabic')->first();
            $exam = Exam::with(['subject', 'questions.answers'])->where('subject_id',$subject->id)->get();
            if(!$exam)
            {
                return response()->json([
                    "success"=>false,
                    "message"=>"exam not found",
                ],status: 404);
            }

            return response()->json([
                "success"=>true,
                "message"=>"arabic exam retrived successfully",
                "data"=> new ExamResource($exam),
            ],200);
            
        }
        // return response()->json([
        //     "success"=>true,
        //     "message"=>"student does't have to take exams",
        //     "data"=> null,
        // ],200);
        
    }
    
}
