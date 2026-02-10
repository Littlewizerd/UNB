<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends User
{
    use HasFactory;

    protected $table = 'users';
    protected $fillable = ['name', 'email', 'student_id', 'phone', 'class_id'];

    /**
     * ความสัมพันธ์กับชั้นเรียน
     */
    public function studentClass(): BelongsTo
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }

    /**
     * ความสัมพันธ์กับบันทึกการเข้าเรียน
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    /**
     * ตรวจสอบว่าเป็นนักเรียนหรือไม่
     */
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }
}
