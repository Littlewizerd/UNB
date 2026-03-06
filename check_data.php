<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

$admin = \App\Models\User::where('email', 'admin001@gmail.com')->first();
$teacher = \App\Models\User::where('email', 'teacher001@gmail.com')->first();
$student = \App\Models\User::where('email', 'student001@gmail.com')->first();
$totalUsers = \App\Models\User::count();
$totalClasses = \App\Models\StudentClass::count();
$totalSubjects = \App\Models\Subject::count();

echo "\n✅ DATABASE CHECK:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "📊 Total Users: " . $totalUsers . "\n";
echo "📍 Total Classes: " . $totalClasses . "\n";
echo "📚 Total Subjects: " . $totalSubjects . "\n\n";

echo "👤 TEST USERS:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Admin: " . ($admin ? $admin->name . " ✅" : "NOT FOUND ❌") . "\n";
echo "Teacher: " . ($teacher ? $teacher->name . " ✅" : "NOT FOUND ❌") . "\n";
echo "Student: " . ($student ? $student->name . " ✅" : "NOT FOUND ❌") . "\n";
echo "\n";
