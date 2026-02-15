<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateDefaultUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // สร้างบัญชีนักเรียน
        User::create([
            'name' => 'นักเรียน001',
            'email' => 'student001@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'student',
        ]);

        // สร้างบัญชีอาจารย์
        User::create([
            'name' => 'อาจารย์001',
            'email' => 'teacher001@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'teacher',
        ]);

        // สร้างบัญชีแอดมิน
        User::create([
            'name' => 'แอดมิน001',
            'email' => 'admin001@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'admin',
        ]);
    }
}
