<?php

/**
 * ─────────────────────────────────────────────────────────────
 *  AccessControlTest.php – ทดสอบสิทธิ์การเข้าถึงระบบในเชิงตรรกะ
 * ─────────────────────────────────────────────────────────────
 *
 *  ใครควรทำได้ / ไม่ควรทำได้ ตามบทบาท (admin, teacher, student, guest)
 *
 *  Section A – Authentication (Guest)
 *  Section B – Dashboard
 *  Section C – Admin-only: Classes, Teachers, Users, Semesters, Schedules (Manage)
 *  Section D – Admin+Teacher: Students (view), Subjects (view), Reports
 *  Section E – Student: สิทธิ์จำกัดเฉพาะดูข้อมูล ห้าม CRUD
 *  Section F – Attendance: บันทึกได้เฉพาะครู/admin
 *  Section G – Messages: ส่งถึงบุคคลที่ถูกต้อง / ห้ามส่งถึงตัวเอง
 *  Section H – Reports: student ดูได้เฉพาะข้อมูลตัวเอง
 */

use App\Models\User;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\Schedule;
use App\Models\Teacher;
use App\Models\Message;

// ───────────────────────────────────────────────────────────
//  Helper: สร้าง user ตาม role
// ───────────────────────────────────────────────────────────
function makeAdmin(): User
{
    return User::factory()->create(['role' => 'admin']);
}

function makeTeacher(): User
{
    return User::factory()->create(['role' => 'teacher', 'teacher_id' => 'T' . fake()->unique()->numerify('###')]);
}

function makeStudent(): User
{
    return User::factory()->create(['role' => 'student', 'student_id' => 'S' . fake()->unique()->numerify('###')]);
}

// ───────────────────────────────────────────────────────────
//  Section A – Guest (ยังไม่ได้ login)
// ───────────────────────────────────────────────────────────

it('[A] guest เข้าหน้าแรก / ได้', function () {
    $this->get('/')->assertStatus(200);
});

it('[A] guest เข้า /dashboard ถูก redirect ไป login', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});

it('[A] guest เข้า /students ถูก redirect ไป login', function () {
    $this->get('/students')->assertRedirect('/login');
});

it('[A] guest เข้า /classes ถูก redirect ไป login', function () {
    $this->get('/classes')->assertRedirect('/login');
});

it('[A] guest POST /students ถูก redirect ไป login', function () {
    $this->post('/students')->assertRedirect('/login');
});

it('[A] guest เข้า /users ถูก redirect ไป login', function () {
    $this->get('/users')->assertRedirect('/login');
});

// ───────────────────────────────────────────────────────────
//  Section B – Dashboard
// ───────────────────────────────────────────────────────────

it('[B] admin เข้า /dashboard ได้', function () {
    $this->actingAs(makeAdmin())->get('/dashboard')->assertOk();
});

it('[B] teacher เข้า /dashboard ได้', function () {
    $this->actingAs(makeTeacher())->get('/dashboard')->assertOk();
});

it('[B] student เข้า /dashboard ได้', function () {
    $this->actingAs(makeStudent())->get('/dashboard')->assertOk();
});

// ───────────────────────────────────────────────────────────
//  Section C – Admin-only: Classes
// ───────────────────────────────────────────────────────────

it('[C] admin เข้า /classes ได้ (200)', function () {
    $this->actingAs(makeAdmin())->get('/classes')->assertOk();
});

it('[C] teacher เข้า /classes ถูก block (403)', function () {
    $this->actingAs(makeTeacher())->get('/classes')->assertStatus(403);
});

it('[C] student เข้า /classes ถูก block (403)', function () {
    $this->actingAs(makeStudent())->get('/classes')->assertStatus(403);
});

it('[C] admin สร้าง class ได้', function () {
    $teacher = makeTeacher();
    $this->actingAs(makeAdmin())
        ->post('/classes', [
            'class_name' => 'ม.1/1',
            'class_code' => 'M11',
            'advisor_id' => $teacher->id,
            'level' => 'ม.1',
        ])->assertRedirect();
    expect(StudentClass::where('class_code', 'M11')->exists())->toBeTrue();
});

it('[C] teacher ไม่สามารถสร้าง class ได้ (403)', function () {
    $teacher = makeTeacher();
    $this->actingAs($teacher)
        ->post('/classes', [
            'class_name' => 'ม.2/1',
            'class_code' => 'M21X',
            'advisor_id' => $teacher->id,
            'level' => 'ม.2',
        ])->assertStatus(403);
    expect(StudentClass::where('class_code', 'M21X')->exists())->toBeFalse();
});

it('[C] student ไม่สามารถสร้าง class ได้ (403)', function () {
    $student = makeStudent();
    $this->actingAs($student)
        ->post('/classes', [
            'class_name' => 'ม.3/1',
            'class_code' => 'M31X',
            'advisor_id' => $student->id,
            'level' => 'ม.3',
        ])->assertStatus(403);
});

// ───────────────────────────────────────────────────────────
//  Section C – Admin-only: Teachers
// ───────────────────────────────────────────────────────────

it('[C] admin เข้า /teachers ได้', function () {
    $this->actingAs(makeAdmin())->get('/teachers')->assertOk();
});

it('[C] teacher เข้า /teachers ถูก block (403)', function () {
    $this->actingAs(makeTeacher())->get('/teachers')->assertStatus(403);
});

it('[C] student เข้า /teachers ถูก block (403)', function () {
    $this->actingAs(makeStudent())->get('/teachers')->assertStatus(403);
});

// ───────────────────────────────────────────────────────────
//  Section C – Admin-only: Users
// ───────────────────────────────────────────────────────────

it('[C] admin เข้า /users ได้', function () {
    $this->actingAs(makeAdmin())->get('/users')->assertOk();
});

it('[C] teacher เข้า /users ถูก block (403)', function () {
    $this->actingAs(makeTeacher())->get('/users')->assertStatus(403);
});

it('[C] student เข้า /users ถูก block (403)', function () {
    $this->actingAs(makeStudent())->get('/users')->assertStatus(403);
});

// ───────────────────────────────────────────────────────────
//  Section C – Admin-only: Semesters
// ───────────────────────────────────────────────────────────

it('[C] admin เข้า /semesters ได้', function () {
    $this->actingAs(makeAdmin())->get('/semesters')->assertOk();
});

it('[C] teacher เข้า /semesters ถูก block (403)', function () {
    $this->actingAs(makeTeacher())->get('/semesters')->assertStatus(403);
});

it('[C] student เข้า /semesters ถูก block (403)', function () {
    $this->actingAs(makeStudent())->get('/semesters')->assertStatus(403);
});

// ───────────────────────────────────────────────────────────
//  Section D – Students: admin+teacher ดูได้ / student ดูไม่ได้
// ───────────────────────────────────────────────────────────

it('[D] admin เข้า /students ได้', function () {
    $this->actingAs(makeAdmin())->get('/students')->assertOk();
});

it('[D] teacher เข้า /students ได้', function () {
    $this->actingAs(makeTeacher())->get('/students')->assertOk();
});

it('[D] student เข้า /students ถูก block (403)', function () {
    $this->actingAs(makeStudent())->get('/students')->assertStatus(403);
});

it('[D] teacher เข้าหน้าสร้าง student (/students/create) ถูก block (403)', function () {
    $this->actingAs(makeTeacher())->get('/students/create')->assertStatus(403);
});

it('[D] teacher ไม่สามารถ POST สร้าง student ได้ (403)', function () {
    $this->actingAs(makeTeacher())
        ->post('/students', [
            'name' => 'นักเรียนทดสอบ',
            'email' => 'test-student@example.com',
            'student_id' => 'S999',
            'role' => 'student',
            'password' => 'password',
        ])->assertStatus(403);
});

it('[D] teacher ไม่สามารถลบ student ได้ (403)', function () {
    $student = makeStudent();
    $this->actingAs(makeTeacher())
        ->delete("/students/{$student->id}")
        ->assertStatus(403);
});

// ───────────────────────────────────────────────────────────
//  Section D – Subjects: ทุก role ดูได้ / เฉพาะ admin จัดการ
// ───────────────────────────────────────────────────────────

it('[D] admin เข้า /subjects ได้', function () {
    $this->actingAs(makeAdmin())->get('/subjects')->assertOk();
});

it('[D] teacher เข้า /subjects ได้', function () {
    $this->actingAs(makeTeacher())->get('/subjects')->assertOk();
});

it('[D] student เข้า /subjects ได้', function () {
    $this->actingAs(makeStudent())->get('/subjects')->assertOk();
});

it('[D] teacher ไม่สามารถสร้าง subject ได้ (403)', function () {
    $teacher = makeTeacher();
    $this->actingAs($teacher)
        ->post('/subjects', [
            'name' => 'วิชาทดสอบ',
            'subject_code' => 'TEST101',
            'teacher_id' => $teacher->id,
            'credits' => 3,
        ])->assertStatus(403);
});

it('[D] student ไม่สามารถสร้าง subject ได้ (403)', function () {
    $this->actingAs(makeStudent())
        ->post('/subjects', [
            'name' => 'วิชาทดสอบ',
            'subject_code' => 'TEST102',
            'credits' => 3,
        ])->assertStatus(403);
});

// ───────────────────────────────────────────────────────────
//  Section E – Schedules: admin จัดการ / teacher+student ดูได้
// ───────────────────────────────────────────────────────────

it('[E] teacher เข้า /schedules ถูก block (403)', function () {
    $this->actingAs(makeTeacher())->get('/schedules')->assertStatus(403);
});

it('[E] student เข้า /schedules ถูก block (403)', function () {
    $this->actingAs(makeStudent())->get('/schedules')->assertStatus(403);
});

it('[E] teacher เข้า /my-schedule ได้ (redirect หรือ 200)', function () {
    $response = $this->actingAs(makeTeacher())->get('/my-schedule');
    expect($response->status())->toBeIn([200, 302]);
});

it('[E] student เข้า /my-schedule ได้ (redirect หรือ 200)', function () {
    $response = $this->actingAs(makeStudent())->get('/my-schedule');
    expect($response->status())->toBeIn([200, 302]);
});

// ───────────────────────────────────────────────────────────
//  Section F – Attendance: บันทึกได้เฉพาะ teacher/admin
// ───────────────────────────────────────────────────────────

it('[F] teacher เข้าหน้าบันทึกเวลาได้', function () {
    $this->actingAs(makeTeacher())->get('/teacher/record')->assertOk();
});

it('[F] student เข้าหน้าบันทึกเวลาของครูไม่ได้ (403)', function () {
    $this->actingAs(makeStudent())->get('/teacher/record')->assertStatus(403);
});

it('[F] admin เข้าหน้าบันทึกเวลาของครูได้', function () {
    $this->actingAs(makeAdmin())->get('/teacher/record')->assertOk();
});

// ───────────────────────────────────────────────────────────
//  Section G – Messages
// ───────────────────────────────────────────────────────────

it('[G] ทุก role เข้า /messages ได้', function () {
    $this->actingAs(makeAdmin())->get('/messages')->assertOk();
    $this->actingAs(makeTeacher())->get('/messages')->assertOk();
    $this->actingAs(makeStudent())->get('/messages')->assertOk();
});

it('[G] ส่งข้อความหาตัวเองไม่ได้', function () {
    $user = makeAdmin();
    $this->actingAs($user)
        ->post('/messages', [
            'recipient_id' => $user->id,
            'subject' => 'Test',
            'message' => 'Hello me',
        ])->assertSessionHasErrors('recipient_id');
    expect(Message::where('sender_id', $user->id)->count())->toBe(0);
});

it('[G] student ส่งข้อความหา student คนอื่นไม่ได้', function () {
    $sender = makeStudent();
    $receiver = makeStudent();

    $this->actingAs($sender)
        ->post('/messages', [
            'recipient_id' => $receiver->id,
            'subject' => 'Test',
            'message' => 'Hello S2S',
        ])->assertSessionHasErrors('recipient_id');
    expect(Message::where('sender_id', $sender->id)->count())->toBe(0);
});

it('[G] teacher ส่งข้อความหา teacher คนอื่นไม่ได้', function () {
    $sender = makeTeacher();
    $receiver = makeTeacher();

    $this->actingAs($sender)
        ->post('/messages', [
            'recipient_id' => $receiver->id,
            'subject' => 'Test',
            'message' => 'Hello T2T',
        ])->assertSessionHasErrors('recipient_id');
    expect(Message::where('sender_id', $sender->id)->count())->toBe(0);
});

it('[G] student ส่งข้อความหา teacher ได้', function () {
    $student = makeStudent();
    $teacher = makeTeacher();

    $this->actingAs($student)
        ->post('/messages', [
            'recipient_id' => $teacher->id,
            'subject' => 'ขอลา',
            'message' => 'ขอลาป่วย',
        ])->assertRedirect(route('messages.index'));
    expect(Message::where('sender_id', $student->id)->where('recipient_id', $teacher->id)->count())->toBe(1);
});

it('[G] teacher ส่งข้อความหา student ได้', function () {
    $teacher = makeTeacher();
    $student = makeStudent();

    $this->actingAs($teacher)
        ->post('/messages', [
            'recipient_id' => $student->id,
            'subject' => 'แจ้งผล',
            'message' => 'แจ้งผลการเรียน',
        ])->assertRedirect(route('messages.index'));
    expect(Message::where('sender_id', $teacher->id)->where('recipient_id', $student->id)->count())->toBe(1);
});

it('[G] student ไม่สามารถส่งข้อความเป็น class broadcast ได้ (403)', function () {
    $teacher = makeTeacher();
    $classA = StudentClass::create([
        'class_name' => 'ม.1/1',
        'class_code' => 'MC01',
        'advisor_id' => $teacher->id,
        'level' => 'ม.1',
    ]);

    $this->actingAs(makeStudent())
        ->post('/messages/send-class', [
            'class_id' => $classA->id,
            'subject' => 'Test broadcast',
            'message' => 'Hello class',
        ])->assertStatus(403);
});

// ───────────────────────────────────────────────────────────
//  Section H – Reports
// ───────────────────────────────────────────────────────────

it('[H] student ดูรายงานของตัวเองได้', function () {
    $student = makeStudent();
    $this->actingAs($student)
        ->get("/reports/student/{$student->id}")
        ->assertOk();
});

it('[H] student ดูรายงานนักเรียนคนอื่นไม่ได้ (403)', function () {
    $student1 = makeStudent();
    $student2 = makeStudent();

    $this->actingAs($student1)
        ->get("/reports/student/{$student2->id}")
        ->assertStatus(403);
});

it('[H] teacher ดูรายงานนักเรียนคนใดก็ได้ (200)', function () {
    $student = makeStudent();
    $this->actingAs(makeTeacher())
        ->get("/reports/student/{$student->id}")
        ->assertOk();
});

it('[H] student เข้า /reports/daily-summary ไม่ได้ (403)', function () {
    $this->actingAs(makeStudent())
        ->get('/reports/daily-summary')
        ->assertStatus(403);
});

it('[H] teacher เข้า /reports/daily-summary ได้', function () {
    $this->actingAs(makeTeacher())
        ->get('/reports/daily-summary')
        ->assertOk();
});

it('[H] admin เข้า /reports/users/pdf ได้', function () {
    $this->actingAs(makeAdmin())
        ->get('/reports/users/pdf')
        ->assertOk();
});

it('[H] teacher เข้า /reports/users/pdf ไม่ได้ (403)', function () {
    $this->actingAs(makeTeacher())
        ->get('/reports/users/pdf')
        ->assertStatus(403);
});

it('[H] student เข้า /reports/users/pdf ไม่ได้ (403)', function () {
    $this->actingAs(makeStudent())
        ->get('/reports/users/pdf')
        ->assertStatus(403);
});
