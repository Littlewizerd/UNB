<?php

$mysqli = new mysqli('127.0.0.1', 'root', '', 'finalproject_app');
$mysqli->set_charset('utf8mb4');

echo "====== USERS DATA ======\n";
$res = $mysqli->query('SELECT id, name, email, role, student_id, teacher_id FROM users');
printf("| %-3s | %-22s | %-27s | %-8s | %-10s | %-10s |\n", 'ID', 'Name', 'Email', 'Role', 'Std ID', 'Tch ID');
echo str_repeat('-', 105) . "\n";
while($row = $res->fetch_assoc()) {
    printf("| %-3d | %-22s | %-27s | %-8s | %-10s | %-10s |\n", 
        $row['id'], 
        substr($row['name'], 0, 22),
        substr($row['email'], 0, 27),
        $row['role'],
        $row['student_id'] ?? '-',
        $row['teacher_id'] ?? '-'
    );
}

echo "\n====== STUDENT_CLASSES DATA ======\n";
$res = $mysqli->query('SELECT id, class_name, class_code, level, advisor_id FROM student_classes');
printf("| %-3s | %-20s | %-12s | %-10s | %-10s |\n", 'ID', 'Class Name', 'Code', 'Level', 'Advisor');
echo str_repeat('-', 60) . "\n";
while($row = $res->fetch_assoc()) {
    printf("| %-3d | %-20s | %-12s | %-10s | %-10s |\n", 
        $row['id'], 
        $row['class_name'],
        $row['class_code'],
        $row['level'],
        $row['advisor_id'] ?? '-'
    );
}

echo "\n====== SUBJECTS DATA ======\n";
$res = $mysqli->query('SELECT id, name, subject_code, teacher_id, credits FROM subjects');
printf("| %-3s | %-20s | %-12s | %-10s | %-8s |\n", 'ID', 'Name', 'Code', 'Teacher', 'Credits');
echo str_repeat('-', 60) . "\n";
while($row = $res->fetch_assoc()) {
    printf("| %-3d | %-20s | %-12s | %-10s | %-8s |\n", 
        $row['id'], 
        substr($row['name'], 0, 20),
        $row['subject_code'],
        $row['teacher_id'],
        $row['credits'] ?? '-'
    );
}

echo "\n====== SCHEDULES DATA ======\n";
$res = $mysqli->query('SELECT id, class_id, subject_id, day_of_week, start_time, end_time FROM schedules');
printf("| %-3s | %-8s | %-10s | %-6s | %-10s | %-10s |\n", 'ID', 'Class', 'Subject', 'Day', 'Start', 'End');
echo str_repeat('-', 60) . "\n";
while($row = $res->fetch_assoc()) {
    printf("| %-3d | %-8s | %-10s | %-6s | %-10s | %-10s |\n", 
        $row['id'], 
        $row['class_id'],
        $row['subject_id'],
        $row['day_of_week'],
        $row['start_time'],
        $row['end_time']
    );
}

echo "\n====== ATTENDANCES DATA (First 5 records) ======\n";
$res = $mysqli->query('SELECT id, student_id, schedule_id, attendance_date, status FROM attendances LIMIT 5');
printf("| %-3s | %-10s | %-11s | %-14s | %-8s |\n", 'ID', 'Student', 'Schedule', 'Date', 'Status');
echo str_repeat('-', 55) . "\n";
while($row = $res->fetch_assoc()) {
    printf("| %-3d | %-10s | %-11s | %-14s | %-8s |\n", 
        $row['id'], 
        $row['student_id'],
        $row['schedule_id'],
        $row['attendance_date'],
        $row['status']
    );
}

$mysqli->close();
