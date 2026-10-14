<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\GalleryItem;
use App\Models\Post;
use App\Models\ProgrammeEntry;

class UpdatesController extends Controller
{
    public function index()
    {
        return view('admin.updates.index', [
            'posts' => Post::latest()->limit(5)->get(),
            'events' => Event::orderByDesc('starts_at')->limit(5)->get(),
            'galleryItems' => GalleryItem::orderBy('sort_order')->limit(5)->get(),
            'programmeEntries' => ProgrammeEntry::orderBy('starts_at')->limit(5)->get(),
            'stats' => [
                'posts' => Post::count(),
                'events' => Event::count(),
                'gallery' => GalleryItem::count(),
                'programme' => ProgrammeEntry::count(),
                'published_posts' => Post::where('is_published', true)->count(),
                'published_events' => Event::where('is_published', true)->count(),
                'published_gallery' => GalleryItem::where('is_published', true)->count(),
                'published_programme' => ProgrammeEntry::where('is_published', true)->count(),
            ],
        ]);
    }
}
