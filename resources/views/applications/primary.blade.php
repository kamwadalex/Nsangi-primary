@extends('layouts.app')

@section('title', 'Online Application — ' . ($school['school_name'] ?? "Nsangi Parents' Primary School"))
@section('meta_description', 'Submit an online application enquiry for Nursery to P.6 at ' . ($school['school_name'] ?? "Nsangi Parents' Primary School") . '.')

@section('content')
@include('partials.page-hero', [
    'title' => 'Online Application',
    'subtitle' => 'Nursery to P.6 admissions',
])

<section class="page-content application-page">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ request()->getPathInfo() }}" method="POST" class="application-paper">
            @csrf
            <header class="application-paper__header">
                <div class="application-paper__school-mark">
                    <x-school-image :src="$school['logo'] ?? null" variant="badge" label="School badge" alt="{{ $school['school_name'] ?? 'School badge' }}" />
                </div>
                <div>
                    <h2>{{ $school['school_name'] ?? "Nsangi Parents' Primary School" }}</h2>
                    <p>Nursery to P.6 &middot; Mixed Day and Boarding</p>
                    <p class="application-paper__meta">Online admission application form</p>
                </div>
                <div class="application-paper__reference">
                    <span>For office use</span>
                    <i></i>
                    <i></i>
                </div>
            </header>

            <p class="application-paper__instructions">Complete the form clearly. The school will contact the parent or guardian to confirm availability, requirements, and the next steps.</p>

            <section class="application-paper__section">
                <h3>1. Child's details</h3>
                <div class="form-grid form-grid--2">
                <div class="form-group">
                    <label for="child_name">Child's full name</label>
                    <input id="child_name" name="child_name" class="form-control application-paper__input" value="{{ old('child_name') }}" required>
                    @error('child_name')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="date_of_birth">Child's date of birth</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" class="form-control application-paper__input" value="{{ old('date_of_birth') }}" required>
                    @error('date_of_birth')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="class_applying_for">Class applying for</label>
                    <select id="class_applying_for" name="class_applying_for" class="form-control application-paper__input" required>
                        <option value="">Select a class</option>
                        @foreach(['Nursery', 'P.1', 'P.2', 'P.3', 'P.4', 'P.5', 'P.6'] as $class)
                            <option value="{{ $class }}" @selected(old('class_applying_for') === $class)>{{ $class }}</option>
                        @endforeach
                    </select>
                    @error('class_applying_for')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="attendance_type">Preferred arrangement</label>
                    <select id="attendance_type" name="attendance_type" class="form-control application-paper__input" required>
                        <option value="">Select an arrangement</option>
                        <option value="Day" @selected(old('attendance_type') === 'Day')>Day</option>
                        <option value="Boarding" @selected(old('attendance_type') === 'Boarding')>Boarding</option>
                    </select>
                    @error('attendance_type')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                </div>
            </section>

            <section class="application-paper__section">
                <h3>2. Parent or guardian details</h3>
                <div class="form-grid form-grid--2">
                <div class="form-group">
                    <label for="guardian_name">Parent or guardian name</label>
                    <input id="guardian_name" name="guardian_name" class="form-control application-paper__input" value="{{ old('guardian_name') }}" required>
                    @error('guardian_name')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="guardian_phone">Parent or guardian phone</label>
                    <input type="tel" id="guardian_phone" name="guardian_phone" class="form-control application-paper__input" value="{{ old('guardian_phone') }}" required>
                    @error('guardian_phone')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="guardian_email">Parent or guardian email <span class="field-hint">(optional)</span></label>
                    <input type="email" id="guardian_email" name="guardian_email" class="form-control application-paper__input" value="{{ old('guardian_email') }}">
                    @error('guardian_email')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                </div>
            </section>

            <section class="application-paper__section">
                <h3>3. Additional information</h3>
                <div class="form-group">
                    <label for="message">Anything the school should know <span class="field-hint">(optional)</span></label>
                    <textarea id="message" name="message" class="form-control application-paper__input" rows="4">{{ old('message') }}</textarea>
                @error('message')<span class="field-error">{{ $message }}</span>@enderror
                </div>
            </section>

            <label class="checkbox-option application-form__confirm">
                <input type="checkbox" name="confirm" value="1" required @checked(old('confirm'))>
                <span>I confirm that the information provided is accurate.</span>
            </label>
            @error('confirm')<span class="field-error">{{ $message }}</span>@enderror
            <footer class="application-paper__footer">
                <p>Thank you for your interest in {{ $school['school_name'] ?? "Nsangi Parents' Primary School" }}.</p>
                <button type="submit" class="btn btn-primary">Submit Online Application</button>
            </footer>
        </form>
    </div>
</section>
@endsection
