<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\RegistrationController;

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


Route::get('/registrations', [RegistrationController::class,'index'])->name('registrations.index');
Route::get('/registration/create', [RegistrationController::class,'getCreate'])->name('registration.create');
Route::post('/registration/create', [RegistrationController::class,'postCreate'])->name('registration.store');
Route::get('/registration/update/{id}', [RegistrationController::class,'getUpdate'])->name('registration.edit');
Route::post('/registration/update/{id}', [RegistrationController::class,'postUpdate'])->name('registration.update');
Route::get('/registration/view/{id}', [RegistrationController::class,'view'])->name('registration.view');
Route::get('/registration/find', [RegistrationController::class, 'find'])->name('registration.find');
Route::get('/registration/find', [RegistrationController::class, 'getFindBadge'])->name('registrations.find');
Route::post('/registration/find', [RegistrationController::class, 'postFindBadge'])->name('registrations.find.search');
Route::get('/registration/delete/{id}', [RegistrationController::class,'delete'])->name('registration.delete');
