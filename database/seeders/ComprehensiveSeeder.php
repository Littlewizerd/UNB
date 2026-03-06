<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\StudentClass;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\Attendance;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ComprehensiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ========== 1. สร้าง StudentClass (ชั้นเรียน) ==========
        $class_m1a = StudentClass::create([
            'class_name' => 'ม.1 อ',
            'class_code' => 'M1A2026',
            'level' => 'ม.1',
            'description' => 'ชั้นมัธยมศึกษาปีที่ 1 ห้อง อ',
        ]);

        $class_m1b = StudentClass::create([
            'class_name' => 'ม.1 ข',
            'class_code' => 'M1B2026',
            'level' => 'ม.1',
            'description' => 'ชั้นมัธยมศึกษาปีที่ 1 ห้อง ข',
        ]);

        $class_m2a = StudentClass::create([
            'class_name' => 'ม.2 อ',
            'class_code' => 'M2A2026',
            'level' => 'ม.2',
            'description' => 'ชั้นมัธยมศึกษาปีที่ 2 ห้อง อ',
        ]);

        // ========== 3. สร้าง Teacher Users ก่อน (เพื่อใช้ในวิชา) ==========
        $teacher1 = User::create([
            'name' => 'อ.สมชาย นวลสำอาง',
            'email' => 'somchai@example.com',
            'password' => bcrypt('password'),
            'role' => 'teacher',
            'teacher_id' => 'T001',
            'phone' => '0812345678',
            'department' => 'สาขาวิทยาศาสตร์',
            'email_verified_at' => now(),
        ]);

        $teacher2 = User::create([
            'name' => 'อ.สมหญิง ทองใหม่',
            'email' => 'somying@example.com',
            'password' => bcrypt('password'),
            'role' => 'teacher',
            'teacher_id' => 'T002',
            'phone' => '0898765432',
            'department' => 'สาขาภาษา',
            'email_verified_at' => now(),
        ]);

        $teacher3 = User::create([
            'name' => 'อ.ประภา ศิริอาจ',
            'email' => 'prapa@example.com',
            'password' => bcrypt('password'),
            'role' => 'teacher',
            'teacher_id' => 'T003',
            'phone' => '0899999999',
            'department' => 'สาขาวิทยาศาสตร์',
            'email_verified_at' => now(),
        ]);

        // ========== 2. สร้าง Subject (วิชา) ==========
        $subjectMath = Subject::create([
            'name' => 'คณิตศาสตร์',
            'subject_code' => 'MATH101',
            'teacher_id' => $teacher1->id,
            'credits' => 3,
            'description' => 'วิชาคณิตศาสตร์ระดับประถม',
        ]);

        $subjectEnglish = Subject::create([
            'name' => 'ภาษาอังกฤษ',
            'subject_code' => 'ENG101',
            'teacher_id' => $teacher2->id,
            'credits' => 2,
            'description' => 'วิชาภาษาอังกฤษพื้นฐาน',
        ]);

        $subjectScience = Subject::create([
            'name' => 'วิทยาศาสตร์',
            'subject_code' => 'SCI101',
            'teacher_id' => $teacher3->id,
            'credits' => 3,
            'description' => 'วิชาวิทยาศาสตร์ทั่วไป',
        ]);

        $subjectThai = Subject::create([
            'name' => 'ภาษาไทย',
            'subject_code' => 'THAI101',
            'teacher_id' => $teacher1->id,
            'credits' => 2,
            'description' => 'วิชาภาษาไทยพื้นฐาน',
        ]);

        $subjectPE = Subject::create([
            'name' => 'พลศึกษา',
            'subject_code' => 'PE101',
            'teacher_id' => $teacher2->id,
            'credits' => 1,
            'description' => 'วิชาพลศึกษา',
        ]);

        // ตั้งให้ teacher1 เป็น advisor ของ class_m1a
        $class_m1a->update(['advisor_id' => $teacher1->id]);

        // ========== 4. สร้าง Admin User ==========
        User::create([
            'name' => 'ผู้ดูแลระบบ',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // ========== 5. สร้าง Student Users ==========
        // ม.1 อ
        $students_m1a = [];
        for ($i = 1; $i <= 5; $i++) {
            $students_m1a[] = User::create([
                'name' => "นักเรียน ม.1 อ ที่ $i",
                'email' => "student_m1a_$i@example.com",
                'password' => bcrypt('password'),
                'role' => 'student',
                'student_id' => "STU001" . str_pad($i, 3, '0', STR_PAD_LEFT),
                'phone' => '081' . str_pad($i * 1111111, 8, '0', STR_PAD_LEFT),
                'class_id' => $class_m1a->id,
                'email_verified_at' => now(),
            ]);
        }

        // ม.1 ข
        $students_m1b = [];
        for ($i = 1; $i <= 5; $i++) {
            $students_m1b[] = User::create([
                'name' => "นักเรียน ม.1 ข ที่ $i",
                'email' => "student_m1b_$i@example.com",
                'password' => bcrypt('password'),
                'role' => 'student',
                'student_id' => "STU002" . str_pad($i, 3, '0', STR_PAD_LEFT),
                'phone' => '082' . str_pad($i * 1111111, 8, '0', STR_PAD_LEFT),
                'class_id' => $class_m1b->id,
                'email_verified_at' => now(),
            ]);
        }

        // ม.2 อ
        $students_m2a = [];
        for ($i = 1; $i <= 5; $i++) {
            $students_m2a[] = User::create([
                'name' => "นักเรียน ม.2 อ ที่ $i",
                'email' => "student_m2a_$i@example.com",
                'password' => bcrypt('password'),
                'role' => 'student',
                'student_id' => "STU003" . str_pad($i, 3, '0', STR_PAD_LEFT),
                'phone' => '083' . str_pad($i * 1111111, 8, '0', STR_PAD_LEFT),
                'class_id' => $class_m2a->id,
                'email_verified_at' => now(),
            ]);
        }

        // ========== 6. สร้าง Schedule (ตารางเรียน) ==========
        // ม.1 อ ตั้ง 5 วิชา ต่อสัปดาห์
        $schedule_m1a_1 = Schedule::create([
            'class_id' => $class_m1a->id,
            'subject_id' => $subjectMath->id,
            'teacher_id' => $teacher1->id,
            'day_of_week' => 'M',
            'start_time' => '08:00:00',
            'end_time' => '09:00:00',
            'room' => '301',
            'semester' => 1,
            'academic_year' => 2026,
        ]);

        $schedule_m1a_2 = Schedule::create([
            'class_id' => $class_m1a->id,
            'subject_id' => $subjectEnglish->id,
            'teacher_id' => $teacher2->id,
            'day_of_week' => 'T',
            'start_time' => '09:00:00',
            'end_time' => '10:00:00',
            'room' => '302',
            'semester' => 1,
            'academic_year' => 2026,
        ]);

        $schedule_m1a_3 = Schedule::create([
            'class_id' => $class_m1a->id,
            'subject_id' => $subjectScience->id,
            'teacher_id' => $teacher3->id,
            'day_of_week' => 'W',
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
            'room' => '303',
            'semester' => 1,
            'academic_year' => 2026,
        ]);

        $schedule_m1a_4 = Schedule::create([
            'class_id' => $class_m1a->id,
            'subject_id' => $subjectThai->id,
            'teacher_id' => $teacher1->id,
            'day_of_week' => 'TH',
            'start_time' => '11:00:00',
            'end_time' => '12:00:00',
            'room' => '301',
            'semester' => 1,
            'academic_year' => 2026,
        ]);

        $schedule_m1a_5 = Schedule::create([
            'class_id' => $class_m1a->id,
            'subject_id' => $subjectPE->id,
            'teacher_id' => $teacher2->id,
            'day_of_week' => 'F',
            'start_time' => '13:00:00',
            'end_time' => '14:00:00',
            'room' => 'สนาม',
            'semester' => 1,
            'academic_year' => 2026,
        ]);

        // ========== 7. สร้าง Attendance Records (บันทึกเข้าเรียน) ==========
        $today = Carbon::today();
        $daysAgo = [];
        for ($i = 0; $i < 10; $i++) {
            $daysAgo[] = $today->copy()->subDays($i);
        }

        $statuses = ['present', 'present', 'present', 'absent', 'late'];
        
        foreach ($students_m1a as $student) {
            foreach ($daysAgo as $index => $date) {
                $status = $statuses[$index % count($statuses)];
                
                // สร้าง attendance สำหรับแต่ละ schedule
                foreach ([$schedule_m1a_1, $schedule_m1a_2, $schedule_m1a_3] as $schedule) {
                    Attendance::create([
                        'student_id' => $student->id,
                        'schedule_id' => $schedule->id,
                        'subject_id' => $schedule->subject_id,
                        'attendance_date' => $date,
                        'check_in_time' => $status === 'present' ? '08:00:00' : ($status === 'late' ? '08:15:00' : null),
                        'check_out_time' => $status === 'present' ? '09:00:00' : ($status === 'late' ? '09:00:00' : null),
                        'status' => $status,
                        'recorded_by' => $teacher1->id,
                        'notes' => $status === 'absent' ? 'ขาดเรียน' : '',
                    ]);
                }
            }
        }

        echo "\n✅ Comprehensive seeding completed!\n";
        echo "- Student Classes: 3\n";
        echo "- Subjects: 5\n";
        echo "- Teachers: 3\n";
        echo "- Students: 15\n";
        echo "- Admin: 1\n";
        echo "- Schedules: 5\n";
        echo "- Attendance Records: Created automatically\n\n";
    }
}
