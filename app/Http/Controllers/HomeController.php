<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\GalleryItem;
use App\Models\Post;
use App\Models\StaffMember;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'latestPosts' => Post::published()->latest('published_at')->take(3)->get(),
            'upcomingEvents' => Event::published()->upcoming()->take(4)->get(),
            'adminStaff' => StaffMember::published()->category('administration')->orderBy('sort_order')->take(5)->get(),
            'galleryItems' => GalleryItem::published()->orderBy('sort_order')->take(8)->get(),
            'testimonials' => Testimonial::published()->orderBy('sort_order')->take(12)->get(),
        ]);
    }
}
