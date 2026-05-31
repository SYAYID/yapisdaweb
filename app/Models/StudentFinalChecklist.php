<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentFinalChecklist extends Model
{
    protected $fillable = [
        'student_type',
        'student_id',
        'documents_complete',
        'administration_complete',
        'student_number_assigned',
        'card_printed',
        'uniform_size_recorded',
        'attribute_distributed',
        'final_status',
        'notes',
        'reviewed_by_user_id',
        'reviewed_at',
    ];

    protected $casts = [
        'documents_complete' => 'boolean',
        'administration_complete' => 'boolean',
        'student_number_assigned' => 'boolean',
        'card_printed' => 'boolean',
        'uniform_size_recorded' => 'boolean',
        'attribute_distributed' => 'boolean',
        'reviewed_at' => 'datetime',
    ];

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by_user_id');
    }

    public function getStudentKeyAttribute(): string
    {
        return $this->student_type . ':' . $this->student_id;
    }
}
