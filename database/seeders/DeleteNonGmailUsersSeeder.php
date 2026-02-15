<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeleteNonGmailUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ลบบัญชีผู้ใช้ที่ไม่ใช่ Gmail
        $deletedCount = User::where('email', 'not like', '%@gmail.com')->delete();
        
        $this->command->info("ลบบัญชีผู้ใช้ที่ไม่ใช่ Gmail: {$deletedCount} บัญชี");
    }
}
