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
     * แปลงวันในสัปดาห์เป็นรหัสตาราง
     */
    private function getTodayDayCode(): string
    {
        $map = [1 => 'M', 2 => 'T', 3 => 'W', 4 => 'TH', 5 => 'F', 6 => 'SA', 0 => 'SU'];
        return $map[Carbon::today()->dayOfWeek] ?? 'M';
    }

    /**
     * หน้าสำหรับครูบันทึกการเข้าเรียน
     */
    public function recordByTeacher()
    {
        $teacher = Auth::user();
        $today = Carbon::today();
        $dayCode = $this->getTodayDayCode();

        // ตารางสอนของครูวันนี้ (จับคู่ day_of_week กับวันจริง)
        $schedules = Schedule::where('teacher_id', $teacher->id)
            ->where('day_of_week', $dayCode)
            ->with(['subject', 'studentClass.students'])
            ->orderBy('start_time')
            ->get();

        // ดึงข้อมูลการลงเวลาที่บันทึกไว้แล้ววันนี้
        $todayAttendances = Attendance::whereDate('attendance_date', $today)
            ->whereIn('schedule_id', $schedules->pluck('id'))
            ->get()
            ->groupBy('schedule_id');

        return view('attendance.teacher-record', compact('schedules', 'todayAttendances', 'teacher'));
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
            'attendances.*.status' => 'required|in:present,absent,late,excused',
            'attendances.*.notes' => 'nullable|string|max:255'
        ]);

        $schedule = Schedule::findOrFail($validated['schedule_id']);
        $teacher = Auth::user();

        $count = 0;
        // บันทึกสถานะการเข้าเรียนสำหรับนักเรียนแต่ละคน
        foreach ($validated['attendances'] as $attendance) {
            $status = $attendance['status'];

            // กำหนดเวลาเข้า-ออกอัตโนมัติ
            $checkInTime = null;
            $checkOutTime = null;
            if ($status === 'present') {
                $checkInTime = $schedule->start_time;   // มาปกติ = เวลาเริ่มเรียน
                $checkOutTime = $schedule->end_time;
            } elseif ($status === 'late') {
                $checkInTime = null;                    // มาสาย = ไม่ทราบเวลาแน่ชัด
                $checkOutTime = $schedule->end_time;
            }

            Attendance::updateOrCreate(
                [
                    'student_id' => $attendance['student_id'],
                    'schedule_id' => $schedule->id,
                    'attendance_date' => Carbon::today()
                ],
                [
                    'subject_id' => $schedule->subject_id,
                    'status' => $status,
                    'check_in_time'  => $checkInTime,
                    'check_out_time' => $checkOutTime,
                    'notes' => $attendance['notes'] ?? null,
                    'recorded_by' => $teacher->id
                ]
            );
            $count++;
        }

        return redirect()->back()->with('success', "บันทึกการเข้าเรียนสำเร็จ ({$count} คน)");
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
        $user = Auth::user();
        $role = strtolower((string) $user->role);

        if (!in_array($role, ['admin', 'teacher'], true)) {
            abort(403, 'ไม่มีสิทธิ์เข้าถึงสถิติของนักศึกษารายนี้');
        }

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
