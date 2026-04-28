<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'photo',
        'access_status',
        'account_start_date',
        'account_expiry_date',
        'renewal_date',
        'access_duration',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'account_start_date' => 'date',
            'account_expiry_date' => 'date',
            'renewal_date' => 'date',
        ];
    }

    // ─── Role Checks ─────────────────────────────
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isSchoolAdmin(): bool
    {
        return $this->role === 'school_admin';
    }

    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    // ─── Access Status Checks ────────────────────
    public function isActive(): bool
    {
        return $this->access_status === 'active';
    }

    public function isSuspended(): bool
    {
        return $this->access_status === 'suspended';
    }

    public function isDisabled(): bool
    {
        return $this->access_status === 'disabled';
    }

    public function isExpired(): bool
    {
        if ($this->isSuperAdmin()) {
            return false;
        }

        return $this->access_status === 'expired' ||
               ($this->account_expiry_date && $this->account_expiry_date->isPast());
    }

    public function hasValidAccess(): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->isActive() && !$this->isExpired();
    }

    public function daysUntilExpiry(): ?int
    {
        if (!$this->account_expiry_date) {
            return null;
        }
        return (int) now()->diffInDays($this->account_expiry_date, false);
    }

    public function isExpiringWithin(int $days): bool
    {
        $remaining = $this->daysUntilExpiry();
        return $remaining !== null && $remaining > 0 && $remaining <= $days;
    }

    // ─── Relationships ──────────────────────────
    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function recordedAttendance()
    {
        return $this->hasMany(AttendanceRecord::class, 'recorded_by');
    }

    public function publishedNotices()
    {
        return $this->hasMany(Notice::class, 'published_by');
    }

    public function issuedCertificates()
    {
        return $this->hasMany(Certificate::class, 'issued_by');
    }

    // ─── Scopes ─────────────────────────────────
    public function scopeByRole($query, string $role)
    {
        return $query->where('role', $role);
    }

    public function scopeActive($query)
    {
        return $query->where('access_status', 'active');
    }

    public function scopeExpired($query)
    {
        return $query->where(function ($q) {
            $q->where('access_status', 'expired')
              ->orWhere('account_expiry_date', '<', now());
        });
    }

    public function scopeExpiringSoon($query, int $days = 30)
    {
        return $query->where('access_status', 'active')
                     ->where('account_expiry_date', '>', now())
                     ->where('account_expiry_date', '<=', now()->addDays($days));
    }

    public function scopeSuspended($query)
    {
        return $query->where('access_status', 'suspended');
    }

    public function scopeDisabled($query)
    {
        return $query->where('access_status', 'disabled');
    }
}
