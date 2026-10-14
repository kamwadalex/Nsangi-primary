@extends('layouts.admin')

@section('title', 'S.5 Application')

@section('content')
<div class="admin-header">
    <h1 style="margin: 0;">S.5 Application — {{ $application->full_name }}</h1>
    <span style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
        <a href="{{ route('admin.admissions.s5.print', $application) }}" class="btn btn-outline" target="_blank" rel="noopener noreferrer">Print</a>
        <a href="{{ route('admin.admissions.s5.download', $application) }}" class="btn btn-primary">Download PDF</a>
    </span>
</div>
<div class="admin-card">
    <h2 style="margin-top: 0;">Personal Details</h2>
    <p><strong>Surname:</strong> {{ $application->surname }}</p>
    <p><strong>First Name:</strong> {{ $application->first_name }}</p>
    @if($application->other_names)<p><strong>Other Names:</strong> {{ $application->other_names }}</p>@endif
    <p><strong>Gender:</strong> {{ $application->gender }}</p>
    <p><strong>Religion:</strong> {{ $application->religion }}</p>
    @if($application->previous_school)<p><strong>Previous School:</strong> {{ $application->previous_school }}</p>@endif

    <hr>
    <h2>UCE Results</h2>
    <p><strong>English:</strong> {{ $application->uce_english }}</p>
    <p><strong>Mathematics:</strong> {{ $application->uce_mathematics }}</p>
    <p><strong>Biology:</strong> {{ $application->uce_biology }}</p>
    <p><strong>Chemistry:</strong> {{ $application->uce_chemistry }}</p>
    <p><strong>Physics:</strong> {{ $application->uce_physics }}</p>
    <p><strong>History and Political Education:</strong> {{ $application->uce_history }}</p>
    <p><strong>Geography:</strong> {{ $application->uce_geography }}</p>
    @if($application->uce_cre)<p><strong>Christian Religious Education:</strong> {{ $application->uce_cre }}</p>@endif
    @if($application->uce_literature)<p><strong>Literature in English:</strong> {{ $application->uce_literature }}</p>@endif
    @if($application->uce_french)<p><strong>French:</strong> {{ $application->uce_french }}</p>@endif
    @if($application->uce_luganda)<p><strong>Luganda:</strong> {{ $application->uce_luganda }}</p>@endif
    @if($application->uce_fine_art)<p><strong>Fine Art:</strong> {{ $application->uce_fine_art }}</p>@endif
    @if($application->uce_kiswahili)<p><strong>Kiswahili:</strong> {{ $application->uce_kiswahili }}</p>@endif
    @if($application->uce_ict)<p><strong>ICT:</strong> {{ $application->uce_ict }}</p>@endif
    @if($application->uce_entrepreneurship)<p><strong>Entrepreneurship:</strong> {{ $application->uce_entrepreneurship }}</p>@endif
    @if($application->uce_physical_education)<p><strong>Physical Education:</strong> {{ $application->uce_physical_education }}</p>@endif
    @if($application->uce_ire)<p><strong>Islamic Religious Education:</strong> {{ $application->uce_ire }}</p>@endif
    @if($application->uce_nutrition)<p><strong>Nutrition and Food Technology:</strong> {{ $application->uce_nutrition }}</p>@endif
    @if($application->uce_agriculture)<p><strong>Agriculture:</strong> {{ $application->uce_agriculture }}</p>@endif
    @if($application->uce_technical_drawing)<p><strong>Technical Drawing:</strong> {{ $application->uce_technical_drawing }}</p>@endif
    <p><strong>Project Work:</strong> {{ $application->uce_project_work }}</p>
    <p><strong>Result:</strong> {{ $application->uce_result }}</p>
    <p><strong>PLE Aggregates:</strong> {{ $application->ple_aggregates }}</p>
    <p><strong>Division:</strong> {{ $application->division }}</p>

    <hr>
    <h2>Combinations &amp; Interests</h2>
    <p><strong>Preferred Combinations:</strong></p>
    <p>{{ $application->preferred_combinations }}</p>
    @if($application->career_interests)
        <p><strong>Career Interests:</strong></p>
        <p>{{ $application->career_interests }}</p>
    @endif
    @if($application->co_curricular_activities)
        <p><strong>Co-curricular Activities:</strong></p>
        <p>{{ $application->co_curricular_activities }}</p>
    @endif
    @if($application->former_school_responsibilities)
        <p><strong>Responsibilities in Former School:</strong></p>
        <p>{{ $application->former_school_responsibilities }}</p>
    @endif

    <hr>
    <h2>Parent/Guardian Details</h2>
    <p><strong>Name:</strong> {{ $application->guardian_name }}</p>
    @if($application->guardian_address)<p><strong>Address:</strong> {{ $application->guardian_address }}</p>@endif
    <p><strong>Phone:</strong> {{ $application->guardian_phone }}</p>
    @if($application->result_slip)
        <p><strong>Result Slip:</strong> <a href="{{ Storage::url($application->result_slip) }}" target="_blank" rel="noopener noreferrer">View file</a></p>
    @endif

    <p><strong>Submitted:</strong> {{ $application->created_at->format('F j, Y g:i A') }}</p>

    <p style="margin-top: 1.5rem;">
        <a href="{{ route('admin.admissions.s5.index') }}">&larr; Back to S.5 Applications</a>
        <span style="margin-left: 1rem;"><a href="{{ route('admin.admissions.index') }}">Admissions overview</a></span>
    </p>
</div>
@endsection
