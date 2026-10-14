<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffMember;
use App\Support\ImageOptimizer;
use App\Support\PlainTextContent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    public const CATEGORIES = [
        'administration' => 'Administration',
        'teaching' => 'Teaching Staff',
        'non-teaching' => 'Non-Teaching Staff',
    ];

    public function index()
    {
        $categories = self::CATEGORIES;
        $staffByCategory = StaffMember::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->groupBy('category');

        return view('admin.staff.index', compact('categories', 'staffByCategory'));
    }

    public function create(Request $request)
    {
        $category = $this->resolveCategory($request->query('category'));

        $member = new StaffMember(['category' => $category]);

        return view('admin.staff.form', [
            'member' => $member,
            'category' => $category,
            'categories' => self::CATEGORIES,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($data['category'] === 'administration' && $request->hasFile('image')) {
            $data['image'] = ImageOptimizer::store($request->file('image'), 'staff', 800);
        }

        StaffMember::create($data);

        return redirect()->route('admin.staff.index')->with('success', 'Staff member created.');
    }

    public function edit(StaffMember $staff)
    {
        return view('admin.staff.form', [
            'member' => $staff,
            'category' => $staff->category,
            'categories' => self::CATEGORIES,
        ]);
    }

    public function update(Request $request, StaffMember $staff)
    {
        $data = $this->validated($request, $staff);

        if ($data['category'] === 'administration' && $request->hasFile('image')) {
            ImageOptimizer::delete($staff->image);
            $data['image'] = ImageOptimizer::store($request->file('image'), 'staff', 800);
        }

        $staff->update($data);

        return redirect()->route('admin.staff.index')->with('success', 'Staff member updated.');
    }

    public function destroy(StaffMember $staff)
    {
        $staff->delete();

        return redirect()->route('admin.staff.index')->with('success', 'Staff member deleted.');
    }

    private function resolveCategory(?string $category): string
    {
        return array_key_exists($category, self::CATEGORIES) ? $category : 'administration';
    }

    private function validated(Request $request, ?StaffMember $member = null): array
    {
        $category = $this->resolveCategory($request->input('category', $member?->category));

        $rules = [
            'name' => 'required|string|max:255',
            'category' => ['required', Rule::in(array_keys(self::CATEGORIES))],
            'sort_order' => 'nullable|integer|min:0',
        ];

        if ($category === 'administration') {
            $rules['position'] = 'required|string|max:255';
            $rules['bio'] = 'nullable|string';
            $rules['image'] = 'nullable|image|max:2048';
        } elseif ($category === 'teaching') {
            $rules['subjects_taught'] = 'required|string|max:255';
        } else {
            $rules['position'] = 'required|string|max:255';
        }

        $validated = $request->validate($rules);

        $data = [
            'name' => $validated['name'],
            'category' => $category,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_published' => $request->boolean('is_published'),
            'position' => null,
            'subjects_taught' => null,
            'bio' => null,
            'email' => null,
            'phone' => null,
            'image' => null,
        ];

        if ($category === 'administration') {
            $data['position'] = $validated['position'];
            $data['bio'] = PlainTextContent::sanitize($validated['bio'] ?? null);
            $data['image'] = $member?->image;
        } elseif ($category === 'teaching') {
            $data['subjects_taught'] = $validated['subjects_taught'];
            // The teaching form does not edit position, but the column is NOT NULL.
            $data['position'] = $member?->position ?: '';
        } else {
            $data['position'] = $validated['position'];
        }

        return $data;
    }
}
