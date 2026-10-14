@extends('layouts.app')

@section('title', 'P.1 Online Application — ' . ($school['school_name'] ?? "Nsangi Parents' Primary School"))

@section('content')
@include('partials.page-hero', [
    'title' => 'P.1 Online Application',
    'subtitle' => 'Nursery to P.6 admissions',
])

<section class="page-content s1-application-page">
    <div class="container">
        <div class="card s1-application-form">
            <header class="s1-application-form__header">
                <h2 class="s1-application-form__school">{{ strtoupper($school['school_name'] ?? "Nsangi Parents' Primary School") }}</h2>
                <p class="s1-application-form__title">ONLINE APPLICATION FORM FOR NURSERY TO P.6</p>
                <div class="s1-application-form__logo">
                    <x-school-image
                        :src="$school['logo'] ?? null"
                        variant="badge"
                        label="School Logo"
                        alt="{{ $school['school_name'] ?? 'School logo' }}"
                    />
                </div>
            </header>

            <form action="{{ route('s1-application.store') }}" method="POST" enctype="multipart/form-data" class="s1-application-form__body" data-clear-on-success>
                @csrf

                <fieldset class="s1-form-section">
                    <legend class="sr-only">Personal Details</legend>
                    <div class="form-grid form-grid--3">
                        <div class="form-group">
                            <label for="surname">Surname <span class="required">*</span></label>
                            <input type="text" id="surname" name="surname" class="form-control" value="{{ old('surname') }}" required>
                            @error('surname')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="first_name">First Name <span class="required">*</span></label>
                            <input type="text" id="first_name" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                            @error('first_name')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="other_names">Other Name(s)</label>
                            <input type="text" id="other_names" name="other_names" class="form-control" value="{{ old('other_names') }}">
                            @error('other_names')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="form-label">Sex <span class="required">*</span></span>
                        <div class="radio-group">
                            <label class="radio-option"><input type="radio" name="sex" value="Male" @checked(old('sex') === 'Male') required> Male</label>
                            <label class="radio-option"><input type="radio" name="sex" value="Female" @checked(old('sex') === 'Female')> Female</label>
                        </div>
                        @error('sex')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-grid form-grid--2">
                        <div class="form-group">
                            <label for="date_of_birth">Date of Birth <span class="required">*</span></label>
                            <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}" required>
                            @error('date_of_birth')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="age">Age <span class="required">*</span></label>
                            <input type="number" id="age" name="age" class="form-control" value="{{ old('age') }}" min="10" max="20" required>
                            @error('age')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="form-label">Religion <span class="required">*</span></span>
                        <div class="radio-group">
                            @foreach(['Catholic', 'Anglican', 'Muslim', 'Others'] as $religion)
                                <label class="radio-option"><input type="radio" name="religion" value="{{ $religion }}" @checked(old('religion') === $religion) required> {{ $religion }}</label>
                            @endforeach
                        </div>
                        @error('religion')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="passport_photo">Upload Passport Photo <span class="required">*</span></label>
                        <input type="file" id="passport_photo" name="passport_photo" class="form-control form-control--file" accept="image/*" required>
                        @error('passport_photo')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </fieldset>

                <fieldset class="s1-form-section">
                    <h3 class="s1-form-section__heading">FORMER SCHOOL WHERE YOU REGISTERED FOR YOUR PLE</h3>
                    <div class="form-grid form-grid--2">
                        <div class="form-group">
                            <label for="former_primary_school">Former Primary School <span class="required">*</span></label>
                            <input type="text" id="former_primary_school" name="former_primary_school" class="form-control" value="{{ old('former_primary_school') }}" required>
                            @error('former_primary_school')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="index_number">Index Number <span class="required">*</span></label>
                            <input type="text" id="index_number" name="index_number" class="form-control" value="{{ old('index_number') }}" required>
                            @error('index_number')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </fieldset>

                <fieldset class="s1-form-section">
                    <h3 class="s1-form-section__heading">PLE RESULTS</h3>
                    <div class="form-grid form-grid--4">
                        @foreach([
                            'ple_english' => 'English',
                            'ple_mathematics' => 'Mathematics',
                            'ple_social_studies' => 'Social Studies',
                            'ple_science' => 'Science',
                        ] as $field => $label)
                        <div class="form-group">
                            <label for="{{ $field }}">{{ $label }} <span class="required">*</span></label>
                            <select id="{{ $field }}" name="{{ $field }}" class="form-control" required>
                                <option value="">Select grade</option>
                                @foreach($pleGrades as $grade)
                                    <option value="{{ $grade }}" @selected(old($field) === $grade)>{{ $grade }}</option>
                                @endforeach
                            </select>
                            @error($field)<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        @endforeach
                    </div>

                    <div class="form-grid form-grid--2">
                        <div class="form-group">
                            <label for="total_aggregates">Total Aggregates <span class="required">*</span></label>
                            <input type="number" id="total_aggregates" name="total_aggregates" class="form-control" value="{{ old('total_aggregates') }}" min="4" max="36" placeholder="Enter aggregates between 4-36 only" required>
                            <p class="field-hint">Enter aggregates between 4-36 only</p>
                            @error('total_aggregates')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <span class="form-label">Division <span class="required">*</span></span>
                            <div class="radio-group">
                                @foreach(['Div 1', 'Div 2', 'Div 3', 'Div 4'] as $div)
                                <label class="radio-option"><input type="radio" name="division" value="{{ $div }}" @checked(old('division') === $div) @if($loop->first) required @endif> {{ $div }}</label>
                                @endforeach
                            </div>
                            @error('division')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="result_slip">Attach a Photocopy of Result Slip <span class="required">*</span></label>
                        <input type="file" id="result_slip" name="result_slip" class="form-control form-control--file" accept="image/*,.pdf" required>
                        @error('result_slip')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </fieldset>

                <fieldset class="s1-form-section">
                    <h3 class="s1-form-section__heading">PLEASE ENTER YOUR CHOICES FOR SECONDARY SCHOOLS</h3>
                    <div class="form-grid form-grid--3">
                        <div class="form-group">
                            <label for="first_choice">1st Choice</label>
                            <input type="text" id="first_choice" name="first_choice" class="form-control" value="{{ old('first_choice') }}">
                            @error('first_choice')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="second_choice">2nd Choice</label>
                            <input type="text" id="second_choice" name="second_choice" class="form-control" value="{{ old('second_choice') }}">
                            @error('second_choice')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="third_choice">3rd Choice</label>
                            <input type="text" id="third_choice" name="third_choice" class="form-control" value="{{ old('third_choice') }}">
                            @error('third_choice')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </fieldset>

                <fieldset class="s1-form-section">
                    <h3 class="s1-form-section__heading">PLEASE ENTER HOBBIES, INTERESTS, PROFESSION</h3>
                    <div class="form-group">
                        <label for="co_curricular_activities">Co-curricular Activities Done <span class="required">*</span></label>
                        <textarea id="co_curricular_activities" name="co_curricular_activities" class="form-control" rows="4" required>{{ old('co_curricular_activities') }}</textarea>
                        @error('co_curricular_activities')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="dream_profession">Dream Profession/Career</label>
                        <input type="text" id="dream_profession" name="dream_profession" class="form-control" value="{{ old('dream_profession') }}">
                        @error('dream_profession')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </fieldset>

                <fieldset class="s1-form-section">
                    <h3 class="s1-form-section__heading">PARENT'S/GUARDIAN'S DETAILS</h3>
                    <div class="form-grid form-grid--2">
                        <div class="form-group">
                            <label for="guardian_name">Parent's/Guardian's Name <span class="required">*</span></label>
                            <input type="text" id="guardian_name" name="guardian_name" class="form-control" value="{{ old('guardian_name') }}" required>
                            @error('guardian_name')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="guardian_phone">Phone Numbers <span class="required">*</span></label>
                            <input type="text" id="guardian_phone" name="guardian_phone" class="form-control" value="{{ old('guardian_phone') }}" required>
                            @error('guardian_phone')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </fieldset>

                <div class="s1-form-notice">
                    <p><strong>NB:</strong> Successful applicants will be contacted.</p>
                    <p>Thank you for showing interest in {{ $school['school_name'] ?? "Nsangi Parents' Primary School" }}@if(!empty($school['motto'])) — &ldquo;{{ $school['motto'] }}&rdquo;@endif</p>
                </div>

                <div class="form-group s1-form-confirm">
                    <label class="checkbox-option">
                        <input type="checkbox" name="confirm" value="1" @checked(old('confirm')) required>
                        <span>Confirm <span class="required">*</span></span>
                    </label>
                    <p class="field-hint">I declare that I have read and understood the guidelines above and accept all terms and conditions.</p>
                    @error('confirm')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <button type="submit" class="btn btn-dark s1-form-submit">Submit</button>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
(function () {
    var dobInput = document.getElementById('date_of_birth');
    var ageInput = document.getElementById('age');

    function updateAge() {
        if (!dobInput.value) return;
        var dob = new Date(dobInput.value + 'T00:00:00');
        var today = new Date();
        var age = today.getFullYear() - dob.getFullYear();
        var monthDiff = today.getMonth() - dob.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            age--;
        }
        if (age >= 0) {
            ageInput.value = age;
        }
    }

    dobInput?.addEventListener('change', updateAge);
    if (dobInput?.value) updateAge();
})();
</script>
@endpush
