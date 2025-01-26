<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        return view("Dashboard.student.index" , compact("students"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            "name"=>"required|string|max:255",
            "gender"=>"required|in:0,1",
            "level"=>"required|string|in:4,5,6",
        ]);
        if($validator->fails()){
            return response()->json([
                "message"=>"failed data entered",
                "data"=>$validator->errors()
            ],300);
        }
        $student = Student::create($request->all());
        return response()->json([
            "message"=>"student created successfully",
            "data"=>$student
        ],200);
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     $student = Student::findOrFail($id);

    //     $grades = $student->grades;
    //     return view('Dashboard.student.show', compact('student', 'grades'));
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);

        $student->grades()->delete();

        $student->delete();

        return redirect()->route('students.index')->with('success', 'تم حذف الطالب بنجاح');
    }
}
