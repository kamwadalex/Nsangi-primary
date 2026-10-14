@extends('layouts.admin')

@section('title', 'Admissions')

@section('content')
<div class="admin-header">
    <h1 style="margin: 0;">Admissions</h1>
    <p style="margin: 0.35rem 0 0; color: #666;">Online applications submitted for Nursery to P.6 are stored here for review.</p>
</div>

<div class="stat-grid" style="margin-bottom: 2rem;">
    <div class="stat-card">
        <div class="num">{{ $stats['primary_total'] }}</div>
        <div>Primary Applications</div>
        @if($stats['primary_unread'] > 0)
            <div style="margin-top: 0.35rem; font-size: 0.85rem; color: var(--red);">{{ $stats['primary_unread'] }} unread</div>
        @endif
    </div>
</div>

@include('admin.admissions.partials.tabs', ['active' => 'overview'])

<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap; margin-bottom: 1rem;">
        <h2 style="margin: 0; font-size: 1.1rem;">Primary School Applications</h2>
        <a href="{{ route('admin.admissions.primary.index') }}">View all primary applications &rarr;</a>
    </div>
    <table class="admin-table">
        <thead>
            <tr><th>Child</th><th>Class</th><th>Arrangement</th><th>Guardian Phone</th><th>Submitted</th><th>Status</th><th></th></tr>
        </thead>
        <tbody>
            @forelse($primaryApplications as $application)
            <tr>
                <td>{{ $application->child_name }}</td>
                <td>{{ $application->class_applying_for }}</td>
                <td>{{ $application->attendance_type }}</td>
                <td>{{ $application->guardian_phone }}</td>
                <td>{{ $application->created_at->format('M j, Y g:i A') }}</td>
                <td>{{ $application->is_read ? 'Read' : 'Unread' }}</td>
                <td><a href="{{ route('admin.admissions.primary.show', $application) }}">View</a></td>
            </tr>
            @empty
            <tr><td colspan="7">No applications have been received yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
