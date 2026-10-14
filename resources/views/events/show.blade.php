@extends('layouts.app')

@section('title', $event->title . ' — ' . ($school['school_name'] ?? "Nsangi Parents' Primary School"))
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($event->description), 155))
@section('og_type', 'article')

@section('content')
@include('partials.page-hero', [
    'title' => $event->title,
    'subtitle' => $event->starts_at->format('F j, Y @ g:i A')
        .($event->ends_at ? ' — '.$event->ends_at->format('g:i A') : '')
        .($event->location ? ' | '.$event->location : ''),
])

<section class="page-content">
    <div class="container prose">
        <x-plain-text :text="$event->description" />
        <p style="margin-top: 2rem;"><a href="{{ route('events.index') }}">&larr; Back to Events</a></p>
    </div>
</section>
@endsection
