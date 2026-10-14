<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\SchoolFee;
use App\Models\SensitiveDocument;
use App\Models\SensitiveSection;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AcademicsController extends Controller
{
    public function schoolFees()
    {
        $fees = SchoolFee::published()->orderBy('sort_order')->orderBy('class')->get();
        $page = Page::published()->where('slug', 'school-fees')->first();

        return view('pages.school-fees', compact('fees', 'page'));
    }

    public function sensitiveInformation()
    {
        $page = Page::published()->where('slug', 'sensitive-information')->first();
        $sections = SensitiveSection::published()
            ->with(['publishedDocuments' => fn ($query) => $query->orderBy('sort_order')->orderBy('title')])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->filter(fn (SensitiveSection $section) => $section->publishedDocuments->isNotEmpty());

        return view('pages.sensitive-information', compact('page', 'sections'));
    }

    public function downloadSensitiveDocument(SensitiveDocument $document): StreamedResponse
    {
        abort_unless($document->is_published && $document->file && $document->fileExists(), 404);

        $filename = $document->original_filename ?: basename($document->file);

        return Storage::disk('public')->download($document->file, $filename);
    }
}
