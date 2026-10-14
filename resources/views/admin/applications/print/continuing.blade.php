@extends('layouts.print-application')

@section('title', ($application ? 'Continuing Application — '.$application->full_name : 'Continuing Student Application Form'))

@section('content')
@php
    $app = $application;
    $val = fn (string $field) => $app?->{$field};
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
            <p>ONLINE APPLICATION FORM FOR CONTINUING / TRANSFER STUDENTS</p>
            @if($app)
                <p class="print-form__meta">Submitted: {{ $app->created_at->format('F j, Y g:i A') }} · Reference #{{ $app->id }}</p>
            @endif
        </div>
        @if($app?->passport_photo && (!empty($pdfEmbedImages) || empty($isPdf)))
            <div class="print-form__photo">
                <img src="{{ \App\Support\StoragePublicPath::url($app->passport_photo, !empty($isPdf)) }}" alt="Passport photo">
            </div>
        @elseif(!$app)
            <div class="print-form__photo print-form__photo--blank">
                <span>Passport Photo</span>
            </div>
        @endif
    </header>

    <section class="print-form__section">
        <h2>Personal Details</h2>
        <div class="print-form__grid print-form__grid--3">
            <x-print-form-field label="Surname" :value="$val('surname')" />
            <x-print-form-field label="First Name" :value="$val('first_name')" />
            <x-print-form-field label="Other Name(s)" :value="$val('other_names')" />
        </div>
        <div class="print-form__grid print-form__grid--3">
            <x-print-form-field label="Sex" :value="$val('sex')" />
            <x-print-form-field label="Date of Birth" :value="$app?->date_of_birth?->format('F j, Y')" />
            <x-print-form-field label="Age" :value="$val('age')" />
        </div>
        <x-print-form-field label="Religion" :value="$val('religion')" />
    </section>

    <section class="print-form__section">
        <h2>Transfer / School Change Details</h2>
        <div class="print-form__grid print-form__grid--2">
            <x-print-form-field label="Class Seeking Admission To" :value="$val('current_class')" />
            <x-print-form-field label="Previous Class" :value="$val('previous_class')" />
        </div>
        <x-print-form-field label="Previous Secondary School" :value="$val('previous_secondary_school')" />
        <div class="print-form__grid print-form__grid--2">
            <x-print-form-field label="Day / Boarding" :value="$val('student_type')" />
            <x-print-form-field label="Index Number" :value="$val('index_number')" />
        </div>
        <x-print-form-field label="Reason for Changing School" :value="$val('reason_for_transfer')" :multiline="true" />
        @if($app?->report_card)
            <p class="print-form__attachment"><strong>Report card attached:</strong> Yes (on file)</p>
        @elseif(!$app)
            <x-print-form-field label="Attach Last Report Card / Academic Record" />
        @endif
    </section>

    <section class="print-form__section">
        <h2>Hobbies, Interests &amp; Profession</h2>
        <x-print-form-field label="Co-curricular Activities Done" :value="$val('co_curricular_activities')" :multiline="true" />
        <x-print-form-field label="Dream Profession/Career" :value="$val('dream_profession')" />
    </section>

    <section class="print-form__section">
        <h2>Parent's/Guardian's Details</h2>
        <div class="print-form__grid print-form__grid--2">
            <x-print-form-field label="Parent's/Guardian's Name" :value="$val('guardian_name')" />
            <x-print-form-field label="Phone Numbers" :value="$val('guardian_phone')" />
        </div>
        <x-print-form-field label="Address" :value="$val('guardian_address')" />
    </section>

    <footer class="print-form__footer">
        <p><strong>NB:</strong> This form is for continuing students already in secondary school who wish to transfer.</p>
        @if(!$app)
            <div class="print-form__signature">
                <span>Applicant / Guardian Signature</span>
                <span>Date</span>
            </div>
        @endif
    </footer>
</article>
@endsection
