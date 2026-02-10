<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * แสดงรายชื่อครูทั้งหมด
     */
    public function index()
    {
        $teachers = Teacher::paginate(15);

        return view('teachers.index', compact('teachers'));
    }

    /**
     * แสดงฟอร์มสร้างครูใหม่
     */
    public function create()
    {
        return view('teachers.create');
    }

    /**
     * บันทึกครูใหม่
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'teacher_id' => 'required|unique:users',
            'phone' => 'nullable|string',
            'department' => 'required|string',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $validated['role'] = 'teacher';
        $validated['password'] = bcrypt($validated['password']);

        Teacher::create($validated);

        return redirect()->route('teachers.index')
            ->with('success', 'เพิ่มครูใหม่สำเร็จ');
    }

    /**
     * แสดงรายละเอียดครู
     */
    public function show(Teacher $teacher)
    {
        $teacher->load('subjects', 'schedules');
        $totalStudents = $teacher->schedules()->distinct('class_id')->count();

        return view('teachers.show', compact('teacher', 'totalStudents'));
    }

    /**
     * แสดงฟอร์มแก้ไขครู
     */
    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    /**
     * อัปเดตข้อมูลครู
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $teacher->id,
            'teacher_id' => 'required|unique:users,teacher_id,' . $teacher->id,
            'phone' => 'nullable|string',
            'department' => 'required|string'
        ]);

        $teacher->update($validated);

        return redirect()->route('teachers.show', $teacher)
            ->with('success', 'อัปเดตข้อมูลครูสำเร็จ');
    }

    /**
     * ลบครู
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return redirect()->route('teachers.index')
            ->with('success', 'ลบครูสำเร็จ');
    }

    /**
     * ค้นหาครู
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $teachers = Teacher::where('name', 'like', "%{$query}%")
            ->orWhere('teacher_id', 'like', "%{$query}%")
            ->orWhere('department', 'like', "%{$query}%")
            ->paginate(15);

        return view('teachers.index', compact('teachers', 'query'));
    }
}
