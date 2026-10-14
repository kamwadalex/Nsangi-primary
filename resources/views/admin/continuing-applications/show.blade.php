@extends('layouts.admin')

@section('title', 'Continuing Application')

@section('content')
<div class="admin-header">
    <h1 style="margin: 0;">Continuing Application — {{ $application->full_name }}</h1>
    <span style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
        <a href="{{ route('admin.admissions.continuing.print', $application) }}" class="btn btn-outline" target="_blank" rel="noopener noreferrer">Print</a>
        <a href="{{ route('admin.admissions.continuing.download', $application) }}" class="btn btn-primary">Download PDF</a>
    </span>
</div>
<div class="admin-card">
    <h2 style="margin-top: 0;">Personal Details</h2>
    <p><strong>Surname:</strong> {{ $application->surname }}</p>
    <p><strong>First Name:</strong> {{ $application->first_name }}</p>
    @if($application->other_names)<p><strong>Other Names:</strong> {{ $application->other_names }}</p>@endif
    <p><strong>Sex:</strong> {{ $application->sex }}</p>
    <p><strong>Date of Birth:</strong> {{ $application->date_of_birth->format('F j, Y') }}</p>
    <p><strong>Age:</strong> {{ $application->age }}</p>
    <p><strong>Religion:</strong> {{ $application->religion }}</p>
    <p><strong>Passport Photo:</strong> <a href="{{ Storage::url($application->passport_photo) }}" target="_blank" rel="noopener noreferrer">View file</a></p>

    <hr>
    <h2>Transfer Details</h2>
    <p><strong>Class Seeking Admission To:</strong> {{ $application->current_class }}</p>
    <p><strong>Previous Class:</strong> {{ $application->previous_class }}</p>
    <p><strong>Previous Secondary School:</strong> {{ $application->previous_secondary_school }}</p>
    <p><strong>Day / Boarding:</strong> {{ $application->student_type }}</p>
    <p><strong>Index Number:</strong> {{ $application->index_number ?: '—' }}</p>
    <p><strong>Reason for Transfer:</strong></p>
    <p>{{ $application->reason_for_transfer }}</p>
    <p><strong>Report Card / Academic Record:</strong> <a href="{{ Storage::url($application->report_card) }}" target="_blank" rel="noopener noreferrer">View file</a></p>

    <hr>
    <h2>Hobbies, Interests &amp; Profession</h2>
    <p><strong>Co-curricular Activities:</strong></p>
    <p>{{ $application->co_curricular_activities }}</p>
    @if($application->dream_profession)<p><strong>Dream Profession/Career:</strong> {{ $application->dream_profession }}</p>@endif

    <hr>
    <h2>Parent/Guardian Details</h2>
    <p><strong>Name:</strong> {{ $application->guardian_name }}</p>
    <p><strong>Phone:</strong> {{ $application->guardian_phone }}</p>
    <p><strong>Address:</strong> {{ $application->guardian_address ?: '—' }}</p>

    <p><strong>Submitted:</strong> {{ $application->created_at->format('F j, Y g:i A') }}</p>

    <p style="margin-top: 1.5rem;">
        <a href="{{ route('admin.admissions.continuing.index') }}">&larr; Back to Continuing Applications</a>
        <span style="margin-left: 1rem;"><a href="{{ route('admin.admissions.index') }}">Admissions overview</a></span>
    </p>
</div>
@endsection
