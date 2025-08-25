<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TrainingCourseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LanguageController;

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('dashboard')->middleware('auth');

// Courses routs
Route::get('courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('courses/create', [CourseController::class, 'create'])->name('courses.create');
Route::post('courses', [CourseController::class, 'store'])->name('courses.store');
Route::get('courses/{id}', [CourseController::class, 'show'])->name('courses.show');
Route::get('courses/{id}/edit', [CourseController::class, 'edit'])->name('courses.edit');
Route::put('courses/{id}', [CourseController::class, 'update'])->name('courses.update');
Route::delete('courses/{id}', [CourseController::class, 'destroy'])->name('courses.destroy');
Route::post('courses/search', [CourseController::class, 'search'])->name('courses.search');


// Students routes
Route::resource('students', StudentController::class);
Route::post('students/search', [StudentController::class, 'search'])->name('students.search');

// Training courses routes
Route::resource('training-courses', TrainingCourseController::class);
Route::get('training-courses/addStudent/{id}', [TrainingCourseController::class, 'addStudent'])->name('training-courses.addStudent');
Route::post('training-courses/addStudent/{id}', [TrainingCourseController::class, 'storeStudent'])->name('training-courses.storeStudent');
Route::delete('training-courses/{courseId}/removeStudent/{studentId}', [TrainingCourseController::class, 'destroyStudent'])->name('training-courses.destroyStudent');

// Authentication Routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.post');

// Localization Route
Route::get('language/switch', [LanguageController::class, 'switchLocale'])->name('language.switch');


// OAuth Google
// توجيه المستخدم لمزود الخدمة
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');

// استلام البيانات بعد تسجيل الدخول
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);


// Fallback Route
Route::fallback(function () {
    // Handle 404 errors
    return response()->json(['error' => 'Not Found'], 404);
});