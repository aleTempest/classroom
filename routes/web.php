<?php

use App\Http\Controllers\CareerController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Estas rutas solo pueden ser accedidas por usuarios con rol 'admin'.
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resources([
        'careers' => CareerController::class,
        'teachers' => TeacherController::class,
        'students' => StudentController::class,
    ]);
});
