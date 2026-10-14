<?php

use App\Models\AboutProfile;
use App\Models\Club;
use App\Models\Event;
use App\Models\Page;
use App\Models\Post;
use App\Models\Prefect;
use App\Models\ProgrammeEntry;
use App\Models\SchoolFee;
use App\Models\SensitiveDocument;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Page::whereIn('slug', ['s1-application', 's5-application', 'continuing-application', 'academic-performance', 'departments'])->delete();

        $pages = [
            ['slug' => 'about-school', 'title' => 'About the School', 'section' => 'about', 'sort_order' => 1, 'content' => "Nsangi Parents' Primary School is a mixed day and boarding school situated along Nsangi Masaka Road. We offer education from Nursery to P.6 in a safe, supportive environment that helps children grow in knowledge, confidence, discipline, and responsibility."],
            ['slug' => 'head-teachers', 'title' => 'School Leadership', 'section' => 'about', 'sort_order' => 2, 'content' => 'Our school leadership team works with teachers, parents, and pupils to maintain effective teaching, good discipline, and a caring learning environment.'],
            ['slug' => 'board-of-governors', 'title' => 'School Management', 'section' => 'about', 'sort_order' => 3, 'content' => "The school management team provides direction for teaching, pupil welfare, staff coordination, and the continued development of Nsangi Parents' Primary School."],
            ['slug' => 'pta', 'title' => "Parents' Teachers' Association", 'section' => 'about', 'sort_order' => 4, 'content' => "The Parents' Teachers' Association brings families and teachers together to support pupil welfare, effective learning, and school development."],
            ['slug' => 'school-founders', 'title' => 'Our Community', 'section' => 'about', 'sort_order' => 5, 'content' => "Nsangi Parents' Primary School is built on the commitment of parents, teachers, and community members who value accessible, quality education for children in Nsangi."],
            ['slug' => 'school-anthem', 'title' => 'School Anthem', 'section' => 'about', 'sort_order' => 6, 'content' => 'School anthem lyrics can be updated by the administration through the admin panel.'],
            ['slug' => 'school-curriculum', 'title' => 'School Curriculum', 'section' => 'academics', 'sort_order' => 1, 'content' => 'Our curriculum supports children from Nursery to P.6 through age-appropriate learning in literacy, numeracy, science, social studies, languages, creative work, physical education, and life skills.'],
            ['slug' => 'school-fees', 'title' => 'School Fees', 'section' => 'academics', 'sort_order' => 2, 'content' => 'The current fee structure for day and boarding pupils is shown below. Please contact the school office for clarification about fees, requirements, and admission arrangements.'],
            ['slug' => 'co-curricular-activities', 'title' => 'Co-curricular Activities', 'section' => 'academics', 'sort_order' => 3, 'content' => 'Pupils take part in sports, music, dance, drama, clubs, reading, creative work, and other activities that build confidence, teamwork, discipline, and talent.'],
            ['slug' => 'sensitive-information', 'title' => 'Parent Information', 'section' => 'academics', 'sort_order' => 4, 'content' => 'This section contains circulars, holiday work, notices, and other documents for parents and pupils.'],
            ['slug' => 'social-responsibility', 'title' => 'Social Responsibility', 'section' => 'students', 'sort_order' => 1, 'content' => 'Pupils learn to care for one another, respect their environment, and serve their families and community through age-appropriate activities.'],
            ['slug' => 'spiritual-welfare', 'title' => 'Character & Values', 'section' => 'students', 'sort_order' => 2, 'content' => 'Character development is part of everyday school life. Pupils are guided to practise honesty, respect, responsibility, kindness, and cooperation.'],
            ['slug' => 'school-programme', 'title' => 'School Programme', 'section' => null, 'sort_order' => 0, 'content' => 'The school programme includes lessons, reading, games, sports, clubs, creative activities, assemblies, and parent engagement throughout the term.'],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }

        SchoolFee::query()->delete();
        foreach ([
            ['class' => 'Nursery', 'item' => 'Tuition', 'sort_order' => 1],
            ['class' => 'P.1 - P.3', 'item' => 'Tuition', 'sort_order' => 2],
            ['class' => 'P.4 - P.6', 'item' => 'Tuition', 'sort_order' => 3],
        ] as $fee) {
            SchoolFee::create($fee + ['day_students' => '', 'boarding_students' => '', 'is_published' => true]);
        }

        SensitiveDocument::where('title', 'Term 1 Holiday Work — S.1 to S.4')
            ->update(['title' => 'Term 1 Holiday Work — Nursery to P.6', 'description' => 'Holiday activities and revision work for pupils from Nursery to P.6.']);

        Club::whereIn('name', ['Science Club', 'Writers Club', 'Mathematics Club', 'Legion of Mary', 'Christian Life Community (CLC)', 'Interact Club', 'Music Club', 'Drama & Debate Club'])->delete();
        Prefect::query()->delete();
        AboutProfile::query()->delete();

        Post::where('slug', 'welcome-new-term-2026')->update([
            'excerpt' => 'We warmly welcome all pupils, parents, and staff to a new term of learning and growth.',
            'content' => "We warmly welcome all pupils, parents, and staff to the new term. Let us work together to build strong learning habits, good character, and a caring school community.",
        ]);

        Event::where('title', 'Academic Exhibition & Visitation Day')->update([
            'title' => 'Learning Exhibition & Parents Day',
            'description' => 'Pupils share their learning and parents meet teachers to discuss progress.',
            'location' => "Nsangi Parents' Primary School",
        ]);

        ProgrammeEntry::whereIn('title', ['Inter-house Sports', 'Science Club Meeting', 'Legion of Mary', 'Writers Club Workshop'])
            ->delete();
    }
};