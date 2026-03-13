<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentClass;
use App\Models\Schedule;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * ดึง class_id ที่อาจารย์คนนี้สอน
     */
    private function getTeacherClassIds()
    {
        return Schedule::where('teacher_id', Auth::id())
            ->distinct()
            ->pluck('class_id');
    }

    /**
     * แสดงรายชื่อนักเรียน (อาจารย์เห็นเฉพาะในรายวิชาที่สอน)
     */
    public function index()
    {
        $query = Student::with('studentClass');

        if (Auth::user()->role === 'teacher') {
            $classIds = $this->getTeacherClassIds();
            $query->whereIn('class_id', $classIds);
        }

        $students = $query->paginate(15);

        return view('students.index', compact('students'));
    }

    /**
     * แสดงฟอร์มสร้างนักเรียนใหม่
     */
    public function create()
    {
        $classes = StudentClass::all();
        return view('students.create', compact('classes'));
    }

    /**
     * บันทึกนักเรียนใหม่
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'student_id' => 'required|unique:users',
            'phone' => 'nullable|string',
            'class_id' => 'required|exists:student_classes,id',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $validated['role'] = 'student';
        $validated['password'] = bcrypt($validated['password']);

        Student::create($validated);

        return redirect()->route('students.index')
            ->with('success', 'เพิ่มนักเรียนใหม่สำเร็จ');
    }

    /**
     * แสดงรายละเอียดนักเรียน
     */
    public function show(Student $student)
    {
        $this->authorizeTeacherAccess($student);

        $student->load('studentClass', 'attendances');
        
        // สถิติการเข้าเรียน
        $stats = [
            'present' => Attendance::where('student_id', $student->id)->where('status', 'present')->count(),
            'absent' => Attendance::where('student_id', $student->id)->where('status', 'absent')->count(),
            'late' => Attendance::where('student_id', $student->id)->where('status', 'late')->count(),
            'excused' => Attendance::where('student_id', $student->id)->where('status', 'excused')->count()
        ];

        return view('students.show', compact('student', 'stats'));
    }

    /**
     * แสดงฟอร์มแก้ไขนักเรียน
     */
    public function edit(Student $student)
    {
        $this->authorizeTeacherAccess($student);

        $classes = StudentClass::all();
        return view('students.edit', compact('student', 'classes'));
    }

    /**
     * อัปเดตข้อมูลนักเรียน
     */
    public function update(Request $request, Student $student)
    {
        $this->authorizeTeacherAccess($student);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->id,
            'student_id' => 'required|unique:users,student_id,' . $student->id,
            'phone' => 'nullable|string',
            'class_id' => 'required|exists:student_classes,id'
        ]);

        $student->update($validated);

        return redirect()->route('students.show', $student)
            ->with('success', 'อัปเดตข้อมูลนักเรียนสำเร็จ');
    }

    /**
     * ลบนักเรียน
     */
    public function destroy(Student $student)
    {
        $this->authorizeTeacherAccess($student);

        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'ลบนักเรียนสำเร็จ');
    }

    /**
     * ค้นหานักเรียน
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $builder = Student::where(function ($b) use ($query) {
            $b->where('name', 'like', "%{$query}%")
                ->orWhere('student_id', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%");
            })
            ->with('studentClass');

        if (Auth::user()->role === 'teacher') {
            $classIds = $this->getTeacherClassIds();
            $builder->whereIn('class_id', $classIds);
        }

        $students = $builder->paginate(15);

        return view('students.index', compact('students', 'query'));
    }

    /**
     * ตรวจสอบสิทธิ์อาจารย์ - เข้าถึงได้เฉพาะนักศึกษาในรายวิชาที่สอน
     */
    private function authorizeTeacherAccess(Student $student): void
    {
        if (Auth::user()->role === 'teacher') {
            $classIds = $this->getTeacherClassIds();
            if (!$classIds->contains($student->class_id)) {
                abort(403, 'ไม่มีสิทธิ์เข้าถึงข้อมูลนักศึกษาคนนี้');
            }
        }
    }
}
