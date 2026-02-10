<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\Subject;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * รายงานสรุปการเข้าเรียนตามชั้นเรียน
     */
    public function classReport(StudentClass $class)
    {
        $students = $class->students()->with('attendances')->get();
        
        $reportData = [];
        foreach ($students as $student) {
            $total = $student->attendances->count();
            $present = $student->attendances->where('status', 'present')->count();
            
            $reportData[] = [
                'student' => $student,
                'total' => $total,
                'present' => $present,
                'absent' => $student->attendances->where('status', 'absent')->count(),
                'late' => $student->attendances->where('status', 'late')->count(),
                'excused' => $student->attendances->where('status', 'excused')->count(),
                'percentage' => $total > 0 ? round(($present / $total) * 100, 2) : 0
            ];
        }

        return view('reports.class-report', compact('class', 'reportData'));
    }

    /**
     * รายงานการเข้าเรียนรายวิชา
     */
    public function subjectReport(Subject $subject)
    {
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
        $students = $class->students()->with('attendances')->get();
        
        $reportData = [];
        foreach ($students as $student) {
            $total = $student->attendances->count();
            $present = $student->attendances->where('status', 'present')->count();
            
            $reportData[] = [
                'student' => $student,
                'total' => $total,
                'present' => $present,
                'absent' => $student->attendances->where('status', 'absent')->count(),
                'late' => $student->attendances->where('status', 'late')->count(),
                'excused' => $student->attendances->where('status', 'excused')->count(),
                'percentage' => $total > 0 ? round(($present / $total) * 100, 2) : 0
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
        $today = now()->toDateString();
        $attendances = Attendance::whereDate('attendance_date', $today)
            ->with('student.studentClass', 'subject')
            ->get();

        $summary = [
            'total' => $attendances->count(),
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'excused' => $attendances->where('status', 'excused')->count()
        ];

        return view('reports.daily-summary', compact('attendances', 'summary'));
    }

    /**
     * รายงานความเสี่ยง (นักเรียนขาดเรียนเกิน)
     */
    public function riskReport()
    {
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
}
