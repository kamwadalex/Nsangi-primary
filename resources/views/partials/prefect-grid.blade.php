<div class="grid-4 prefect-grid">
    @foreach($prefects as $prefect)
    <div class="card prefect-card">
        @if($prefect->image)
            <div class="prefect-card__photo">
                <x-school-image
                    :src="$prefect->image"
                    variant="portrait"
                    :label="$prefect->name"
                    :alt="$prefect->name"
                />
            </div>
        @endif
        <h3 class="prefect-card__name">{{ $prefect->name }}</h3>
        <p class="prefect-card__position">{{ $prefect->position ?: '—' }}</p>
    </div>
    @endforeach
</div>
