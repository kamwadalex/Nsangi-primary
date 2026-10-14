<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SensitiveDocument;
use App\Models\SensitiveSection;
use App\Support\PlainTextContent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SensitiveDocumentController extends Controller
{
    public function index()
    {
        $sections = SensitiveSection::with(['documents' => fn ($query) => $query->orderBy('sort_order')->orderBy('title')])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.sensitive-documents.index', compact('sections'));
    }

    public function create(Request $request)
    {
        $section = $this->resolveSection($request->query('section'));

        return view('admin.sensitive-documents.form', [
            'document' => new SensitiveDocument(['sensitive_section_id' => $section?->id]),
            'sections' => $this->sectionOptions(),
            'selectedSection' => $section,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data = $this->attachUploadedFile($request, $data);

        SensitiveDocument::create($data);

        return redirect()->route('admin.sensitive-documents.index')->with('success', 'Document added.');
    }

    public function edit(SensitiveDocument $sensitive_document)
    {
        return view('admin.sensitive-documents.form', [
            'document' => $sensitive_document,
            'sections' => $this->sectionOptions(),
            'selectedSection' => $sensitive_document->section,
        ]);
    }

    public function update(Request $request, SensitiveDocument $sensitive_document)
    {
        $data = $this->validated($request, $sensitive_document);
        $data = $this->attachUploadedFile($request, $data, $sensitive_document);

        $sensitive_document->update($data);

        return redirect()->route('admin.sensitive-documents.index')->with('success', 'Document updated.');
    }

    public function destroy(SensitiveDocument $sensitive_document)
    {
        $sensitive_document->delete();

        return redirect()->route('admin.sensitive-documents.index')->with('success', 'Document deleted.');
    }

    private function sectionOptions()
    {
        return SensitiveSection::orderBy('sort_order')->orderBy('name')->get();
    }

    private function resolveSection(?string $sectionParam): ?SensitiveSection
    {
        if (! $sectionParam) {
            return null;
        }

        if (is_numeric($sectionParam)) {
            return SensitiveSection::find($sectionParam);
        }

        return SensitiveSection::where('slug', $sectionParam)->first();
    }

    private function validated(Request $request, ?SensitiveDocument $document = null): array
    {
        $sectionIds = SensitiveSection::pluck('id')->all();

        $rules = [
            'title' => 'required|string|max:255',
            'sensitive_section_id' => ['required', Rule::in($sectionIds)],
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_published' => 'nullable|boolean',
            'file' => [
                $document?->file ? 'nullable' : 'required',
                'file',
                'max:'.SensitiveDocument::MAX_FILE_SIZE_KB,
                'mimes:'.implode(',', SensitiveDocument::ALLOWED_EXTENSIONS),
            ],
        ];

        $validated = $request->validate($rules);

        return [
            'title' => $validated['title'],
            'sensitive_section_id' => $validated['sensitive_section_id'],
            'description' => PlainTextContent::sanitize($validated['description'] ?? null),
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_published' => $request->boolean('is_published'),
            'file' => $document?->file,
            'original_filename' => $document?->original_filename,
            'file_size' => $document?->file_size,
        ];
    }

    private function attachUploadedFile(Request $request, array $data, ?SensitiveDocument $document = null): array
    {
        if (! $request->hasFile('file')) {
            return $data;
        }

        $uploaded = $request->file('file');
        $data['file'] = $uploaded->store('sensitive-documents', 'public');
        $data['original_filename'] = $uploaded->getClientOriginalName();
        $data['file_size'] = $uploaded->getSize();

        return $data;
    }
}
