#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\User;
use App\Models\StudentClass;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\Attendance;

echo "\n====== USERS DATA ======\n";
printf("| %-3s | %-22s | %-27s | %-8s | %-10s | %-10s |\n", 'ID', 'Name', 'Email', 'Role', 'Std ID', 'Tch ID');
echo str_repeat('-', 105) . "\n";
User::all()->each(function($row) {
    printf("| %-3d | %-22s | %-27s | %-8s | %-10s | %-10s |\n", 
        $row->id, 
        substr($row->name, 0, 22),
        substr($row->email, 0, 27),
        $row->role,
        $row->student_id ?? '-',
        $row->teacher_id ?? '-'
    );
});

echo "\n====== STUDENT_CLASSES DATA ======\n";
printf("| %-3s | %-20s | %-12s | %-10s | %-10s |\n", 'ID', 'Class Name', 'Code', 'Level', 'Advisor');
echo str_repeat('-', 60) . "\n";
StudentClass::all()->each(function($row) {
    printf("| %-3d | %-20s | %-12s | %-10s | %-10s |\n", 
        $row->id, 
        $row->class_name,
        $row->class_code,
        $row->level,
        $row->advisor_id ?? '-'
    );
});

echo "\n====== SUBJECTS DATA ======\n";
printf("| %-3s | %-20s | %-12s | %-10s | %-8s |\n", 'ID', 'Name', 'Code', 'Teacher', 'Credits');
echo str_repeat('-', 60) . "\n";
Subject::all()->each(function($row) {
    printf("| %-3d | %-20s | %-12s | %-10s | %-8s |\n", 
        $row->id, 
        substr($row->name, 0, 20),
        $row->subject_code,
        $row->teacher_id,
        $row->credits ?? '-'
    );
});

echo "\n====== SCHEDULES DATA ======\n";
printf("| %-3s | %-8s | %-10s | %-6s | %-10s | %-10s |\n", 'ID', 'Class', 'Subject', 'Day', 'Start', 'End');
echo str_repeat('-', 60) . "\n";
Schedule::all()->each(function($row) {
    printf("| %-3d | %-8s | %-10s | %-6s | %-10s | %-10s |\n", 
        $row->id, 
        $row->class_id,
        $row->subject_id,
        $row->day_of_week,
        $row->start_time,
        $row->end_time
    );
});

echo "\n====== ATTENDANCES DATA (First 5 records) ======\n";
printf("| %-3s | %-10s | %-11s | %-14s | %-8s |\n", 'ID', 'Student', 'Schedule', 'Date', 'Status');
echo str_repeat('-', 55) . "\n";
Attendance::limit(5)->get()->each(function($row) {
    printf("| %-3d | %-10s | %-11s | %-14s | %-8s |\n", 
        $row->id, 
        $row->student_id,
        $row->schedule_id,
        $row->attendance_date,
        $row->status
    );
});

echo "\n====== DATABASE STATISTICS ======\n";
echo sprintf("Total Users: %d\n", User::count());
echo sprintf("Total Classes: %d\n", StudentClass::count());
echo sprintf("Total Subjects: %d\n", Subject::count());
echo sprintf("Total Schedules: %d\n", Schedule::count());
echo sprintf("Total Attendance Records: %d\n", Attendance::count());
echo "\n";
