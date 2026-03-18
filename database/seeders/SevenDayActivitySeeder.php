<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Subject;
use App\Models\StudentClass;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SevenDayActivitySeeder extends Seeder
{
    public function run(): void
    {
        // ========== ลบของเดิมออก ==========
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Attendance::truncate();
        Schedule::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ========== ข้อมูลที่มีอยู่ ==========
        // Users: admin id=2, teachers id=1,4,5, students id=3,6-16
        // Classes: id=6 (ม.1 อ), id=7 (ม.1 ข), id=8 (ม.2 อ)
        // Subjects: 10-16

        $classIds  = [6, 7, 8];
        $subjectIds = [10, 11, 12, 13, 14, 15, 16];

        // จับคู่ subject → class (แต่ละวิชาสอนทุกห้อง)
        // วันเรียน: M T W TH F สลับไปตามวิชา
        $dayMap = ['M', 'T', 'W', 'TH', 'F', 'M', 'T'];
        $timeMap = [
            ['08:00', '09:30'],
            ['09:30', '11:00'],
            ['11:00', '12:30'],
            ['13:00', '14:30'],
            ['14:30', '16:00'],
            ['08:00', '09:30'],
            ['09:30', '11:00'],
        ];

        // ========== สร้าง Schedules ==========
        $schedules = []; // [subject_id][class_id] => Schedule

        foreach ($subjectIds as $si => $subjectId) {
            $subject = Subject::find($subjectId);
            if (! $subject) continue;

            foreach ($classIds as $classId) {
                $schedule = Schedule::create([
                    'subject_id'    => $subjectId,
                    'class_id'      => $classId,
                    'teacher_id'    => $subject->teacher_id,
                    'day_of_week'   => $dayMap[$si],
                    'start_time'    => $timeMap[$si][0],
                    'end_time'      => $timeMap[$si][1],
                    'room'          => Schedule::ROOMS[($si + ($classId - 6) * 3) % count(Schedule::ROOMS)],
                    'semester'      => 1,
                    'academic_year' => 2026,
                ]);
                $schedules[$subjectId][$classId] = $schedule;
            }
        }

        // ========== 7 วันทำการย้อนหลัง ==========
        $weekdays = [];
        $date = Carbon::today()->subDays(1);
        while (count($weekdays) < 7) {
            if ($date->isWeekday()) {
                $weekdays[] = $date->copy();
            }
            $date->subDay();
        }
        $weekdays = array_reverse($weekdays); // เรียงเก่าไปใหม่

        // map Carbon day name → schedule day code
        $dayCodeMap = [
            'Monday'    => 'M',
            'Tuesday'   => 'T',
            'Wednesday' => 'W',
            'Thursday'  => 'TH',
            'Friday'    => 'F',
        ];

        // ========== นักศึกษาแต่ละห้อง ==========
        $studentsByClass = [];
        foreach ($classIds as $classId) {
            $studentsByClass[$classId] = Student::where('class_id', $classId)->get();
        }

        // ========== สร้าง Attendance สำหรับ 7 วัน ==========
        $statusOptions = ['present', 'present', 'present', 'present', 'late', 'absent', 'excused'];

        foreach ($weekdays as $dayCarbon) {
            $dayName = $dayCarbon->format('l'); // Monday, etc.
            $dayCode = $dayCodeMap[$dayName] ?? null;
            if (! $dayCode) continue;

            foreach ($subjectIds as $subjectId) {
                foreach ($classIds as $classId) {
                    $schedule = $schedules[$subjectId][$classId] ?? null;
                    if (! $schedule) continue;

                    $students = $studentsByClass[$classId] ?? collect();
                    foreach ($students as $student) {
                        // สุ่มสถานะแบบมีน้ำหนัก (มาเรียนมากกว่าขาด)
                        $status = $statusOptions[array_rand($statusOptions)];

                        Attendance::create([
                            'student_id'      => $student->id,
                            'schedule_id'     => $schedule->id,
                            'subject_id'      => $subjectId,
                            'attendance_date' => $dayCarbon->format('Y-m-d'),
                            'check_in_time'   => in_array($status, ['absent', 'excused']) ? null : $dayCarbon->copy()->setTimeFromTimeString($schedule->start_time)->addMinutes($status === 'late' ? rand(10, 30) : rand(0, 5))->format('H:i:s'),
                            'status'          => $status,
                            'recorded_by'     => $schedule->teacher_id,
                            'notes'           => null,
                        ]);
                    }
                }
            }
        }

        $total = Attendance::count();
        $this->command->info("✅ สร้าง Schedules: " . Schedule::count() . " รายการ");
        $this->command->info("✅ สร้าง Attendances: {$total} รายการ (7 วัน, " . count($subjectIds) . " วิชา, " . count($classIds) . " ห้อง)");
    }
}
