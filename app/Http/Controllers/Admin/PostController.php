<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Support\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(15);

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.form', ['post' => new Post]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['title']);
        $data['excerpt'] = \App\Support\PlainTextContent::sanitize($data['excerpt'] ?? null);
        $data['content'] = \App\Support\PlainTextContent::sanitize($data['content'] ?? null);

        if ($request->hasFile('image')) {
            $data['image'] = ImageOptimizer::store($request->file('image'), 'posts', 1200);
        }

        Post::create($data);

        return redirect()->route('admin.updates.news.index')->with('success', 'News post created.');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.form', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['title']);
        $data['excerpt'] = \App\Support\PlainTextContent::sanitize($data['excerpt'] ?? null);
        $data['content'] = \App\Support\PlainTextContent::sanitize($data['content'] ?? null);

        if ($request->hasFile('image')) {
            ImageOptimizer::delete($post->image);
            $data['image'] = ImageOptimizer::store($request->file('image'), 'posts', 1200);
        }

        $post->update($data);

        return redirect()->route('admin.updates.news.index')->with('success', 'News post updated.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.updates.news.index')->with('success', 'News post deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
            'is_published' => 'boolean',
        ]) + ['is_published' => $request->boolean('is_published')];
    }
}
