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
        // تحديد القواعد بناءً على نوع الامتحان
        $rules = [
            'name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
        ];
    
        // إذا كان النموذج يحتوي على بيانات للقطعة النصية
        if ($request->has('type') && $request->type === 'passage_based') {
            $rules = array_merge($rules, [
                'type' => 'required|in:normal,passage_based',
                'passage_text' => 'required_if:type,passage_based|string',
                'passage_image' => 'nullable|image',
                'passage_questions' => 'required_if:type,passage_based|array',
                'passage_questions.*.text' => 'required_if:type,passage_based|string',
                'passage_questions.*.image' => 'nullable|image',
                'passage_questions.*.type' => 'required_if:type,passage_based|in:mcq,true_false,ordering',
                'passage_questions.*.answers' => 'required_if:type,passage_based|array',
                'passage_questions.*.answers.*.text' => 'required_if:type,passage_based|string',
                'passage_questions.*.answers.*.image' => 'nullable|image',
                'passage_questions.*.answers.*.is_correct' => 'required_if:passage_questions.*.type,mcq,true_false|boolean',
                'passage_questions.*.answers.*.order' => 'required_if:passage_questions.*.type,ordering|integer|min:1',
            ]);
        } else {
            // إذا كان النموذج للامتحان العادي
            $rules = array_merge($rules, [
                'questions' => 'required|array',
                'questions.*.text' => 'required|string',
                'questions.*.image' => 'nullable|image',
                'questions.*.type' => 'required|in:mcq,true_false,ordering',
                'questions.*.answers' => 'required|array',
                'questions.*.answers.*.text' => 'required|string',
                'questions.*.answers.*.image' => 'nullable|image',
                'questions.*.answers.*.is_correct' => 'required_if:questions.*.type,mcq,true_false|boolean',
                'questions.*.answers.*.order' => 'required_if:questions.*.type,ordering|integer|min:1',
            ]);
        }
    
        // التحقق من البيانات
        $validated = $request->validate($rules);
    
        // إنشاء الامتحان
        $exam = Exam::create([
            'name' => $validated['name'],
            'subject_id' => $validated['subject_id'],
            'type' => $request->type ?? 'normal', // النوع الافتراضي هو 'normal'
        ]);
    
        // إذا كان الامتحان مبني على قطعة نصية
        if ($exam->type === 'passage_based') {
            // إنشاء القطعة النصية
            $passage = $exam->questions()->create([
                'text' => $validated['passage_text'], // تحويل النص إلى JSON
                'type' => 'passage',
                'image' => isset($validated['passage_image']) ? $this->uploadImage($validated['passage_image'], 'passages') : null,
                'exam_id' => $exam->id,
            ]);
    
            // إنشاء الأسئلة الفرعية
            foreach ($validated['passage_questions'] as $questionData) {
                $question = $passage->subQuestions()->create([
                    'text' => $questionData['text'], // تحويل النص إلى JSON
                    'type' => $questionData['type'],
                    'image' => isset($questionData['image']) ? $this->uploadImage($questionData['image'], 'questions') : null,
                    'exam_id' => $exam->id,
                ]);
    
                // إنشاء الإجابات
                foreach ($questionData['answers'] as $answerData) {
                    $question->answers()->create([
                        'text' => $answerData['text'], // تحويل النص إلى JSON
                        'image' => isset($answerData['image']) ? $this->uploadImage($answerData['image'], 'answers') : null,
                        'is_correct' => $answerData['is_correct'] ?? false,
                        'order' => $answerData['order'] ?? null,
                    ]);
                }
            }
        } else {
            // إذا كان الامتحان عاديًا
            foreach ($validated['questions'] as $questionData) {
                $question = $exam->questions()->create([
                    'text' => $questionData['text'], // تحويل النص إلى JSON
                    'type' => $questionData['type'],
                    'image' => isset($questionData['image']) ? $this->uploadImage($questionData['image'], 'questions') : null,
                    'exam_id' => $exam->id,
                ]);
    
                // إنشاء الإجابات
                foreach ($questionData['answers'] as $answerData) {
                    $question->answers()->create([
                        'text' => $answerData['text'], // تحويل النص إلى JSON
                        'image' => isset($answerData['image']) ? $this->uploadImage($answerData['image'], 'answers') : null,
                        'is_correct' => $answerData['is_correct'] ?? false,
                        'order' => $answerData['order'] ?? null,
                    ]);
                }
            }
        }
    
        return redirect()->route('exams.index')->with('success', 'تم إنشاء الامتحان بنجاح.');
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
    public function edit($id)
    {
        $exam = Exam::with(['questions.answers', 'questions.subQuestions.answers'])->findOrFail($id);
        $subjects = Subject::all();
        if ($exam->type === 'passage_based') {
            return view('Dashboard.Exams.editPassage', compact(['exam','subjects']));
        } else {
            return view('Dashboard.Exams.edit', compact(['exam','subjects']));
        }
    }
    /**
     * تحديث الامتحان في قاعدة البيانات.
     */
    public function update(Request $request, Exam $exam)
    {
        // تحديد القواعد بناءً على نوع الامتحان
        $rules = [
            'name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
        ];
    
        // إذا كان النموذج يحتوي على بيانات للقطعة النصية
        if ($request->has('type') && $request->type === 'passage_based') {
            $rules = array_merge($rules, [
                'type' => 'required|in:normal,passage_based',
                'passage_text' => 'required_if:type,passage_based|string',
                'passage_image' => 'nullable|image',
                'passage_questions' => 'required_if:type,passage_based|array',
                'passage_questions.*.text' => 'required_if:type,passage_based|string',
                'passage_questions.*.image' => 'nullable|image',
                'passage_questions.*.type' => 'required_if:type,passage_based|in:mcq,true_false,ordering',
                'passage_questions.*.answers' => 'required_if:type,passage_based|array',
                'passage_questions.*.answers.*.text' => 'required_if:type,passage_based|string',
                'passage_questions.*.answers.*.image' => 'nullable|image',
                'passage_questions.*.answers.*.is_correct' => 'required_if:passage_questions.*.type,mcq,true_false|boolean',
                'passage_questions.*.answers.*.order' => 'required_if:passage_questions.*.type,ordering|integer|min:1',
            ]);
        } else {
            // إذا كان النموذج للامتحان العادي
            $rules = array_merge($rules, [
                'questions' => 'required|array',
                'questions.*.text' => 'required|string',
                'questions.*.image' => 'nullable|image',
                'questions.*.type' => 'required|in:mcq,true_false,ordering',
                'questions.*.answers' => 'required|array',
                'questions.*.answers.*.text' => 'required|string',
                'questions.*.answers.*.image' => 'nullable|image',
                'questions.*.answers.*.is_correct' => 'required_if:questions.*.type,mcq,true_false|boolean',
                'questions.*.answers.*.order' => 'required_if:questions.*.type,ordering|integer|min:1',
            ]);
        }
    
        // التحقق من البيانات
        $validated = $request->validate($rules);
    
        // تحديث بيانات الامتحان
        $exam->update([
            'name' => $validated['name'],
            'subject_id' => $validated['subject_id'],
            'type' => $request->type ?? 'normal', // النوع الافتراضي هو 'normal'
        ]);
    
        // إذا كان الامتحان مبني على قطعة نصية
        if ($exam->type === 'passage_based') {
            // تحديث القطعة النصية
            $passage = $exam->questions()->where('type', 'passage')->first();
            if ($passage) {
                $passage->update([
                    'text' => $validated['passage_text'], // تحويل النص إلى JSON
                    'image' => isset($validated['passage_image']) ? $this->uploadImage($validated['passage_image'], 'passages') : $passage->image,
                ]);
            } else {
                $passage = $exam->questions()->create([
                    'text' => $validated['passage_text'], // تحويل النص إلى JSON
                    'type' => 'passage',
                    'image' => isset($validated['passage_image']) ? $this->uploadImage($validated['passage_image'], 'passages') : null,
                    'exam_id' => $exam->id,
                ]);
            }
    
            // تحديث الأسئلة الفرعية
            foreach ($validated['passage_questions'] as $questionData) {
                $question = $passage->subQuestions()->updateOrCreate(
                    ['id' => $questionData['id'] ?? null], // إذا كان السؤال موجودًا، قم بتحديثه، وإلا قم بإنشائه
                    [
                        'text' => $questionData['text'], // تحويل النص إلى JSON
                        'type' => $questionData['type'],
                        'image' => isset($questionData['image']) ? $this->uploadImage($questionData['image'], 'questions') : null,
                        'exam_id' => $exam->id,
                    ]
                );
    
                // تحديث الإجابات
                foreach ($questionData['answers'] as $answerData) {
                    $question->answers()->updateOrCreate(
                        ['id' => $answerData['id'] ?? null], // إذا كانت الإجابة موجودة، قم بتحديثها، وإلا قم بإنشائها
                        [
                            'text' => $answerData['text'], // تحويل النص إلى JSON
                            'image' => isset($answerData['image']) ? $this->uploadImage($answerData['image'], 'answers') : null,
                            'is_correct' => $answerData['is_correct'] ?? false,
                            'order' => $answerData['order'] ?? null,
                        ]
                    );
                }
            }
        } else {
            // إذا كان الامتحان عاديًا
            foreach ($validated['questions'] as $questionData) {
                $question = $exam->questions()->updateOrCreate(
                    ['id' => $questionData['id'] ?? null], // إذا كان السؤال موجودًا، قم بتحديثه، وإلا قم بإنشائه
                    [
                        'text' => json_encode([$questionData['text']]), // تحويل النص إلى JSON
                        'type' => $questionData['type'],
                        'image' => isset($questionData['image']) ? $this->uploadImage($questionData['image'], 'questions') : null,
                        'exam_id' => $exam->id,
                    ]
                );
    
                // تحديث الإجابات
                foreach ($questionData['answers'] as $answerData) {
                    $question->answers()->updateOrCreate(
                        ['id' => $answerData['id'] ?? null], // إذا كانت الإجابة موجودة، قم بتحديثها، وإلا قم بإنشائها
                        [
                            'text' => json_encode([$answerData['text']]), // تحويل النص إلى JSON
                            'image' => isset($answerData['image']) ? $this->uploadImage($answerData['image'], 'answers') : null,
                            'is_correct' => $answerData['is_correct'] ?? false,
                            'order' => $answerData['order'] ?? null,
                        ]
                    );
                }
            }
        }
    
        return redirect()->route('exams.index')->with('success', 'تم تحديث الامتحان بنجاح.');
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
    public function createPassage()
    {
    $subjects = Subject::all(); 
    return view("Dashboard.Exams.passage" ,compact('subjects'));
    }
}