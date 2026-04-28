<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'attendee_type',
        'attendee_id',
        'class_id',
        'section_id',
        'date',
        'status',
        'remarks',
        'recorded_by',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    // ─── Relationships ──────────────────────────
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

    public function student()
    {
        return $this->belongsTo(Student::class, 'attendee_id')
                    ->where('attendee_type', 'student');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'attendee_id')
                    ->where('attendee_type', 'teacher');
    }

    // ─── Scopes ─────────────────────────────────
    public function scopeForStudents($query)
    {
        return $query->where('attendee_type', 'student');
    }

    public function scopeForTeachers($query)
    {
        return $query->where('attendee_type', 'teacher');
    }

    public function scopeForDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    public function scopeForMonth($query, $month, $year)
    {
        return $query->whereMonth('date', $month)->whereYear('date', $year);
    }

    public function scopeForClass($query, $classId)
    {
        return $query->where('class_id', $classId);
    }

    public function scopePresent($query)
    {
        return $query->where('status', 'present');
    }

    public function scopeAbsent($query)
    {
        return $query->where('status', 'absent');
    }
}
