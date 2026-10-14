<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use App\Support\ImageOptimizer;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $items = GalleryItem::orderBy('sort_order')->paginate(20);

        return view('admin.gallery.index', compact('items'));
    }

    public function create()
    {
        return view('admin.gallery.form', ['item' => new GalleryItem]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['image'] = ImageOptimizer::store($request->file('image'), 'gallery', 1200);
        GalleryItem::create($data);

        return redirect()->route('admin.updates.gallery.index')->with('success', 'Gallery item added.');
    }

    public function edit(GalleryItem $gallery)
    {
        return view('admin.gallery.form', ['item' => $gallery]);
    }

    public function update(Request $request, GalleryItem $gallery)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            ImageOptimizer::delete($gallery->image);
            $data['image'] = ImageOptimizer::store($request->file('image'), 'gallery', 1200);
        }

        $gallery->update($data);

        return redirect()->route('admin.updates.gallery.index')->with('success', 'Gallery item updated.');
    }

    public function destroy(GalleryItem $gallery)
    {
        $gallery->delete();

        return redirect()->route('admin.updates.gallery.index')->with('success', 'Gallery item deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:4096',
            'caption' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_published' => 'boolean',
        ]) + [
            'is_published' => $request->boolean('is_published'),
            'sort_order' => $request->input('sort_order', 0),
        ];
    }
}
