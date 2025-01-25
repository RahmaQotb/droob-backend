<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExamResource;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\AnswerResource;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Answer;

class ExamController extends Controller
{

    public function getExams()
    {
        $exams = Exam::with(['subject', 'questions.answers'])->get();
        return ExamResource::collection($exams);
    }

    /**
     * عرض تفاصيل امتحان معين.
     */
    public function getExam($id)
    {
        $exam = Exam::with(['subject', 'questions.answers'])->find($id);
    
        if (!$exam) {
            return response()->json([
                "success" => false,
                "message" => "Exam not found",
            ], 404);
        }
    
        return response()->json([
            "success" => true,
            "message" => "Exam retrieved successfully",
            "data" => new ExamResource($exam),
        ], 200);
    }

   
}