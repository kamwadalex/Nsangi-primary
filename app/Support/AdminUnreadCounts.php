<?php

namespace App\Support;

use App\Models\ContactMessage;
use App\Models\PrimaryApplication;
use Illuminate\Support\Facades\Cache;

class AdminUnreadCounts
{
    private const CACHE_KEY = 'admin.unread_counts';

    private const CACHE_SECONDS = 30;

    public static function get(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_SECONDS, function () {
            $messages = ContactMessage::where('is_read', false)->count();
            $primaryAdmissions = PrimaryApplication::where('is_read', false)->count();

            return [
                'messages' => $messages,
                'primary_admissions' => $primaryAdmissions,
                'admissions' => $primaryAdmissions,
                'total' => $messages + $primaryAdmissions,
            ];
        });
    }

    public static function forget(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
