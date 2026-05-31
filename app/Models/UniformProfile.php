<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UniformProfile extends Model
{
    protected $fillable = [
        'student_type',
        'student_id',
        'shirt_size',
        'pants_size',
        'attribute_status',
        'picked_up_at',
        'notes',
        'updated_by_user_id',
    ];

    protected $casts = [
        'picked_up_at' => 'datetime',
    ];

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_user_id');
    }

    public function getStudentKeyAttribute(): string
    {
        return $this->student_type . ':' . $this->student_id;
    }
}
