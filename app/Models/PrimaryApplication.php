<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrimaryApplication extends Model
{
    protected $fillable = [
        'child_name',
        'date_of_birth',
        'class_applying_for',
        'attendance_type',
        'guardian_name',
        'guardian_phone',
        'guardian_email',
        'message',
        'is_read',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'is_read' => 'boolean',
        ];
    }
}
