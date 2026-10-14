@extends('layouts.app')

@section('title', 'Pupil Leadership — ' . ($school['school_name'] ?? "Nsangi Parents' Primary School"))

@section('content')
@include('partials.page-hero', ['title' => $current ? 'Current Pupil Leadership' : 'Past Pupil Leadership'])

<section class="page-content">
    <div class="container">
        <div class="tabs">
            <a href="{{ route('prefects.index') }}" class="tab {{ $current ? 'active' : '' }}">Current Leaders</a>
            <a href="{{ route('prefects.index', ['view' => 'past']) }}" class="tab {{ !$current ? 'active' : '' }}">Past Leaders</a>
        </div>

        @if($prefects->isEmpty())
            <p>No prefects listed.</p>
        @else
            @include('partials.prefect-grid', ['prefects' => $prefects])
        @endif
    </div>
</section>
@endsection
