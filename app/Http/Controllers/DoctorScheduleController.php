<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DoctorScheduleController extends Controller
{
    public function index()
    {
        // สามารถดึงข้อมูลตารางหมอจากฐานข้อมูลได้ที่นี่
        return view('doctor_schedules.index');
    }
}
