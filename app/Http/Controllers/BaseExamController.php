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
    public function ExamRedirection($id, $examsArray)
    {
        // Check if the student exists
        $student = Student::find($id);
        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student does not exist',
                'data' => null
            ], 404);
        }
    
        // Decode and validate examsArray
        $examsArray = json_decode($examsArray, true);
        if (!is_array($examsArray)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid examsArray parameter',
                'data' => null
            ], 400);
        }
    
        // Check if examsArray is empty
        if (empty($examsArray)) {
            return response()->json([
                'success' => false,
                'message' => 'Student does not have to take exams',
                'data' => null
            ], 400);
        }
    
        // Remove duplicates and count occurrences
        $exams = array_values(array_unique($examsArray));
        $arabicOnly = in_array(1, $exams) ? 1 : 0;
        $mathOnly = in_array(2, $exams) ? 1 : 0;
        $arabic_math = ($arabicOnly && $mathOnly) ? 1 : 0;
    
        // Determine which exams to retrieve
        if (($arabicOnly && $mathOnly) || $arabic_math) {
            // Retrieve all exams
            $exams = Exam::with(['subject', 'questions.answers'])->get();
            if ($exams->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No exams found',
                    'data' => null
                ], 404);
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Arabic and Math exams retrieved successfully',
                'data' => ExamResource::collection($exams)
            ], 200);
        }
    
        if ($mathOnly) {
            // Retrieve Math exam
            $subject = Subject::where('name', 'Math')->first();
            if (!$subject) {
                return response()->json([
                    'success' => false,
                    'message' => 'Math subject not found',
                    'data' => null
                ], 404);
            }
    
            $exam = Exam::with(['subject', 'questions.answers'])
                ->where('subject_id', $subject->id)
                ->first();
            if (!$exam) {
                return response()->json([
                    'success' => false,
                    'message' => 'Math exam not found',
                    'data' => null
                ], 404);
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Math exam retrieved successfully',
                'data' => new ExamResource($exam)
            ], 200);
        }
    
        if ($arabicOnly) {
            // Retrieve Arabic exam
            $subject = Subject::where('name', 'Arabic')->first();
            if (!$subject) {
                return response()->json([
                    'success' => false,
                    'message' => 'Arabic subject not found',
                    'data' => null
                ], 404);
            }
    
            $exam = Exam::with(['subject', 'questions.answers'])
                ->where('subject_id', $subject->id)
                ->first();
            if (!$exam) {
                return response()->json([
                    'success' => false,
                    'message' => 'Arabic exam not found',
                    'data' => null
                ], 404);
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Arabic exam retrieved successfully',
                'data' => new ExamResource($exam)
            ], 200);
        }
    
        // Default response if no conditions are met
        return response()->json([
            'success' => true,
            'message' => 'Student does not have to take exams',
            'data' => null
        ], 200);
    }
    
}

