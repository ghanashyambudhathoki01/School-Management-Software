<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'message',
        'type',
        'target_audience',
        'published_by',
        'publish_date',
        'expiry_date',
        'status',
        'attachment',
    ];

    protected function casts(): array
    {
        return [
            'publish_date' => 'date',
            'expiry_date' => 'date',
            'status' => 'boolean',
        ];
    }

    public function publisher()
    {
        return $this->belongsTo(User::class, 'published_by');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true)
                     ->where(function ($q) {
                         $q->whereNull('expiry_date')
                           ->orWhere('expiry_date', '>=', now());
                     });
    }

    public function scopeForTeachers($query)
    {
        return $query->whereIn('type', ['general', 'teacher', 'urgent']);
    }

    public function scopeForStudents($query)
    {
        return $query->whereIn('type', ['general', 'student', 'urgent']);
    }

    public function scopeUrgent($query)
    {
        return $query->where('type', 'urgent');
    }
}
