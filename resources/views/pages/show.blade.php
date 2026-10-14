@extends('layouts.app')

@section('title', $page->title . ' — ' . ($school['school_name'] ?? "Nsangi Parents' Primary School"))
@section('meta_description', $page->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($page->content), 155))

@section('content')
@include('partials.page-hero', ['title' => $page->title])

<section class="page-content">
    <div class="container prose">
        <x-plain-text :text="$page->content" />
    </div>
</section>
@endsection
