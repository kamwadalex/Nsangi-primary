@extends('layouts.app')

@section('title', 'Staff — ' . ($school['school_name'] ?? "Nsangi Parents' Primary School"))

@section('content')
@include('partials.page-hero', ['title' => 'Staff'])

<section class="staff-page__nav">
    <div class="container">
        <div class="tabs staff-tabs">
            @foreach($categories as $key => $label)
                <a
                    href="{{ route('staff.index', ['category' => $key]) }}#staff-content"
                    class="tab {{ $category === $key ? 'active' : '' }}"
                >{{ $label }}</a>
            @endforeach
        </div>
    </div>
</section>

<section class="page-content staff-page" id="staff-content">
    <div class="container">
        <h2 class="staff-page__heading">{{ $categories[$category] ?? 'Staff' }}</h2>

        @if($staff->isEmpty())
            <p>No staff members listed in this category.</p>
        @elseif($category === 'administration')
            <div class="staff-grid">
                @foreach($staff as $member)
                    @include('partials.staff-member-card', ['member' => $member])
                @endforeach
            </div>
        @else
            @include('partials.staff-table', ['staff' => $staff, 'category' => $category])
        @endif
    </div>
</section>
@endsection
