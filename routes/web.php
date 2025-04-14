<?php

use App\Http\Controllers\CareerController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherRoomController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\TeacherPostController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [SessionController::class, 'dashboard'])
        ->name('dashboard')
        ->middleware('auth');
});

// Estas rutas solo pueden ser accedidas por usuarios con rol 'admin'.
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin-dashboard', [AdminDashboardController::class, 'index']);
    Route::resources([
        'careers' => CareerController::class,
        'teachers' => TeacherController::class,
        'rooms' => RoomController::class,
    ]);
    Route::get('/admin/posts', [AdminPostController::class, 'index'])->name('admin.posts.index');
});

Route::middleware(['auth', 'teacher'])->group(function () {
    Route::resources([
        'students' => StudentController::class,
        'posts' => PostController::class,
    ]);
    Route::get('/teacher-dashboard', [TeacherRoomController::class, 'index']);
    Route::get('/teacher/posts', [TeacherPostController::class, 'index'])->name('teacher.posts.index');
});
