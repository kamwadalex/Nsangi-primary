@extends('layouts.admin')

@section('title', 'Primary Applications')

@section('content')
<div class="admin-header">
    <h1 style="margin: 0;">Primary Applications</h1>
</div>

@include('admin.admissions.partials.tabs', ['active' => 'primary'])

<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr><th>Child</th><th>Class</th><th>Arrangement</th><th>Guardian</th><th>Phone</th><th>Submitted</th><th>Status</th><th></th></tr>
        </thead>
        <tbody>
            @forelse($applications as $application)
            <tr>
                <td>{{ $application->child_name }}</td>
                <td>{{ $application->class_applying_for }}</td>
                <td>{{ $application->attendance_type }}</td>
                <td>{{ $application->guardian_name }}</td>
                <td>{{ $application->guardian_phone }}</td>
                <td>{{ $application->created_at->format('M j, Y g:i A') }}</td>
                <td>{{ $application->is_read ? 'Read' : 'Unread' }}</td>
                <td><a href="{{ route('admin.admissions.primary.show', $application) }}">View</a></td>
            </tr>
            @empty
            <tr><td colspan="8">No primary applications received.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination">{{ $applications->links() }}</div>
</div>
@endsection
