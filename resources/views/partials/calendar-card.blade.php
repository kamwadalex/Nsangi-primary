@props(['event'])

<article class="calendar-card">
    <div class="calendar-card__body">
        <div class="calendar-card__date-inline">
            <span class="calendar-card__day">{{ $event->starts_at->format('d') }}</span>
            <span class="calendar-card__month">{{ $event->starts_at->format('M') }}</span>
        </div>
        <h3 class="calendar-card__title">
            <a href="{{ route('events.show', $event->slug) }}">{{ $event->title }}</a>
        </h3>
        <p class="calendar-card__meta">
            {{ $event->starts_at->format('M j, Y @ g:i A') }}
            @if($event->location) · {{ $event->location }} @endif
        </p>
        @if($event->description)
            <p class="calendar-card__desc">{{ Str::limit(\App\Support\PlainTextContent::toPlain($event->description), 160) }}</p>
        @endif
    </div>
</article>
