<?php

namespace Database\Seeders;

use App\Models\StudentClass;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AddTeacherStudentBatchSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('12345678');

        foreach (range(2, 3) as $number) {
            $suffix = str_pad((string) $number, 3, '0', STR_PAD_LEFT);

            User::updateOrCreate(
                ['email' => "Teacher{$suffix}@gmail.com"],
                [
                    'name' => "Teacher{$suffix}",
                    'password' => $password,
                    'role' => 'teacher',
                    'teacher_id' => "T{$suffix}",
                    'email_verified_at' => now(),
                ]
            );
        }

        $classId = StudentClass::query()->value('id');

        foreach (range(2, 6) as $number) {
            $suffix = str_pad((string) $number, 3, '0', STR_PAD_LEFT);

            User::updateOrCreate(
                ['email' => "Student{$suffix}@gmail.com"],
                [
                    'name' => "Student{$suffix}",
                    'password' => $password,
                    'role' => 'student',
                    'student_id' => "STU{$suffix}",
                    'class_id' => $classId,
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
