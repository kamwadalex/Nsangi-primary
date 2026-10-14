<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\GalleryItem;
use App\Models\Page;
use App\Models\Post;
use App\Models\PrimaryApplication;
use App\Models\StaffMember;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'stats' => [
                'posts' => Post::count(),
                'events' => Event::count(),
                'pages' => Page::count(),
                'staff' => StaffMember::count(),
                'gallery' => GalleryItem::count(),
                'messages' => ContactMessage::where('is_read', false)->count(),
                'primary_admissions' => PrimaryApplication::where('is_read', false)->count(),
            ],
        ]);
    }
}
