<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\StudentClass;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of schedules
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $semesterId = $request->query('semester_id');

        $query = Schedule::with(['studentClass', 'subject', 'teacher', 'semesterData']);

        if ($search) {
            $query->whereHas('subject', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('studentClass', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($semesterId) {
            $query->where('semester_id', $semesterId);
        }

        $schedules = $query->orderBy('semester', 'asc')
            ->orderBy('day_of_week', 'asc')
            ->orderBy('start_time', 'asc')
            ->paginate(10);

        $semesters = Semester::all();

        return view('schedules.index', compact('schedules', 'search', 'semesterId', 'semesters'));
    }

    /**
     * Show the form for creating a new schedule
     */
    public function create()
    {
        $classes = StudentClass::all();
        $subjects = Subject::all();
        $teachers = User::where('role', 'teacher')->get();
        $semesters = Semester::all();

        return view('schedules.create', compact('classes', 'subjects', 'teachers', 'semesters'));
    }

    /**
     * Store a newly created schedule
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:student_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:users,id',
            'day_of_week' => 'required|in:M,T,W,TH,F,SA,SU',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string|max:50',
            'semester' => 'required|integer|in:1,2',
            'academic_year' => 'required|integer|min:2560|max:2650',
            'semester_id' => 'nullable|exists:semesters,id',
        ]);

        Schedule::create($request->all());

        return redirect()->route('schedules.index')->with('success', 'สร้างตารางเรียนสำเร็จ');
    }

    /**
     * Display the specified schedule
     */
    public function show(Schedule $schedule)
    {
        $schedule->load(['studentClass', 'subject', 'teacher', 'semesterData']);
        return view('schedules.show', compact('schedule'));
    }

    /**
     * Show the form for editing the schedule
     */
    public function edit(Schedule $schedule)
    {
        $classes = StudentClass::all();
        $subjects = Subject::all();
        $teachers = User::where('role', 'teacher')->get();
        $semesters = Semester::all();

        return view('schedules.edit', compact('schedule', 'classes', 'subjects', 'teachers', 'semesters'));
    }

    /**
     * Update the specified schedule
     */
    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'class_id' => 'required|exists:student_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:users,id',
            'day_of_week' => 'required|in:M,T,W,TH,F,SA,SU',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string|max:50',
            'semester' => 'required|integer|in:1,2',
            'academic_year' => 'required|integer|min:2560|max:2650',
            'semester_id' => 'nullable|exists:semesters,id',
        ]);

        $schedule->update($request->all());

        return redirect()->route('schedules.index')->with('success', 'อัปเดตตารางเรียนสำเร็จ');
    }

    /**
     * Remove the specified schedule
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'ลบตารางเรียนสำเร็จ');
    }

    /**
     * Show teacher's schedule
     */
    public function teacherSchedule()
    {
        $teacher = Auth::user();
        $schedules = Schedule::where('teacher_id', $teacher->id)
            ->with(['studentClass', 'subject', 'semesterData'])
            ->orderBy('semester', 'asc')
            ->orderBy('day_of_week', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        return view('schedules.teacher-schedule', compact('schedules'));
    }

    /**
     * Show student's schedule
     */
    public function studentSchedule()
    {
        $student = Auth::user();
        $classId = $student->class_id;

        $schedules = Schedule::where('class_id', $classId)
            ->with(['subject', 'teacher', 'semesterData'])
            ->orderBy('semester', 'asc')
            ->orderBy('day_of_week', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        return view('schedules.student-schedule', compact('schedules'));
    }
}
