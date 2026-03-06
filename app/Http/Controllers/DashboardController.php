<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\StudentClass;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = ['user' => $user];

        if ($user->role === 'admin') {
            $data['stats'] = $this->getAdminStats();
            $data['todayAttendance'] = $this->getTodayAttendanceSummary();
        } elseif ($user->role === 'teacher') {
            $data['stats'] = $this->getTeacherStats($user);
            $data['todaySchedules'] = $this->getTeacherTodaySchedules($user);
        } elseif ($user->role === 'student') {
            $data['stats'] = $this->getStudentStats($user);
            $data['todaySchedules'] = $this->getStudentTodaySchedules($user);
        }

        return view('dashboard', $data);
    }

    private function getAdminStats()
    {
        return [
            'totalStudents' => User::where('role', 'student')->count(),
            'totalTeachers' => User::where('role', 'teacher')->count(),
            'totalClasses' => StudentClass::count(),
            'totalSubjects' => Subject::count(),
            'totalSchedules' => Schedule::count(),
            'totalUsers' => User::count(),
        ];
    }

    private function getTodayAttendanceSummary()
    {
        $today = Carbon::today();
        $attendances = Attendance::whereDate('attendance_date', $today)->get();
        
        return [
            'total' => $attendances->count(),
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'excused' => $attendances->where('status', 'excused')->count(),
        ];
    }

    private function getTeacherStats($teacher)
    {
        $scheduleCount = Schedule::where('teacher_id', $teacher->id)->count();
        $classIds = Schedule::where('teacher_id', $teacher->id)->distinct()->pluck('class_id');
        
        return [
            'totalSchedules' => $scheduleCount,
            'totalClasses' => $classIds->count(),
            'totalStudents' => User::where('role', 'student')->whereIn('class_id', $classIds)->count(),
        ];
    }

    private function getTeacherTodaySchedules($teacher)
    {
        $dayOfWeek = $this->getDayOfWeek();
        
        return Schedule::where('teacher_id', $teacher->id)
            ->where('day_of_week', $dayOfWeek)
            ->with(['studentClass', 'subject'])
            ->orderBy('start_time')
            ->get();
    }

    private function getStudentStats($student)
    {
        $attendances = Attendance::where('student_id', $student->id)->get();
        $total = $attendances->count();
        $present = $attendances->where('status', 'present')->count();
        
        return [
            'totalAttendance' => $total,
            'present' => $present,
            'absent' => $attendances->where('status', 'absent')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'percentage' => $total > 0 ? round(($present / $total) * 100, 1) : 0,
        ];
    }

    private function getStudentTodaySchedules($student)
    {
        $dayOfWeek = $this->getDayOfWeek();
        
        return Schedule::where('class_id', $student->class_id)
            ->where('day_of_week', $dayOfWeek)
            ->with(['subject', 'teacher'])
            ->orderBy('start_time')
            ->get();
    }

    private function getDayOfWeek()
    {
        $dayMap = [
            0 => 'SU', // Sunday
            1 => 'M',  // Monday
            2 => 'T',  // Tuesday
            3 => 'W',  // Wednesday
            4 => 'TH', // Thursday
            5 => 'F',  // Friday
            6 => 'SA', // Saturday
        ];
        
        return $dayMap[Carbon::now()->dayOfWeek];
    }
}
