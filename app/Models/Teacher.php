<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'employee_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'blood_group',
        'religion',
        'photo',
        'qualification',
        'experience',
        'designation',
        'department',
        'joining_date',
        'phone',
        'email',
        'address',
        'city',
        'state',
        'zip_code',
        'salary_amount',
        'salary_type',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'joining_date' => 'date',
            'salary_amount' => 'decimal:2',
        ];
    }

    // ─── Accessors ──────────────────────────────
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // ─── Relationships ──────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function attendanceRecords()
    {
        return $this->hasMany(AttendanceRecord::class, 'attendee_id')
                    ->where('attendee_type', 'teacher');
    }

    public function salaryRecords()
    {
        return $this->hasMany(SalaryRecord::class);
    }

    public function routines()
    {
        return $this->hasMany(Routine::class);
    }

    // ─── Scopes ─────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeSearch($query, ?string $search)
    {
        if (!$search) return $query;
        return $query->where(function ($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere('employee_id', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    public function getAssignedClasses()
    {
        return SchoolClass::whereIn('id', $this->subjects()->pluck('class_id')->unique());
    }
}
