<?php

use App\Http\Controllers\Api\ExamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    
});

Route::post("/register",[AuthController::class,"register"]);
Route::post("/login",[AuthController::class,"login"]);

Route::middleware("auth:sanctum")->group(function(){
    Route::post("/logout",[AuthController::class,"logout"]);
});
// Routes for Subjects (Read-only)
Route::get('/subjects', [ExamController::class, 'getSubjects']); // عرض جميع المواد
Route::get('/subjects/{id}', [ExamController::class, 'getSubject']); // عرض مادة معينة

// Routes for Exams (Read-only)
Route::get('/exams', [ExamController::class, 'getExams']); // عرض جميع الامتحانات
Route::get('/exam/{id}', [ExamController::class, 'getExam']); // عرض امتحان معين

// Routes for Questions (Read-only)
Route::get('/questions', [ExamController::class, 'getQuestions']); // عرض جميع الأسئلة
Route::get('/questions/{id}', [ExamController::class, 'getQuestion']); // عرض سؤال معين

// Routes for Answers (Read-only)
Route::get('/answers', [ExamController::class, 'getAnswers']); // عرض جميع الإجابات
Route::get('/answers/{id}', [ExamController::class, 'getAnswer']);
