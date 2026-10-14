<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /** Slugs handled outside the CMS page table (redirects or dedicated views). */
    private const SKIP_PAGE_SLUGS = [
        'about-school',
        'head-teachers',
        'board-of-governors',
        'pta',
        'school-founders',
        'school-anthem',
        's1-application',
        's5-application',
        'continuing-application',
        'school-curriculum',
        'school-fees',
        'departments',
        'sensitive-information',
        'school-programme',
        'social-responsibility',
        'spiritual-welfare',
    ];

    public function index(): Response
    {
        $urls = [];

        foreach ($this->staticUrls() as [$loc, $changefreq, $priority]) {
            $urls[] = [
                'loc' => $loc,
                'lastmod' => null,
                'changefreq' => $changefreq,
                'priority' => $priority,
            ];
        }

        foreach (Post::published()->latest('published_at')->get(['slug', 'updated_at', 'published_at']) as $post) {
            $urls[] = [
                'loc' => route('news.show', $post->slug),
                'lastmod' => ($post->updated_at ?? $post->published_at)?->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ];
        }

        foreach (Event::published()->latest('updated_at')->get(['slug', 'updated_at', 'starts_at']) as $event) {
            $urls[] = [
                'loc' => route('events.show', $event->slug),
                'lastmod' => ($event->updated_at ?? $event->starts_at)?->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.6',
            ];
        }

        $pages = Page::published()
            ->whereNotIn('slug', self::SKIP_PAGE_SLUGS)
            ->get(['slug', 'updated_at']);

        foreach ($pages as $page) {
            $urls[] = [
                'loc' => route('pages.show', $page->slug),
                'lastmod' => $page->updated_at?->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.5',
            ];
        }

        return response()
            ->view('sitemap', compact('urls'))
            ->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        $lines = [
            'User-agent: *',
            'Disallow: /admin',
            'Disallow: /admin/',
            '',
            'Sitemap: '.url('/sitemap.xml'),
            '',
        ];

        return response(implode("\n", $lines), 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }

    /**
     * @return list<array{0: string, 1: string, 2: string}>
     */
    private function staticUrls(): array
    {
        return [
            [route('home'), 'weekly', '1.0'],
            [route('about'), 'monthly', '0.8'],
            [route('contact'), 'monthly', '0.7'],
            [route('news.index'), 'daily', '0.8'],
            [route('events.index'), 'daily', '0.8'],
            [route('gallery.index'), 'weekly', '0.7'],
            [route('school-programme'), 'weekly', '0.7'],
            [route('staff.index'), 'monthly', '0.6'],
            [route('clubs.index'), 'monthly', '0.6'],
            [route('prefects.index'), 'monthly', '0.6'],
            [route('academics'), 'monthly', '0.7'],
            [route('students'), 'monthly', '0.7'],
            [route('academics.school-fees'), 'monthly', '0.7'],
            [route('academics.sensitive-information'), 'monthly', '0.5'],
            [route('applications.primary.create'), 'monthly', '0.8'],
            [route('pages.show', 'social-responsibility'), 'monthly', '0.5'],
            [route('pages.show', 'spiritual-welfare'), 'monthly', '0.5'],
        ];
    }
}
