<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/students', [StudentController::class,'index'])->name('students.index');
Route::get('/student/create', [StudentController::class,'getCreate'])->name('student.create');
Route::post('/student/create', [StudentController::class,'postCreate'])->name('student.store');
Route::get('/student/update/{id}', [StudentController::class,'getUpdate'])->name('student.edit');
Route::post('/student/update/{id}', [StudentController::class,'postUpdate'])->name('student.update');
Route::get('/student/view/{id}', [StudentController::class,'view'])->name('student.view');
Route::get('/student/delete/{id}', [StudentController::class,'delete'])->name('student.delete');
