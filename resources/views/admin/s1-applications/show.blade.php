@extends('layouts.admin')

@section('title', 'S.1 Application')

@section('content')
<div class="admin-header">
    <h1 style="margin: 0;">S.1 Application — {{ $application->full_name }}</h1>
    <span style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
        <a href="{{ route('admin.admissions.s1.print', $application) }}" class="btn btn-outline" target="_blank" rel="noopener noreferrer">Print</a>
        <a href="{{ route('admin.admissions.s1.download', $application) }}" class="btn btn-primary">Download PDF</a>
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
    <h2>Former School</h2>
    <p><strong>Former Primary School:</strong> {{ $application->former_primary_school }}</p>
    <p><strong>Index Number:</strong> {{ $application->index_number }}</p>

    <hr>
    <h2>PLE Results</h2>
    <p><strong>English:</strong> {{ $application->ple_english }}</p>
    <p><strong>Mathematics:</strong> {{ $application->ple_mathematics }}</p>
    <p><strong>Social Studies:</strong> {{ $application->ple_social_studies }}</p>
    <p><strong>Science:</strong> {{ $application->ple_science }}</p>
    <p><strong>Total Aggregates:</strong> {{ $application->total_aggregates }}</p>
    <p><strong>Division:</strong> {{ $application->division }}</p>
    <p><strong>Result Slip:</strong> <a href="{{ Storage::url($application->result_slip) }}" target="_blank" rel="noopener noreferrer">View file</a></p>

    <hr>
    <h2>Secondary School Choices</h2>
    <p><strong>1st Choice:</strong> {{ $application->first_choice ?: '—' }}</p>
    <p><strong>2nd Choice:</strong> {{ $application->second_choice ?: '—' }}</p>
    <p><strong>3rd Choice:</strong> {{ $application->third_choice ?: '—' }}</p>

    <hr>
    <h2>Hobbies, Interests &amp; Profession</h2>
    <p><strong>Co-curricular Activities:</strong></p>
    <p>{{ $application->co_curricular_activities }}</p>
    @if($application->dream_profession)<p><strong>Dream Profession/Career:</strong> {{ $application->dream_profession }}</p>@endif

    <hr>
    <h2>Parent/Guardian Details</h2>
    <p><strong>Name:</strong> {{ $application->guardian_name }}</p>
    <p><strong>Phone:</strong> {{ $application->guardian_phone }}</p>

    <p><strong>Submitted:</strong> {{ $application->created_at->format('F j, Y g:i A') }}</p>

    <p style="margin-top: 1.5rem;">
        <a href="{{ route('admin.admissions.s1.index') }}">&larr; Back to S.1 Applications</a>
        <span style="margin-left: 1rem;"><a href="{{ route('admin.admissions.index') }}">Admissions overview</a></span>
    </p>
</div>
@endsection
