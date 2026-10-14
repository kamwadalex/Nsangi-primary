<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContinuingApplication extends Model
{
    public const CLASSES = ['S.2', 'S.3', 'S.4', 'S.5', 'S.6'];

    public const STUDENT_TYPES = ['Day', 'Boarding'];

    protected $fillable = [
        'surname',
        'first_name',
        'other_names',
        'sex',
        'date_of_birth',
        'age',
        'religion',
        'passport_photo',
        'current_class',
        'previous_secondary_school',
        'previous_class',
        'student_type',
        'index_number',
        'reason_for_transfer',
        'report_card',
        'co_curricular_activities',
        'dream_profession',
        'guardian_name',
        'guardian_phone',
        'guardian_address',
        'is_read',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'is_read' => 'boolean',
        ];
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->surname} {$this->first_name} {$this->other_names}");
    }
}
