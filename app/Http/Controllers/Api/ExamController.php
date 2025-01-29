<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExamResource;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\AnswerResource;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Student;
use Illuminate\Http\Request;

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
    public function ExamCorrection(Request $request, $examId, $id)
    {
        $request->validate([
            'answers' => 'required|array',
        ]);
    
        $student = Student::findOrFail($id);
        $exam = Exam::findOrFail($examId);
        $questions = Question::where('exam_id', $examId)->whereNull('parent_question_id')->get();
    
        $totalQuestions = $questions->count();
        $degreePerQuestion = 100 / $totalQuestions;
        $totalScore = 0;
    
        foreach ($questions as $question) {
            $questionId = $question->id;
            $questionType = $question->type;
    
            $studentAnswer = $request->input("answers.$questionId");
    
            switch ($questionType) {
                case 'mcq':
                case 'true_false':
                    $correctAnswer = Answer::where('question_id', $questionId)
                        ->where('is_correct', true)
                        ->first();
    
                    if ($correctAnswer && $studentAnswer == $correctAnswer->id) {
                        $totalScore += $degreePerQuestion;
                    }
                    break;
    
                case 'ordering':
                    $correctOrder = Answer::where('question_id', $questionId)
                        ->orderBy('order')
                        ->pluck('id')
                        ->toArray();
    
                    $studentOrder = array_keys($studentAnswer);
                    if ($studentOrder === $correctOrder) {
                        $totalScore += $degreePerQuestion;
                    }
                    break;
    
                case 'passage':
                    $subQuestions = Question::where('parent_question_id', $questionId)->get();
                    $subQuestionDegree = $degreePerQuestion / $subQuestions->count();
    
                    foreach ($subQuestions as $subQuestion) {
                        $subQuestionId = $subQuestion->id;
                        $subQuestionType = $subQuestion->type;
    
                        $subQuestionAnswer = $request->input("answers.$subQuestionId");
    
                        switch ($subQuestionType) {
                            case 'mcq':
                            case 'true_false':
                                $correctSubAnswer = Answer::where('question_id', $subQuestionId)
                                    ->where('is_correct', true)
                                    ->first();
    
                                if ($correctSubAnswer && $subQuestionAnswer == $correctSubAnswer->id) {
                                    $totalScore += $subQuestionDegree;
                                }
                                break;
    
                            case 'ordering':
                                $correctSubOrder = Answer::where('question_id', $subQuestionId)
                                    ->orderBy('order')
                                    ->pluck('id')
                                    ->toArray();
    
                                $studentSubOrder = array_keys($subQuestionAnswer);
                                if ($studentSubOrder === $correctSubOrder) {
                                    $totalScore += $subQuestionDegree;
                                }
                                break;
                        }
                    }
                    break;
            }
        }
    
        $totalScore = min(100, max(0, $totalScore));
    
        Grade::create([
            'exam_id' => $exam->id,
            'student_id' => $student->id,
            'degree' => $totalScore,
        ]);
    
        return response()->json([
            "message" => "Exam correction done",
            'total_score' => $totalScore,
        ], 200);
    }
    }
   
