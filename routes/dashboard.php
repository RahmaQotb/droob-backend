<?php

use App\Http\Controllers\ExamController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::prefix("/dashboard")->group(function () {
    Route::resource("exams",ExamController::class);
    // Route::get('/exams/passage', [ExamController::class, 'createPassage  '])->name('exams.passage');
    Route::resource("students" , StudentController::class);
    Route::resource("subjects" , SubjectController::class);

});
Route::get('/exams/passage', [ExamController::class, 'createPassage'])->name('exams.passage');