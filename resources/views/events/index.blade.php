@extends('layouts.app')

@section('title', 'School Events — ' . ($school['school_name'] ?? "Nsangi Parents' Primary School"))
@section('meta_description', 'Upcoming and past events at ' . ($school['school_name'] ?? "Nsangi Parents' Primary School") . '.')

@section('content')
@include('partials.page-hero', ['title' => 'School Events'])

<section class="page-content">
    <div class="container">
        @if($upcoming->isNotEmpty())
            <div class="section-header" style="text-align: left; margin-bottom: 1.5rem;">
                <span class="label">Upcoming</span>
                <h2 style="font-size: 1.35rem;">Upcoming Events</h2>
            </div>
            <div class="calendar-grid" style="margin-bottom: 2.5rem;">
                @foreach($upcoming as $event)
                    @include('partials.calendar-card', ['event' => $event])
                @endforeach
            </div>
        @endif

        <div class="section-header" style="text-align: left; margin-bottom: 1.5rem;">
            <span class="label">Archive</span>
            <h2 style="font-size: 1.35rem;">Past Events</h2>
        </div>
        @if($past->isEmpty())
            <p>No past events recorded.</p>
        @else
            <div class="calendar-grid">
                @foreach($past as $event)
                    @include('partials.calendar-card', ['event' => $event])
                @endforeach
            </div>
            <div class="pagination">{{ $past->links() }}</div>
        @endif
    </div>
</section>
@endsection
