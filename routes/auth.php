

<?php


use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [StudentController::class, 'index'])->name('students.index');

