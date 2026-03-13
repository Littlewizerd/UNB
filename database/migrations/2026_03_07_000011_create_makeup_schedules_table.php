<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('makeup_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('student_classes')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained('semesters')->cascadeOnDelete();
            $table->date('makeup_date')->comment('วันที่เรียนชดเชย');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('room', 50)->nullable();
            $table->text('notes')->nullable()->comment('หมายเหตุเพิ่มเติม');
            $table->timestamps();

            $table->index(['teacher_id', 'makeup_date']);
            $table->index(['class_id', 'makeup_date']);
            $table->index(['semester_id', 'makeup_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('makeup_schedules');
    }
};
