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



  
public function ExamCorrection(Request $request, $examId)
{
    // Validate the request
    $request->validate([
        'answers' => 'required|array',
    ]);

    // Fetch the exam and its questions
    $exam = Exam::findOrFail($examId);
    $questions = Question::where('exam_id', $examId)->get();

    // Calculate the degree for each question
    $totalQuestions = $questions->count();
    $degreePerQuestion = 100 / $totalQuestions; // Degrees per question
    $totalScore = 0;

    // Iterate through each question and check the student's answer
    foreach ($questions as $question) {
        $questionId = $question->id;
        $questionType = $question->type;

        // Get the student's answer for this question
        $studentAnswer = $request->input("answers.$questionId");

        // Handle different question types
        switch ($questionType) {
            case 'mcq':
            case 'true_false':
                // For MCQ and True/False, check if the student's answer is correct
                $correctAnswer = Answer::where('question_id', $questionId)
                    ->where('is_correct', true)
                    ->first();

                if ($correctAnswer && $studentAnswer == $correctAnswer->id) {
                    $totalScore += $degreePerQuestion;
                }
                break;

            case 'ordering':
                // For ordering questions, check if the student's order matches the correct order
                $correctOrder = Answer::where('question_id', $questionId)
                    ->orderBy('order')
                    ->pluck('id')
                    ->toArray();

                $studentOrder = array_keys($studentAnswer); // Get the student's order
                if ($studentOrder == $correctOrder) {
                    $totalScore += $degreePerQuestion;
                }
                break;

            case 'passage':
                // For passage questions, handle subquestions
                $subQuestions = Question::where('parent_question_id', $questionId)->get();
                $subQuestionDegree = $degreePerQuestion / $subQuestions->count();

                foreach ($subQuestions as $subQuestion) {
                    $subQuestionId = $subQuestion->id;
                    $subQuestionType = $subQuestion->type;

                    // Get the student's answer for this subquestion
                    $subQuestionAnswer = $request->input("answers.$subQuestionId");

                    // Handle subquestion types
                    switch ($subQuestionType) {
                        case 'mcq':
                        case 'true_false':
                            // For MCQ and True/False, check if the student's answer is correct
                            $correctSubAnswer = Answer::where('question_id', $subQuestionId)
                                ->where('is_correct', true)
                                ->first();

                            if ($correctSubAnswer && $subQuestionAnswer == $correctSubAnswer->id) {
                                $totalScore += $subQuestionDegree;
                            }
                            break;

                        case 'ordering':
                            // For ordering subquestions, check if the student's order matches the correct order
                            $correctSubOrder = Answer::where('question_id', $subQuestionId)
                                ->orderBy('order')
                                ->pluck('id')
                                ->toArray();

                            $studentSubOrder = array_keys($subQuestionAnswer); // Get the student's order
                            if ($studentSubOrder == $correctSubOrder) {
                                $totalScore += $subQuestionDegree;
                            }
                            break;
                    }
                }
                break;
        }
    }

    // Return the total score to a Blade view
    return response()->json([
        "message"=>"Exam correction done",
        'total_score' => $totalScore,]
        ,200);}
}