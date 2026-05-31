<?php

namespace App\Support;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Throwable;

class AuditLogger
{
    public static function record(string $event, string $description, ?Model $subject = null, array $properties = []): void
    {
        try {
            $user = Auth::user();

            AuditLog::create([
                'user_id' => $user?->id,
                'user_name' => $user?->name,
                'user_role' => $user?->role,
                'event' => $event,
                'subject_type' => $subject ? $subject::class : null,
                'subject_id' => $subject?->getKey(),
                'subject_label' => self::subjectLabel($subject),
                'description' => $description,
                'properties' => $properties ?: null,
                'ip_address' => request()?->ip(),
                'user_agent' => request()?->userAgent(),
                'occurred_at' => now('Asia/Jakarta'),
            ]);
        } catch (Throwable $exception) {
            report($exception);
        }
    }

    private static function subjectLabel(?Model $subject): ?string
    {
        if (!$subject) {
            return null;
        }

        foreach (['reference_number', 'student_identification_number', 'registration_number', 'code', 'full_name', 'name'] as $attribute) {
            if (!empty($subject->{$attribute})) {
                return (string) $subject->{$attribute};
            }
        }

        return class_basename($subject) . '#' . $subject->getKey();
    }
}
