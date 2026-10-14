@extends('layouts.app')

@section('title', 'School News — ' . ($school['school_name'] ?? "Nsangi Parents' Primary School"))
@section('meta_description', 'Latest news and announcements from ' . ($school['school_name'] ?? "Nsangi Parents' Primary School") . '.')

@section('content')
@include('partials.page-hero', ['title' => 'School News'])

<section class="page-content">
    <div class="container">
        @if($posts->isEmpty())
            <p>No news posts yet.</p>
        @else
            <div class="grid-3">
                @foreach($posts as $post)
                    @include('partials.post-card', ['post' => $post])
                @endforeach
            </div>
            <div class="pagination">{{ $posts->links() }}</div>
        @endif
    </div>
</section>
@endsection
