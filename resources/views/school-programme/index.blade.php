@extends('layouts.app')

@section('title', 'School Programme — ' . ($school['school_name'] ?? "Nsangi Parents' Primary School"))

@php
    $monthName = \Carbon\Carbon::create($year, $month, 1)->format('F');
    $queryBase = fn (array $overrides = []) => route('school-programme', array_merge(
        request()->only(['view', 'month', 'year', 'category', 'date']),
        $overrides
    ));
    $prevMonth = $focus->copy()->subMonth();
    $nextMonth = $focus->copy()->addMonth();
    $prevWeek = $focus->copy()->subWeek();
    $nextWeek = $focus->copy()->addWeek();
    $prevDay = $focus->copy()->subDay();
    $nextDay = $focus->copy()->addDay();
@endphp

@section('content')
@include('partials.page-hero', ['title' => 'School Programme'])

<section class="page-content programme-calendar-page">
    <div class="container programme-calendar" id="programme-calendar">
        <header class="programme-calendar__header">
            <h2 class="programme-calendar__title">
                @if($view === 'day')
                    Events on {{ $focus->format('F j, Y') }}
                @elseif($view === 'week')
                    Events for week of {{ $rangeStart->format('M j') }} – {{ $rangeEnd->format('M j, Y') }}
                @else
                    Events in {{ $monthName }} {{ $year }}
                @endif
            </h2>

            <div class="programme-calendar__toolbar">
                <div class="programme-calendar__view-group">
                    <span class="programme-calendar__label">View as</span>
                    <a href="{{ $queryBase(['view' => 'grid']) }}" class="programme-calendar__pill @if(in_array($view, ['grid', 'month'])) active @endif">Grid</a>
                    <a href="{{ $queryBase(['view' => 'list']) }}" class="programme-calendar__pill @if($view === 'list') active @endif">List</a>
                </div>

                <div class="programme-calendar__view-group">
                    <a href="{{ $queryBase(['view' => 'month', 'date' => null]) }}" class="programme-calendar__pill @if($view === 'month') active @endif">Month</a>
                    <a href="{{ $queryBase(['view' => 'week', 'date' => $focus->format('Y-m-d')]) }}" class="programme-calendar__pill @if($view === 'week') active @endif">Week</a>
                    <a href="{{ $queryBase(['view' => 'day', 'date' => $today->format('Y-m-d')]) }}" class="programme-calendar__pill @if($view === 'day') active @endif">Day</a>
                </div>

                <form class="programme-calendar__filters" method="GET" action="{{ route('school-programme') }}">
                    <input type="hidden" name="view" value="{{ $view }}">
                    @if(in_array($view, ['week', 'day']))
                        <input type="hidden" name="date" value="{{ $focus->format('Y-m-d') }}">
                    @endif
                    <label class="sr-only" for="programme-month">Month</label>
                    <select id="programme-month" name="month" class="form-control programme-calendar__select">
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" @selected($m === $month)>{{ \Carbon\Carbon::create(null, $m, 1)->format('F') }}</option>
                        @endfor
                    </select>
                    <label class="sr-only" for="programme-year">Year</label>
                    <select id="programme-year" name="year" class="form-control programme-calendar__select">
                        @for($y = $year - 2; $y <= $year + 2; $y++)
                            <option value="{{ $y }}" @selected($y === $year)>{{ $y }}</option>
                        @endfor
                    </select>
                    @if($category !== 'all')
                        <input type="hidden" name="category" value="{{ $category }}">
                    @endif
                    <button type="submit" class="btn btn-outline programme-calendar__go">Go</button>
                </form>

                <div class="programme-calendar__nav">
                    @if($view === 'week')
                        <a href="{{ $queryBase(['view' => 'week', 'date' => $prevWeek->format('Y-m-d')]) }}" class="programme-calendar__nav-link">Previous</a>
                        <a href="{{ $queryBase(['view' => 'week', 'date' => $today->format('Y-m-d')]) }}" class="programme-calendar__nav-link">Today</a>
                        <a href="{{ $queryBase(['view' => 'week', 'date' => $nextWeek->format('Y-m-d')]) }}" class="programme-calendar__nav-link">Next</a>
                    @elseif($view === 'day')
                        <a href="{{ $queryBase(['view' => 'day', 'date' => $prevDay->format('Y-m-d')]) }}" class="programme-calendar__nav-link">Previous</a>
                        <a href="{{ $queryBase(['view' => 'day', 'date' => $today->format('Y-m-d')]) }}" class="programme-calendar__nav-link">Today</a>
                        <a href="{{ $queryBase(['view' => 'day', 'date' => $nextDay->format('Y-m-d')]) }}" class="programme-calendar__nav-link">Next</a>
                    @else
                        <a href="{{ $queryBase(['view' => $view === 'list' ? 'list' : ($view === 'grid' ? 'grid' : 'month'), 'month' => $prevMonth->month, 'year' => $prevMonth->year]) }}" class="programme-calendar__nav-link">Previous</a>
                        <a href="{{ $queryBase(['view' => $view, 'month' => $today->month, 'year' => $today->year, 'date' => null]) }}" class="programme-calendar__nav-link">Today</a>
                        <a href="{{ $queryBase(['view' => $view === 'list' ? 'list' : ($view === 'grid' ? 'grid' : 'month'), 'month' => $nextMonth->month, 'year' => $nextMonth->year]) }}" class="programme-calendar__nav-link">Next</a>
                    @endif
                </div>

                <button type="button" class="btn btn-outline programme-calendar__print" onclick="window.print()">Print</button>
            </div>
        </header>

        <aside class="programme-calendar__sidebar">
            <h3 class="programme-calendar__sidebar-title">Categories</h3>
            <ul class="programme-calendar__categories">
                <li><a href="{{ $queryBase(['category' => 'all']) }}" @if($category === 'all') class="active" @endif>All Categories</a></li>
                @foreach($categories as $cat)
                    <li><a href="{{ $queryBase(['category' => $cat]) }}" @if($category === $cat) class="active" @endif>{{ $cat }}</a></li>
                @endforeach
            </ul>
        </aside>

        <div class="programme-calendar__main">
            @if(in_array($view, ['month', 'grid']))
                <div class="programme-calendar__month-grid @if($view === 'grid') programme-calendar__month-grid--cards @endif">
                    <div class="programme-calendar__weekdays">
                        @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $weekday)
                            <div class="programme-calendar__weekday">{{ $weekday }}</div>
                        @endforeach
                    </div>
                    @foreach($calendarWeeks as $week)
                        <div class="programme-calendar__week">
                            @foreach($week as $day)
                                @php $dayKey = $day->format('Y-m-d'); @endphp
                                <div class="programme-calendar__day @if(!$day->isSameMonth($focus)) is-muted @endif @if($day->isSameDay($today)) is-today @endif">
                                    <a href="{{ $queryBase(['view' => 'day', 'date' => $dayKey, 'month' => $day->month, 'year' => $day->year]) }}" class="programme-calendar__day-label">
                                        <span class="programme-calendar__day-num">{{ $day->day }}</span>
                                        <span class="programme-calendar__day-name">{{ $day->format('F j, Y') }}</span>
                                    </a>
                                    <div class="programme-calendar__day-events">
                                        @foreach($entriesByDate->get($dayKey, collect()) as $entry)
                                            <div class="programme-calendar__event">
                                                <strong>{{ $entry->starts_at->format('g:i A') }}</strong>
                                                {{ $entry->title }}
                                                @if($entry->category !== 'General')
                                                    <em>({{ $entry->category }})</em>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @elseif($view === 'week')
                <div class="programme-calendar__week-list">
                    @for($d = $rangeStart->copy(); $d->lte($rangeEnd); $d->addDay())
                        @php $dayKey = $d->format('Y-m-d'); @endphp
                        <div class="programme-calendar__week-day @if($d->isSameDay($today)) is-today @endif">
                            <h3>{{ $d->format('l, F j, Y') }}</h3>
                            @forelse($entriesByDate->get($dayKey, collect()) as $entry)
                                <div class="programme-calendar__list-item">
                                    <span class="programme-calendar__time">{{ $entry->starts_at->format('g:i A') }}@if($entry->ends_at) – {{ $entry->ends_at->format('g:i A') }}@endif</span>
                                    <strong>{{ $entry->title }}</strong>
                                    @if($entry->description)<p>{{ $entry->description }}</p>@endif
                                </div>
                            @empty
                                <p class="programme-calendar__empty">No programme items scheduled.</p>
                            @endforelse
                        </div>
                    @endfor
                </div>
            @elseif($view === 'day')
                <div class="programme-calendar__day-view">
                    <h3>{{ $focus->format('l, F j, Y') }}</h3>
                    @forelse($entries as $entry)
                        <div class="programme-calendar__list-item">
                            <span class="programme-calendar__time">{{ $entry->starts_at->format('g:i A') }}@if($entry->ends_at) – {{ $entry->ends_at->format('g:i A') }}@endif</span>
                            <strong>{{ $entry->title }}</strong>
                            @if($entry->category !== 'General')<span class="programme-calendar__cat">{{ $entry->category }}</span>@endif
                            @if($entry->description)<p>{{ $entry->description }}</p>@endif
                        </div>
                    @empty
                        <p class="programme-calendar__empty">No programme items scheduled for this day.</p>
                    @endforelse
                </div>
            @elseif($view === 'list')
                @forelse($entries as $entry)
                    <div class="programme-calendar__list-item programme-calendar__list-item--row">
                        <span class="programme-calendar__date">{{ $entry->starts_at->format('D, M j, Y') }}</span>
                        <span class="programme-calendar__time">{{ $entry->starts_at->format('g:i A') }}</span>
                        <strong>{{ $entry->title }}</strong>
                        @if($entry->category !== 'General')<span class="programme-calendar__cat">{{ $entry->category }}</span>@endif
                        @if($entry->description)<p>{{ $entry->description }}</p>@endif
                    </div>
                @empty
                    <p class="programme-calendar__empty">No programme items for {{ $monthName }} {{ $year }}.</p>
                @endforelse
            @endif
        </div>
    </div>
</section>
@endsection
