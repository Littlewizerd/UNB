<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ===== Attendance Routes (ครู) =====
    Route::prefix('teacher')->name('teacher.')->middleware('role:teacher,admin')->group(function () {
        Route::get('/record', [AttendanceController::class, 'recordByTeacher'])->name('record');
        Route::post('/record-attendance', [AttendanceController::class, 'recordAttendanceByTeacher'])->name('record-attendance');
    });

    // ===== Classes Management (Admin Only) =====
    Route::middleware('role:admin')->group(function () {
        Route::resource('classes', ClassController::class);
    });

    // ===== Students Management =====
    // Admin: full CRUD
    Route::middleware('role:admin')->group(function () {
        Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
        Route::post('/students', [StudentController::class, 'store'])->name('students.store');
        Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
        Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
        Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
    });
    // Admin + Teacher: view only
    Route::middleware('role:admin,teacher')->group(function () {
        Route::get('/students', [StudentController::class, 'index'])->name('students.index');
        Route::get('/students/search', [StudentController::class, 'search'])->name('students.search');
        Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
    });

    // ===== Subjects (View: Admin/Teacher/Student, Manage: Admin Only) =====
    Route::middleware('role:admin')->group(function () {
        Route::get('/subjects/create', [SubjectController::class, 'create'])->name('subjects.create');
        Route::post('/subjects', [SubjectController::class, 'store'])->name('subjects.store');
        Route::get('/subjects/{subject}/edit', [SubjectController::class, 'edit'])->name('subjects.edit');
        Route::put('/subjects/{subject}', [SubjectController::class, 'update'])->name('subjects.update');
        Route::delete('/subjects/{subject}', [SubjectController::class, 'destroy'])->name('subjects.destroy');
    });

    Route::middleware('role:admin,teacher,student')->group(function () {
        Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');
        Route::get('/subjects/{subject}', [SubjectController::class, 'show'])->name('subjects.show');
    });

    // ===== Semesters Management (Admin Only) =====
    Route::middleware('is_admin')->group(function () {
        Route::resource('semesters', SemesterController::class);
    });

    // ===== Schedules Management (Admin Only) =====
    Route::middleware('role:admin')->group(function () {
        Route::resource('schedules', ScheduleController::class);
    });
    Route::get('/my-schedule', function () {
        if (auth()->user()->role === 'teacher') {
            return app(ScheduleController::class)->teacherSchedule();
        } elseif (auth()->user()->role === 'student') {
            return app(ScheduleController::class)->studentSchedule();
        }
    })->name('schedules.my-schedule');
    
    Route::get('/schedules/teacher/schedule', [ScheduleController::class, 'teacherSchedule'])
        ->middleware('role:teacher,admin')
        ->name('schedules.teacher-schedule');
    Route::get('/schedules/student/schedule', [ScheduleController::class, 'studentSchedule'])
        ->middleware('role:student,admin')
        ->name('schedules.student-schedule');

    // ===== Messages =====
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::get('/create', [MessageController::class, 'create'])->name('create');
        Route::post('/', [MessageController::class, 'store'])->name('store');
        Route::post('/send-class', [MessageController::class, 'storeClassMessage'])->name('store-class');
        Route::patch('/read-all', [MessageController::class, 'markAllAsRead'])->name('read-all');
        Route::post('/undo-delete', [MessageController::class, 'undoDelete'])->name('undo-delete');
        Route::delete('/bulk', [MessageController::class, 'bulkDestroy'])->name('bulk-destroy');
        Route::get('/{message}', [MessageController::class, 'show'])->name('show');
        Route::patch('/{message}/read', [MessageController::class, 'markAsRead'])->name('mark-read');
        Route::delete('/{message}', [MessageController::class, 'destroy'])->name('destroy');
    });

    // ===== User Management (Admin Only) =====
    Route::middleware('is_admin')->group(function () {
        Route::resource('users', UserController::class);
    });

    // ===== Reports =====
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::middleware('role:admin,teacher')->group(function () {
            Route::get('/daily-summary', [ReportController::class, 'dailySummary'])->name('dailySummary');
            Route::get('/class/{class}', [ReportController::class, 'classReport'])->name('classReport');
            Route::get('/class/{class}/pdf', [ReportController::class, 'classReportPdf'])->name('classReportPdf');
        });

        // Admin-only PDF reports
        Route::middleware('role:admin')->group(function () {
            Route::get('/users/pdf', [ReportController::class, 'userReportPdf'])->name('userReportPdf');
            Route::get('/subjects/pdf', [ReportController::class, 'subjectReportPdf'])->name('subjectReportPdf');
            Route::get('/classrooms/pdf', [ReportController::class, 'classroomReportPdf'])->name('classroomReportPdf');
            Route::get('/schedules/pdf', [ReportController::class, 'scheduleReportPdf'])->name('scheduleReportPdf');
        });

        Route::middleware('role:admin,teacher,student')->group(function () {
            Route::get('/student/{student}', [ReportController::class, 'individualReport'])->name('individualReport');
            Route::get('/student/{student}/pdf', [ReportController::class, 'individualReportPdf'])->name('individualReportPdf');
        });
    });
});

require __DIR__.'/auth.php';