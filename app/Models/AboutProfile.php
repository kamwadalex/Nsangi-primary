<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutProfile extends Model
{
    public const CATEGORIES = [
        'head-teachers' => 'Head Teachers',
        'board-of-governors' => 'Board of Governors',
        'pta' => "Parents' Teachers' Association",
        'school-founders' => 'School Founders',
    ];

    protected $fillable = [
        'name', 'position', 'category', 'bio', 'image', 'sort_order', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
}
