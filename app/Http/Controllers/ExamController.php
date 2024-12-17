<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exams = Exam::all();
        return view("Dashboard.Exams.index",compact("exams"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("Dashboard.Exams.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "subject_id" => "required|exists:subjects,id",
        ],
        
    [
                        'subject_id.required' => 'يجب إدخال اسم المادة.',
                        'subject_id.exists' => 'يجب أن تكون المادة مسجلة في قاعدة البيانات.',

            ]
        
        );
        Exam::create($validated);
        return back()->with("success","تم إضافة الامتحان بنجاح .");
    }

    /**
     * Display the specified resource.
     */
    public function show(Exam $exam)
    {
        $exam = Exam::findOrFail($exam);
        return view("Dashboard.Exams.show",compact("exam"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam)
    {
        $exam = Exam::findOrFail($exam);
        return view("Dashboard.Exams.edit",compact("exam"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exam $exam)
    {
            $validated = $request->validate([
                "subject_id" => "required|exists:subjects,id",
            ],
            
        [
                            'subject_id.required' => 'يجب إدخال اسم المادة.',
                            'subject_id.exists' => 'يجب أن تكون المادة مسجلة في قاعدة البيانات.',
    
                ]
        
            
        
        );
        $exam = Exam::findOrFail($exam);
        $exam->update($validated);
        return back()->with("success","تم تعديل تفاصيل الامتحان بنجاح .");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam)
    {
        $exam = Exam::findOrFail($exam);
        $exam->delete();
        return redirect()->route("exams.index")->with("success","الامتحان تم حذفه بنجاح");
    }
}
