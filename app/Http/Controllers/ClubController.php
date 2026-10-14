<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    private const CATEGORIES = [
        'academic' => 'Academic Clubs',
        'ecclesiastical' => 'Ecclesiastical Movements',
        'social' => 'Social Clubs',
    ];

    private const CATEGORY_INTROS = [
        'academic' => [
            'summary' => 'Academic clubs strengthen classroom learning through practical projects, competitions, and peer study. They help students build confidence in sciences, languages, and research beyond normal lesson time.',
            'points' => [
                'Hands-on experiments, exhibitions, and academic contests',
                'Support for science fair projects and national competitions',
                'Guidance from subject teachers who serve as club patrons',
            ],
        ],
        'ecclesiastical' => [
            'summary' => 'Ecclesiastical movements nurture the spiritual life of students in line with the school\'s Catholic identity. Members grow in prayer, service, and Christian leadership within the school community.',
            'points' => [
                'Regular prayer meetings, retreats, and liturgical participation',
                'Service to the school chapel and wider parish community',
                'Formation in faith, discipline, and moral responsibility',
            ],
        ],
        'social' => [
            'summary' => 'Social clubs develop talent, teamwork, and leadership through music, service, and co-curricular engagement. They give students a positive platform to discover interests and serve others.',
            'points' => [
                'Music, drama, and creative performances at school events',
                'Community outreach and student leadership opportunities',
                'Structured meetings that build cooperation and school spirit',
            ],
        ],
    ];

    public function index(Request $request)
    {
        $category = $request->get('category', 'academic');

        if (! array_key_exists($category, self::CATEGORIES)) {
            $category = 'academic';
        }

        $clubs = Club::published()
            ->where('category', $category)
            ->orderBy('sort_order')
            ->get();

        return view('clubs.index', [
            'clubs' => $clubs,
            'categories' => self::CATEGORIES,
            'category' => $category,
            'categoryIntro' => self::CATEGORY_INTROS[$category],
        ]);
    }
}
