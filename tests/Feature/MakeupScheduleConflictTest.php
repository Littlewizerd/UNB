<?php

use App\Models\MakeupSchedule;
use App\Models\Schedule;
use App\Models\Semester;
use App\Models\StudentClass;
use App\Models\Subject;
use App\Models\User;

function createMakeupDependencies(): array
{
    $admin = User::factory()->create([
        'role' => 'admin',
        'email' => 'admin2@example.com',
    ]);

    $teacherA = User::factory()->create([
        'role' => 'teacher',
        'email' => 'makeup-teacher-a@example.com',
        'teacher_id' => 'MT001',
    ]);

    $teacherB = User::factory()->create([
        'role' => 'teacher',
        'email' => 'makeup-teacher-b@example.com',
        'teacher_id' => 'MT002',
    ]);

    $classA = StudentClass::create([
        'class_name' => 'ม.2/1',
        'class_code' => 'M21',
        'advisor_id' => $teacherA->id,
        'level' => 'ม.2',
    ]);

    $classB = StudentClass::create([
        'class_name' => 'ม.2/2',
        'class_code' => 'M22',
        'advisor_id' => $teacherB->id,
        'level' => 'ม.2',
    ]);

    $semester = Semester::create([
        'name' => 'ภาคเรียนที่ 1',
        'start_date' => '2026-05-01',
        'end_date' => '2026-09-30',
        'year' => 2569,
        'is_active' => true,
    ]);

    $subjectA = Subject::create([
        'name' => 'ภาษาไทย',
        'subject_code' => 'TH101',
        'teacher_id' => $teacherA->id,
        'credits' => 3,
    ]);

    $subjectB = Subject::create([
        'name' => 'สังคมศึกษา',
        'subject_code' => 'SO101',
        'teacher_id' => $teacherB->id,
        'credits' => 3,
    ]);

    return compact('admin', 'teacherA', 'teacherB', 'classA', 'classB', 'semester', 'subjectA', 'subjectB');
}

it('blocks makeup schedules that collide by room with regular schedules', function () {
    $deps = createMakeupDependencies();

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

    $response = $this->actingAs($deps['admin'])->post(route('makeup-schedules.store'), [
        'class_id' => $deps['classB']->id,
        'subject_id' => $deps['subjectB']->id,
        'teacher_id' => $deps['teacherB']->id,
        'semester_id' => $deps['semester']->id,
        'makeup_date' => '2026-06-01',
        'start_time' => '09:30',
        'end_time' => '10:30',
        'room' => 'A101',
    ]);

    $response->assertSessionHasErrors('start_time');
    expect(MakeupSchedule::count())->toBe(0);
});

it('blocks makeup schedules that collide by subject', function () {
    $deps = createMakeupDependencies();

    MakeupSchedule::create([
        'class_id' => $deps['classA']->id,
        'subject_id' => $deps['subjectA']->id,
        'teacher_id' => $deps['teacherA']->id,
        'semester_id' => $deps['semester']->id,
        'makeup_date' => '2026-06-02',
        'start_time' => '13:00',
        'end_time' => '14:00',
        'room' => 'A102',
    ]);

    $response = $this->actingAs($deps['admin'])->post(route('makeup-schedules.store'), [
        'class_id' => $deps['classB']->id,
        'subject_id' => $deps['subjectA']->id,
        'teacher_id' => $deps['teacherB']->id,
        'semester_id' => $deps['semester']->id,
        'makeup_date' => '2026-06-02',
        'start_time' => '13:30',
        'end_time' => '14:30',
        'room' => 'B201',
    ]);

    $response->assertSessionHasErrors('start_time');
    expect(MakeupSchedule::count())->toBe(1);
});
