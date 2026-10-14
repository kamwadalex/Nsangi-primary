<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class S5Application extends Model
{
    public const DIVISIONS = ['Div 1', 'Div 2', 'Div 3', 'Div 4'];

    public const UCE_RESULTS = ['1', '2', '3', '4'];

    protected $fillable = [
        'surname',
        'first_name',
        'other_names',
        'gender',
        'religion',
        'previous_school',
        'uce_english',
        'uce_mathematics',
        'uce_biology',
        'uce_chemistry',
        'uce_physics',
        'uce_history',
        'uce_geography',
        'uce_cre',
        'uce_literature',
        'uce_french',
        'uce_luganda',
        'uce_fine_art',
        'uce_kiswahili',
        'uce_ict',
        'uce_entrepreneurship',
        'uce_physical_education',
        'uce_ire',
        'uce_nutrition',
        'uce_agriculture',
        'uce_technical_drawing',
        'uce_project_work',
        'uce_result',
        'ple_aggregates',
        'division',
        'preferred_combinations',
        'career_interests',
        'co_curricular_activities',
        'former_school_responsibilities',
        'guardian_name',
        'guardian_address',
        'guardian_phone',
        'result_slip',
        'is_read',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
        ];
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->surname} {$this->first_name} {$this->other_names}");
    }
}
