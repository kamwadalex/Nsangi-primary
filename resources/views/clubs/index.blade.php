@extends('layouts.app')

@section('title', ($categories[$category] ?? 'Clubs') . ' — ' . ($school['school_name'] ?? "Nsangi Parents' Primary School"))

@section('content')
@include('partials.page-hero', ['title' => 'Clubs & Societies'])

<section class="page-content">
    <div class="container">
        <div class="tabs staff-tabs clubs-tabs">
            @foreach($categories as $key => $label)
                <a href="{{ route('clubs.index', ['category' => $key]) }}" class="tab {{ $category === $key ? 'active' : '' }}">{{ $label }}</a>
            @endforeach
        </div>

        <article class="club-category-intro card">
            <h2 class="club-category-intro__title">{{ $categories[$category] }}</h2>
            <p class="club-category-intro__summary">{{ $categoryIntro['summary'] }}</p>
            <ul class="club-category-intro__points">
                @foreach($categoryIntro['points'] as $point)
                    <li>{{ $point }}</li>
                @endforeach
            </ul>
        </article>

        @if($clubs->isEmpty())
            <p class="club-empty-message">No clubs listed in this category yet.</p>
        @else
            <div class="club-grid">
                @foreach($clubs as $club)
                <article class="club-card card">
                    <h3 class="club-card__title">{{ $club->name }}</h3>
                    @if($club->description)
                        <p class="club-card__description">{{ $club->description }}</p>
                    @endif

                    <dl class="club-card__meta">
                        @if($club->patron)
                            <div class="club-card__meta-item">
                                <dt>Patron</dt>
                                <dd>{{ $club->patron }}</dd>
                            </div>
                        @endif
                        @if($club->meeting_schedule)
                            <div class="club-card__meta-item">
                                <dt>Meeting Time</dt>
                                <dd>{{ $club->meeting_schedule }}</dd>
                            </div>
                        @endif
                    </dl>

                    @if($club->activityList())
                        <div class="club-card__activities">
                            <h4>Main Activities</h4>
                            <ul>
                                @foreach($club->activityList() as $activity)
                                    <li>{{ $activity }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </article>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
