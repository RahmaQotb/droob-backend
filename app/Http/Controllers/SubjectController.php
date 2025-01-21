<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::all();
        return view('Dashboard.subject.index', compact('subjects'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Dashboard.subject.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|string|max:255|unique:subjects',
                'desc' => 'nullable|string',
            ],

            [
                'name.required' => 'يجب إدخال الاسم.',
                'name.string' => 'يجب أن يكون الأسم نصًا.',
                'name.unique' => 'هذا الاسم مستخدم من قبل.',
                'desc.string' => 'يجب أن يكون الوصف نصًا.',

            ]
        );

        Subject::create($validated);


        // $subjects = Subject::all();
        return redirect()->route('subjects.index')->with('success', 'تم إضافة المادة بنجاح.');  
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subject = Subject::findOrFail($id);
        return view('Dashboard.subject.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate(
            [
                'name' => 'required|string|max:255|unique:subjects,name,'.$id,
                'desc' => 'nullable|string',
            ],

            [
                'name.required' => 'يجب إدخال الاسم.',
                'name.string' => 'يجب أن يكون الأسم نصًا.',
                'name.unique' => 'هذا الاسم مستخدم من قبل.',
                'desc.string' => 'يجب أن يكون الوصف نصًا.',

            ]
        );


        $subject = Subject::findOrFail($id);
        $subject->update($validated);

        $subjects = Subject::all();
        return redirect()->route('subjects.index')->with('success', 'تم تحديث المادة بنجاح.');    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        // $subjects = Subject::all();
        return redirect()->route('subjects.index')->with('success', 'تم حذف المادة بنجاح.');    }
}
