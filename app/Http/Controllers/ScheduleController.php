<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\StudentClass;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
                $q->where('class_name', 'like', "%{$search}%");
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
        $rooms = Schedule::ROOMS;

        return view('schedules.create', compact('classes', 'subjects', 'teachers', 'semesters', 'rooms'));
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
            'start_time' => 'required|date_format:H:i|before:20:00',
            'end_time' => 'required|date_format:H:i|after:start_time|before_or_equal:20:00',
            'room' => ['required', 'string', 'max:50', Rule::in(Schedule::ROOMS)],
            'semester_id' => 'required|exists:semesters,id',
        ]);

        $semesterRecord = Semester::findOrFail($request->semester_id);
        $semesterNumber = (int) filter_var($semesterRecord->name, FILTER_SANITIZE_NUMBER_INT) ?: 1;
        $academicYear = $semesterRecord->year - 543;

        // ตรวจสอบตารางชนกัน
        $conflicts = $this->findConflicts(
            $request->class_id,
            $request->subject_id,
            $request->teacher_id,
            $request->room,
            $request->day_of_week,
            $request->start_time,
            $request->end_time,
            $request->semester_id
        );

        if ($conflicts->isNotEmpty()) {
            $messages = $conflicts->map(function ($s) {
                return "วิชา {$s->subject->name} (ห้อง {$s->room}) {$s->start_time}-{$s->end_time}";
            })->implode(', ');
            return back()->withInput()->withErrors(['start_time' => "เวลาชนกับ: {$messages}"]);
        }

        Schedule::create(array_merge($request->except(['semester', 'academic_year']), [
            'semester' => $semesterNumber,
            'academic_year' => $academicYear,
        ]));

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
        $rooms = Schedule::ROOMS;

        return view('schedules.edit', compact('schedule', 'classes', 'subjects', 'teachers', 'semesters', 'rooms'));
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
            'start_time' => 'required|date_format:H:i|before:20:00',
            'end_time' => 'required|date_format:H:i|after:start_time|before_or_equal:20:00',
            'room' => ['required', 'string', 'max:50', Rule::in(Schedule::ROOMS)],
            'semester_id' => 'required|exists:semesters,id',
        ]);

        $semesterRecord = Semester::findOrFail($request->semester_id);
        $semesterNumber = (int) filter_var($semesterRecord->name, FILTER_SANITIZE_NUMBER_INT) ?: 1;
        $academicYear = $semesterRecord->year - 543;

        // ตรวจสอบตารางชนกัน (ยกเว้นตัวเอง)
        $conflicts = $this->findConflicts(
            $request->class_id,
            $request->subject_id,
            $request->teacher_id,
            $request->room,
            $request->day_of_week,
            $request->start_time,
            $request->end_time,
            $request->semester_id,
            $schedule->id
        );

        if ($conflicts->isNotEmpty()) {
            $messages = $conflicts->map(function ($s) {
                return "วิชา {$s->subject->name} (ห้อง {$s->room}) {$s->start_time}-{$s->end_time}";
            })->implode(', ');
            return back()->withInput()->withErrors(['start_time' => "เวลาชนกับ: {$messages}"]);
        }

        $schedule->update(array_merge($request->except(['semester', 'academic_year']), [
            'semester' => $semesterNumber,
            'academic_year' => $academicYear,
        ]));

        return redirect()->route('schedules.index')->with('success', 'อัปเดตตารางเรียนสำเร็จ');
    }

    public function availableRooms(Request $request)
    {
        $validated = $request->validate([
            'day_of_week' => 'nullable|in:M,T,W,TH,F,SA,SU',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'semester_id' => 'nullable|exists:semesters,id',
            'exclude_schedule_id' => 'nullable|integer|exists:schedules,id',
        ]);

        $rooms = collect(Schedule::ROOMS);

        if (empty($validated['day_of_week']) || empty($validated['start_time']) || empty($validated['end_time']) || empty($validated['semester_id'])) {
            return response()->json([
                'rooms' => $rooms->map(fn ($room) => ['name' => $room, 'available' => true])->values(),
            ]);
        }

        $occupiedRooms = Schedule::query()
            ->where('day_of_week', $validated['day_of_week'])
            ->where('semester_id', $validated['semester_id'])
            ->where(function ($query) use ($validated) {
                $query->where('start_time', '<', $validated['end_time'])
                    ->where('end_time', '>', $validated['start_time']);
            })
            ->when(!empty($validated['exclude_schedule_id']), function ($query) use ($validated) {
                $query->where('id', '!=', $validated['exclude_schedule_id']);
            })
            ->pluck('room')
            ->filter()
            ->unique();

        return response()->json([
            'rooms' => $rooms->map(fn ($room) => [
                'name' => $room,
                'available' => !$occupiedRooms->contains($room),
            ])->values(),
        ]);
    }

    /**
     * ตรวจสอบตารางชนกัน (ช่วงเวลา overlap สำหรับห้องเรียนหรืออาจารย์)
     */
    private function findConflicts(string $classId, string $subjectId, string $teacherId, string $room, string $dayOfWeek, string $startTime, string $endTime, string $semesterId, ?int $excludeId = null)
    {
        $query = Schedule::with('subject')
            ->where('day_of_week', $dayOfWeek)
            ->where('semester_id', $semesterId)
            ->where(function ($q) use ($classId, $subjectId, $teacherId, $room) {
                $q->where('class_id', $classId)
                  ->orWhere('subject_id', $subjectId)
                  ->orWhere('teacher_id', $teacherId)
                  ->orWhere('room', $room);
            })
            ->where(function ($q) use ($startTime, $endTime) {
                // ช่วงเวลาชนกัน: start < existing_end AND end > existing_start
                $q->where('start_time', '<', $endTime)
                  ->where('end_time', '>', $startTime);
            });

        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->get();
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
        $activeSemester = Semester::where('is_active', true)->first();

        $query = Schedule::where('teacher_id', $teacher->id)
            ->with(['studentClass', 'subject', 'semesterData']);

        if ($activeSemester) {
            $query->where('semester_id', $activeSemester->id);
        }

        $schedules = $query->orderBy('day_of_week', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        return view('schedules.teacher-schedule', compact('schedules', 'teacher', 'activeSemester'));
    }

    /**
     * Show student's schedule
     */
    public function studentSchedule()
    {
        $student = Auth::user();
        $classId = $student->class_id;
        $activeSemester = Semester::where('is_active', true)->first();
        $studentClass = $classId ? StudentClass::find($classId) : null;

        $query = Schedule::where('class_id', $classId)
            ->with(['subject', 'teacher', 'semesterData']);

        if ($activeSemester) {
            $query->where('semester_id', $activeSemester->id);
        }

        $schedules = $query->orderBy('day_of_week', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        return view('schedules.grid-view', compact('schedules', 'student', 'activeSemester', 'studentClass'));
    }
}
