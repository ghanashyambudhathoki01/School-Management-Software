<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeeInvoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'invoice_no',
        'student_id',
        'class_id',
        'fee_category_id',
        'amount',
        'discount',
        'fine',
        'total',
        'paid_amount',
        'due_amount',
        'status',
        'due_date',
        'issue_date',
        'month',
        'year',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'discount' => 'decimal:2',
            'fine' => 'decimal:2',
            'total' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'due_amount' => 'decimal:2',
            'due_date' => 'date',
            'issue_date' => 'date',
        ];
    }

    // ─── Boot ───────────────────────────────────
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            if (empty($invoice->invoice_no)) {
                $invoice->invoice_no = 'INV-' . date('Ymd') . '-' . str_pad(static::count() + 1, 5, '0', STR_PAD_LEFT);
            }
            // Calculate totals
            $invoice->total = ($invoice->amount - $invoice->discount) + $invoice->fine;
            $invoice->due_amount = $invoice->total - $invoice->paid_amount;
        });
    }

    // ─── Relationships ──────────────────────────
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function feeCategory()
    {
        return $this->belongsTo(FeeCategory::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // ─── Scopes ─────────────────────────────────
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeUnpaid($query)
    {
        return $query->where('status', 'unpaid');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue')
                     ->orWhere(function ($q) {
                         $q->where('status', '!=', 'paid')
                           ->where('due_date', '<', now());
                     });
    }

    public function scopePartial($query)
    {
        return $query->where('status', 'partial');
    }

    public function updatePaymentStatus(): void
    {
        $totalPaid = $this->payments()->sum('amount');
        $this->paid_amount = $totalPaid;
        $this->due_amount = $this->total - $totalPaid;

        if ($totalPaid >= $this->total) {
            $this->status = 'paid';
        } elseif ($totalPaid > 0) {
            $this->status = 'partial';
        } elseif ($this->due_date && $this->due_date->isPast()) {
            $this->status = 'overdue';
        } else {
            $this->status = 'unpaid';
        }

        $this->save();
    }
}
