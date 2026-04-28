<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mark extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'exam_id',
        'student_id',
        'subject_id',
        'class_id',
        'section_id',
        'marks_obtained',
        'total_marks',
        'grade',
        'remarks',
        'recorded_by',
    ];

    protected function casts(): array
    {
        return [
            'marks_obtained' => 'decimal:2',
            'total_marks' => 'decimal:2',
        ];
    }

    // ─── Relationships ──────────────────────────
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    // ─── Accessors ──────────────────────────────
    public function getPercentageAttribute(): float
    {
        if ($this->total_marks == 0) return 0;
        return round(($this->marks_obtained / $this->total_marks) * 100, 2);
    }

    public function getCalculatedGradeAttribute(): string
    {
        $pct = $this->percentage;
        if ($pct >= 90) return 'A+';
        if ($pct >= 80) return 'A';
        if ($pct >= 70) return 'B+';
        if ($pct >= 60) return 'B';
        if ($pct >= 50) return 'C+';
        if ($pct >= 40) return 'C';
        if ($pct >= 33) return 'D';
        return 'F';
    }

    public function getGpaAttribute(): float
    {
        $pct = $this->percentage;
        if ($pct >= 90) return 4.0;
        if ($pct >= 80) return 3.6;
        if ($pct >= 70) return 3.2;
        if ($pct >= 60) return 2.8;
        if ($pct >= 50) return 2.4;
        if ($pct >= 40) return 2.0;
        if ($pct >= 33) return 1.6;
        return 0.0;
    }
}
