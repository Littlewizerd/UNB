<?php

namespace App\Http\Controllers;

use App\Models\MakeupSchedule;
use App\Models\Schedule;
use App\Models\Semester;
use App\Models\StudentClass;
use App\Models\Subject;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MakeupScheduleController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $semesterId = $request->query('semester_id');
        $user = Auth::user();

        $query = MakeupSchedule::with(['studentClass', 'subject', 'teacher', 'semesterData'])
            ->when(strtolower((string) $user->role) === 'teacher', function ($builder) use ($user) {
                $builder->where('teacher_id', $user->id);
            })
            ->when($search !== '', function ($builder) use ($search) {
                $builder->where(function ($q) use ($search) {
                    $q->whereHas('subject', function ($subQuery) use ($search) {
                        $subQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('subject_code', 'like', "%{$search}%");
                    })->orWhereHas('studentClass', function ($classQuery) use ($search) {
                        $classQuery->where('class_name', 'like', "%{$search}%")
                            ->orWhere('class_code', 'like', "%{$search}%");
                    })->orWhereHas('teacher', function ($teacherQuery) use ($search) {
                        $teacherQuery->where('name', 'like', "%{$search}%");
                    })->orWhere('room', 'like', "%{$search}%");
                });
            })
            ->when($semesterId, fn ($builder) => $builder->where('semester_id', $semesterId));

        $makeupSchedules = $query->orderBy('makeup_date')
            ->orderBy('start_time')
            ->paginate(12)
            ->withQueryString();

        $semesters = Semester::orderByDesc('year')->orderBy('name')->get();

        return view('makeup-schedules.index', compact('makeupSchedules', 'search', 'semesterId', 'semesters'));
    }

    public function create()
    {
        [$classes, $subjects, $teachers, $selectedTeacherId] = $this->getFormOptions();
        $semesters = Semester::orderByDesc('year')->orderBy('name')->get();
        $rooms = Schedule::ROOMS;

        return view('makeup-schedules.create', compact('classes', 'subjects', 'teachers', 'selectedTeacherId', 'semesters', 'rooms'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        $this->ensureTeacherCanManage($validated['class_id'], $validated['subject_id'], $validated['teacher_id']);
        $this->ensureDateWithinSemester($validated['makeup_date'], (int) $validated['semester_id']);

        $conflicts = $this->findConflicts(
            (int) $validated['class_id'],
            (int) $validated['subject_id'],
            (int) $validated['teacher_id'],
            $validated['room'],
            $validated['makeup_date'],
            $validated['start_time'],
            $validated['end_time'],
            (int) $validated['semester_id']
        );

        if ($conflicts->isNotEmpty()) {
            return back()->withInput()->withErrors([
                'start_time' => 'ช่วงเวลานี้ชนกับ: ' . $conflicts->implode(' | '),
            ]);
        }

        MakeupSchedule::create($validated);

        return redirect()->route($this->redirectRoute())->with('success', 'เพิ่มตารางชดเชยสำเร็จ');
    }

    public function edit(MakeupSchedule $makeupSchedule)
    {
        $this->authorizeManageRecord($makeupSchedule);

        [$classes, $subjects, $teachers, $selectedTeacherId] = $this->getFormOptions();
        $semesters = Semester::orderByDesc('year')->orderBy('name')->get();
        $rooms = Schedule::ROOMS;

        return view('makeup-schedules.edit', compact('makeupSchedule', 'classes', 'subjects', 'teachers', 'selectedTeacherId', 'semesters', 'rooms'));
    }

    public function update(Request $request, MakeupSchedule $makeupSchedule)
    {
        $this->authorizeManageRecord($makeupSchedule);

        $validated = $this->validateRequest($request, $makeupSchedule);
        $this->ensureTeacherCanManage($validated['class_id'], $validated['subject_id'], $validated['teacher_id']);
        $this->ensureDateWithinSemester($validated['makeup_date'], (int) $validated['semester_id']);

        $conflicts = $this->findConflicts(
            (int) $validated['class_id'],
            (int) $validated['subject_id'],
            (int) $validated['teacher_id'],
            $validated['room'],
            $validated['makeup_date'],
            $validated['start_time'],
            $validated['end_time'],
            (int) $validated['semester_id'],
            $makeupSchedule->id
        );

        if ($conflicts->isNotEmpty()) {
            return back()->withInput()->withErrors([
                'start_time' => 'ช่วงเวลานี้ชนกับ: ' . $conflicts->implode(' | '),
            ]);
        }

        $makeupSchedule->update($validated);

        return redirect()->route($this->redirectRoute())->with('success', 'อัปเดตตารางชดเชยสำเร็จ');
    }

    public function destroy(MakeupSchedule $makeupSchedule)
    {
        $this->authorizeManageRecord($makeupSchedule);

        $makeupSchedule->delete();

        return redirect()->route($this->redirectRoute())->with('success', 'ลบตารางชดเชยสำเร็จ');
    }

    public function complete(MakeupSchedule $makeupSchedule)
    {
        $this->authorizeManageRecord($makeupSchedule);

        $makeupSchedule->update(['status' => 'completed']);

        return redirect()->route($this->redirectRoute())->with('success', 'ยืนยันการสอนชดเชยสำเร็จ');
    }

    public function availableRooms(Request $request)
    {
        $validated = $request->validate([
            'makeup_date' => ['nullable', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'semester_id' => ['nullable', 'exists:semesters,id'],
            'exclude_makeup_schedule_id' => ['nullable', 'integer', 'exists:makeup_schedules,id'],
        ]);

        $rooms = collect(Schedule::ROOMS);

        if (empty($validated['makeup_date']) || empty($validated['start_time']) || empty($validated['end_time']) || empty($validated['semester_id'])) {
            return response()->json([
                'rooms' => $rooms->map(fn ($room) => ['name' => $room, 'available' => true])->values(),
            ]);
        }

        $occupiedMakeupRooms = MakeupSchedule::query()
            ->where('makeup_date', $validated['makeup_date'])
            ->where(function ($query) use ($validated) {
                $query->where('start_time', '<', $validated['end_time'])
                    ->where('end_time', '>', $validated['start_time']);
            })
            ->when(!empty($validated['exclude_makeup_schedule_id']), function ($query) use ($validated) {
                $query->where('id', '!=', $validated['exclude_makeup_schedule_id']);
            })
            ->pluck('room')
            ->filter()
            ->unique();

        $dayCode = $this->resolveDayCode($validated['makeup_date']);

        $occupiedRegularRooms = Schedule::query()
            ->where('semester_id', $validated['semester_id'])
            ->where('day_of_week', $dayCode)
            ->where(function ($query) use ($validated) {
                $query->where('start_time', '<', $validated['end_time'])
                    ->where('end_time', '>', $validated['start_time']);
            })
            ->pluck('room')
            ->filter()
            ->unique();

        $occupiedRooms = $occupiedMakeupRooms->concat($occupiedRegularRooms)->unique()->values();

        return response()->json([
            'rooms' => $rooms->map(fn ($room) => [
                'name' => $room,
                'available' => !$occupiedRooms->contains($room),
            ])->values(),
        ]);
    }

    public function teacherSchedule()
    {
        $teacher = Auth::user();
        $activeSemester = Semester::where('is_active', true)->first();

        $query = MakeupSchedule::where('teacher_id', $teacher->id)
            ->with(['studentClass', 'subject', 'semesterData']);

        if ($activeSemester) {
            $query->where('semester_id', $activeSemester->id);
        }

        $makeupSchedules = $query->orderBy('makeup_date')
            ->orderBy('start_time')
            ->get();

        return view('makeup-schedules.teacher-schedule', compact('teacher', 'activeSemester', 'makeupSchedules'));
    }

    public function studentSchedule()
    {
        $student = Auth::user();
        $activeSemester = Semester::where('is_active', true)->first();
        $studentClass = $student->class_id ? StudentClass::find($student->class_id) : null;

        $query = MakeupSchedule::where('class_id', $student->class_id)
            ->where('status', 'pending')
            ->with(['subject', 'teacher', 'semesterData']);

        if ($activeSemester) {
            $query->where('semester_id', $activeSemester->id);
        }

        $makeupSchedules = $query->orderBy('makeup_date')
            ->orderBy('start_time')
            ->get();

        return view('makeup-schedules.student-schedule', compact('student', 'studentClass', 'activeSemester', 'makeupSchedules'));
    }

    private function validateRequest(Request $request, ?MakeupSchedule $makeupSchedule = null): array
    {
        if ($this->isTeacher()) {
            $request->merge(['teacher_id' => Auth::id()]);
        }

        return $request->validate([
            'class_id' => ['required', 'exists:student_classes,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'teacher_id' => ['required', 'exists:users,id'],
            'semester_id' => ['required', 'exists:semesters,id'],
            'makeup_date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'room' => ['required', 'string', 'max:50', Rule::in(Schedule::ROOMS)],
            'notes' => ['nullable', 'string'],
        ]);
    }

    private function getFormOptions(): array
    {
        $user = Auth::user();

        if ($this->isTeacher()) {
            $teacherSchedules = Schedule::with(['studentClass', 'subject'])
                ->where('teacher_id', $user->id)
                ->get();

            $classes = StudentClass::whereIn('id', $teacherSchedules->pluck('class_id')->unique())
                ->orderBy('class_name')
                ->get();

            $subjects = Subject::whereIn('id', $teacherSchedules->pluck('subject_id')->unique())
                ->orderBy('subject_code')
                ->get();

            return [$classes, $subjects, collect([$user]), $user->id];
        }

        $classes = StudentClass::orderBy('class_name')->get();
        $subjects = Subject::with('teacher')->orderBy('subject_code')->get();
        $teachers = User::where('role', 'teacher')->orderBy('name')->get();

        return [$classes, $subjects, $teachers, null];
    }

    private function ensureTeacherCanManage(int $classId, int $subjectId, int $teacherId): void
    {
        if (!$this->isTeacher()) {
            return;
        }

        if ($teacherId !== Auth::id()) {
            abort(403, 'อาจารย์สามารถสร้างตารางชดเชยให้ตนเองเท่านั้น');
        }

        $allowed = Schedule::where('teacher_id', Auth::id())
            ->where('class_id', $classId)
            ->where('subject_id', $subjectId)
            ->exists();

        if (!$allowed) {
            abort(403, 'คุณสามารถสร้างตารางชดเชยได้เฉพาะรายวิชาและชั้นเรียนที่ตนเองสอน');
        }
    }

    private function ensureDateWithinSemester(string $makeupDate, int $semesterId): void
    {
        $semester = Semester::findOrFail($semesterId);

        if (!$semester->start_date || !$semester->end_date) {
            return;
        }

        $date = Carbon::parse($makeupDate)->startOfDay();
        $startDate = $semester->start_date->copy()->startOfDay();
        $endDate = $semester->end_date->copy()->endOfDay();

        if ($date->lt($startDate) || $date->gt($endDate)) {
            abort(422, 'วันที่เรียนชดเชยต้องอยู่ภายในช่วงของภาคเรียนที่เลือก');
        }
    }

    private function authorizeManageRecord(MakeupSchedule $makeupSchedule): void
    {
        if ($this->isTeacher() && (int) $makeupSchedule->teacher_id !== (int) Auth::id()) {
            abort(403, 'ไม่มีสิทธิ์จัดการตารางชดเชยนี้');
        }
    }

    private function findConflicts(int $classId, int $subjectId, int $teacherId, string $room, string $makeupDate, string $startTime, string $endTime, int $semesterId, ?int $excludeId = null): Collection
    {
        $makeupConflicts = MakeupSchedule::with('subject')
            ->whereDate('makeup_date', $makeupDate)
            ->where(function ($query) use ($classId, $subjectId, $teacherId, $room) {
                $query->where('class_id', $classId)
                    ->orWhere('subject_id', $subjectId)
                    ->orWhere('teacher_id', $teacherId)
                    ->orWhere('room', $room);
            })
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where('start_time', '<', $endTime)
                    ->where('end_time', '>', $startTime);
            })
            ->when($excludeId, fn ($query) => $query->where('id', '!=', $excludeId))
            ->get()
            ->map(function (MakeupSchedule $schedule) {
                return 'ตารางชดเชย ' . ($schedule->subject->name ?? '-') . ' วันที่ ' . optional($schedule->makeup_date)->format('d/m/Y') . ' ' . substr((string) $schedule->start_time, 0, 5) . '-' . substr((string) $schedule->end_time, 0, 5);
            });

        $dayCode = $this->resolveDayCode($makeupDate);

        // ห้ามชนกับตารางสอนปกติของอาจารย์ ชั้นเรียน หรือห้องเดียวกันในภาคเรียนเดียวกัน
        $regularConflicts = Schedule::with('subject')
            ->where('semester_id', $semesterId)
            ->where('day_of_week', $dayCode)
                ->where(function ($query) use ($classId, $subjectId, $teacherId, $room) {
                $query->where('class_id', $classId)
                    ->orWhere('subject_id', $subjectId)
                    ->orWhere('teacher_id', $teacherId)
                    ->orWhere('room', $room);
            })
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where('start_time', '<', $endTime)
                    ->where('end_time', '>', $startTime);
            })
            ->get()
            ->map(function (Schedule $schedule) {
                return 'ตารางสอนปกติ ' . ($schedule->subject->name ?? '-') . ' ' . substr((string) $schedule->start_time, 0, 5) . '-' . substr((string) $schedule->end_time, 0, 5);
            });

        return $makeupConflicts->concat($regularConflicts)->values();
    }

    private function resolveDayCode(string $date): string
    {
        return match (Carbon::parse($date)->dayOfWeekIso) {
            1 => 'M',
            2 => 'T',
            3 => 'W',
            4 => 'TH',
            5 => 'F',
            6 => 'SA',
            default => 'SU',
        };
    }

    private function isTeacher(): bool
    {
        return strtolower((string) Auth::user()->role) === 'teacher';
    }

    private function redirectRoute(): string
    {
        return $this->isTeacher() ? 'makeup-schedules.teacher-schedule' : 'makeup-schedules.index';
    }
}
