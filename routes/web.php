<?php

use App\Http\Controllers\ExamController;
use App\Models\Exam;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $exams = Exam::all();
    return view('Dashboard.Exams.index' , compact('exams'));
});


require __DIR__."/dashboard.php";

Route::get('/exam/{examId}/form', [ExamController::class, 'showExamForm'])->name('exam.form');
Route::post('/exam/{examId}/correction', [ExamController::class, 'ExamCorrection'])->name('exam.correction');