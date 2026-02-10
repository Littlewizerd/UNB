<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'subject_code', 'teacher_id', 'description', 'credits'];
    protected $casts = ['created_at' => 'datetime', 'updated_at' => 'datetime'];

    /**
     * ความสัมพันธ์กับครู
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * ความสัมพันธ์กับตารางเรียน
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * ความสัมพันธ์กับการเข้าเรียน
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
