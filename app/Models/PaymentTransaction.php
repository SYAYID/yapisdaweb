<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_type_id',
        'direction',
        'amount',
        'student_type',
        'applicant_id',
        'smp_applicant_id',
        'payment_method',
        'reference_number',
        'status',
        'paid_at',
        'description',
        'notes',
        'created_by_user_id',
    ];

    protected $casts = [
        'amount' => 'integer',
        'paid_at' => 'datetime',
    ];

    public function paymentType(): BelongsTo
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function smkApplicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class, 'applicant_id');
    }

    public function smpApplicant(): BelongsTo
    {
        return $this->belongsTo(SmpApplicant::class, 'smp_applicant_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function getStudentNameAttribute(): string
    {
        return $this->student_type === 'smp'
            ? (string) ($this->smpApplicant?->full_name ?? '-')
            : (string) ($this->smkApplicant?->full_name ?? '-');
    }

    public function getStudentRegistrationAttribute(): string
    {
        return $this->student_type === 'smp'
            ? (string) ($this->smpApplicant?->registration_number ?? '-')
            : (string) ($this->smkApplicant?->registration_number ?? '-');
    }

    public function getStudentUnitAttribute(): string
    {
        return match ($this->student_type) {
            'smp' => 'SMPS',
            'smk' => 'SMKS',
            default => '-',
        };
    }
}
