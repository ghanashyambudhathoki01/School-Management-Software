<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'teacher_id',
        'month',
        'year',
        'basic_salary',
        'bonus',
        'deductions',
        'net_salary',
        'payment_status',
        'due_date',
        'payment_date',
        'next_payment_date',
        'payment_method',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'basic_salary' => 'decimal:2',
            'bonus' => 'decimal:2',
            'deductions' => 'decimal:2',
            'net_salary' => 'decimal:2',
            'due_date' => 'date',
            'payment_date' => 'date',
            'next_payment_date' => 'date',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($record) {
            $record->net_salary = ($record->basic_salary + $record->bonus) - $record->deductions;
        });

        static::updating(function ($record) {
            $record->net_salary = ($record->basic_salary + $record->bonus) - $record->deductions;
        });
    }

    // ─── Relationships ──────────────────────────
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // ─── Scopes ─────────────────────────────────
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->whereIn('payment_status', ['pending', 'pending_payment']);
    }

    public function scopeForMonth($query, $month, $year)
    {
        return $query->where('month', $month)->where('year', $year);
    }
}
