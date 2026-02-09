<?php


use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;


Route::get('/api/students', [StudentController::class, 'apiIndex']);

Route::get('/api/students/{id}', [StudentController::class, 'apiShow']);

Route::post('/api/student/update/{id}', [StudentController::class, 'apiUpdate']);

Route::delete('/api/student/delete/{id}', [StudentController::class, 'apiDestroy']);


Route::post('/api/students', [StudentController::class, 'apiStore']);
