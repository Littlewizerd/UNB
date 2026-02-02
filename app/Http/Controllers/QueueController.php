<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function book()
    {
        // ดึงข้อมูลแพทย์จากฐานข้อมูล
        $doctors = User::where('role', 'doctor')->get();
        
        // หากไม่มีข้อมูลแพทย์ ใช้ตัวอย่าง
        if ($doctors->isEmpty()) {
            $doctors = collect([
                (object)['id' => 1, 'name' => 'หมอ A'],
                (object)['id' => 2, 'name' => 'หมอ B'],
                (object)['id' => 3, 'name' => 'หมอ C'],
            ]);
        }

        // เวลาที่มีให้จอง
        $timeSlots = ['09:00', '09:20', '09:40', '10:00', '10:20', '10:40'];
        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

        return view('queue.book', compact('doctors', 'timeSlots', 'days'));
    }

    public function bookingTable()
    {
        // ดึงข้อมูลแพทย์จากฐานข้อมูล
        $doctors = \App\Models\User::where('role', 'doctor')->get();
        
        // หากไม่มีข้อมูลแพทย์ ใช้ตัวอย่าง
        if ($doctors->isEmpty()) {
            $doctors = collect([
                (object)['id' => 1, 'name' => 'หมอ A'],
                (object)['id' => 2, 'name' => 'หมอ B'],
                (object)['id' => 3, 'name' => 'หมอ C'],
            ]);
        }

        // เวลาที่มีให้จอง
        $timeSlots = ['09:00', '09:20', '09:40', '10:00', '10:20', '10:40'];
        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

        return view('queue.booking-table', compact('doctors', 'timeSlots', 'days'));
    }

    public function myQueue()
    {
        return view('queue.my');
    }

    public function currentQueue()
    {
        return view('queue.current');
    }

    public function history()
    {
        return view('queue.history');
    }

    public function manage()
    {
        return view('queue.manage');
    }

    public function call()
    {
        return view('queue.call');
    }
}
