<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProgrammeEntry extends Model
{
    public const DEFAULT_CATEGORY = 'General';

    protected $fillable = [
        'title',
        'description',
        'category',
        'starts_at',
        'ends_at',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeBetween($query, Carbon $start, Carbon $end)
    {
        return $query->where('starts_at', '>=', $start)->where('starts_at', '<=', $end);
    }

    public function scopeForCategory($query, ?string $category)
    {
        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }

        return $query;
    }
}
