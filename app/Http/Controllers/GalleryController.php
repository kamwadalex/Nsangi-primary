<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;

class GalleryController extends Controller
{
    public function index()
    {
        $items = GalleryItem::published()->orderBy('sort_order')->paginate(12);

        return view('gallery.index', compact('items'));
    }
}
