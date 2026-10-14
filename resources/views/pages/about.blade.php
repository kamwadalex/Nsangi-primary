@extends('layouts.app')

@section('title', 'About Us — ' . ($school['school_name'] ?? "Nsangi Parents' Primary School"))
@section('meta_description', \Illuminate\Support\Str::limit(preg_replace('/\s+/', ' ', $school['about_school_content'] ?? ($school['tagline'] ?? "About Nsangi Parents' Primary School.")), 155))

@section('content')
@include('partials.page-hero', ['title' => 'About Us'])

<section class="about-page">
    <div class="container">
        <section id="about-school" class="about-section">
            <div class="about-section__header">
                <span class="label">Who We Are</span>
                <h2>About the School</h2>
            </div>
            <div class="about-intro-grid">
                <div class="about-intro-grid__media">
                    <x-school-image
                        :src="$school['about_image'] ?? null"
                        variant="landscape"
                        label="School Campus Photo"
                        alt="About the school"
                    />
                </div>
                <div class="prose about-intro-grid__story">
                    @if(!empty($school['about_school_content']))
                        <x-plain-text :text="$school['about_school_content']" />
                    @elseif(!empty($school['school_story']))
                        <x-plain-text :text="$school['school_story']" />
                    @else
                        <p>{{ $school['tagline'] ?? "Nsangi Parents' Primary School is a mixed day and boarding school offering Nursery to P.6 education." }}</p>
                    @endif
                </div>
            </div>
        </section>

        <section id="our-values" class="about-section">
            <div class="about-section__header">
                <span class="label">What Guides Us</span>
                <h2>Mission, Vision &amp; Core Values</h2>
            </div>
            @include('partials.school-values')
        </section>

        @if($headTeachers->isNotEmpty())
        <section id="head-teachers" class="about-section">
            <div class="about-section__header">
                <span class="label">Leadership</span>
                <h2>Head Teachers</h2>
            </div>
            <div class="about-profiles-grid">
                @foreach($headTeachers as $profile)
                    @include('partials.about-profile-card', ['profile' => $profile])
                @endforeach
            </div>
        </section>
        @endif

        @if($boardMembers->isNotEmpty())
        <section id="board-of-governors" class="about-section">
            <div class="about-section__header">
                <span class="label">Governance</span>
                <h2>Board of Governors</h2>
            </div>
            <div class="prose about-section__intro">
                <p>The Board of Governors provides strategic oversight and governance for the school. Members represent the church, parents, staff, and the wider community in guiding the school's development.</p>
            </div>
            <div class="about-profiles-grid">
                @foreach($boardMembers as $profile)
                    @include('partials.about-profile-card', ['profile' => $profile])
                @endforeach
            </div>
        </section>
        @endif

        @if($ptaMembers->isNotEmpty())
        <section id="pta" class="about-section">
            <div class="about-section__header">
                <span class="label">Partnership</span>
                <h2>Parents' Teachers' Association</h2>
            </div>
            <div class="prose about-section__intro">
                <p>The Parents' Teachers' Association brings together parents and teachers to support student welfare, academic progress, and school development projects.</p>
            </div>
            <div class="about-profiles-grid">
                @foreach($ptaMembers as $profile)
                    @include('partials.about-profile-card', ['profile' => $profile])
                @endforeach
            </div>
        </section>
        @endif

        @if($founders->isNotEmpty())
        <section id="school-founders" class="about-section">
            <div class="about-section__header">
                <span class="label">Our Roots</span>
                <h2>School Founders</h2>
            </div>
            <div class="prose about-section__intro">
                <p>{{ $school['school_name'] ?? "Nsangi Parents' Primary School" }} was founded to provide accessible, quality education for children in the Nsangi community.</p>
            </div>
            <div class="about-profiles-grid">
                @foreach($founders as $profile)
                    @include('partials.about-profile-card', ['profile' => $profile])
                @endforeach
            </div>
        </section>
        @endif

        <section id="school-life" class="about-section">
            <div class="about-section__header">
                <span class="label">Life at School</span>
                <h2>Facilities and School Life</h2>
            </div>
            <div class="grid-2">
                <div class="card">
                    <h3>Learning and Growth</h3>
                    <p>Our school combines classroom learning with sports, creative activities, clubs, and opportunities for children to take responsibility.</p>
                </div>
                <div class="card">
                    <h3>Day and Boarding Care</h3>
                    <p>Families can choose the arrangement that best supports their child. Contact the school for current places, routines, and boarding information.</p>
                </div>
            </div>
        </section>

        @if(!empty($school['school_anthem']))
        <section id="school-anthem" class="about-section">
            <div class="about-section__header">
                <span class="label">School Pride</span>
                <h2>School Anthem</h2>
            </div>
            <div class="about-anthem card">
                    <div class="about-anthem__viewport" aria-label="School anthem lyrics">
                        <div class="about-anthem__track">
                            <div class="about-anthem__lyrics"><x-plain-text :text="$school['school_anthem']" /></div>
                            <div class="about-anthem__lyrics" aria-hidden="true"><x-plain-text :text="$school['school_anthem']" /></div>
                        </div>
                    </div>
            </div>
        </section>
        @endif

        @if(!empty($school['mission_objectives']) || !empty($school['short_term_objectives']))
        <section id="objectives" class="about-section">
            <div class="about-section__header">
                <span class="label">Our Direction</span>
                <h2>School Objectives</h2>
            </div>
            <div class="grid-2">
                @foreach([
                    ['mission_objectives', 'School Mission Objectives'],
                    ['short_term_objectives', 'Short Term Objectives'],
                ] as [$field, $heading])
                    @if(!empty($school[$field]))
                        <div class="card">
                            <h3>{{ $heading }}</h3>
                            <ul>
                                @foreach(preg_split('/\r\n|\r|\n/', $school[$field]) as $objective)
                                    @if(trim($objective) !== '')
                                        <li>{{ $objective }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endforeach
            </div>
        </section>
        @endif
    </div>
</section>
@endsection
