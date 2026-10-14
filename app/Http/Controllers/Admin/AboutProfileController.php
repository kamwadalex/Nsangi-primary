<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutProfile;
use App\Support\ImageOptimizer;
use App\Support\PlainTextContent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AboutProfileController extends Controller
{
    public function index()
    {
        $categories = AboutProfile::CATEGORIES;
        $profilesByCategory = AboutProfile::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->groupBy('category');

        return view('admin.about-profiles.index', compact('categories', 'profilesByCategory'));
    }

    public function create(Request $request)
    {
        $category = $this->resolveCategory($request->query('category'));

        $profile = new AboutProfile(['category' => $category]);

        return view('admin.about-profiles.form', [
            'profile' => $profile,
            'category' => $category,
            'categories' => AboutProfile::CATEGORIES,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image'] = ImageOptimizer::store($request->file('image'), 'about-profiles', 800);
        }

        AboutProfile::create($data);

        return redirect()->route('admin.about-profiles.index')->with('success', 'Profile created.');
    }

    public function edit(AboutProfile $about_profile)
    {
        return view('admin.about-profiles.form', [
            'profile' => $about_profile,
            'category' => $about_profile->category,
            'categories' => AboutProfile::CATEGORIES,
        ]);
    }

    public function update(Request $request, AboutProfile $about_profile)
    {
        $data = $this->validated($request, $about_profile);

        if ($request->hasFile('image')) {
            ImageOptimizer::delete($about_profile->image);
            $data['image'] = ImageOptimizer::store($request->file('image'), 'about-profiles', 800);
        }

        $about_profile->update($data);

        return redirect()->route('admin.about-profiles.index')->with('success', 'Profile updated.');
    }

    public function destroy(AboutProfile $about_profile)
    {
        $about_profile->delete();

        return redirect()->route('admin.about-profiles.index')->with('success', 'Profile deleted.');
    }

    private function resolveCategory(?string $category): string
    {
        return array_key_exists($category, AboutProfile::CATEGORIES) ? $category : 'head-teachers';
    }

    private function validated(Request $request, ?AboutProfile $profile = null): array
    {
        $category = $this->resolveCategory($request->input('category', $profile?->category));

        $rules = [
            'name' => 'required|string|max:255',
            'category' => ['required', Rule::in(array_keys(AboutProfile::CATEGORIES))],
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
            'sort_order' => 'nullable|integer|min:0',
        ];

        $validated = $request->validate($rules);

        return [
            'name' => $validated['name'],
            'category' => $category,
            'position' => $validated['position'],
            'bio' => PlainTextContent::sanitize($validated['bio'] ?? null),
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_published' => $request->boolean('is_published'),
            'image' => $profile?->image,
        ];
    }
}
