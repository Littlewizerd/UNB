<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DoctorScheduleController extends Controller
{
    public function index()
    {
        // ดึงข้อมูลหมอจากตาราง users ที่มี role = 'doctor'
        $doctors = User::where('role', 'doctor')->get();
        
        return view('doctor_schedules.index', compact('doctors'));
    }

    public function create()
    {
        // ดึงข้อมูลหมอทั้งหมด
        $doctors = User::where('role', 'doctor')->get();
        return view('doctor_schedules.create', compact('doctors'));
    }

    public function store(Request $request)
    {
        // บันทึกข้อมูลตารางใหม่
        return redirect()->route('doctor.schedule')->with('success', 'เพิ่มตารางสำเร็จ');
    }

    public function edit($id)
    {
        $doctors = User::where('role', 'doctor')->get();
        return view('doctor_schedules.edit', ['id' => $id, 'doctors' => $doctors]);
    }

    public function update(Request $request, $id)
    {
        // อัปเดตข้อมูลตารางเดิม
        return redirect()->route('doctor.schedule')->with('success', 'แก้ไขตารางสำเร็จ');
    }

    public function destroy($id)
    {
        // ลบตารางออกจากฐานข้อมูล
        return redirect()->route('doctor.schedule')->with('success', 'ลบตารางสำเร็จ');
    }
}
