@extends('layouts.app')

@section('title', $sectionTitle . ' — ' . ($school['school_name'] ?? "Nsangi Parents' Primary School"))

@section('content')
@include('partials.page-hero', ['title' => $sectionTitle])

<section class="page-content">
    <div class="container">
        @if($pages->isEmpty())
            <p>No pages available in this section yet.</p>
        @else
            <div class="grid-2">
                @foreach($pages as $page)
                @php
                    $pageUrl = match ($page->slug) {
                        'school-fees' => route('academics.school-fees'),
                        'sensitive-information', 'departments' => route('academics.sensitive-information'),
                        default => route('pages.show', $page->slug),
                    };
                @endphp
                <div class="card feature-card">
                    <div class="feature-card__icon feature-card__icon--green" aria-hidden="true">
                        <x-icons name="book" />
                    </div>
                    <h3><a href="{{ $pageUrl }}">{{ $page->title }}</a></h3>
                    <p>{{ Str::limit(\App\Support\PlainTextContent::toPlain($page->content), 180) }}</p>
                    <a href="{{ $pageUrl }}">Read more &rarr;</a>
                </div>
                @endforeach
            </div>
        @endif
        @if($section === 'students')
        <div class="students-prefectorate" style="margin-top: 2.5rem;">
            <h2 class="section-heading">Prefectorial Body</h2>
            <p class="students-intro">Meet the student leaders who serve in the current prefectorial body.</p>
            @if(($prefects ?? collect())->isEmpty())
                <p class="empty-state">Pupil leadership information will be available soon.</p>
            @else
                @include('partials.prefect-grid', ['prefects' => $prefects])
                <p style="text-align: center; margin-top: 1.5rem;">
                    <a href="{{ route('prefects.index') }}">View current &amp; past prefectorate &rarr;</a>
                </p>
            @endif
        </div>
        @endif
        @if($section === 'about')
        <div style="margin-top: 2.5rem;">
            @include('partials.school-values')
        </div>
        @endif
    </div>
</section>
@endsection
