<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends User
{
    use HasFactory;

    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password', 'role', 'teacher_id', 'phone', 'department'];

    protected static function booted(): void
    {
        static::addGlobalScope('teacher_role', function (Builder $builder) {
            $builder->where('role', 'teacher');
        });
    }

    /**
     * ความสัมพันธ์กับวิชาที่สอน
     */
    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class, 'teacher_id');
    }

    /**
     * ความสัมพันธ์กับตารางเรียน
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'teacher_id');
    }

    /**
     * ความสัมพันธ์กับบันทึกการเข้าเรียน (ที่ครูบันทึก)
     */
    public function attendanceRecords(): HasMany
    {
        return $this->hasMany(Attendance::class, 'recorded_by');
    }

    /**
     * ตรวจสอบว่าเป็นครูหรือไม่
     */
    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }
}
