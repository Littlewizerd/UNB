<?php

namespace Database\Seeders;

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
        // เรียก Seeder สำหรับ Gmail users ที่มีข้อมูล
        $this->call(GmailUsersSeeder::class);
        $this->call(SevenDayActivitySeeder::class);
    }
}
