<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // เพิ่ม foreign key constraint เมื่อ student_classes table สร้างแล้ว
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'class_id')) {
                return;
            }
            
            // ตรวจสอบว่า foreign key ยังไม่สร้าง
            $tableDetails = Schema::getConnection()->select("SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_NAME='users' AND COLUMN_NAME='class_id' AND REFERENCED_TABLE_NAME='student_classes'");
            
            if (empty($tableDetails)) {
                $table->foreign('class_id')
                    ->references('id')
                    ->on('student_classes')
                    ->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['class_id']);
        });
    }
};
