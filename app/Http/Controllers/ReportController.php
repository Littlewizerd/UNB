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

        $allAttendances = Attendance::where('subject_id', $subject->id)
            ->with('student.studentClass', 'schedule')
            ->orderBy('attendance_date', 'asc')
            ->get();

        // สถิติรวมของวิชา
        $total   = $allAttendances->count();
        $present = $allAttendances->where('status', 'present')->count();
        $late    = $allAttendances->where('status', 'late')->count();
        $subjectSummary = [
            'total'      => $total,
            'present'    => $present,
            'absent'     => $allAttendances->where('status', 'absent')->count(),
            'late'       => $late,
            'excused'    => $allAttendances->where('status', 'excused')->count(),
            'percentage' => $total > 0 ? round((($present + $late) / $total) * 100, 1) : 0,
        ];

        // ภาพรวมรายนักศึกษาในวิชานี้
        $studentStats = $allAttendances
            ->groupBy(fn($a) => $a->student_id)
            ->map(function ($records) {
                $student = $records->first()->student;
                $total   = $records->count();
                $present = $records->where('status', 'present')->count();
                $late    = $records->where('status', 'late')->count();
                return [
                    'student'    => $student,
                    'total'      => $total,
                    'present'    => $present,
                    'absent'     => $records->where('status', 'absent')->count(),
                    'late'       => $late,
                    'excused'    => $records->where('status', 'excused')->count(),
                    'percentage' => $total > 0 ? round((($present + $late) / $total) * 100, 1) : 0,
                ];
            })
            ->sortBy(fn($row) => $row['student']->student_id)
            ->values();

        // วันที่ทั้งหมดที่มีการเช็คชื่อ (เรียงน้อยไปมาก)
        $dates = $allAttendances
            ->pluck('attendance_date')
            ->map(fn($d) => $d->format('Y-m-d'))
            ->unique()
            ->sort()
            ->values();

        // matrix: student_id -> date_string -> status
        $attendanceMatrix = $allAttendances
            ->groupBy('student_id')
            ->map(fn($recs) => $recs->keyBy(fn($a) => $a->attendance_date->format('Y-m-d'))->map->status);

        // รายละเอียดตามวัน: date_string -> array of attendances
        $dateAttendances = $allAttendances
            ->groupBy(fn($a) => $a->attendance_date->format('Y-m-d'))
            ->all();

        return view('reports.subject-report', compact(
            'subject', 'subjectSummary', 'studentStats',
            'dates', 'attendanceMatrix', 'dateAttendances'
        ));
    }

    /**
     * รายงานรายบุคคล
     */
    public function individualReport(Student $student)
    {
        $this->ensureCanAccessStudentData($student);

        $allAttendances = Attendance::where('student_id', $student->id)
            ->with('schedule.subject', 'schedule.studentClass')
            ->orderBy('attendance_date', 'desc')
            ->get();

        $stats = [
            'present' => $allAttendances->where('status', 'present')->count(),
            'absent' => $allAttendances->where('status', 'absent')->count(),
            'late' => $allAttendances->where('status', 'late')->count(),
            'excused' => $allAttendances->where('status', 'excused')->count(),
        ];

        $subjectStats = $allAttendances
            ->groupBy(fn($a) => $a->schedule?->subject?->id ?? 0)
            ->filter(fn($records, $subjectId) => $subjectId != 0)
            ->map(function ($records) {
                $subject = $records->first()->schedule->subject;
                $total = $records->count();
                $present = $records->where('status', 'present')->count();
                $late = $records->where('status', 'late')->count();
                return [
                    'subject'    => $subject,
                    'total'      => $total,
                    'present'    => $present,
                    'absent'     => $records->where('status', 'absent')->count(),
                    'late'       => $late,
                    'excused'    => $records->where('status', 'excused')->count(),
                    'percentage' => $total > 0 ? round((($present + $late) / $total) * 100, 2) : 0,
                    'records'    => $records->values(),
                ];
            })
            ->values();

        return view('reports.individual-report', compact('student', 'allAttendances', 'stats', 'subjectStats'));
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
     * ภาพรวมการเข้าเรียนตลอดภาคเรียน (รายนักศึกษา + รายวิชา)
     */
    public function dailySummary()
    {
        $this->ensureAdminOrTeacher();

        $user = auth()->user();
        $userRole = strtolower($user->role ?? '');

        // --- scope by teacher if needed ---
        $allowedScheduleIds = null;
        $allowedStudentIds  = null;
        $allowedSubjectIds  = null;

        if ($userRole === 'teacher') {
            $teacherSchedules    = Schedule::where('teacher_id', $user->id)->get();
            $allowedScheduleIds  = $teacherSchedules->pluck('id');
            $allowedSubjectIds   = $teacherSchedules->pluck('subject_id')->unique()->values();
            $allowedClassIds     = $teacherSchedules->pluck('class_id')->unique()->values();
            $allowedStudentIds   = Student::whereIn('class_id', $allowedClassIds)->pluck('id');
        }

        // --- all attendances in scope ---
        $attendanceQuery = Attendance::with('schedule.subject');
        if ($allowedScheduleIds !== null) {
            $attendanceQuery->whereIn('schedule_id', $allowedScheduleIds);
        }
        $allAttendances = $attendanceQuery->get();

        // --- student overview ---
        $studentsQuery = Student::with(['studentClass', 'attendances' => function ($q) use ($allowedScheduleIds) {
            if ($allowedScheduleIds !== null) {
                $q->whereIn('schedule_id', $allowedScheduleIds);
            }
        }]);
        if ($allowedStudentIds !== null) {
            $studentsQuery->whereIn('id', $allowedStudentIds);
        }
        $students = $studentsQuery->get();

        $studentStats = $students->map(function ($student) {
            $att     = $student->attendances;
            $total   = $att->count();
            $present = $att->where('status', 'present')->count();
            $late    = $att->where('status', 'late')->count();
            return [
                'student'    => $student,
                'total'      => $total,
                'present'    => $present,
                'absent'     => $att->where('status', 'absent')->count(),
                'late'       => $late,
                'excused'    => $att->where('status', 'excused')->count(),
                'percentage' => $total > 0 ? round((($present + $late) / $total) * 100, 1) : 0,
            ];
        })->sortByDesc('percentage')->values();

        // --- subject overview ---
        $subjectsQuery = Subject::with(['attendances' => function ($q) use ($allowedScheduleIds) {
            if ($allowedScheduleIds !== null) {
                $q->whereIn('schedule_id', $allowedScheduleIds);
            }
        }]);
        if ($allowedSubjectIds !== null) {
            $subjectsQuery->whereIn('id', $allowedSubjectIds);
        }
        $subjects = $subjectsQuery->get();

        $subjectStats = $subjects->map(function ($subject) {
            $att = $subject->attendances;
            $total   = $att->count();
            $present = $att->where('status', 'present')->count();
            $late    = $att->where('status', 'late')->count();
            return [
                'subject'    => $subject,
                'total'      => $total,
                'present'    => $present,
                'absent'     => $att->where('status', 'absent')->count(),
                'late'       => $late,
                'excused'    => $att->where('status', 'excused')->count(),
                'percentage' => $total > 0 ? round((($present + $late) / $total) * 100, 1) : 0,
            ];
        })->sortByDesc('percentage')->values();

        // --- overall totals ---
        $summary = [
            'total'   => $allAttendances->count(),
            'present' => $allAttendances->where('status', 'present')->count(),
            'absent'  => $allAttendances->where('status', 'absent')->count(),
            'late'    => $allAttendances->where('status', 'late')->count(),
            'excused' => $allAttendances->where('status', 'excused')->count(),
        ];

        return view('reports.daily-summary', compact('summary', 'studentStats', 'subjectStats'));
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
