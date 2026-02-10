<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * แสดงรายวิชาทั้งหมด
     */
    public function index()
    {
        $subjects = Subject::with('teacher')
            ->paginate(15);

        return view('subjects.index', compact('subjects'));
    }

    /**
     * แสดงฟอร์มสร้างวิชาใหม่
     */
    public function create()
    {
        $teachers = Teacher::all();
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

        Subject::create($validated);

        return redirect()->route('subjects.index')
            ->with('success', 'เพิ่มวิชาใหม่สำเร็จ');
    }

    /**
     * แสดงรายละเอียดวิชา
     */
    public function show(Subject $subject)
    {
        $subject->load('teacher', 'schedules', 'attendances');
        return view('subjects.show', compact('subject'));
    }

    /**
     * แสดงฟอร์มแก้ไขวิชา
     */
    public function edit(Subject $subject)
    {
        $teachers = Teacher::all();
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

        $subject->update($validated);

        return redirect()->route('subjects.show', $subject)
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
