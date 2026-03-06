# ระบบบันทึกเวลาเรียนของนักศึกษา (Attendance Management System)

โปรเจกต์นี้เป็นระบบจัดการการเข้าเรียนสำหรับ 3 บทบาทหลัก: ผู้ดูแลระบบ (Admin), อาจารย์ (Teacher), นักศึกษา (Student)
โดยอ้างอิง Use Case ในไฟล์ [USE_CASE_DIAGRAM.md](USE_CASE_DIAGRAM.md)

## ฟีเจอร์หลัก

- Authentication: เข้าสู่ระบบ/ออกระบบ/รีเซ็ตรหัสผ่าน
- Dashboard สรุปข้อมูลตามบทบาท
- Attendance: ลงเวลา, บันทึกการเข้าเรียน, ประวัติ, สถิติ
- Management: ชั้นเรียน, นักศึกษา, ครู, วิชา, ภาคเรียน, ตารางเรียน
- Messaging: ส่งข้อความ, กล่องรับ/ส่ง, ค้นหา, ลบหลายรายการ, เลิกทำการลบล่าสุด
- Reports: รายงานสรุป/รายชั้น/รายบุคคล/รายวิชา/กลุ่มเสี่ยง และ Export PDF

## การกำหนดสิทธิ์ (Role-based Access)

ระบบใช้ middleware `role` และ `is_admin` เพื่อควบคุมสิทธิ์ให้สอดคล้องกับเล่ม

- Admin:
  - จัดการ classes, teachers, users, semesters, schedules
  - เข้าถึง dashboard, reports, messages และเมนูรวมทั้งหมด
- Teacher:
  - บันทึกเวลาแทนนักศึกษา (`/teacher/record`)
  - จัดการ students และ subjects
  - ดูตารางสอน และเข้าถึง reports
- Student:
  - ลงเวลา (`/attendance/check-in`), ดูประวัติ, ดูตารางเรียน
  - ส่งข้อความถึงผู้สอน/ผู้ดูแลตามสิทธิ์

## โครงสร้างโมดูลสำคัญ

- Routes: [routes/web.php](routes/web.php)
- Middleware:
  - [app/Http/Middleware/IsAdmin.php](app/Http/Middleware/IsAdmin.php)
  - [app/Http/Middleware/EnsureRole.php](app/Http/Middleware/EnsureRole.php)
- รายงาน PDF: [app/Http/Controllers/ReportController.php](app/Http/Controllers/ReportController.php)

## วิธีติดตั้ง

1. ติดตั้งแพ็กเกจ
   - `composer install`
   - `npm install`
2. ตั้งค่า env
   - คัดลอก `.env.example` เป็น `.env`
   - ตั้งค่า database
3. สร้าง app key และ migrate
   - `php artisan key:generate`
   - `php artisan migrate`
4. Seed ข้อมูลเริ่มต้น
   - `php artisan db:seed`
5. รันระบบ
   - `composer run dev`

## หมายเหตุ

- ฟีเจอร์รายงาน PDF ใช้แพ็กเกจ `barryvdh/laravel-dompdf` (ติดตั้งแล้ว)
- หากมีการเพิ่ม Use Case ใหม่ ให้ปรับทั้ง route/middleware/controller และอัปเดตเอกสารไฟล์นี้ควบคู่กัน
