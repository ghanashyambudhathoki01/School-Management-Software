<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'class_id',
        'name',
        'capacity',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    // ─── Relationships ──────────────────────────
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function routines()
    {
        return $this->hasMany(Routine::class);
    }

    // ─── Scopes ─────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function getFullNameAttribute(): string
    {
        return $this->schoolClass->name . ' - ' . $this->name;
    }
}
