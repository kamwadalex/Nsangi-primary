<?php

namespace Database\Seeders;

use App\Models\AboutProfile;
use App\Models\Club;
use App\Models\Event;
use App\Models\Page;
use App\Models\Post;
use App\Models\Prefect;
use App\Models\ProgrammeEntry;
use App\Models\SchoolFee;
use App\Models\SensitiveDocument;
use App\Models\SensitiveSection;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@nsangiparentsprimaryschool.com'],
            ['name' => 'Administrator', 'password' => Hash::make('password')]
        );

        $settings = [
            'school_name' => "Nsangi Parents' Primary School",
            'motto' => 'Education is the Key',
            'tagline' => "Nsangi Parents' Primary School is a mixed day and boarding school offering Nursery to P.6 education.",
            'school_story' => "Nsangi Parents' Primary School is a mixed day and boarding school located on Nsangi Masaka Road. We provide a supportive learning environment for children from Nursery to P.6, preparing them to become law abiding and productive citizens.",
            'phone' => '0772331480',
            'phone_2' => '0758 008545',
            'phone_3' => '',
            'email' => 'nsangiparentsschool@gmail.com',
            'address' => 'Nsangi Masaka Rd, P.O.Box 89',
            'levels_offered' => 'Nursery - P.6',
            'admission_status' => 'OPEN',
            'center_number' => '280020',
            'years_existence' => '',
            'head_teacher_name' => '',
            'head_teacher_message' => '',
            'mission' => 'To prepare law abiding and productive citizens for the country.',
            'mission_objectives' => "To encourage effective teaching/learning, so that pupils become productive in future.\nTo employ Sports teachers to emphasize co-curricular activities.\nTo put more practice in languages 1 x 2 for easy communication.\nTo sensitize Parents of the importance of education.\nTo develop the School in all possible ways to meet the minimum standard indicators.",
            'short_term_objectives' => "Teachers should teach willingly to eradicate laziness from pupils.\nTeachers and pupils should attend School daily and participate in the daily School activities.\nSchool administration to regularly monitor teaching/learning.",
            'vision' => '',
            'core_values' => '',
            'about_school_content' => "Nsangi Parents' Primary School is a mixed day and boarding school offering education from Nursery to P.6. Located on Nsangi Masaka Road, the school is committed to preparing law abiding and productive citizens for the country.",
            'school_anthem' => '',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        $badgeSource = public_path('favicon.jpeg');
        if (File::exists($badgeSource)) {
            $badgeDir = storage_path('app/public/settings');
            File::ensureDirectoryExists($badgeDir);
            File::copy($badgeSource, $badgeDir.'/school-badge.jpeg');
            Setting::set('logo', 'settings/school-badge.jpeg');
        }

        $pages = [
            ['slug' => 'about-school', 'title' => 'About the School', 'section' => 'about', 'sort_order' => 1, 'content' => "Nsangi Parents' Primary School is a mixed day and boarding school situated along Nsangi Masaka Road. We offer education from Nursery to P.6 in a safe, supportive environment that helps children grow in knowledge, confidence, discipline, and responsibility."],
            ['slug' => 'head-teachers', 'title' => 'School Leadership', 'section' => 'about', 'sort_order' => 2, 'content' => 'Our school leadership team works with teachers, parents, and pupils to maintain effective teaching, good discipline, and a caring learning environment.'],
            ['slug' => 'board-of-governors', 'title' => 'School Management', 'section' => 'about', 'sort_order' => 3, 'content' => 'The school management team provides direction for teaching, pupil welfare, staff coordination, and the continued development of Nsangi Parents\' Primary School.'],
            ['slug' => 'pta', 'title' => "Parents' Teachers' Association", 'section' => 'about', 'sort_order' => 4, 'content' => 'The Parents\' Teachers\' Association brings families and teachers together to support pupil welfare, effective learning, and school development.'],
            ['slug' => 'school-founders', 'title' => 'Our Community', 'section' => 'about', 'sort_order' => 5, 'content' => "Nsangi Parents' Primary School is built on the commitment of parents, teachers, and community members who value accessible, quality education for children in Nsangi."],
            ['slug' => 'school-anthem', 'title' => 'School Anthem', 'section' => 'about', 'sort_order' => 6, 'content' => 'School anthem lyrics can be updated by the administration through the admin panel.'],
            ['slug' => 'school-curriculum', 'title' => 'School Curriculum', 'section' => 'academics', 'sort_order' => 1, 'content' => 'Our curriculum supports children from Nursery to P.6 through age-appropriate learning in literacy, numeracy, science, social studies, languages, creative work, physical education, and life skills.'],
            ['slug' => 'school-fees', 'title' => 'School Fees', 'section' => 'academics', 'sort_order' => 2, 'content' => 'The current fee structure for day and boarding pupils is shown below. Please contact the school office for clarification about fees, requirements, and admission arrangements.'],
            ['slug' => 'co-curricular-activities', 'title' => 'Co-curricular Activities', 'section' => 'academics', 'sort_order' => 3, 'content' => 'Pupils take part in sports, music, dance, drama, clubs, reading, creative work, and other activities that build confidence, teamwork, discipline, and talent.'],
            ['slug' => 'sensitive-information', 'title' => 'Parent Information', 'section' => 'academics', 'sort_order' => 4, 'content' => 'This section contains circulars, holiday work, notices, and other documents for parents and pupils.'],
            ['slug' => 'social-responsibility', 'title' => 'Social Responsibility', 'section' => 'students', 'sort_order' => 1, 'content' => 'Pupils learn to care for one another, respect their environment, and serve their families and community through age-appropriate activities.'],
            ['slug' => 'spiritual-welfare', 'title' => 'Character &amp; Values', 'section' => 'students', 'sort_order' => 2, 'content' => 'Character development is part of everyday school life. Pupils are guided to practise honesty, respect, responsibility, kindness, and cooperation.'],
            ['slug' => 'school-programme', 'title' => 'School Programme', 'section' => null, 'sort_order' => 0, 'content' => 'The school programme includes lessons, reading, games, sports, clubs, creative activities, assemblies, and parent engagement throughout the term.'],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }

        Page::whereIn('slug', ['s1-application', 's5-application', 'continuing-application', 'academic-performance', 'departments'])->delete();

        $schoolFees = [
            ['class' => 'Nursery', 'item' => 'Tuition', 'day_students' => '', 'boarding_students' => '', 'sort_order' => 1],
            ['class' => 'P.1 - P.3', 'item' => 'Tuition', 'day_students' => '', 'boarding_students' => '', 'sort_order' => 2],
            ['class' => 'P.4 - P.6', 'item' => 'Tuition', 'day_students' => '', 'boarding_students' => '', 'sort_order' => 3],
        ];

        foreach ($schoolFees as $fee) {
            SchoolFee::updateOrCreate(
                ['class' => $fee['class'], 'item' => $fee['item']],
                $fee + ['is_published' => true]
            );
        }

        $holidayWorkSection = SensitiveSection::updateOrCreate(
            ['slug' => 'holiday-work'],
            ['name' => 'Holiday Work', 'sort_order' => 1, 'is_published' => true]
        );

        $notesSection = SensitiveSection::updateOrCreate(
            ['slug' => 'notes'],
            ['name' => 'Notes & Files', 'sort_order' => 2, 'is_published' => true]
        );

        $circularSection = SensitiveSection::updateOrCreate(
            ['slug' => 'school-circular'],
            ['name' => 'School Circular', 'sort_order' => 3, 'is_published' => true]
        );

        SensitiveDocument::updateOrCreate(
            ['title' => 'Term 1 Holiday Work — Nursery to P.6', 'sensitive_section_id' => $holidayWorkSection->id],
            [
                'description' => 'Holiday activities and revision work for pupils from Nursery to P.6.',
                'sort_order' => 1,
                'is_published' => true,
            ]
        );

        SensitiveDocument::updateOrCreate(
            ['title' => 'Parent Circular — Term Programme', 'sensitive_section_id' => $notesSection->id],
            [
                'description' => 'Important dates, reporting requirements, and school programme notes for parents.',
                'sort_order' => 1,
                'is_published' => true,
            ]
        );

        SensitiveDocument::updateOrCreate(
            ['title' => 'School Circular — Reporting Dates', 'sensitive_section_id' => $circularSection->id],
            [
                'description' => 'Official circular with reporting dates, requirements, and term reminders for parents and students.',
                'sort_order' => 1,
                'is_published' => true,
            ]
        );

        Post::updateOrCreate(
            ['slug' => 'welcome-new-term-2026'],
            [
                'title' => 'Welcome to the New Term 2026',
                'excerpt' => 'We warmly welcome all students and staff back for a new term of learning and growth.',
                'content' => "We warmly welcome all pupils, parents, and staff to the new term. Let us work together to build strong learning habits, good character, and a caring school community.\n\nAll pupils are reminded to report with the required materials and maintain the high standards of Nsangi Parents' Primary School.",
                'published_at' => now()->subDays(5),
                'is_published' => true,
            ]
        );

        Post::updateOrCreate(
            ['slug' => 'visitation-day-announcement'],
            [
                'title' => 'Visitation Day Announcement',
                'excerpt' => 'Parents are invited to the upcoming visitation day to meet teachers and view student progress.',
                'content' => 'The school administration announces the upcoming visitation day. Parents and guardians are encouraged to attend and engage with teachers regarding their children\'s academic and social progress.',
                'published_at' => now()->subDays(12),
                'is_published' => true,
            ]
        );

        Event::updateOrCreate(
            ['slug' => 'careers-day-2026'],
            [
                'title' => "Careers Day 2026",
                'description' => 'An opportunity for students to interact with professionals and explore career paths.',
                'location' => 'School Main Hall',
                'starts_at' => now()->addDays(8)->setTime(9, 0),
                'category' => 'Academic',
                'is_published' => true,
            ]
        );

        Event::updateOrCreate(
            ['slug' => 'academic-exhibition-2026'],
            [
                'title' => 'Learning Exhibition & Parents Day',
                'description' => 'Pupils share their learning and parents meet teachers to discuss progress.',
                'location' => "Nsangi Parents' Primary School",
                'starts_at' => now()->addDays(22)->setTime(9, 0),
                'category' => 'School Event',
                'is_published' => true,
            ]
        );

        $programmeMonth = now()->startOfMonth();
        $programmeSamples = [
            ['day' => 2, 'time' => '08:00', 'title' => 'Morning Assembly', 'category' => 'General'],
            ['day' => 5, 'time' => '14:00', 'title' => 'Inter-class Sports', 'category' => 'Sports'],
            ['day' => 9, 'time' => '10:30', 'title' => 'Reading Club Meeting', 'category' => 'Clubs'],
            ['day' => 12, 'time' => '08:00', 'title' => 'Staff Briefing', 'category' => 'General'],
            ['day' => 12, 'time' => '15:00', 'title' => 'Music and Creative Arts', 'category' => 'Activities'],
            ['day' => 18, 'time' => '09:00', 'title' => 'Parent-Teacher Meeting', 'category' => 'General'],
            ['day' => 25, 'time' => '11:00', 'title' => 'Storytelling Workshop', 'category' => 'Clubs'],
        ];

        foreach ($programmeSamples as $sample) {
            ProgrammeEntry::updateOrCreate(
                [
                    'title' => $sample['title'],
                    'starts_at' => $programmeMonth->copy()->day($sample['day'])->setTimeFromTimeString($sample['time']),
                ],
                [
                    'description' => null,
                    'category' => $sample['category'],
                    'ends_at' => null,
                    'is_published' => true,
                ]
            );
        }

        $clubs = [
            [
                'name' => 'Science Club',
                'category' => 'academic',
                'description' => 'A club where pupils explore nature, simple experiments, observation, and problem-solving through guided activities.',
                'patron' => 'School Teacher',
                'meeting_schedule' => 'Wednesdays, 4:00 PM — Classroom',
                'activities' => "Simple practical activities\nNature observation\nProblem-solving games\nLearning exhibition preparation",
                'sort_order' => 1,
            ],
            [
                'name' => 'Writers Club',
                'category' => 'academic',
                'description' => 'Builds a love of reading, storytelling, handwriting, creative writing, and confident speaking.',
                'patron' => 'School Teacher',
                'meeting_schedule' => 'Thursdays, 4:00 PM — Library',
                'activities' => "Reading circles and story time\nCreative writing and drawing\nSpeaking and recitation practice\nContributions to school displays",
                'sort_order' => 2,
            ],
            [
                'name' => 'Mathematics Club',
                'category' => 'academic',
                'description' => 'Makes mathematics enjoyable through puzzles, counting games, practical activities, and teamwork.',
                'patron' => 'School Teacher',
                'meeting_schedule' => 'Fridays, 4:00 PM — Mathematics Room',
                'activities' => "Number games and puzzles\nPractical counting activities\nMental mathematics practice\nTeam challenges across classes",
                'sort_order' => 3,
            ],
            [
                'name' => 'Good Citizenship Club',
                'category' => 'ecclesiastical',
                'description' => 'Encourages pupils to practise honesty, kindness, respect, responsibility, and service in everyday life.',
                'patron' => 'School Teacher',
                'meeting_schedule' => 'Saturdays, 2:00 PM — School Hall',
                'activities' => "Good manners and responsibility\nCare for the school environment\nHelping others\nPupil leadership activities",
                'sort_order' => 1,
            ],
            [
                'name' => 'Young Readers Club',
                'category' => 'ecclesiastical',
                'description' => 'Encourages pupils to discover books, share stories, and support one another in reading.',
                'patron' => 'School Teacher',
                'meeting_schedule' => 'Mondays, 4:30 PM — Library',
                'activities' => "Shared reading\nStorytelling\nBook care\nReading progress activities",
                'sort_order' => 2,
            ],
            [
                'name' => 'Interact Club',
                'category' => 'social',
                'description' => 'A service and leadership club where pupils learn teamwork, care, and responsibility through simple community projects.',
                'patron' => 'School Teacher',
                'meeting_schedule' => 'Tuesdays, 4:00 PM — Main Hall',
                'activities' => "School clean-up activities\nSharing and caring projects\nTeamwork and leadership games\nHealth and safety awareness",
                'sort_order' => 1,
            ],
            [
                'name' => 'Music Club',
                'category' => 'social',
                'description' => 'Brings together pupils interested in singing, instruments, dance, and performances at school events.',
                'patron' => 'School Teacher',
                'meeting_schedule' => 'Wednesdays, 4:30 PM — Music Room',
                'activities' => "Singing and rhythm practice\nBasic instrument activities\nCultural day performances\nSchool celebration support",
                'sort_order' => 2,
            ],
            [
                'name' => 'Drama & Debate Club',
                'category' => 'social',
                'description' => 'Develops confidence, expression, imagination, and teamwork through drama, role play, and speaking activities.',
                'patron' => 'School Teacher',
                'meeting_schedule' => 'Fridays, 4:30 PM — Main Hall',
                'activities' => "Role play and drama\nStory presentations\nPublic speaking practice\nSupport for assemblies and celebrations",
                'sort_order' => 3,
            ],
        ];

        foreach ($clubs as $club) {
            Club::updateOrCreate(['name' => $club['name']], $club);
        }

        $prefects = [
            ['name' => 'Pupil Leader', 'position' => 'Head Pupil', 'class' => 'P.6', 'house' => 'Blue House', 'is_current' => true, 'sort_order' => 1],
            ['name' => 'Pupil Leader', 'position' => 'Deputy Head Pupil', 'class' => 'P.6', 'house' => 'Green House', 'is_current' => true, 'sort_order' => 2],
            ['name' => 'Pupil Leader', 'position' => 'Sports Leader', 'class' => 'P.6', 'house' => 'Red House', 'is_current' => true, 'sort_order' => 3],
        ];

        foreach ($prefects as $prefect) {
            Prefect::updateOrCreate(
                ['name' => $prefect['name'], 'is_current' => $prefect['is_current']],
                $prefect
            );
        }

        Testimonial::updateOrCreate(
            ['name' => 'Sarah Nakimera'],
            [
                'role' => 'Parent',
                'content' => "Nsangi Parents' Primary School gives children a caring environment where they learn, build confidence, and develop good values.",
                'sort_order' => 1,
            ]
        );

        Testimonial::updateOrCreate(
            ['name' => 'Mrs. Henry Walusimbi'],
            [
                'role' => 'Parent',
                'content' => 'As a parent, I appreciate the care given to pupils and the strong partnership between the school and families.',
                'sort_order' => 2,
            ]
        );

        AboutProfile::query()->delete();

        $aboutProfiles = [
            ['name' => 'School Management', 'position' => 'Management Team', 'category' => 'board-of-governors', 'sort_order' => 1, 'bio' => 'Provides direction for the school and supports a positive learning environment for every child.'],
            ['name' => 'Parent Representative', 'position' => 'Parent Representative', 'category' => 'pta', 'sort_order' => 1, 'bio' => 'Supports communication and cooperation between families, teachers, and school management.'],
            ['name' => 'Nsangi Community', 'position' => 'Community Partner', 'category' => 'school-founders', 'sort_order' => 1, 'bio' => 'Parents and community members support the school\'s mission to provide quality education for children in Nsangi.'],
        ];

        foreach ($aboutProfiles as $profile) {
            AboutProfile::create($profile);
        }

        $this->call(SiteImageSeeder::class);
    }
}
