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

        <div class="application-page__intro prose">
            <p>Complete this form to enquire about admission for your child. A member of the school team will contact you to confirm availability, requirements, and the next steps.</p>
        </div>

        <form action="{{ route('applications.primary.store') }}" method="POST" class="card application-form">
            @csrf
            <div class="form-grid form-grid--2">
                <div class="form-group">
                    <label for="child_name">Child's full name</label>
                    <input id="child_name" name="child_name" class="form-control" value="{{ old('child_name') }}" required>
                    @error('child_name')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="date_of_birth">Child's date of birth</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}" required>
                    @error('date_of_birth')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="class_applying_for">Class applying for</label>
                    <select id="class_applying_for" name="class_applying_for" class="form-control" required>
                        <option value="">Select a class</option>
                        @foreach(['Nursery', 'P.1', 'P.2', 'P.3', 'P.4', 'P.5', 'P.6'] as $class)
                            <option value="{{ $class }}" @selected(old('class_applying_for') === $class)>{{ $class }}</option>
                        @endforeach
                    </select>
                    @error('class_applying_for')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="attendance_type">Preferred arrangement</label>
                    <select id="attendance_type" name="attendance_type" class="form-control" required>
                        <option value="">Select an arrangement</option>
                        <option value="Day" @selected(old('attendance_type') === 'Day')>Day</option>
                        <option value="Boarding" @selected(old('attendance_type') === 'Boarding')>Boarding</option>
                    </select>
                    @error('attendance_type')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="guardian_name">Parent or guardian name</label>
                    <input id="guardian_name" name="guardian_name" class="form-control" value="{{ old('guardian_name') }}" required>
                    @error('guardian_name')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="guardian_phone">Parent or guardian phone</label>
                    <input type="tel" id="guardian_phone" name="guardian_phone" class="form-control" value="{{ old('guardian_phone') }}" required>
                    @error('guardian_phone')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="guardian_email">Parent or guardian email <span class="field-hint">(optional)</span></label>
                    <input type="email" id="guardian_email" name="guardian_email" class="form-control" value="{{ old('guardian_email') }}">
                    @error('guardian_email')<span class="field-error">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="form-group">
                <label for="message">Additional information <span class="field-hint">(optional)</span></label>
                <textarea id="message" name="message" class="form-control" rows="5">{{ old('message') }}</textarea>
                @error('message')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <label class="checkbox-option application-form__confirm">
                <input type="checkbox" name="confirm" value="1" required @checked(old('confirm'))>
                <span>I confirm that the information provided is accurate.</span>
            </label>
            @error('confirm')<span class="field-error">{{ $message }}</span>@enderror
            <button type="submit" class="btn btn-primary">Submit Online Application</button>
        </form>
    </div>
</section>
@endsection
