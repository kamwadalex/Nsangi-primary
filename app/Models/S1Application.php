<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class S1Application extends Model
{
    public const PLE_GRADES = ['D1', 'D2', 'C3', 'C4', 'C5', 'C6', 'P7', 'P8', 'F9'];

    protected $fillable = [
        'surname',
        'first_name',
        'other_names',
        'sex',
        'date_of_birth',
        'age',
        'religion',
        'passport_photo',
        'former_primary_school',
        'index_number',
        'ple_english',
        'ple_mathematics',
        'ple_social_studies',
        'ple_science',
        'total_aggregates',
        'division',
        'result_slip',
        'first_choice',
        'second_choice',
        'third_choice',
        'co_curricular_activities',
        'dream_profession',
        'guardian_name',
        'guardian_phone',
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
