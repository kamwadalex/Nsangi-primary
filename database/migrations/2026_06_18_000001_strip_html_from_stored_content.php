<?php

use App\Models\AboutProfile;
use App\Models\Event;
use App\Models\Page;
use App\Models\Post;
use App\Models\ProgrammeEntry;
use App\Models\SensitiveDocument;
use App\Models\Setting;
use App\Models\StaffMember;
use App\Support\PlainTextContent;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;

return new class extends Migration
{
    public function up(): void
    {
        foreach (Page::query()->cursor() as $page) {
            if ($page->content !== null) {
                $page->update(['content' => PlainTextContent::sanitize($page->content)]);
            }
        }

        foreach (Post::query()->cursor() as $post) {
            $post->update([
                'excerpt' => PlainTextContent::sanitize($post->excerpt),
                'content' => PlainTextContent::sanitize($post->content),
            ]);
        }

        foreach (Event::query()->cursor() as $event) {
            if ($event->description !== null) {
                $event->update(['description' => PlainTextContent::sanitize($event->description)]);
            }
        }

        foreach (AboutProfile::query()->cursor() as $profile) {
            if ($profile->bio !== null) {
                $profile->update(['bio' => PlainTextContent::sanitize($profile->bio)]);
            }
        }

        foreach (StaffMember::query()->cursor() as $member) {
            if ($member->bio !== null) {
                $member->update(['bio' => PlainTextContent::sanitize($member->bio)]);
            }
        }

        foreach (ProgrammeEntry::query()->cursor() as $entry) {
            if ($entry->description !== null) {
                $entry->update(['description' => PlainTextContent::sanitize($entry->description)]);
            }
        }

        foreach (SensitiveDocument::query()->cursor() as $document) {
            if ($document->description !== null) {
                $document->update(['description' => PlainTextContent::sanitize($document->description)]);
            }
        }

        $textSettings = [
            'tagline',
            'school_story',
            'about_school_content',
            'school_anthem',
            'head_teacher_message',
            'mission',
            'vision',
            'core_values',
            'motto',
        ];

        foreach ($textSettings as $key) {
            $value = Setting::get($key);
            if ($value !== null && $value !== '') {
                Setting::set($key, PlainTextContent::sanitize($value) ?? '');
            }
        }

        Cache::forget('settings.all');
    }

    public function down(): void
    {
        // Plain-text conversion is not reversible.
    }
};
