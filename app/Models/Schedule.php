<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['class_id', 'subject_id', 'teacher_id', 'day_of_week', 'start_time', 'end_time', 'room', 'semester', 'academic_year'];
    protected $casts = ['created_at' => 'datetime', 'updated_at' => 'datetime'];

    // วันในสัปดาห์
    const DAYS = [
        'M' => 'จันทร์',
        'T' => 'อังคาร',
        'W' => 'พุธ',
        'TH' => 'พฤหัสบดี',
        'F' => 'ศุกร์',
        'SA' => 'เสาร์',
        'SU' => 'อาทิตย์'
    ];

    /**
     * ความสัมพันธ์กับชั้นเรียน
     */
    public function studentClass(): BelongsTo
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }

    /**
     * ความสัมพันธ์กับวิชา
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * ความสัมพันธ์กับครู
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * ความสัมพันธ์กับการเข้าเรียน
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
