<?php

use App\Http\Controllers\Api\ExamController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/student',[StudentController::class,"store"]);
Route::post('/exam/{examId}/correct/{Id}', [ExamController::class, 'ExamCorrection']);
Route::get('/exam/{Id}', [ExamController::class, 'getExam']);
Route::get('/exams', [ExamController::class, 'getExams']);