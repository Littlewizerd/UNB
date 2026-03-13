<?php

use App\Models\Schedule;
use App\Models\Semester;
use App\Models\StudentClass;
use App\Models\Subject;
use App\Models\User;

function createScheduleDependencies(): array
{
    $admin = User::factory()->create([
        'role' => 'admin',
        'email' => 'admin@example.com',
    ]);

    $teacherA = User::factory()->create([
        'role' => 'teacher',
        'email' => 'teacher-a@example.com',
        'teacher_id' => 'T001',
    ]);

    $teacherB = User::factory()->create([
        'role' => 'teacher',
        'email' => 'teacher-b@example.com',
        'teacher_id' => 'T002',
    ]);

    $classA = StudentClass::create([
        'class_name' => 'ม.1/1',
        'class_code' => 'M11',
        'advisor_id' => $teacherA->id,
        'level' => 'ม.1',
    ]);

    $classB = StudentClass::create([
        'class_name' => 'ม.1/2',
        'class_code' => 'M12',
        'advisor_id' => $teacherB->id,
        'level' => 'ม.1',
    ]);

    $semester = Semester::create([
        'name' => 'ภาคเรียนที่ 1',
        'start_date' => '2026-05-01',
        'end_date' => '2026-09-30',
        'year' => 2569,
        'is_active' => true,
    ]);

    $subjectA = Subject::create([
        'name' => 'คณิตศาสตร์',
        'subject_code' => 'MATH101',
        'teacher_id' => $teacherA->id,
        'credits' => 3,
    ]);

    $subjectB = Subject::create([
        'name' => 'วิทยาศาสตร์',
        'subject_code' => 'SCI101',
        'teacher_id' => $teacherB->id,
        'credits' => 3,
    ]);

    return compact('admin', 'teacherA', 'teacherB', 'classA', 'classB', 'semester', 'subjectA', 'subjectB');
}

it('blocks regular schedules that collide by room', function () {
    $deps = createScheduleDependencies();

    Schedule::create([
        'class_id' => $deps['classA']->id,
        'subject_id' => $deps['subjectA']->id,
        'teacher_id' => $deps['teacherA']->id,
        'day_of_week' => 'M',
        'start_time' => '09:00',
        'end_time' => '10:00',
        'room' => 'A101',
        'semester' => 1,
        'academic_year' => 2026,
        'semester_id' => $deps['semester']->id,
    ]);

    $response = $this->actingAs($deps['admin'])->post(route('schedules.store'), [
        'class_id' => $deps['classB']->id,
        'subject_id' => $deps['subjectB']->id,
        'teacher_id' => $deps['teacherB']->id,
        'day_of_week' => 'M',
        'start_time' => '09:30',
        'end_time' => '10:30',
        'room' => 'A101',
        'semester_id' => $deps['semester']->id,
    ]);

    $response->assertSessionHasErrors('start_time');
    expect(Schedule::count())->toBe(1);
});

it('blocks regular schedules that collide by subject', function () {
    $deps = createScheduleDependencies();

    Schedule::create([
        'class_id' => $deps['classA']->id,
        'subject_id' => $deps['subjectA']->id,
        'teacher_id' => $deps['teacherA']->id,
        'day_of_week' => 'T',
        'start_time' => '13:00',
        'end_time' => '14:00',
        'room' => 'A101',
        'semester' => 1,
        'academic_year' => 2026,
        'semester_id' => $deps['semester']->id,
    ]);

    $response = $this->actingAs($deps['admin'])->post(route('schedules.store'), [
        'class_id' => $deps['classB']->id,
        'subject_id' => $deps['subjectA']->id,
        'teacher_id' => $deps['teacherB']->id,
        'day_of_week' => 'T',
        'start_time' => '13:30',
        'end_time' => '14:30',
        'room' => 'B201',
        'semester_id' => $deps['semester']->id,
    ]);

    $response->assertSessionHasErrors('start_time');
    expect(Schedule::count())->toBe(1);
});
