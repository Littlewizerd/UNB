<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * รายงานสรุปการเข้าเรียนตามชั้นเรียน
     */
    public function classReport(StudentClass $class)
    {
        $this->ensureAdminOrTeacher();

        $students = $class->students()->with('attendances')->get();
        
        $reportData = [];
        foreach ($students as $student) {
            $total = $student->attendances->count();
            $present = $student->attendances->where('status', 'present')->count();
            $late = $student->attendances->where('status', 'late')->count();
            $attended = $present + $late; // มาสายนับเป็นมาเรียน
            
            $reportData[] = [
                'student' => $student,
                'total' => $total,
                'present' => $present,
                'absent' => $student->attendances->where('status', 'absent')->count(),
                'late' => $late,
                'excused' => $student->attendances->where('status', 'excused')->count(),
                'percentage' => $total > 0 ? round(($attended / $total) * 100, 2) : 0
            ];
        }

        return view('reports.class-report', compact('class', 'reportData'));
    }

    /**
     * รายงานการเข้าเรียนรายวิชา
     */
    public function subjectReport(Subject $subject)
    {
        $this->ensureAdminOrTeacher();

        $attendances = Attendance::where('subject_id', $subject->id)
            ->with('student', 'schedule')
            ->orderBy('attendance_date', 'desc')
            ->paginate(30);

        return view('reports.subject-report', compact('subject', 'attendances'));
    }

    /**
     * รายงานรายบุคคล
     */
    public function individualReport(Student $student)
    {
        $this->ensureCanAccessStudentData($student);

        $attendances = Attendance::where('student_id', $student->id)
            ->with('schedule.subject', 'schedule.studentClass')
            ->orderBy('attendance_date', 'desc')
            ->paginate(20);

        $stats = [
            'present' => Attendance::where('student_id', $student->id)->where('status', 'present')->count(),
            'absent' => Attendance::where('student_id', $student->id)->where('status', 'absent')->count(),
            'late' => Attendance::where('student_id', $student->id)->where('status', 'late')->count(),
            'excused' => Attendance::where('student_id', $student->id)->where('status', 'excused')->count()
        ];

        return view('reports.individual-report', compact('student', 'attendances', 'stats'));
    }

    /**
     * ดาวน์โหลดรายงาน PDF ชั้นเรียน
     */
    public function classReportPdf(StudentClass $class)
    {
        $this->ensureAdminOrTeacher();

        $students = $class->students()->with('attendances')->get();
        
        $reportData = [];
        foreach ($students as $student) {
            $total = $student->attendances->count();
            $present = $student->attendances->where('status', 'present')->count();
            $late = $student->attendances->where('status', 'late')->count();
            $attended = $present + $late;
            
            $reportData[] = [
                'student' => $student,
                'total' => $total,
                'present' => $present,
                'absent' => $student->attendances->where('status', 'absent')->count(),
                'late' => $late,
                'excused' => $student->attendances->where('status', 'excused')->count(),
                'percentage' => $total > 0 ? round(($attended / $total) * 100, 2) : 0
            ];
        }

        $pdf = Pdf::loadView('reports.class-report-pdf', compact('class', 'reportData'));
        return $pdf->download("report-class-{$class->class_code}.pdf");
    }

    /**
     * ดาวน์โหลดรายงาน PDF รายบุคคล
     */
    public function individualReportPdf(Student $student)
    {
        $this->ensureCanAccessStudentData($student);

        $attendances = Attendance::where('student_id', $student->id)
            ->with('schedule.subject')
            ->orderBy('attendance_date', 'desc')
            ->get();

        $stats = [
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'excused' => $attendances->where('status', 'excused')->count()
        ];

        $pdf = Pdf::loadView('reports.individual-report-pdf', compact('student', 'attendances', 'stats'));
        return $pdf->download("report-student-{$student->student_id}.pdf");
    }

    /**
     * สรุปการเข้าเรียนประจำวัน
     */
    public function dailySummary()
    {
        $this->ensureAdminOrTeacher();

        $user = auth()->user();
        $userRole = strtolower($user->role ?? '');
        $today = now()->toDateString();

        $attendancesQuery = Attendance::whereDate('attendance_date', $today)
            ->with('student.studentClass', 'subject');

        // อาจารย์เห็นเฉพาะข้อมูลของนักศึกษาในรายวิชาที่ตนเองสอน (ใช้ schedule.teacher_id)
        if ($userRole === 'teacher') {
            $teacherScheduleIds = \App\Models\Schedule::where('teacher_id', $user->id)->pluck('id');
            $attendancesQuery->whereIn('schedule_id', $teacherScheduleIds);
        }

        $attendances = $attendancesQuery->get();

        $summary = [
            'total' => $attendances->count(),
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'excused' => $attendances->where('status', 'excused')->count()
        ];

        // ส่งข้อมูลห้องเรียน/รายวิชา สำหรับนำทางไปรายงานอื่น ๆ
        if ($userRole === 'teacher') {
            $teacherSchedules = \App\Models\Schedule::where('teacher_id', $user->id)->get();
            $teacherSubjects = \App\Models\Subject::whereIn('id', $teacherSchedules->pluck('subject_id')->unique())->get();
            $teacherClasses = \App\Models\StudentClass::whereIn('id', $teacherSchedules->pluck('class_id')->unique())->get();
        } else {
            $teacherSubjects = \App\Models\Subject::all();
            $teacherClasses = \App\Models\StudentClass::all();
        }

        return view('reports.daily-summary', compact('attendances', 'summary', 'teacherSubjects', 'teacherClasses'));
    }

    /**
     * รายงานความเสี่ยง (นักเรียนขาดเรียนเกิน)
     */
    public function riskReport()
    {
        $this->ensureAdminOrTeacher();

        $students = Student::with('attendances')->get();
        
        $riskStudents = [];
        foreach ($students as $student) {
            $total = $student->attendances->count();
            $absent = $student->attendances->where('status', 'absent')->count();
            $percentage = $total > 0 ? ($absent / $total) * 100 : 0;
            
            // จำแนกเสี่ยงมากกว่า 20%
            if ($percentage > 20) {
                $riskStudents[] = [
                    'student' => $student,
                    'total' => $total,
                    'absent' => $absent,
                    'percentage' => round($percentage, 2),
                    'risk_level' => $percentage > 30 ? 'สูง' : 'ปานกลาง'
                ];
            }
        }

        return view('reports.risk-report', compact('riskStudents'));
    }

    /**
     * รายงานบัญชีผู้ใช้ PDF (Admin)
     */
    public function userReportPdf()
    {
        $this->ensureAdmin();

        $users = User::orderBy('role')->orderBy('name')->get();

        $summary = [
            'total' => $users->count(),
            'admin' => $users->where('role', 'admin')->count(),
            'teacher' => $users->where('role', 'teacher')->count(),
            'student' => $users->where('role', 'student')->count(),
        ];

        $pdf = Pdf::loadView('reports.user-report-pdf', compact('users', 'summary'));
        return $pdf->download('report-users-' . now()->format('Ymd') . '.pdf');
    }

    /**
     * รายงานข้อมูลรายวิชา PDF (Admin)
     */
    public function subjectReportPdf()
    {
        $this->ensureAdmin();

        $subjects = Subject::with('teacher')->orderBy('subject_code')->get();

        $pdf = Pdf::loadView('reports.subject-report-pdf', compact('subjects'));
        return $pdf->download('report-subjects-' . now()->format('Ymd') . '.pdf');
    }

    /**
     * รายงานข้อมูลห้องเรียน PDF (Admin)
     */
    public function classroomReportPdf()
    {
        $this->ensureAdmin();

        $classes = StudentClass::withCount('students', 'schedules')
            ->with('advisor')
            ->orderBy('class_code')
            ->get();

        $pdf = Pdf::loadView('reports.classroom-report-pdf', compact('classes'));
        return $pdf->download('report-classrooms-' . now()->format('Ymd') . '.pdf');
    }

    /**
     * รายงานตารางเรียน/สอน PDF (Admin)
     */
    public function scheduleReportPdf()
    {
        $this->ensureAdmin();

        $schedules = Schedule::with(['subject', 'teacher', 'studentClass', 'semesterData'])
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        $pdf = Pdf::loadView('reports.schedule-report-pdf', compact('schedules'));
        return $pdf->download('report-schedules-' . now()->format('Ymd') . '.pdf');
    }

    private function ensureAdmin(): void
    {
        $role = strtolower((string) Auth::user()?->role);
        if ($role !== 'admin') {
            abort(403, 'ไม่มีสิทธิ์เข้าถึงรายงานนี้');
        }
    }

    private function ensureAdminOrTeacher(): void
    {
        $role = strtolower((string) Auth::user()?->role);
        if (!in_array($role, ['admin', 'teacher'], true)) {
            abort(403, 'ไม่มีสิทธิ์เข้าถึงรายงานนี้');
        }
    }

    private function ensureCanAccessStudentData(Student $student): void
    {
        $user = Auth::user();
        $role = strtolower((string) $user?->role);

        if (in_array($role, ['admin', 'teacher'], true)) {
            return;
        }

        if ($role === 'student' && (int) $user->id === (int) $student->id) {
            return;
        }

        abort(403, 'ไม่มีสิทธิ์เข้าถึงข้อมูลนักศึกษารายนี้');
    }
}
