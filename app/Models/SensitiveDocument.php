<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class SensitiveDocument extends Model
{
    public const MAX_FILE_SIZE_KB = 51200;

    public const ALLOWED_EXTENSIONS = [
        'pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'txt', 'zip', 'rar', 'jpg', 'jpeg', 'png',
    ];

    protected $fillable = [
        'sensitive_section_id',
        'title',
        'description',
        'file',
        'original_filename',
        'file_size',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'file_size' => 'integer',
        ];
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(SensitiveSection::class, 'sensitive_section_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function fileUrl(): ?string
    {
        return $this->file ? asset('storage/'.$this->file) : null;
    }

    public function formattedFileSize(): ?string
    {
        if (! $this->file_size) {
            return null;
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $size = (float) $this->file_size;
        $unit = 0;

        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return round($size, $unit === 0 ? 0 : 1).' '.$units[$unit];
    }

    public function fileExtension(): ?string
    {
        $name = $this->original_filename ?: $this->file;

        return $name ? strtoupper(pathinfo($name, PATHINFO_EXTENSION)) : null;
    }

    public function fileExists(): bool
    {
        return $this->file && Storage::disk('public')->exists($this->file);
    }
}
