<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentClass extends Model
{
    use HasFactory;

    protected $table = 'student_classes';
    protected $fillable = ['class_name', 'class_code', 'advisor_id', 'level', 'description'];
    protected $casts = ['created_at' => 'datetime', 'updated_at' => 'datetime'];

    /**
     * ความสัมพันธ์กับอาจารย์ที่ปรึกษา
     */
    public function advisor(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'advisor_id');
    }

    /**
     * ความสัมพันธ์กับนักเรียน
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    /**
     * ความสัมพันธ์กับตารางเรียน
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'class_id');
    }
}
