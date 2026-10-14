@props(['post'])

<article class="post-card">
    @if($post->image)
        <x-school-image :src="$post->image" variant="card" :label="$post->title" :alt="$post->title" />
    @endif
    <div class="meta">{{ $post->published_at?->format('F j, Y') }}</div>
    <div class="body">
        <h3>{{ $post->title }}</h3>
        <p>{{ Str::limit(\App\Support\PlainTextContent::toPlain($post->excerpt ?? $post->content), 120) }}</p>
        <a href="{{ route('news.show', $post->slug) }}" class="post-card__read-more">Read more &rarr;</a>
    </div>
</article>
