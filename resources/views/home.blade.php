@extends('layouts.app')

@section('title', ($school['school_name'] ?? "Nsangi Parents' Primary School") . ' — Home')
@section('meta_description', $school['tagline'] ?? ($school['motto'] ?? "Nsangi Parents' Primary School in Nsangi, Uganda."))

@section('content')
<section class="hero">
    <div class="hero__media">
        @if(!empty($school['hero_image']))
            <x-school-image
                :src="$school['hero_image']"
                variant="hero"
                label="Welcome banner"
                alt="Welcome banner"
            />
        @endif
    </div>
    <div class="hero__content container">
        <p class="label hero-label">Welcome to</p>
        <h2>{{ $school['school_name'] ?? "Nsangi Parents' Primary School" }}</h2>
        @if(!empty($school['motto']))
            <p class="tagline hero-tagline">{{ $school['motto'] }}</p>
        @endif
        <div class="hero-actions">
            <a href="{{ route('applications.primary.create') }}" class="btn btn-primary">Apply Online</a>
            <a href="{{ route('about') }}#about-school" class="btn btn-outline btn-contact">Discover Our School</a>
        </div>
    </div>
</section>

<section class="section admissions-callout" id="admissions">
    <div class="container admissions-callout__inner">
        <div>
            <span class="label">Admissions</span>
            <h2>Take the next step for your child</h2>
            <p>Nsangi Parents' Primary School welcomes learners from Nursery to P.6 in a supportive mixed day and boarding environment.</p>
        </div>
        <div class="admissions-callout__actions">
            <a href="{{ route('academics.school-fees') }}" class="btn btn-primary">View School Fees</a>
            <a href="{{ route('applications.primary.create') }}" class="btn btn-outline">Apply Online</a>
        </div>
    </div>
</section>

@if(!empty($school['levels_offered']) || !empty($school['admission_status']) || !empty($school['center_number']))
<section class="section school-profile-strip">
    <div class="container grid-3">
        @if(!empty($school['levels_offered']))
            <div class="stat-box">
                <div class="label">Levels Offered</div>
                <div class="number">{{ $school['levels_offered'] }}</div>
            </div>
        @endif
        @if(!empty($school['admission_status']))
            <div class="stat-box">
                <div class="label">Admissions</div>
                <div class="number">{{ $school['admission_status'] }}</div>
            </div>
        @endif
        @if(!empty($school['center_number']))
            <div class="stat-box">
                <div class="label">Center Number</div>
                <div class="number">{{ $school['center_number'] }}</div>
            </div>
        @endif
    </div>
</section>
@endif

@if(!empty($school['head_teacher_message']))
<section class="section">
    <div class="container head-teacher-grid">
        <div class="head-teacher-photo">
            @if(!empty($school['head_teacher_photo']))
                <x-school-image
                    :src="$school['head_teacher_photo']"
                    variant="portrait"
                    label="Head Teacher Photo"
                    :alt="$school['head_teacher_name'] ?? 'Head Teacher'"
                />
            @endif
        </div>
        <div>
            <div class="section-header" style="text-align: left;">
                <span class="label">Message from the Head Teacher</span>
                <h2>{{ $school['head_teacher_name'] ?? 'Head Teacher' }}</h2>
            </div>
            <div class="prose">
                <x-plain-text :text="$school['head_teacher_message']" />
            </div>
        </div>
    </div>
</section>
@endif

<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <span class="label">Introduction</span>
            <h2>The Humble Beginning of the School</h2>
        </div>
        <div class="about-intro-grid">
            <div class="about-intro-grid__media">
                @if(!empty($school['about_image']))
                    <x-school-image
                        :src="$school['about_image']"
                        variant="landscape"
                        label="School Campus Photo"
                        alt="About the school"
                    />
                @endif
            </div>
            <div class="prose about-intro-grid__story">
                @if(!empty($school['school_story']))
                    <x-plain-text :text="$school['school_story']" />
                @else
                    <p>{{ $school['tagline'] ?? 'Nsangi Parents\' Primary School is a mixed day and boarding school offering Nursery to P.6 education.' }}</p>
                @endif
            </div>
        </div>
        @include('partials.school-values')
        <div style="text-align: center; margin-top: 2rem;">
            <a href="{{ route('about') }}" class="btn btn-primary">More About Us</a>
        </div>
    </div>
</section>

@if(!empty($school['years_existence']))
<section class="section">
    <div class="container" style="max-width: 300px;">
        <div class="stat-box">
            <div class="stat-box__icon" aria-hidden="true">
                <x-icons name="calendar" />
            </div>
            <div class="number">{{ $school['years_existence'] }}</div>
            <div class="label">Years of Existence</div>
        </div>
    </div>
</section>
@endif

<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <span class="label">Learning at Our School</span>
            <h2>Why Education at {{ $school['school_name'] ?? "Nsangi Parents' Primary School" }}</h2>
        </div>
        <div class="grid-2">
            @foreach([
                ['Academic Foundations', 'book', 'green', 'Strong foundations in literacy, numeracy, science, creativity, and problem-solving from Nursery through P.6.'],
                ['Character and Discipline', 'heart', 'red', 'We nurture respect, responsibility, honesty, self-discipline, and confidence in every learner.'],
                ['Co-curricular Development', 'sport', 'green', 'Games, sports, music, dance, drama, and clubs help learners discover their talents and work with others.'],
                ['Safe and Supportive Community', 'users', 'red', 'A caring mixed day and boarding environment where children are known, guided, and encouraged to grow.'],
            ] as [$title, $icon, $color, $text])
            <div class="card feature-card">
                <div class="feature-card__icon feature-card__icon--{{ $color }}" aria-hidden="true">
                    <x-icons :name="$icon" />
                </div>
                <h3>{{ $title }}</h3>
                <p>{{ $text }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

@if($galleryItems->contains(fn ($item) => !empty($item->image)))
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <span class="label">School Gallery</span>
            <h2>Our School's Special Moments</h2>
        </div>
        <div class="gallery-grid">
            @forelse($galleryItems->take(8) as $item)
                @if($item->image)
                    <div class="gallery-item">
                        <button type="button" class="gallery-item__trigger" data-gallery-image="{{ \App\Support\StoragePublicPath::url($item->image) }}" data-gallery-title="{{ $item->title ?? 'School gallery photo' }}" aria-label="View {{ $item->title ?? 'school gallery photo' }}">
                        <x-school-image :src="$item->image" variant="gallery" :label="$item->title ?? 'Gallery photo'" :alt="$item->title ?? 'Gallery photo'" />
                        </button>
                    </div>
                @endif
            @empty
            @endforelse
        </div>
        <div style="text-align: center; margin-top: 1.5rem;">
            <a href="{{ route('gallery.index') }}" class="btn btn-primary">Go to Gallery</a>
        </div>
    </div>
</section>
@endif

@if($latestPosts->isNotEmpty())
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="label">Latest News &amp; School Events</span>
            <h2>News from School Events</h2>
        </div>
        <div class="grid-3">
            @foreach($latestPosts as $post)
                @include('partials.post-card', ['post' => $post])
            @endforeach
        </div>
    </div>
</section>
@endif

@if($upcomingEvents->isNotEmpty())
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <span class="label">Upcoming Events</span>
            <h2>School Calendar</h2>
        </div>
        <div class="calendar-grid">
            @foreach($upcomingEvents as $event)
                @include('partials.calendar-card', ['event' => $event])
            @endforeach
        </div>
        <div style="text-align: center; margin-top: 1.5rem;">
            <a href="{{ route('events.index') }}" class="btn btn-outline">View All Events</a>
        </div>
    </div>
</section>
@endif

@endsection
