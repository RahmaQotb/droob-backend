<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Traits\ImageUpload;


class ExamController extends Controller
{
    use ImageUpload;

    /**
     * عرض قائمة الامتحانات.
     */
    public function index()
    {
        $exams = Exam::all();
        return view("Dashboard.Exams.index", compact("exams"));
    }

    /**
     * عرض نموذج إنشاء امتحان جديد.
     */
    public function create()
    {
        $subjects = Subject::all();
        return view('Dashboard.Exams.create', compact('subjects'));
    }

    /**
     * حفظ الامتحان الجديد في قاعدة البيانات.
     */
    public function store(Request $request)
    {
        // التحقق من البيانات
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'questions' => 'required|array',
            'questions.*.text' => 'required|string',
            'questions.*.type' => 'required|in:mcq,true_false,ordering,passage',
            'questions.*.image' => 'nullable|image',
            'questions.*.answers' => 'required_if:questions.*.type,mcq,true_false,ordering|array',
            'questions.*.answers.*.text' => 'required|string',
            'questions.*.answers.*.image' => 'nullable|image',
            'questions.*.answers.*.order' => 'required_if:questions.*.type,ordering|integer|min:1',
            'questions.*.answers.*.is_correct' => 'required_if:questions.*.type,mcq,true_false|boolean',
        ], [
            'questions.*.answers.*.is_correct.required_if' => 'The is_correct field is required for MCQ and True/False questions.',
            'questions.*.answers.*.order.required_if' => 'The order field is required for ordering questions.',
        ]);
    
        // إنشاء الامتحان
        $exam = Exam::create([
            'name' => $validated['name'],
            'subject_id' => $validated['subject_id'],
        ]);
    
        // إضافة الأسئلة
        if (isset($validated['questions'])) {
            foreach ($validated['questions'] as $questionData) {
                $questionImage = null;
                if (isset($questionData['image'])) {
                    $questionImage = "storage/" . $this->uploadImage($questionData['image'], 'exams/questions/image');
                }
    
                $question = $exam->questions()->create([
                    'text' => json_encode($questionData['text']), 
                    'type' => $questionData['type'],
                    'image' => $questionImage,
                ]);
    
                // إضافة الإجابات
                foreach ($questionData['answers'] as $answerData) {
                    $answerImage = null;
                    if (isset($answerData['image'])) {
                        $answerImage = "storage/" . $this->uploadImage($answerData['image'], 'exams/answers/image');
                    }
    
                    // إنشاء مصفوفة البيانات للإجابة
                    $answerAttributes = [
                        'text' => json_encode($answerData['text']), 
                        'image' => $answerImage,
                    ];
    
                    // إذا كان السؤال من نوع ordering، أضف الترتيب
                    if ($questionData['type'] === 'ordering') {
                        $answerAttributes['order'] = $answerData['order'];
                    } else {
                        // إذا كان السؤال من نوع mcq أو true_false، أضف is_correct
                        $answerAttributes['is_correct'] = $answerData['is_correct'];
                    }
    
                    // إنشاء الإجابة
                    $question->answers()->create($answerAttributes);
                }
            }
        }
    
        return back()->with("success", "تم إضافة الامتحان بنجاح.");
    }
    /**
     * عرض تفاصيل الامتحان.
     */
    public function show(Exam $exam)
{
    $exam->load(['questions' => function ($query) {
        $query->with('answers')->paginate(10); // Paginate questions
    }]);
    return view('Dashboard.Exams.show', compact('exam'));
}

    /**
     * عرض نموذج تعديل الامتحان.
     */
    public function edit(Exam $exam)
    {
        $subjects = Subject::all();
        return view("Dashboard.Exams.edit", compact("exam", "subjects"));
    }

    /**
     * تحديث الامتحان في قاعدة البيانات.
     */
    public function update(Request $request, Exam $exam)
    {
        // التحقق من البيانات
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "subject_id" => "required|exists:subjects,id",
            "questions" => "nullable|array", 
            "questions.*.id" => "nullable|exists:questions,id", 
            "questions.*.text" => "required|string|max:255", 
            "questions.*.type" => "required|in:mcq,true_false,ordering", 
            "questions.*.image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048", 
            "questions.*.answers" => "required|array", 
            "questions.*.answers.*.id" => "nullable|exists:answers,id", 
            "questions.*.answers.*.text" => "required|string|max:255", 
            "questions.*.answers.*.image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048", 
            "questions.*.answers.*.is_correct" => "required|boolean", 
        ]);
    
        $exam->update([
            'name' => $validated['name'],
            'subject_id' => $validated['subject_id'],
        ]);
    
        if (isset($validated['questions'])) {
            foreach ($validated['questions'] as $questionData) {
                $questionImage = null;
                if (isset($questionData['image'])) {
                    $questionImage = "storage/" . $this->uploadImage($questionData['image'], 'exams/questions/image');
                }
    
                $question = $exam->questions()->updateOrCreate(
                    ['id' => $questionData['id'] ?? null], 
                    [
                        'text' => json_encode($questionData['text']), 
                        'type' => $questionData['type'],
                        'image' => $questionImage,
                    ]
                );
    
                foreach ($questionData['answers'] as $answerData) {
                    $answerImage = null;
                    if (isset($answerData['image'])) {
                        $answerImage = "storage/" . $this->uploadImage($answerData['image'], 'exams/answers/image');
                    }
    
                    $question->answers()->updateOrCreate(
                        ['id' => $answerData['id'] ?? null], 
                        [
                            'text' => json_encode($answerData['text']), 
                            'image' => $answerImage,
                            'is_correct' => $answerData['is_correct'],
                        ]
                    );
                }
            }
        }
    
        return back()->with("success", "تم تعديل تفاصيل الامتحان بنجاح.");
    }

    /**
     * حذف الامتحان من قاعدة البيانات.
     */
    public function destroy(Exam $exam)
    {
        if ($exam->image) {
            $exam->image = str_replace('storage', '', $exam->image);
            $this->deleteImage($exam->image);
        }
    
        $exam->delete();
 
        return redirect()->route("exams.index")->with("success", "الامتحان تم حذفه بنجاح");
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
        return view('exam-result', [
            'total_score' => $totalScore,
            'exam' => $exam,
        ]);
    }
    public function showExamForm($examId)
    {
        // Fetch the exam and its questions with answers
        $exam = Exam::with(['questions.answers'])->findOrFail($examId);
    
        return view('exam-form', [
            'exam' => $exam,
        ]);
    }

}