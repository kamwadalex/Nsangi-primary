<?php

namespace App\Support;

use App\Models\ContactMessage;
use App\Models\ContinuingApplication;
use App\Models\S1Application;
use App\Models\S5Application;
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
            $s1Admissions = S1Application::where('is_read', false)->count();
            $s5Admissions = S5Application::where('is_read', false)->count();
            $continuingAdmissions = ContinuingApplication::where('is_read', false)->count();
            $primaryAdmissions = PrimaryApplication::where('is_read', false)->count();

            return [
                'messages' => $messages,
                's1_admissions' => $s1Admissions,
                's5_admissions' => $s5Admissions,
                'continuing_admissions' => $continuingAdmissions,
                'primary_admissions' => $primaryAdmissions,
                'admissions' => $s1Admissions + $s5Admissions + $continuingAdmissions + $primaryAdmissions,
                'total' => $messages + $s1Admissions + $s5Admissions + $continuingAdmissions + $primaryAdmissions,
            ];
        });
    }

    public static function forget(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
