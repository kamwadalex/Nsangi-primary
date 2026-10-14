@extends('layouts.app')

@section('title', 'Continuing Learner Application — ' . ($school['school_name'] ?? "Nsangi Parents' Primary School"))

@section('content')
@include('partials.page-hero', [
    'title' => 'Continuing Learner Application',
    'subtitle' => 'Speak to admissions about transferring to the school',
])

<section class="page-content s1-application-page">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success" style="margin-bottom: 1.5rem;">{{ session('success') }}</div>
        @endif

        <div class="card s1-application-form">
            <header class="s1-application-form__header">
                <h2 class="s1-application-form__school">{{ strtoupper($school['school_name'] ?? "Nsangi Parents' Primary School") }}</h2>
                <p class="s1-application-form__title">ONLINE APPLICATION FORM FOR CONTINUING / TRANSFER STUDENTS</p>
                <p style="margin: 0.5rem 0 0; font-size: 0.95rem;">For learners who have already joined secondary school and wish to change schools.</p>
                <div class="s1-application-form__logo">
                    <x-school-image
                        :src="$school['logo'] ?? null"
                        variant="badge"
                        label="School Logo"
                        alt="{{ $school['school_name'] ?? 'School logo' }}"
                    />
                </div>
            </header>

            <form action="{{ route('continuing-application.store') }}" method="POST" enctype="multipart/form-data" class="s1-application-form__body" data-clear-on-success>
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
                            <input type="number" id="age" name="age" class="form-control" value="{{ old('age') }}" min="10" max="25" required>
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
                    <h3 class="s1-form-section__heading">TRANSFER / SCHOOL CHANGE DETAILS</h3>
                    <div class="form-grid form-grid--2">
                        <div class="form-group">
                            <label for="current_class">Class Seeking Admission To <span class="required">*</span></label>
                            <select id="current_class" name="current_class" class="form-control" required>
                                <option value="">Select class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class }}" @selected(old('current_class') === $class)>{{ $class }}</option>
                                @endforeach
                            </select>
                            @error('current_class')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="previous_class">Current / Last Class at Previous School <span class="required">*</span></label>
                            <select id="previous_class" name="previous_class" class="form-control" required>
                                <option value="">Select class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class }}" @selected(old('previous_class') === $class)>{{ $class }}</option>
                                @endforeach
                            </select>
                            @error('previous_class')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="previous_secondary_school">Previous Secondary School <span class="required">*</span></label>
                        <input type="text" id="previous_secondary_school" name="previous_secondary_school" class="form-control" value="{{ old('previous_secondary_school') }}" required>
                        @error('previous_secondary_school')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-grid form-grid--2">
                        <div class="form-group">
                            <span class="form-label">Day or Boarding <span class="required">*</span></span>
                            <div class="radio-group">
                                @foreach($studentTypes as $type)
                                    <label class="radio-option"><input type="radio" name="student_type" value="{{ $type }}" @checked(old('student_type') === $type) @if($loop->first) required @endif> {{ $type }}</label>
                                @endforeach
                            </div>
                            @error('student_type')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="index_number">Index Number (if any)</label>
                            <input type="text" id="index_number" name="index_number" class="form-control" value="{{ old('index_number') }}">
                            @error('index_number')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="reason_for_transfer">Reason for Changing School <span class="required">*</span></label>
                        <textarea id="reason_for_transfer" name="reason_for_transfer" class="form-control" rows="4" required>{{ old('reason_for_transfer') }}</textarea>
                        @error('reason_for_transfer')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="report_card">Attach Last Report Card / Academic Record <span class="required">*</span></label>
                        <input type="file" id="report_card" name="report_card" class="form-control form-control--file" accept="image/*,.pdf" required>
                        @error('report_card')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </fieldset>

                <fieldset class="s1-form-section">
                    <h3 class="s1-form-section__heading">HOBBIES, INTERESTS &amp; PROFESSION</h3>
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
                    <div class="form-group">
                        <label for="guardian_address">Address</label>
                        <input type="text" id="guardian_address" name="guardian_address" class="form-control" value="{{ old('guardian_address') }}">
                        @error('guardian_address')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </fieldset>

                <div class="s1-form-notice">
                    <p><strong>Note:</strong> Please contact the school to confirm the appropriate application route for your child.</p>
                    <p>Thank you for showing interest in {{ $school['school_name'] ?? "Nsangi Parents' Primary School" }}@if(!empty($school['motto'])) — &ldquo;{{ $school['motto'] }}&rdquo;@endif</p>
                </div>

                <div class="form-group s1-form-confirm">
                    <label class="checkbox-option">
                        <input type="checkbox" name="confirm" value="1" @checked(old('confirm')) required>
                        <span>Confirm <span class="required">*</span></span>
                    </label>
                    <p class="field-hint">I declare that the information provided is true and I accept the school's admission terms.</p>
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
