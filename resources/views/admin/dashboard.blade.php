@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="admin-header">
    <h1 style="margin: 0;">Dashboard</h1>
</div>

<div class="stat-grid" style="margin-bottom: 2rem;">
    <div class="stat-card"><div class="num">{{ $stats['posts'] }}</div><div>News Posts</div></div>
    <div class="stat-card"><div class="num">{{ $stats['events'] }}</div><div>Events</div></div>
    <div class="stat-card"><div class="num">{{ $stats['pages'] }}</div><div>Pages</div></div>
    <div class="stat-card"><div class="num">{{ $stats['staff'] }}</div><div>Staff</div></div>
    <div class="stat-card"><div class="num">{{ $stats['gallery'] }}</div><div>Gallery</div></div>
    <div class="stat-card"><div class="num" data-stat="unread-messages">{{ $stats['messages'] }}</div><div>Unread Messages</div></div>
    <div class="stat-card"><div class="num" data-stat="unread-admissions">{{ $stats['s1_admissions'] + $stats['s5_admissions'] + ($stats['continuing_admissions'] ?? 0) + ($stats['primary_admissions'] ?? 0) }}</div><div>Unread Admissions</div></div>
</div>

<div class="admin-card">
    <h2 style="margin-top: 0; font-size: 1.1rem;">Quick Actions</h2>
    <p>
        <a href="{{ route('admin.help') }}" class="btn btn-primary">How-To Guide</a>
        <a href="{{ route('admin.updates.index') }}" class="btn btn-primary">Manage Updates</a>
        <a href="{{ route('admin.admissions.index') }}" class="btn btn-primary">View Admissions</a>
        <a href="{{ route('admin.settings.edit') }}" class="btn btn-outline">Edit Settings</a>
    </p>
</div>
@endsection
