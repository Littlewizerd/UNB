<?php

namespace App\Http\Controllers;

use App\Models\StudentClass;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    /**
     * แสดงรายชั้นเรียนทั้งหมด
     */
    public function index()
    {
        $classes = StudentClass::with('advisor', 'students')
            ->paginate(10);

        return view('classes.index', compact('classes'));
    }

    /**
     * แสดงฟอร์มสร้างชั้นเรียนใหม่
     */
    public function create()
    {
        $advisors = Teacher::all();
        return view('classes.create', compact('advisors'));
    }

    /**
     * บันทึกชั้นเรียนใหม่
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_name' => 'required|string|max:255',
            'class_code' => 'required|unique:student_classes',
            'advisor_id' => 'required|exists:users,id',
            'level' => 'required|string',
            'description' => 'nullable|string'
        ]);

        StudentClass::create($validated);

        return redirect()->route('classes.index')
            ->with('success', 'สร้างชั้นเรียนใหม่สำเร็จ');
    }

    /**
     * แสดงรายละเอียดชั้นเรียน
     */
    public function show(StudentClass $class)
    {
        $class->load('advisor', 'students', 'schedules');
        return view('classes.show', compact('class'));
    }

    /**
     * แสดงฟอร์มแก้ไขชั้นเรียน
     */
    public function edit(StudentClass $class)
    {
        $advisors = Teacher::all();
        return view('classes.edit', compact('class', 'advisors'));
    }

    /**
     * อัปเดตชั้นเรียน
     */
    public function update(Request $request, StudentClass $class)
    {
        $validated = $request->validate([
            'class_name' => 'required|string|max:255',
            'class_code' => 'required|unique:student_classes,class_code,' . $class->id,
            'advisor_id' => 'required|exists:users,id',
            'level' => 'required|string',
            'description' => 'nullable|string'
        ]);

        $class->update($validated);

        return redirect()->route('classes.show', $class)
            ->with('success', 'อัปเดตชั้นเรียนสำเร็จ');
    }

    /**
     * ลบชั้นเรียน
     */
    public function destroy(StudentClass $class)
    {
        $class->delete();

        return redirect()->route('classes.index')
            ->with('success', 'ลบชั้นเรียนสำเร็จ');
    }
}
