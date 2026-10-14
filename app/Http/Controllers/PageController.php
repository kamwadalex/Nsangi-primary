<?php

namespace App\Http\Controllers;

use App\Models\AboutProfile;
use App\Models\GalleryItem;
use App\Models\Page;
use App\Models\Prefect;
use Illuminate\Http\Request;

class PageController extends Controller
{
    private const RETIRED_PAGE_SLUGS = [
        's1-application',
        's5-application',
        'continuing-application',
    ];

    private const ABOUT_ANCHORS = [
        'about-school' => 'about-school',
        'head-teachers' => 'head-teachers',
        'board-of-governors' => 'board-of-governors',
        'pta' => 'pta',
        'school-founders' => 'school-founders',
        'school-anthem' => 'school-anthem',
    ];

    public function about()
    {
        $profiles = AboutProfile::published()
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category');

        return view('pages.about', [
            'headTeachers' => $profiles->get('head-teachers', collect()),
            'boardMembers' => $profiles->get('board-of-governors', collect()),
            'ptaMembers' => $profiles->get('pta', collect()),
            'founders' => $profiles->get('school-founders', collect()),
        ]);
    }

    public function show(string $slug)
    {
        if (in_array($slug, self::RETIRED_PAGE_SLUGS, true)) {
            abort(404);
        }

        if (isset(self::ABOUT_ANCHORS[$slug])) {
            return redirect()->to(route('about') . '#' . self::ABOUT_ANCHORS[$slug]);
        }

        if ($slug === 'school-fees') {
            return redirect()->route('academics.school-fees');
        }

        if (in_array($slug, ['departments', 'sensitive-information'], true)) {
            return redirect()->route('academics.sensitive-information');
        }

        if ($slug === 'social-responsibility') {
            return view('pages.social-responsibility', [
                'labImage' => GalleryItem::published()
                    ->where('title', 'Science Laboratory')
                    ->value('image'),
            ]);
        }

        if ($slug === 'spiritual-welfare') {
            return view('pages.spiritual-welfare');
        }

        if ($slug === 'school-programme') {
            return redirect()->route('school-programme');
        }

        $page = Page::published()->where('slug', $slug)->firstOrFail();

        return view('pages.show', compact('page'));
    }

    public function section(Request $request, string $section)
    {
        $pages = Page::published()
            ->where('section', $section)
            ->orderBy('sort_order')
            ->get();

        if ($section === 'about') {
            return redirect()->route('about');
        }

        $titles = [
            'academics' => 'Academics',
            'students' => 'Students',
        ];

        $data = [
            'section' => $section,
            'sectionTitle' => $titles[$section] ?? ucfirst($section),
            'pages' => $pages,
        ];

        if ($section === 'students') {
            $data['prefects'] = Prefect::query()
                ->where('is_current', true)
                ->orderBy('sort_order')
                ->get();
        }

        return view('pages.section', $data);
    }
}
