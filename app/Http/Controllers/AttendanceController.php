<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * หน้าสำหรับนักเรียนลงเวลาเข้าเรียน
     */
    public function checkIn()
    {
        $student = Auth::user();
        $today = Carbon::today();
        
        // ตารางเรียนวันนี้
        $schedules = Schedule::where('class_id', $student->class_id)
            ->whereDate('created_at', $today)
            ->get();

        return view('attendance.check-in', compact('schedules'));
    }

    /**
     * บันทึกการเข้าเรียนของนักเรียน
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'check_in_time' => 'nullable|date_format:H:i',
            'check_out_time' => 'nullable|date_format:H:i'
        ]);

        $schedule = Schedule::findOrFail($validated['schedule_id']);
        $student = Auth::user();
        
        // ตรวจสอบว่ามีบันทึกแล้วหรือไม่
        $attendance = Attendance::firstOrCreate(
            [
                'student_id' => $student->id,
                'schedule_id' => $schedule->id,
                'attendance_date' => Carbon::today()
            ],
            [
                'subject_id' => $schedule->subject_id,
                'check_in_time' => $validated['check_in_time'],
                'check_out_time' => $validated['check_out_time'],
                'status' => $this->determineStatus($schedule, $validated['check_in_time'])
            ]
        );

        // อัปเดตเวลาออก
        if ($validated['check_out_time']) {
            $attendance->update(['check_out_time' => $validated['check_out_time']]);
        }

        return redirect()->route('attendance.history')
            ->with('success', 'บันทึกการลงเวลาสำเร็จ');
    }

    /**
     * ประวัติการเข้าเรียนของนักเรียน
     */
    public function history()
    {
        $student = Auth::user();
        $attendances = Attendance::where('student_id', $student->id)
            ->with(['schedule.subject', 'schedule.studentClass'])
            ->orderBy('attendance_date', 'desc')
            ->paginate(15);

        return view('attendance.history', compact('attendances'));
    }

    /**
     * หน้าสำหรับครูบันทึกการเข้าเรียน
     */
    public function recordByTeacher()
    {
        $teacher = Auth::user();
        
        // ตารางเรียนของครูวันนี้
        $schedules = Schedule::where('teacher_id', $teacher->id)
            ->whereDate('created_at', Carbon::today())
            ->with('studentClass')
            ->get();

        return view('attendance.teacher-record', compact('schedules'));
    }

    /**
     * ครูบันทึกการเข้าเรียนสำหรับชั้นเรียน
     */
    public function recordAttendanceByTeacher(Request $request)
    {
        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'attendances' => 'required|array',
            'attendances.*.student_id' => 'required|exists:users,id',
            'attendances.*.status' => 'required|in:present,absent,late,excused'
        ]);

        $schedule = Schedule::findOrFail($validated['schedule_id']);
        $teacher = Auth::user();

        // บันทึกสถานะการเข้าเรียนสำหรับนักเรียนแต่ละคน
        foreach ($validated['attendances'] as $attendance) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $attendance['student_id'],
                    'schedule_id' => $schedule->id,
                    'attendance_date' => Carbon::today()
                ],
                [
                    'subject_id' => $schedule->subject_id,
                    'status' => $attendance['status'],
                    'recorded_by' => $teacher->id
                ]
            );
        }

        return redirect()->back()->with('success', 'บันทึกการเข้าเรียนสำเร็จ');
    }

    /**
     * ตรวจสอบสถานะการเข้าเรียน
     */
    private function determineStatus($schedule, $checkInTime)
    {
        if (!$checkInTime) {
            return Attendance::STATUS_ABSENT;
        }

        $startTime = Carbon::createFromTimeString($schedule->start_time);
        $checkInDateTime = Carbon::createFromTimeString($checkInTime);

        if ($checkInDateTime->lessThanOrEqualTo($startTime)) {
            return Attendance::STATUS_PRESENT;
        } else {
            return Attendance::STATUS_LATE;
        }
    }

    /**
     * สถิติการเข้าเรียนของนักเรียน
     */
    public function statistics(Student $student)
    {
        $stats = [
            'present' => Attendance::where('student_id', $student->id)->where('status', Attendance::STATUS_PRESENT)->count(),
            'absent' => Attendance::where('student_id', $student->id)->where('status', Attendance::STATUS_ABSENT)->count(),
            'late' => Attendance::where('student_id', $student->id)->where('status', Attendance::STATUS_LATE)->count(),
            'excused' => Attendance::where('student_id', $student->id)->where('status', Attendance::STATUS_EXCUSED)->count()
        ];

        $stats['total'] = array_sum($stats);
        $stats['percentage'] = $stats['total'] > 0 ? round(($stats['present'] / $stats['total']) * 100, 2) : 0;

        return view('attendance.statistics', compact('student', 'stats'));
    }
}
