<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prefect extends Model
{
    protected $fillable = [
        'name', 'position', 'image', 'class', 'house', 'year', 'is_current', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_current' => 'boolean',
        ];
    }
}
