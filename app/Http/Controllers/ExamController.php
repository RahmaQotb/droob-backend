<?php

namespace App\Http\Controllers;

use App\Models\Exam;
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
            "name" => "required|string|max:255",
            "subject_id" => "required|exists:subjects,id",
            "questions" => "nullable|array", 
            "questions.*.text" => "required|string|max:255", 
            "questions.*.type" => "required|in:mcq,true_false,ordering", 
            "questions.*.image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048", 
            "questions.*.answers" => "required|array", 
            "questions.*.answers.*.text" => "required|string|max:255", 
            "questions.*.answers.*.image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048", 
            "questions.*.answers.*.is_correct" => "required|boolean", 
        ]);

        $exam = Exam::create([
            'name' => $validated['name'],
            'subject_id' => $validated['subject_id'],
        ]);

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

              
                foreach ($questionData['answers'] as $answerData) {
                    $answerImage = null;
                    if (isset($answerData['image'])) {
                        $answerImage = "storage/" . $this->uploadImage($answerData['image'], 'exams/answers/image');
                    }

                    $question->answers()->create([
                        'text' => json_encode($answerData['text']), 
                        'image' => $answerImage,
                        'is_correct' => $answerData['is_correct'],
                    ]);
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
}