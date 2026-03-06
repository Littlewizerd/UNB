<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;

class AddThreeSubjectsSeeder extends Seeder
{
    public function run(): void
    {
        $teacher = User::where('role', 'teacher')->orderBy('id')->first();

        if (!$teacher) {
            $this->command?->warn('ไม่พบผู้ใช้ role=teacher จึงยังไม่สามารถเพิ่มวิชาได้');
            return;
        }

        $subjects = [
            [
                'name' => 'คอมพิวเตอร์พื้นฐาน',
                'subject_code' => 'COM102',
                'credits' => 2,
                'description' => 'พื้นฐานการใช้งานคอมพิวเตอร์และการคิดเชิงคำนวณ',
            ],
            [
                'name' => 'ประวัติศาสตร์ไทย',
                'subject_code' => 'HIS102',
                'credits' => 2,
                'description' => 'ความรู้พื้นฐานประวัติศาสตร์ไทยและเหตุการณ์สำคัญ',
            ],
            [
                'name' => 'สุขศึกษาและพลศึกษา',
                'subject_code' => 'HEA102',
                'credits' => 2,
                'description' => 'ส่งเสริมสุขภาพ การออกกำลังกาย และวินัยส่วนบุคคล',
            ],
        ];

        foreach ($subjects as $item) {
            Subject::updateOrCreate(
                ['subject_code' => $item['subject_code']],
                [
                    'name' => $item['name'],
                    'teacher_id' => $teacher->id,
                    'credits' => $item['credits'],
                    'description' => $item['description'],
                ]
            );
        }
    }
}
