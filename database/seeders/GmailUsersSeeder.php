<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\StudentClass;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\Attendance;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class GmailUsersSeeder extends Seeder
{
    /**
     * Seed the application's database with Gmail users
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

        // ========== 2. สร้าง Teacher User ก่อน (เพื่อใช้ใน Subject) ==========
        $teacher = User::create([
            'name' => 'อาจารย์001',
            'email' => 'teacher001@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'teacher',
            'teacher_id' => 'T001',
            'phone' => '0812345678',
            'department' => 'สาขาวิทยาศาสตร์',
            'email_verified_at' => now(),
        ]);

        // ========== 3. สร้าง Subject (วิชา) ==========
        $subjectMath = Subject::create([
            'name' => 'คณิตศาสตร์',
            'subject_code' => 'MATH101',
            'teacher_id' => $teacher->id,
            'credits' => 3,
            'description' => 'วิชาคณิตศาสตร์ระดับประถม',
        ]);

        $subjectEnglish = Subject::create([
            'name' => 'ภาษาอังกฤษ',
            'subject_code' => 'ENG101',
            'teacher_id' => $teacher->id,
            'credits' => 2,
            'description' => 'วิชาภาษาอังกฤษพื้นฐาน',
        ]);

        $subjectScience = Subject::create([
            'name' => 'วิทยาศาสตร์',
            'subject_code' => 'SCI101',
            'teacher_id' => $teacher->id,
            'credits' => 3,
            'description' => 'วิชาวิทยาศาสตร์ทั่วไป',
        ]);

        // ตั้ง teacher เป็น advisor
        $class_m1a->update(['advisor_id' => $teacher->id]);

        // ========== 4. สร้าง Admin User ==========
        User::create([
            'name' => 'แอดมิน001',
            'email' => 'admin001@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // ========== 5. สร้าง Student User ==========
        $student = User::create([
            'name' => 'นักเรียน001',
            'email' => 'student001@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'student',
            'student_id' => 'STU001',
            'phone' => '0898765432',
            'class_id' => $class_m1a->id,
            'email_verified_at' => now(),
        ]);

        // ========== 6. สร้าง Schedule (ตารางเรียน) ==========
        $schedules = [];
        $schedules[] = Schedule::create([
            'class_id' => $class_m1a->id,
            'subject_id' => $subjectMath->id,
            'teacher_id' => $teacher->id,
            'day_of_week' => 'M',
            'start_time' => '08:00:00',
            'end_time' => '09:00:00',
            'room' => '301',
            'semester' => 1,
            'academic_year' => 2026,
        ]);

        $schedules[] = Schedule::create([
            'class_id' => $class_m1a->id,
            'subject_id' => $subjectEnglish->id,
            'teacher_id' => $teacher->id,
            'day_of_week' => 'T',
            'start_time' => '09:00:00',
            'end_time' => '10:00:00',
            'room' => '302',
            'semester' => 1,
            'academic_year' => 2026,
        ]);

        $schedules[] = Schedule::create([
            'class_id' => $class_m1a->id,
            'subject_id' => $subjectScience->id,
            'teacher_id' => $teacher->id,
            'day_of_week' => 'W',
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
            'room' => '303',
            'semester' => 1,
            'academic_year' => 2026,
        ]);

        // ========== 7. สร้าง Attendance Records ==========
        $today = Carbon::today();
        $daysAgo = [];
        for ($i = 0; $i < 10; $i++) {
            $daysAgo[] = $today->copy()->subDays($i);
        }

        $statuses = ['present', 'present', 'present', 'absent', 'late'];
        
        foreach ($daysAgo as $index => $date) {
            $status = $statuses[$index % count($statuses)];
            
            foreach ($schedules as $schedule) {
                Attendance::create([
                    'student_id' => $student->id,
                    'schedule_id' => $schedule->id,
                    'subject_id' => $schedule->subject_id,
                    'attendance_date' => $date,
                    'check_in_time' => $status === 'present' ? '08:00:00' : ($status === 'late' ? '08:15:00' : null),
                    'check_out_time' => $status === 'present' ? '09:00:00' : ($status === 'late' ? '09:00:00' : null),
                    'status' => $status,
                    'recorded_by' => $teacher->id,
                    'notes' => $status === 'absent' ? 'ขาดเรียน' : '',
                ]);
            }
        }

        echo "\n✅ Gmail Users seeding completed!\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "📧 Gmail Accounts:\n";
        echo "   • Admin: admin001@gmail.com / 12345678\n";
        echo "   • Teacher: teacher001@gmail.com / 12345678\n";
        echo "   • Student: student001@gmail.com / 12345678\n\n";
        echo "📊 Created:\n";
        echo "   • Student Classes: 3\n";
        echo "   • Subjects: 3\n";
        echo "   • Schedules: 3\n";
        echo "   • Attendance Records: 30\n\n";
    }
}
