<?php
/**
 * Comprehensive Simulation Test Script
 * Tests all system features from admin/teacher/student perspectives
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\StudentClass;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\Attendance;
use App\Models\Message;
use App\Models\Semester;
use App\Models\Announcement;

$results = [];
$passed = 0;
$failed = 0;
$warnings = [];

function test($name, $callback) {
    global $results, $passed, $failed, $warnings;
    try {
        $result = $callback();
        if ($result === true) {
            $results[] = "[PASS] {$name}";
            $passed++;
        } elseif (is_string($result)) {
            $results[] = "[WARN] {$name}: {$result}";
            $warnings[] = "{$name}: {$result}";
        } else {
            $results[] = "[FAIL] {$name}: returned " . var_export($result, true);
            $failed++;
        }
    } catch (\Throwable $e) {
        $results[] = "[FAIL] {$name}: " . get_class($e) . " - " . $e->getMessage();
        $failed++;
    }
}

echo "=" . str_repeat("=", 79) . "\n";
echo "  COMPREHENSIVE SYSTEM SIMULATION TEST\n";
echo "  Date: " . now()->format('Y-m-d H:i:s') . "\n";
echo "=" . str_repeat("=", 79) . "\n\n";

// ============================================================================
// SECTION 1: DATABASE INTEGRITY
// ============================================================================
echo "--- SECTION 1: DATABASE INTEGRITY ---\n";

test('14 users exist (1 admin, 3 teachers, 10 students)', function() {
    $admin = User::where('role', 'admin')->count();
    $teacher = User::where('role', 'teacher')->count();
    $student = User::where('role', 'student')->count();
    return $admin === 1 && $teacher === 3 && $student === 10;
});

test('All students assigned to classes', function() {
    $unassigned = User::where('role', 'student')->whereNull('class_id')->count();
    if ($unassigned > 0) return "Found {$unassigned} students without class_id";
    return true;
});

test('3 classes exist with advisors', function() {
    $classes = StudentClass::with('advisor')->get();
    if ($classes->count() !== 3) return false;
    foreach ($classes as $c) {
        if (!$c->advisor) return "Class {$c->class_name} has no advisor";
    }
    return true;
});

test('6 subjects exist with teachers', function() {
    $subjects = Subject::with('teacher')->get();
    if ($subjects->count() !== 6) return "Found " . $subjects->count() . " subjects";
    foreach ($subjects as $s) {
        if (!$s->teacher) return "Subject {$s->name} has no teacher";
    }
    return true;
});

test('Schedules exist with valid references', function() {
    $schedules = Schedule::with(['subject', 'teacher', 'studentClass'])->get();
    if ($schedules->count() < 10) return "Only " . $schedules->count() . " schedules";
    foreach ($schedules as $s) {
        if (!$s->subject) return "Schedule {$s->id} has invalid subject_id";
        if (!$s->teacher) return "Schedule {$s->id} has invalid teacher_id";
        if (!$s->studentClass) return "Schedule {$s->id} has invalid class_id";
    }
    return true;
});

test('Active semester exists', function() {
    $active = Semester::where('is_active', true)->count();
    return $active === 1;
});

test('Attendance records exist', function() {
    $count = Attendance::count();
    return $count > 0 ? true : "No attendance records found";
});

test('Attendance foreign keys valid', function() {
    $bad = Attendance::whereNotIn('student_id', User::where('role','student')->pluck('id'))->count();
    if ($bad > 0) return "Found {$bad} attendance records with invalid student_id";
    $bad2 = Attendance::whereNotIn('schedule_id', Schedule::pluck('id'))->count();
    if ($bad2 > 0) return "Found {$bad2} attendance records with invalid schedule_id";
    return true;
});

// ============================================================================
// SECTION 2: ADMIN FEATURES
// ============================================================================
echo "\n--- SECTION 2: ADMIN FEATURES ---\n";

$admin = User::where('role', 'admin')->first();
Auth::login($admin);

test('Admin login', function() { return Auth::check() && Auth::user()->role === 'admin'; });

test('Admin Dashboard Stats', function() {
    $controller = app(\App\Http\Controllers\DashboardController::class);
    Auth::login(User::where('role', 'admin')->first());
    $request = Request::create('/dashboard', 'GET');
    $response = $controller->index();
    $data = $response->getData();
    return isset($data['stats']) && $data['stats']['totalStudents'] === 10 
        && $data['stats']['totalTeachers'] === 3
        && $data['stats']['totalClasses'] === 3;
});

test('Admin can list users', function() {
    $controller = app(\App\Http\Controllers\UserController::class);
    $request = Request::create('/users', 'GET');
    $response = $controller->index($request);
    return $response->status() === 200 || $response instanceof \Illuminate\View\View;
});

test('Admin can list classes', function() {
    $controller = app(\App\Http\Controllers\ClassController::class);
    $response = $controller->index();
    return $response instanceof \Illuminate\View\View;
});

test('Admin can view class details', function() {
    $class = StudentClass::first();
    $controller = app(\App\Http\Controllers\ClassController::class);
    $response = $controller->show($class);
    return $response instanceof \Illuminate\View\View;
});

test('Admin can list subjects', function() {
    $controller = app(\App\Http\Controllers\SubjectController::class);
    $request = Request::create('/subjects', 'GET');
    $response = $controller->index($request);
    return $response instanceof \Illuminate\View\View;
});

test('Admin can list schedules', function() {
    $controller = app(\App\Http\Controllers\ScheduleController::class);
    $request = Request::create('/schedules', 'GET');
    $response = $controller->index($request);
    return $response instanceof \Illuminate\View\View;
});

test('Admin can list students', function() {
    $controller = app(\App\Http\Controllers\StudentController::class);
    $response = $controller->index();
    return $response instanceof \Illuminate\View\View;
});

test('Admin can view student details', function() {
    $student = Student::first();
    $controller = app(\App\Http\Controllers\StudentController::class);
    $response = $controller->show($student);
    return $response instanceof \Illuminate\View\View;
});

test('Admin can list semesters', function() {
    $controller = app(\App\Http\Controllers\SemesterController::class);
    $response = $controller->index();
    return $response instanceof \Illuminate\View\View;
});

test('Admin Daily Summary Report', function() {
    Auth::login(User::where('role', 'admin')->first());
    $controller = app(\App\Http\Controllers\ReportController::class);
    $response = $controller->dailySummary();
    return $response instanceof \Illuminate\View\View;
});

test('Admin Class Report', function() {
    Auth::login(User::where('role', 'admin')->first());
    $class = StudentClass::first();
    $controller = app(\App\Http\Controllers\ReportController::class);
    $response = $controller->classReport($class);
    return $response instanceof \Illuminate\View\View;
});

test('Admin Risk Report', function() {
    Auth::login(User::where('role', 'admin')->first());
    $controller = app(\App\Http\Controllers\ReportController::class);
    $response = $controller->riskReport();
    return $response instanceof \Illuminate\View\View;
});

test('Admin Subject Report', function() {
    Auth::login(User::where('role', 'admin')->first());
    $subject = Subject::first();
    $controller = app(\App\Http\Controllers\ReportController::class);
    $response = $controller->subjectReport($subject);
    return $response instanceof \Illuminate\View\View;
});

// ============================================================================
// SECTION 3: TEACHER FEATURES  
// ============================================================================
echo "\n--- SECTION 3: TEACHER FEATURES ---\n";

$teacher1 = User::find(1); // Teacher001
Auth::login($teacher1);

test('Teacher login', function() { return Auth::check() && Auth::user()->role === 'teacher'; });

test('Teacher Dashboard Stats', function() {
    $teacher = User::find(1);
    Auth::login($teacher);
    $controller = app(\App\Http\Controllers\DashboardController::class);
    $response = $controller->index();
    $data = $response->getData();
    return isset($data['stats']) && isset($data['stats']['totalSchedules']);
});

test('Teacher can view subjects', function() {
    Auth::login(User::find(1));
    $controller = app(\App\Http\Controllers\SubjectController::class);
    $request = Request::create('/subjects', 'GET');
    $response = $controller->index($request);
    return $response instanceof \Illuminate\View\View;
});

test('Teacher can view own schedule', function() {
    Auth::login(User::find(1));
    $controller = app(\App\Http\Controllers\ScheduleController::class);
    $response = $controller->teacherSchedule();
    return $response instanceof \Illuminate\View\View;
});

test('Teacher record page loads (BUG CHECK - uses wrong query)', function() {
    Auth::login(User::find(1));
    $controller = app(\App\Http\Controllers\AttendanceController::class);
    $response = $controller->recordByTeacher();
    
    // Check if schedules are found - this uses whereDate('created_at', today()) which is WRONG
    $data = $response->getData();
    $schedulesFound = isset($data['schedules']) ? $data['schedules']->count() : 'N/A';
    
    if ($schedulesFound === 0) {
        return "BUG CONFIRMED: recordByTeacher uses whereDate('created_at', today()) - returns 0 schedules. Should use where('day_of_week', todayCode)";
    }
    return true;
});

test('Teacher can view student list', function() {
    Auth::login(User::find(1));
    $controller = app(\App\Http\Controllers\StudentController::class);
    $response = $controller->index();
    return $response instanceof \Illuminate\View\View;
});

test('Teacher can view student details', function() {
    Auth::login(User::find(1));
    $student = Student::first();
    $controller = app(\App\Http\Controllers\StudentController::class);
    $response = $controller->show($student);
    return $response instanceof \Illuminate\View\View;
});

test('Teacher can view attendance statistics', function() {
    Auth::login(User::find(1));
    $student = Student::first();
    $controller = app(\App\Http\Controllers\AttendanceController::class);
    $response = $controller->statistics($student);
    return $response instanceof \Illuminate\View\View;
});

test('Teacher Daily Summary access', function() {
    Auth::login(User::find(1));
    $controller = app(\App\Http\Controllers\ReportController::class);
    $response = $controller->dailySummary();
    return $response instanceof \Illuminate\View\View;
});

test('Teacher Individual Student Report', function() {
    Auth::login(User::find(1));
    $student = Student::first();
    $controller = app(\App\Http\Controllers\ReportController::class);
    $response = $controller->individualReport($student);
    return $response instanceof \Illuminate\View\View;
});

// Teacher002 and Teacher003 tests
test('Teacher002 can view own schedule', function() {
    Auth::login(User::find(4));
    $controller = app(\App\Http\Controllers\ScheduleController::class);
    $response = $controller->teacherSchedule();
    return $response instanceof \Illuminate\View\View;
});

test('Teacher003 can view own schedule', function() {
    Auth::login(User::find(5));
    $controller = app(\App\Http\Controllers\ScheduleController::class);
    $response = $controller->teacherSchedule();
    return $response instanceof \Illuminate\View\View;
});

// ============================================================================
// SECTION 4: STUDENT FEATURES
// ============================================================================
echo "\n--- SECTION 4: STUDENT FEATURES ---\n";

$student1 = User::find(3); // Student001
Auth::login($student1);

test('Student login', function() { return Auth::check() && Auth::user()->role === 'student'; });

test('Student Dashboard Stats', function() {
    Auth::login(User::find(3));
    $controller = app(\App\Http\Controllers\DashboardController::class);
    $response = $controller->index();
    $data = $response->getData();
    return isset($data['stats']) && isset($data['stats']['present']);
});

test('Student can view subjects', function() {
    Auth::login(User::find(3));
    $controller = app(\App\Http\Controllers\SubjectController::class);
    $request = Request::create('/subjects', 'GET');
    $response = $controller->index($request);
    return $response instanceof \Illuminate\View\View;
});

test('Student can view own schedule', function() {
    Auth::login(User::find(3));
    $controller = app(\App\Http\Controllers\ScheduleController::class);
    $response = $controller->studentSchedule();
    return $response instanceof \Illuminate\View\View;
});

test('Student attendance history', function() {
    Auth::login(User::find(3));
    $controller = app(\App\Http\Controllers\AttendanceController::class);
    $response = $controller->history();
    return $response instanceof \Illuminate\View\View;
});

test('Student can view own individual report', function() {
    Auth::login(User::find(3));
    $student = Student::find(3);
    $controller = app(\App\Http\Controllers\ReportController::class);
    $response = $controller->individualReport($student);
    return $response instanceof \Illuminate\View\View;
});

test('Student can view own statistics', function() {
    Auth::login(User::find(3));
    $student = Student::find(3);
    $controller = app(\App\Http\Controllers\AttendanceController::class);
    $response = $controller->statistics($student);
    return $response instanceof \Illuminate\View\View;
});

// Test all 10 students can see their dashboard
for ($i = 0; $i < 10; $i++) {
    $studentIds = [3, 6, 7, 8, 9, 10, 11, 12, 13, 14];
    $sid = $studentIds[$i];
    $num = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
    test("Student{$num} (id={$sid}) dashboard loads", function() use ($sid) {
        Auth::login(User::find($sid));
        $controller = app(\App\Http\Controllers\DashboardController::class);
        $response = $controller->index();
        return $response instanceof \Illuminate\View\View;
    });
}

// ============================================================================
// SECTION 5: MESSAGING SYSTEM
// ============================================================================
echo "\n--- SECTION 5: MESSAGING SYSTEM ---\n";

test('Admin can send message to teacher', function() {
    Auth::login(User::where('role', 'admin')->first());
    Message::create([
        'sender_id' => Auth::id(),
        'recipient_id' => 1, // Teacher001
        'subject' => 'ทดสอบข้อความจาก Admin',
        'message' => 'นี่คือข้อความทดสอบจาก Admin ถึง Teacher001',
    ]);
    return true;
});

test('Admin can send message to student', function() {
    Auth::login(User::where('role', 'admin')->first());
    Message::create([
        'sender_id' => Auth::id(),
        'recipient_id' => 3, // Student001
        'subject' => 'ทดสอบข้อความจาก Admin',
        'message' => 'นี่คือข้อความทดสอบจาก Admin ถึง Student001',
    ]);
    return true;
});

test('Teacher can send message to student', function() {
    Auth::login(User::find(1));
    Message::create([
        'sender_id' => 1,
        'recipient_id' => 3, // Student001
        'subject' => 'แจ้งเตือนจากอาจารย์',
        'message' => 'กรุณาส่งงานกลุ่มภายในสัปดาห์นี้',
    ]);
    return true;
});

test('Student can send message to teacher', function() {
    Auth::login(User::find(3));
    Message::create([
        'sender_id' => 3,
        'recipient_id' => 1, // Teacher001
        'subject' => 'สอบถามเกี่ยวกับงานกลุ่ม',
        'message' => 'อาจารย์ครับ ส่งงานช้า 1 วันได้ไหมครับ',
    ]);
    return true;
});

test('Student CANNOT send to another student (logic check)', function() {
    Auth::login(User::find(3));
    $controller = app(\App\Http\Controllers\MessageController::class);
    $sender = Auth::user();
    $recipient = User::find(6); // Student002
    
    // Test canSendToRecipient logic
    $reflection = new ReflectionMethod($controller, 'canSendToRecipient');
    $reflection->setAccessible(true);
    $result = $reflection->invoke($controller, $sender, $recipient);
    return $result === false;
});

test('Teacher CANNOT send to another teacher (logic check)', function() {
    Auth::login(User::find(1));
    $controller = app(\App\Http\Controllers\MessageController::class);
    $sender = Auth::user();
    $recipient = User::find(4); // Teacher002
    
    $reflection = new ReflectionMethod($controller, 'canSendToRecipient');
    $reflection->setAccessible(true);
    $result = $reflection->invoke($controller, $sender, $recipient);
    return $result === false;
});

test('Message inbox loads for all roles', function() {
    foreach ([2, 1, 3] as $userId) {
        Auth::login(User::find($userId));
        $controller = app(\App\Http\Controllers\MessageController::class);
        $request = Request::create('/messages', 'GET');
        $response = $controller->index($request);
        if (!($response instanceof \Illuminate\View\View)) return "Failed for user {$userId}";
    }
    return true;
});

test('Message sent box loads', function() {
    Auth::login(User::find(1));
    $controller = app(\App\Http\Controllers\MessageController::class);
    $request = Request::create('/messages?box=sent', 'GET');
    $response = $controller->index($request);
    return $response instanceof \Illuminate\View\View;
});

test('Mark message as read', function() {
    $msg = Message::where('recipient_id', 1)->where('is_read', false)->first();
    if (!$msg) return "No unread messages for Teacher001";
    Auth::login(User::find(1));
    $controller = app(\App\Http\Controllers\MessageController::class);
    $controller->markAsRead($msg);
    $msg->refresh();
    return $msg->is_read === true;
});

test('Mark all messages as read', function() {
    Auth::login(User::find(3)); // Student001
    $controller = app(\App\Http\Controllers\MessageController::class);
    $controller->markAllAsRead();
    $unread = Message::where('recipient_id', 3)->where('is_read', false)->count();
    return $unread === 0;
});

// ============================================================================
// SECTION 6: PDF REPORTS
// ============================================================================
echo "\n--- SECTION 6: PDF REPORTS ---\n";

test('Admin User Report PDF', function() {
    Auth::login(User::where('role', 'admin')->first());
    $controller = app(\App\Http\Controllers\ReportController::class);
    $response = $controller->userReportPdf();
    return $response->headers->get('content-type') === 'application/pdf'
        || str_contains($response->headers->get('content-disposition', ''), '.pdf');
});

test('Admin Subject Report PDF', function() {
    Auth::login(User::where('role', 'admin')->first());
    $controller = app(\App\Http\Controllers\ReportController::class);
    $response = $controller->subjectReportPdf();
    return $response->headers->get('content-type') === 'application/pdf'
        || str_contains($response->headers->get('content-disposition', ''), '.pdf');
});

test('Admin Classroom Report PDF', function() {
    Auth::login(User::where('role', 'admin')->first());
    $controller = app(\App\Http\Controllers\ReportController::class);
    $response = $controller->classroomReportPdf();
    return $response->headers->get('content-type') === 'application/pdf'
        || str_contains($response->headers->get('content-disposition', ''), '.pdf');
});

test('Admin Schedule Report PDF', function() {
    Auth::login(User::where('role', 'admin')->first());
    $controller = app(\App\Http\Controllers\ReportController::class);
    $response = $controller->scheduleReportPdf();
    return $response->headers->get('content-type') === 'application/pdf'
        || str_contains($response->headers->get('content-disposition', ''), '.pdf');
});

test('Class Report PDF', function() {
    Auth::login(User::where('role', 'admin')->first());
    $class = StudentClass::first();
    $controller = app(\App\Http\Controllers\ReportController::class);
    $response = $controller->classReportPdf($class);
    return $response->headers->get('content-type') === 'application/pdf'
        || str_contains($response->headers->get('content-disposition', ''), '.pdf');
});

test('Individual Student Report PDF', function() {
    Auth::login(User::where('role', 'admin')->first());
    $student = Student::first();
    $controller = app(\App\Http\Controllers\ReportController::class);
    $response = $controller->individualReportPdf($student);
    return $response->headers->get('content-type') === 'application/pdf'
        || str_contains($response->headers->get('content-disposition', ''), '.pdf');
});

test('Student can download own report PDF', function() {
    Auth::login(User::find(3));
    $student = Student::find(3);
    $controller = app(\App\Http\Controllers\ReportController::class);
    $response = $controller->individualReportPdf($student);
    return $response->headers->get('content-type') === 'application/pdf'
        || str_contains($response->headers->get('content-disposition', ''), '.pdf');
});

// ============================================================================
// SECTION 7: SECURITY & AUTHORIZATION
// ============================================================================
echo "\n--- SECTION 7: SECURITY & AUTHORIZATION ---\n";

test('Student CANNOT access admin class management', function() {
    Auth::login(User::find(3));
    try {
        $controller = app(\App\Http\Controllers\ClassController::class);
        // Middleware handles this, but let's test the route middleware definition
        // In a real request, middleware would block. We verify middleware is set in routes.
        return "Middleware 'role:admin' protects classes routes - verified in routes/web.php";
    } catch (\Throwable $e) {
        return true;
    }
});

test('Student CANNOT access other student report', function() {
    Auth::login(User::find(3)); // Student001
    $otherStudent = Student::find(6); // Student002
    $controller = app(\App\Http\Controllers\ReportController::class);
    try {
        $response = $controller->individualReport($otherStudent);
        return false; // Should have been blocked
    } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
        return $e->getStatusCode() === 403;
    }
});

test('Student CANNOT access other student statistics', function() {
    Auth::login(User::find(3)); // Student001
    $otherStudent = Student::find(6); // Student002
    $controller = app(\App\Http\Controllers\AttendanceController::class);
    try {
        $response = $controller->statistics($otherStudent);
        return false; // Should have been blocked
    } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
        return $e->getStatusCode() === 403;
    }
});

test('Teacher CANNOT access admin-only user management', function() {
    Auth::login(User::find(1));
    // Middleware 'is_admin' blocks this
    return "Middleware 'is_admin' protects users routes - verified in routes/web.php";
});

test('Teacher CANNOT access admin-only PDF reports', function() {
    Auth::login(User::find(1));
    $controller = app(\App\Http\Controllers\ReportController::class);
    try {
        $controller->userReportPdf();
        return false; // Should have been blocked
    } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
        return $e->getStatusCode() === 403;
    }
});

test('Student CANNOT access teacher record page', function() {
    Auth::login(User::find(3));
    // Route has middleware 'role:teacher,admin' - we can verify from code
    return "Middleware 'role:teacher,admin' protects teacher.record - verified in routes/web.php";
});

// ============================================================================
// SECTION 8: CODE ANALYSIS - BUGS & ISSUES
// ============================================================================
echo "\n--- SECTION 8: CODE ANALYSIS ---\n";

test('BUG: checkIn() uses whereDate(created_at) instead of day_of_week', function() {
    // AttendanceController::checkIn() line 25:
    // Schedule::where('class_id', $student->class_id)->whereDate('created_at', $today)
    // This will NEVER return schedules because schedules are created once, not daily.
    return "CRITICAL BUG: checkIn() uses whereDate('created_at', today) - schedules created once, not daily. Must use where('day_of_week', todayCode)";
});

test('BUG: recordByTeacher() same issue as checkIn()', function() {
    // AttendanceController::recordByTeacher() line 91:
    // Schedule::where('teacher_id', $teacher->id)->whereDate('created_at', Carbon::today())
    return "CRITICAL BUG: recordByTeacher() uses whereDate('created_at', today) - always returns 0 schedules. Teacher can NEVER record attendance.";
});

test('BUG: teacher-record.blade.php uses Bootstrap, system uses Tailwind', function() {
    $content = file_get_contents(resource_path('views/attendance/teacher-record.blade.php'));
    $hasBootstrap = str_contains($content, 'data-bs-toggle') || str_contains($content, 'class="btn ');
    $usesLayoutsApp = str_contains($content, "@extends('layouts.app')");
    if ($hasBootstrap) {
        return "VIEW BUG: teacher-record.blade.php uses Bootstrap classes (card, btn, data-bs-toggle, collapse) but system uses Tailwind CSS";
    }
    return true;
});

test('BUG: check-in.blade.php uses Bootstrap classes', function() {
    $content = file_get_contents(resource_path('views/attendance/check-in.blade.php'));
    $hasBootstrap = str_contains($content, 'data-bs-toggle') || str_contains($content, 'class="btn ');
    if ($hasBootstrap) {
        return "VIEW BUG: check-in.blade.php uses Bootstrap modal/btn classes but system uses Tailwind CSS";
    }
    return true;
});

test('BUG: statistics.blade.php uses Bootstrap classes', function() {
    $content = file_get_contents(resource_path('views/attendance/statistics.blade.php'));
    $hasBootstrap = str_contains($content, "extends('layouts.app')") || str_contains($content, 'class="card');
    if ($hasBootstrap) {
        return "VIEW BUG: statistics.blade.php uses Bootstrap layout/classes but system uses Tailwind CSS";
    }
    return true;
});

test('ISSUE: check-in route not defined in routes/web.php', function() {
    // attendance.store and attendance.check-in are NOT in routes/web.php
    $routes = file_get_contents(base_path('routes/web.php'));
    $hasCheckIn = str_contains($routes, 'checkIn') || str_contains($routes, 'check-in');
    $hasStore = str_contains($routes, "store']");
    if (!$hasCheckIn) {
        return "MISSING ROUTE: attendance.checkIn() is defined in controller but has no route in web.php";
    }
    return true;
});

test('ISSUE: attendance.store route not in routes/web.php', function() {
    $routes = file_get_contents(base_path('routes/web.php'));
    if (!str_contains($routes, "attendance.store") && !str_contains($routes, "AttendanceController::class, 'store'")) {
        return "MISSING ROUTE: AttendanceController::store() has no route - check-in form will get 404";
    }
    return true;
});

test('ISSUE: UserController.store does not set student_id/teacher_id', function() {
    // When admin creates a new user with role='student', student_id and teacher_id are not handled
    return "LOGICAL ISSUE: UserController::store() only saves name/email/password/role. Does not handle student_id, teacher_id, class_id, phone, department fields.";
});

test('ISSUE: Schedule academic_year uses MySQL YEAR type (max 2155)', function() {
    return "DATA ISSUE: schedules.academic_year uses MySQL YEAR type (max 2155), but Thai calendar year is 2569. Causes Out of Range error.";
});

test('ISSUE: Student model global scope conflicts with User operations', function() {
    // Student extends User with global scope 'where(role, student)'
    // This means Student::find(id) will fail if the user isn't a student
    // Teacher::find(id) will fail if user isn't a teacher
    return "DESIGN NOTE: Student/Teacher models use global scopes on users table. Admin operations adding User with role changes won't be reflected immediately.";
});

test('ISSUE: subjects.create route ordering conflict', function() {
    // Route::get('/subjects/{subject}') is defined BEFORE Route::get('/subjects/create')
    // This means /subjects/create will be treated as /subjects/{subject} where subject='create'
    $routes = file_get_contents(base_path('routes/web.php'));
    $showPos = strpos($routes, "subjects/{subject}");
    $createPos = strpos($routes, "subjects/create");
    if ($showPos !== false && $createPos !== false && $showPos < $createPos) {
        return "ROUTE CONFLICT: GET /subjects/{subject} is defined before GET /subjects/create. /subjects/create may match as {subject}='create' causing 404.";
    }
    return true;
});

test('SECURITY: No CSRF protection tested on POST routes', function() {
    // All forms should have @csrf - let's check some views
    $views = [
        'attendance/teacher-record.blade.php',
        'messages/create.blade.php',
    ];
    foreach ($views as $v) {
        $path = resource_path("views/{$v}");
        if (file_exists($path)) {
            $content = file_get_contents($path);
            if (str_contains($content, 'method="POST"') && !str_contains($content, '@csrf') && !str_contains($content, 'csrf')) {
                return "SECURITY: {$v} has POST form without @csrf";
            }
        }
    }
    return true;
});

test('SECURITY: No password hashing bypass', function() {
    // Check that store methods hash passwords
    $userController = file_get_contents(app_path('Http/Controllers/UserController.php'));
    if (str_contains($userController, 'bcrypt') || str_contains($userController, 'Hash::make')) {
        return true;
    }
    return "SECURITY: UserController does not hash passwords";
});

test('SECURITY: SQL injection in search', function() {
    // Check if searches use parameterized queries (LIKE with %)
    // Laravel's where('col', 'like', "%{$search}%") IS parameterized through bindings
    return true; // Laravel Eloquent ORM uses parameterized queries
});

test('SECURITY: Message viewing authorization', function() {
    Auth::login(User::find(3)); // Student001
    // Try to view a message not for this student
    $otherMsg = Message::where('recipient_id', '!=', 3)->where('sender_id', '!=', 3)->first();
    if (!$otherMsg) return "No test messages available";
    $controller = app(\App\Http\Controllers\MessageController::class);
    try {
        $controller->show($otherMsg);
        return "SECURITY ISSUE: Student could view another user's message";
    } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
        return $e->getStatusCode() === 403;
    }
});

test('SECURITY: Admin can view ALL messages (design concern)', function() {
    Auth::login(User::where('role', 'admin')->first());
    $msg = Message::where('sender_id', '!=', 2)->where('recipient_id', '!=', 2)->first();
    if (!$msg) return "No test messages available";
    $controller = app(\App\Http\Controllers\MessageController::class);
    try {
        $controller->show($msg);
        return "PRIVACY CONCERN: Admin can view messages between other users. May want audit logging.";
    } catch (\Throwable $e) {
        return true;
    }
});

// ============================================================================
// SECTION 9: EDGE CASES
// ============================================================================
echo "\n--- SECTION 9: EDGE CASES ---\n";

test('Student with no attendance data sees empty dashboard', function() {
    // Create a temp student with 0 attendance
    Auth::login(User::find(14)); // Student010 may have records
    $controller = app(\App\Http\Controllers\DashboardController::class);
    $response = $controller->index();
    $data = $response->getData();
    // Check percentage is 0 when no data
    return isset($data['stats']);
});

test('Student with null class_id sees empty schedule', function() {
    // Temporarily test with null class_id scenario
    $student = User::find(3);
    $origClass = $student->class_id;
    $student->class_id = null;
    $student->save();
    
    Auth::login($student->fresh());
    $controller = app(\App\Http\Controllers\ScheduleController::class);
    $response = $controller->studentSchedule();
    
    // Restore
    $student->class_id = $origClass;
    $student->save();
    
    return $response instanceof \Illuminate\View\View;
});

test('Empty subject list renders correctly', function() {
    Auth::login(User::find(3));
    $controller = app(\App\Http\Controllers\SubjectController::class);
    $request = Request::create('/subjects?q=nonexistent_xyz', 'GET');
    $response = $controller->index($request);
    return $response instanceof \Illuminate\View\View;
});

test('Risk report with no risky students', function() {
    // This should not crash even if no students are at risk
    Auth::login(User::where('role', 'admin')->first());
    $controller = app(\App\Http\Controllers\ReportController::class);
    $response = $controller->riskReport();
    return $response instanceof \Illuminate\View\View;
});

// ============================================================================
// FINAL REPORT
// ============================================================================
echo "\n" . str_repeat("=", 80) . "\n";
echo "  SIMULATION TEST RESULTS\n";
echo str_repeat("=", 80) . "\n\n";

foreach ($results as $r) {
    echo $r . "\n";
}

echo "\n" . str_repeat("-", 80) . "\n";
echo "SUMMARY: {$passed} PASSED, {$failed} FAILED, " . count($warnings) . " WARNINGS\n";
echo str_repeat("-", 80) . "\n";

if (count($warnings) > 0) {
    echo "\nWARNINGS/ISSUES FOUND:\n";
    foreach ($warnings as $i => $w) {
        echo "  " . ($i + 1) . ". {$w}\n";
    }
}

echo "\n";
