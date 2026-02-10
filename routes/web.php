<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ===== Attendance Routes (นักเรียน) =====
    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/check-in', [AttendanceController::class, 'checkIn'])->name('check-in');
        Route::post('/store', [AttendanceController::class, 'store'])->name('store');
        Route::get('/history', [AttendanceController::class, 'history'])->name('history');
        Route::get('/statistics/{student}', [AttendanceController::class, 'statistics'])->name('statistics');
    });

    // ===== Attendance Routes (ครู) =====
    Route::prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/record', [AttendanceController::class, 'recordByTeacher'])->name('record');
        Route::post('/record-attendance', [AttendanceController::class, 'recordAttendanceByTeacher'])->name('record-attendance');
    });

    // ===== Classes Management =====
    Route::resource('classes', ClassController::class);

    // ===== Students Management =====
    Route::resource('students', StudentController::class);
    Route::get('/students/search', [StudentController::class, 'search'])->name('students.search');

    // ===== Teachers Management =====
    Route::resource('teachers', TeacherController::class);
    Route::get('/teachers/search', [TeacherController::class, 'search'])->name('teachers.search');

    // ===== Subjects Management =====
    Route::resource('subjects', SubjectController::class);

    // ===== User Management (Admin Only) =====
    Route::middleware('is_admin')->group(function () {
        Route::resource('users', UserController::class);
    });

    // ===== Reports =====
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/daily-summary', [ReportController::class, 'dailySummary'])->name('dailySummary');
        Route::get('/class/{class}', [ReportController::class, 'classReport'])->name('classReport');
        Route::get('/class/{class}/pdf', [ReportController::class, 'classReportPdf'])->name('classReportPdf');
        Route::get('/subject/{subject}', [ReportController::class, 'subjectReport'])->name('subjectReport');
        Route::get('/student/{student}', [ReportController::class, 'individualReport'])->name('individualReport');
        Route::get('/student/{student}/pdf', [ReportController::class, 'individualReportPdf'])->name('individualReportPdf');
        Route::get('/risk-report', [ReportController::class, 'riskReport'])->name('riskReport');
    });
});

require __DIR__.'/auth.php';