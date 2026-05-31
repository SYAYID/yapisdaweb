<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicantActivity extends Model
{
    protected $fillable = [
        'applicant_type',
        'applicant_id',
        'user_id',
        'category',
        'title',
        'body',
        'metadata',
        'follow_up_at',
        'is_pinned',
    ];

    protected $casts = [
        'metadata' => 'array',
        'follow_up_at' => 'datetime',
        'is_pinned' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForApplicant(Builder $query, string $type, int $id): Builder
    {
        return $query->where('applicant_type', $type)->where('applicant_id', $id);
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'status' => 'Status',
            'document' => 'Berkas',
            'phone' => 'Telepon',
            'visit' => 'Kunjungan',
            'payment' => 'Keuangan',
            'warning' => 'Perhatian',
            default => 'Catatan',
        };
    }

    public function getCategoryIconAttribute(): string
    {
        return match ($this->category) {
            'status' => 'fa-circle-check',
            'document' => 'fa-folder-open',
            'phone' => 'fa-phone',
            'visit' => 'fa-location-dot',
            'payment' => 'fa-wallet',
            'warning' => 'fa-triangle-exclamation',
            default => 'fa-note-sticky',
        };
    }
}
