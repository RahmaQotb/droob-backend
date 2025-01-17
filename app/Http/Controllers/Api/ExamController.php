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
use Illuminate\Http\Request;

class ExamController extends Controller
{
    // ==================== Subjects ====================
    /**
     * عرض قائمة المواد.
     */
    public function getSubjects()
    {
        $subjects = Subject::all();
        return SubjectResource::collection($subjects);
    }

    /**
     * عرض تفاصيل مادة معينة.
     */
    public function getSubject($id)
    {
        $subject = Subject::findOrFail($id);
        return new SubjectResource($subject);
    }

    // ==================== Exams ====================
    /**
     * عرض قائمة الامتحانات.
     */
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
        if(!$exam){
            return response()->json([
                "success"=>false,
                "message"=>"exam not found",
            ],300);
        }
        return response()->json([
            "success"=>true,
            "message"=>"exam retrived successfully",
            "data"=> new ExamResource($exam),
        ],200);
    }

    // ==================== Questions ====================
    /**
     * عرض قائمة الأسئلة.
     */
    public function getQuestions()
    {
        $questions = Question::with(['exam', 'answers'])->get();
        return QuestionResource::collection($questions);
    }

    /**
     * عرض تفاصيل سؤال معين.
     */
    public function getQuestion($id)
    {
        $question = Question::with(['exam', 'answers'])->findOrFail($id);
        return new QuestionResource($question);
    }

  
    public function getAnswers()
    {
        $answers = Answer::with(['question'])->get();
        return AnswerResource::collection($answers);
    }

    /**
     * عرض تفاصيل إجابة معينة.
     */
    public function getAnswer($id)
    {
        $answer = Answer::with(['question'])->findOrFail($id);
        return new AnswerResource($answer);
    }



    public function calculateGrade(Request $request, Exam $exam)
    {
        
        $validated = $request->validate([
            'answers' => 'required|array', 
            'answers.*.question_id' => 'required|exists:questions,id', 
            'answers.*.answer_id' => 'nullable|exists:answers,id', 
            'answers.*.order' => 'nullable|array', 
        ]);
    
        $totalQuestions = $exam->questions->count(); 
        $gradePerQuestion = 100 / $totalQuestions; 
        $totalScore = 0; 
    
        
        foreach ($exam->questions as $question) {
            $studentAnswer = collect($validated['answers'])->firstWhere('question_id', $question->id);
    
            if ($studentAnswer) {
                switch ($question->type) {
                    case 'mcq':
                    case 'true_false':
                        $correctAnswer = $question->answers->firstWhere('is_correct', true);
                        if ($correctAnswer && $studentAnswer['answer_id'] == $correctAnswer->id) {
                            $totalScore += $gradePerQuestion; 
                        }
                        break;
    
                    case 'ordering':
                        $correctOrder = $question->answers->sortBy('order')->pluck('id')->toArray();
                        if ($studentAnswer['order'] === $correctOrder) {
                            $totalScore += $gradePerQuestion;
                        }
                        break;
    
                    default:
                       
                        break;
                }
            }
        }
       
        $percentageScore = round($totalScore, 2); 
    
        return response()->json([
            'success' => true,
            'message' => 'Grade calculated successfully.',
            'data' => [
                'total_questions' => $totalQuestions,
                'correct_answers' => $totalScore / $gradePerQuestion,
                'total_score' => $totalScore,
                'percentage_score' => $percentageScore . '%',
            ],
        ]);
    }
}