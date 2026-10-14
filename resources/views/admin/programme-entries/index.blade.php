@extends('layouts.admin')

@section('title', 'School Programme')

@section('content')
@php
    $monthName = \Carbon\Carbon::create($year, $month, 1)->format('F');
    $prev = \Carbon\Carbon::create($year, $month, 1)->subMonth();
    $next = \Carbon\Carbon::create($year, $month, 1)->addMonth();
@endphp

<div class="admin-header">
    <h1 style="margin: 0;">School Programme — {{ $monthName }} {{ $year }}</h1>
    <a href="{{ route('admin.updates.programme.create', ['date' => now()->format('Y-m-d')]) }}" class="btn btn-primary">Add Entry</a>
</div>

@include('admin.updates.partials.tabs', ['active' => 'programme'])

<div class="admin-card" style="margin-bottom: 1.5rem;">
    <div class="programme-calendar__nav" style="justify-content: flex-start; margin-bottom: 1rem;">
        <a href="{{ route('admin.updates.programme.index', ['month' => $prev->month, 'year' => $prev->year]) }}" class="programme-calendar__nav-link">Previous Month</a>
        <a href="{{ route('admin.updates.programme.index', ['month' => now()->month, 'year' => now()->year]) }}" class="programme-calendar__nav-link">This Month</a>
        <a href="{{ route('admin.updates.programme.index', ['month' => $next->month, 'year' => $next->year]) }}" class="programme-calendar__nav-link">Next Month</a>
        <a href="{{ route('school-programme') }}" target="_blank" class="programme-calendar__nav-link">View on site</a>
    </div>
    <p style="margin: 0; color: #666;">Add or edit programme items for each day. Changes appear on the public School Programme calendar.</p>
</div>

<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($entries as $entry)
            <tr>
                <td>{{ $entry->starts_at->format('D, M j, Y') }}</td>
                <td>{{ $entry->starts_at->format('g:i A') }}@if($entry->ends_at) – {{ $entry->ends_at->format('g:i A') }}@endif</td>
                <td>{{ $entry->title }}</td>
                <td>{{ $entry->category }}</td>
                <td>{{ $entry->is_published ? 'Published' : 'Draft' }}</td>
                <td>
                    <a href="{{ route('admin.updates.programme.edit', $entry) }}">Edit</a>
                    <form action="{{ route('admin.updates.programme.destroy', $entry) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <input type="hidden" name="return_month" value="{{ $month }}">
                        <input type="hidden" name="return_year" value="{{ $year }}">
                        <button type="submit" onclick="return confirm('Delete this entry?')" style="background:none;border:none;cursor:pointer;color:var(--red);">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6">No programme entries for {{ $monthName }} {{ $year }}. <a href="{{ route('admin.updates.programme.create') }}">Add one</a></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
