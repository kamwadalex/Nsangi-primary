@extends('layouts.admin')

@section('title', 'Primary Application')

@section('content')
<div class="admin-header">
    <h1 style="margin: 0;">Primary Application</h1>
    <a href="{{ route('admin.admissions.primary.index') }}">Back to applications</a>
</div>

<div class="admin-card primary-application-details">
    <dl>
        <dt>Child</dt><dd>{{ $application->child_name }}</dd>
        <dt>Date of birth</dt><dd>{{ $application->date_of_birth->format('F j, Y') }}</dd>
        <dt>Class applying for</dt><dd>{{ $application->class_applying_for }}</dd>
        <dt>Preferred arrangement</dt><dd>{{ $application->attendance_type }}</dd>
        <dt>Parent or guardian</dt><dd>{{ $application->guardian_name }}</dd>
        <dt>Phone</dt><dd>{{ $application->guardian_phone }}</dd>
        @if($application->guardian_email)<dt>Email</dt><dd>{{ $application->guardian_email }}</dd>@endif
        @if($application->message)<dt>Additional information</dt><dd>{{ $application->message }}</dd>@endif
        <dt>Submitted</dt><dd>{{ $application->created_at->format('F j, Y g:i A') }}</dd>
    </dl>
</div>
@endsection
