<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // สร้าง Admin User
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // สร้าง Teacher User
        User::factory()->create([
            'name' => 'Teacher User',
            'email' => 'teacher@example.com',
            'password' => bcrypt('password'),
            'role' => 'teacher',
            'teacher_id' => 'T001',
            'department' => 'สาขาวิทยาศาสตร์',
        ]);

        // สร้าง Student Users
        User::factory()->create([
            'name' => 'Student User 1',
            'email' => 'student1@example.com',
            'password' => bcrypt('password'),
            'role' => 'student',
            'student_id' => 'S001',
        ]);

        User::factory()->create([
            'name' => 'Student User 2',
            'email' => 'student2@example.com',
            'password' => bcrypt('password'),
            'role' => 'student',
            'student_id' => 'S002',
        ]);
    }
}
