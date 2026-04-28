<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certificate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'type',
        'certificate_no',
        'issue_date',
        'content',
        'issued_by',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cert) {
            if (empty($cert->certificate_no)) {
                $prefix = match($cert->type) {
                    'transfer' => 'TC',
                    'character' => 'CC',
                    'completion' => 'CMP',
                    default => 'CERT',
                };
                $cert->certificate_no = $prefix . '-' . date('Y') . '-' . str_pad(static::count() + 1, 5, '0', STR_PAD_LEFT);
            }
        });
    }

    // ─── Relationships ──────────────────────────
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function issuer()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    // ─── Scopes ─────────────────────────────────
    public function scopeIssued($query)
    {
        return $query->where('status', 'issued');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
