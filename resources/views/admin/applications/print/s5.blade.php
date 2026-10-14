@extends('layouts.print-application')

@section('title', ($application ? 'S.5 Application — '.$application->full_name : 'S.5 Application Form'))

@section('content')
@php
    $app = $application;
    $val = fn (string $field) => $app?->{$field};
    $uceSubjects = [
        'uce_english' => 'English',
        'uce_mathematics' => 'Mathematics',
        'uce_biology' => 'Biology',
        'uce_chemistry' => 'Chemistry',
        'uce_physics' => 'Physics',
        'uce_history' => 'History and Political Education',
        'uce_geography' => 'Geography',
        'uce_cre' => 'Christian Religious Education',
        'uce_literature' => 'Literature in English',
        'uce_french' => 'French',
        'uce_luganda' => 'Luganda',
        'uce_fine_art' => 'Fine Art',
        'uce_kiswahili' => 'Kiswahili',
        'uce_ict' => 'ICT',
        'uce_entrepreneurship' => 'Entrepreneurship',
        'uce_physical_education' => 'Physical Education',
        'uce_ire' => 'Islamic Religious Education',
        'uce_nutrition' => 'Nutrition and Food Technology',
        'uce_agriculture' => 'Agriculture',
        'uce_technical_drawing' => 'Technical Drawing',
    ];
@endphp

<article class="print-form">
    <header class="print-form__header">
        <div class="print-form__logo">
            <x-school-image
                :src="$school['logo'] ?? null"
                variant="badge"
                label="School Logo"
                alt="{{ $school['school_name'] ?? 'School logo' }}"
            />
        </div>
        <div class="print-form__heading">
            <h1>{{ strtoupper($school['school_name'] ?? "Nsangi Parents' Primary School") }}</h1>
            <p>ONLINE APPLICATION FORM FOR ADMISSION TO S5</p>
            @if($app)
                <p class="print-form__meta">Submitted: {{ $app->created_at->format('F j, Y g:i A') }} · Reference #{{ $app->id }}</p>
            @endif
        </div>
    </header>

    <section class="print-form__section">
        <h2>Personal Details</h2>
        <div class="print-form__grid print-form__grid--3">
            <x-print-form-field label="Surname" :value="$val('surname')" />
            <x-print-form-field label="First Name" :value="$val('first_name')" />
            <x-print-form-field label="Other Name(s)" :value="$val('other_names')" />
        </div>
        <div class="print-form__grid print-form__grid--2">
            <x-print-form-field label="Gender" :value="$val('gender')" />
            <x-print-form-field label="Religion" :value="$val('religion')" />
        </div>
        <x-print-form-field label="Previous School" :value="$val('previous_school')" />
    </section>

    <section class="print-form__section">
        <h2>Uganda Certificate of Education (UCE) Results</h2>
        <div class="print-form__grid print-form__grid--3">
            @foreach($uceSubjects as $field => $label)
                <x-print-form-field :label="$label" :value="$val($field)" />
            @endforeach
        </div>
        <div class="print-form__grid print-form__grid--2">
            <x-print-form-field label="Project Work" :value="$val('uce_project_work')" />
            <x-print-form-field label="Result" :value="$val('uce_result')" />
        </div>
        <div class="print-form__grid print-form__grid--2">
            <x-print-form-field label="PLE Aggregates" :value="$val('ple_aggregates')" />
            <x-print-form-field label="Division" :value="$val('division')" />
        </div>
        @if($app?->result_slip)
            <p class="print-form__attachment"><strong>Result slip attached:</strong> Yes (on file)</p>
        @elseif(!$app)
            <x-print-form-field label="Attach a Photocopy of Result Slip" />
        @endif
    </section>

    <section class="print-form__section">
        <h2>Combinations &amp; Interests</h2>
        <p class="print-form__note"><strong>NB:</strong> Preferred Combinations — Should have at least obtained a B in the subject</p>
        <x-print-form-field label="Preferred Combinations" :value="$val('preferred_combinations')" :multiline="true" />
        <x-print-form-field label="Career Interests" :value="$val('career_interests')" :multiline="true" />
        <x-print-form-field label="Co-curricular Activities" :value="$val('co_curricular_activities')" :multiline="true" />
        <x-print-form-field label="Responsibilities Held in Former School" :value="$val('former_school_responsibilities')" :multiline="true" />
    </section>

    <section class="print-form__section">
        <h2>Parent's/Guardian's Details</h2>
        <x-print-form-field label="Parent's/Guardian's Name" :value="$val('guardian_name')" />
        <x-print-form-field label="Address" :value="$val('guardian_address')" />
        <x-print-form-field label="Phone Numbers" :value="$val('guardian_phone')" />
    </section>

    <footer class="print-form__footer">
        <p><strong>NB:</strong> Successful applicants will be contacted.</p>
        @if(!$app)
            <div class="print-form__signature">
                <span>Applicant / Guardian Signature</span>
                <span>Date</span>
            </div>
        @endif
    </footer>
</article>
@endsection
