<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolClass extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'numeric_name',
        'description',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    // ─── Relationships ──────────────────────────
    public function sections()
    {
        return $this->hasMany(Section::class, 'class_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'class_id');
    }

    public function routines()
    {
        return $this->hasMany(Routine::class, 'class_id');
    }

    public function exams()
    {
        return $this->hasManyThrough(ExamSchedule::class, Subject::class, 'class_id', 'subject_id');
    }

    // ─── Scopes ─────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function getFullNameAttribute(): string
    {
        return $this->name;
    }
}
