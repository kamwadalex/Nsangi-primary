<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SensitiveSection;
use Illuminate\Http\Request;

class SensitiveSectionController extends Controller
{
    public function index()
    {
        $sections = SensitiveSection::withCount('documents')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.sensitive-sections.index', compact('sections'));
    }

    public function create()
    {
        return view('admin.sensitive-sections.form', ['section' => new SensitiveSection]);
    }

    public function store(Request $request)
    {
        SensitiveSection::create($this->validated($request));

        return redirect()->route('admin.sensitive-sections.index')->with('success', 'Section created.');
    }

    public function edit(SensitiveSection $sensitive_section)
    {
        return view('admin.sensitive-sections.form', ['section' => $sensitive_section]);
    }

    public function update(Request $request, SensitiveSection $sensitive_section)
    {
        $sensitive_section->update($this->validated($request, $sensitive_section));

        return redirect()->route('admin.sensitive-sections.index')->with('success', 'Section updated.');
    }

    public function destroy(SensitiveSection $sensitive_section)
    {
        $sensitive_section->delete();

        return redirect()->route('admin.sensitive-sections.index')->with('success', 'Section deleted.');
    }

    private function validated(Request $request, ?SensitiveSection $section = null): array
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_published' => 'nullable|boolean',
        ]);

        return [
            'name' => $data['name'],
            'slug' => SensitiveSection::uniqueSlug($data['name'], $section?->id),
            'sort_order' => $data['sort_order'] ?? 0,
            'is_published' => $request->boolean('is_published'),
        ];
    }
}
