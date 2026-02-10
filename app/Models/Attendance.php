<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'schedule_id', 'subject_id', 'attendance_date', 'check_in_time', 'check_out_time', 'status', 'recorded_by', 'notes'];
    protected $casts = ['attendance_date' => 'date', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    // สถานะการเข้าเรียน
    const STATUS_PRESENT = 'present';
    const STATUS_ABSENT = 'absent';
    const STATUS_LATE = 'late';
    const STATUS_EXCUSED = 'excused';

    const STATUSES = [
        'present' => 'มาเรียน',
        'absent' => 'ขาดเรียน',
        'late' => 'มาสายเรียน',
        'excused' => 'ลาป่วย/ลากิจ'
    ];

    /**
     * ความสัมพันธ์กับนักเรียน
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * ความสัมพันธ์กับตารางเรียน
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * ความสัมพันธ์กับวิชา
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * ความสัมพันธ์กับครูที่บันทึก (ถ้ามี)
     */
    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'recorded_by');
    }

    /**
     * ตรวจสอบว่ามาเรียนหรือไม่
     */
    public function isPresent(): bool
    {
        return $this->status === self::STATUS_PRESENT;
    }

    /**
     * ตรวจสอบว่าขาดเรียนหรือไม่
     */
    public function isAbsent(): bool
    {
        return $this->status === self::STATUS_ABSENT;
    }

    /**
     * ตรวจสอบว่ามาสายหรือไม่
     */
    public function isLate(): bool
    {
        return $this->status === self::STATUS_LATE;
    }
}
