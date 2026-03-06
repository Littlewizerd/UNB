<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\StudentClass;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleDemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $classes = StudentClass::orderBy('id')->get();
        $subjects = Subject::orderBy('id')->limit(3)->get();
        $teacher = User::where('role', 'teacher')->orderBy('id')->first();

        if ($classes->isEmpty() || $subjects->isEmpty() || !$teacher) {
            $this->command?->warn('ข้อมูลพื้นฐาน (class/subject/teacher) ยังไม่พร้อมสำหรับเดโม');
            return;
        }

        foreach (range(7, 10) as $number) {
            $suffix = str_pad((string) $number, 3, '0', STR_PAD_LEFT);
            $classId = $classes[($number - 1) % $classes->count()]->id;

            User::updateOrCreate(
                ['email' => "Student{$suffix}@gmail.com"],
                [
                    'name' => "Student{$suffix}",
                    'student_id' => "STU{$suffix}",
                    'password' => Hash::make('12345678'),
                    'role' => 'student',
                    'class_id' => $classId,
                    'email_verified_at' => now(),
                ]
            );
        }

        $days = ['M', 'T', 'W'];
        $starts = ['08:00:00', '09:00:00', '10:00:00'];
        $ends = ['09:00:00', '10:00:00', '11:00:00'];

        foreach ($classes as $classIndex => $class) {
            foreach ($subjects as $subjectIndex => $subject) {
                Schedule::updateOrCreate(
                    [
                        'class_id' => $class->id,
                        'subject_id' => $subject->id,
                        'teacher_id' => $teacher->id,
                        'day_of_week' => $days[$subjectIndex % count($days)],
                        'start_time' => $starts[$subjectIndex % count($starts)],
                        'end_time' => $ends[$subjectIndex % count($ends)],
                    ],
                    [
                        'room' => 'R' . (100 + $classIndex * 10 + $subjectIndex + 1),
                        'semester' => 1,
                        'academic_year' => (int) now()->year,
                    ]
                );
            }
        }
    }
}
