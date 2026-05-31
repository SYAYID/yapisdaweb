<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActiveStudent extends Model
{
    protected $fillable = [
        'student_type',
        'student_id',
        'unit',
        'registration_number',
        'student_identification_number',
        'full_name',
        'program',
        'class_group',
        'status',
        'enrolled_at',
        'notes',
        'created_by_user_id',
        'updated_by_user_id',
    ];

    protected $casts = [
        'enrolled_at' => 'date',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_user_id');
    }

    public function getStudentKeyAttribute(): string
    {
        return $this->student_type . ':' . $this->student_id;
    }
}
