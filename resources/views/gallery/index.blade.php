@extends('layouts.app')

@section('title', 'Gallery — ' . ($school['school_name'] ?? "Nsangi Parents' Primary School"))

@section('content')
@include('partials.page-hero', ['title' => 'School Gallery'])

<section class="page-content">
    <div class="container">
        @if($items->contains(fn ($item) => !empty($item->image)))
        <div class="gallery-grid">
            @foreach($items as $item)
                    @if($item->image)
                        <div class="gallery-item">
                            <button type="button" class="gallery-item__trigger" data-gallery-image="{{ \App\Support\StoragePublicPath::url($item->image) }}" data-gallery-title="{{ $item->title ?? 'School gallery photo' }}" aria-label="View {{ $item->title ?? 'school gallery photo' }}">
                            <x-school-image :src="$item->image" variant="gallery" :label="$item->title ?? 'Gallery'" :alt="$item->title ?? 'Gallery photo'" />
                            </button>
                        </div>
                    @endif
            @endforeach
        </div>
        @if($items->isNotEmpty())
            <div class="pagination">{{ $items->links() }}</div>
        @endif
        @else
            <p class="empty-state">School photographs will be added here as activities and events are documented.</p>
        @endif
    </div>
</section>
@endsection
