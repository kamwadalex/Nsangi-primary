@extends('layouts.admin')

@section('title', 'S.5 Applications')

@section('content')
<div class="admin-header"><h1 style="margin: 0;">S.5 Applications</h1></div>

@include('admin.admissions.partials.tabs', ['active' => 's5'])

<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Applicant</th>
                <th>Previous School</th>
                <th>UCE Result</th>
                <th>Division</th>
                <th>Guardian Phone</th>
                <th>Submitted</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $application)
            <tr>
                <td>{{ $application->full_name }}</td>
                <td>{{ $application->previous_school ?: '—' }}</td>
                <td>{{ $application->uce_result }}</td>
                <td>{{ $application->division }}</td>
                <td>{{ $application->guardian_phone }}</td>
                <td>{{ $application->created_at->format('M j, Y g:i A') }}</td>
                <td>{{ $application->is_read ? 'Read' : 'Unread' }}</td>
                <td><a href="{{ route('admin.admissions.s5.show', $application) }}">View</a></td>
            </tr>
            @empty
            <tr><td colspan="8">No S.5 applications yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $applications->links() }}
</div>
@endsection
