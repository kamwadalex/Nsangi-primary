@extends('layouts.app')

@section('title', $post->title . ' — ' . ($school['school_name'] ?? "Nsangi Parents' Primary School"))
@section('meta_description', $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 155))
@section('og_type', 'article')
@section('og_image', \App\Support\StoragePublicPath::url($post->image) ?? '')

@section('content')
@include('partials.page-hero', [
    'title' => $post->title,
    'subtitle' => $post->published_at?->format('F j, Y'),
])

<section class="page-content">
    <div class="container prose news-article">
        @if($post->image)
            <x-school-image :src="$post->image" variant="landscape" :label="$post->title" :alt="$post->title" class="news-article__image" />
        @endif
        <x-plain-text :text="$post->content" />
        <p style="margin-top: 2rem;"><a href="{{ route('news.index') }}">&larr; Back to News</a></p>
    </div>
</section>
@endsection
