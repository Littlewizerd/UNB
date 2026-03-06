<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * แสดงรายวิชาทั้งหมด (อาจารย์จะเห็นเฉพาะวิชาที่ตนเองสอน)
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));
        $user = auth()->user();

        $subjects = Subject::with('teacher')
            ->when(strtolower($user->role ?? '') === 'teacher', function ($query) use ($user) {
                $query->where('teacher_id', $user->id);
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($builder) use ($search) {
                    $builder->where('name', 'like', "%{$search}%")
                        ->orWhere('subject_code', 'like', "%{$search}%");
                });
            })
            ->orderBy('subject_code')
            ->paginate(15);

        return view('subjects.index', compact('subjects', 'search'));
    }

    /**
     * แสดงฟอร์มสร้างวิชาใหม่
     */
    public function create()
    {
        $teachers = User::where('role', 'teacher')
            ->orderBy('name')
            ->get(['id', 'name', 'teacher_id']);

        return view('subjects.create', compact('teachers'));
    }

    /**
     * บันทึกวิชาใหม่
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject_code' => 'required|unique:subjects',
            'teacher_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
            'credits' => 'nullable|integer|min:1|max:4'
        ]);

        $validated['subject_code'] = strtoupper(trim($validated['subject_code']));

        Subject::create($validated);

        return redirect()->route('subjects.index')
            ->with('success', 'เพิ่มวิชาใหม่สำเร็จ');
    }

    /**
     * แสดงรายละเอียดวิชา + นักศึกษาในรายวิชา
     */
    public function show(Subject $subject)
    {
        $subject->load('teacher', 'schedules.studentClass');

        $attendanceRecords = null;
        $enrolledStudents = collect();
        $userRole = strtolower((string) auth()->user()->role);

        if (in_array($userRole, ['admin', 'teacher'], true)) {
            $attendanceRecords = Attendance::where('subject_id', $subject->id)
                ->with(['student:id,name,student_id', 'schedule:id,start_time,end_time,day_of_week'])
                ->orderByDesc('attendance_date')
                ->paginate(20);

            // ดึงนักศึกษาที่ลงทะเบียนเรียนในรายวิชานี้ ผ่าน schedules → classes → students
            $classIds = $subject->schedules->pluck('class_id')->unique()->filter();
            if ($classIds->isNotEmpty()) {
                $enrolledStudents = \App\Models\Student::whereIn('class_id', $classIds)
                    ->with('studentClass')
                    ->orderBy('student_id')
                    ->get();
            }
        }

        return view('subjects.show', compact('subject', 'attendanceRecords', 'enrolledStudents'));
    }

    /**
     * แสดงฟอร์มแก้ไขวิชา
     */
    public function edit(Subject $subject)
    {
        $teachers = User::where('role', 'teacher')
            ->orderBy('name')
            ->get(['id', 'name', 'teacher_id']);

        return view('subjects.edit', compact('subject', 'teachers'));
    }

    /**
     * อัปเดตโดยวิชา
     */
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject_code' => 'required|unique:subjects,subject_code,' . $subject->id,
            'teacher_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
            'credits' => 'nullable|integer|min:1|max:4'
        ]);

        $validated['subject_code'] = strtoupper(trim($validated['subject_code']));

        $subject->update($validated);

        return redirect()->route('subjects.index')
            ->with('success', 'อัปเดตวิชาสำเร็จ');
    }

    /**
     * ลบวิชา
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('subjects.index')
            ->with('success', 'ลบวิชาสำเร็จ');
    }
}
