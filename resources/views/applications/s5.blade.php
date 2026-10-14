@extends('layouts.app')

@section('title', 'Primary School Application — ' . ($school['school_name'] ?? "Nsangi Parents' Primary School"))

@section('content')
@include('partials.page-hero', [
    'title' => 'Primary School Application',
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

            <form action="{{ route('s5-application.store') }}" method="POST" enctype="multipart/form-data" class="s1-application-form__body" data-clear-on-success>
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
                        <span class="form-label">Gender <span class="required">*</span></span>
                        <div class="radio-group">
                            <label class="radio-option"><input type="radio" name="gender" value="Male" @checked(old('gender') === 'Male') required> Male</label>
                            <label class="radio-option"><input type="radio" name="gender" value="Female" @checked(old('gender') === 'Female')> Female</label>
                        </div>
                        @error('gender')<span class="field-error">{{ $message }}</span>@enderror
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
                        <label for="previous_school">Previous School</label>
                        <input type="text" id="previous_school" name="previous_school" class="form-control" value="{{ old('previous_school') }}">
                        @error('previous_school')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </fieldset>

                <fieldset class="s1-form-section">
                    <h3 class="s1-form-section__heading">UGANDA CERTIFICATE OF EDUCATION (UCE) RESULTS</h3>
                    <div class="form-grid form-grid--3">
                        @foreach([
                            'uce_english' => ['English', true],
                            'uce_mathematics' => ['Mathematics', true],
                            'uce_biology' => ['Biology', true],
                            'uce_chemistry' => ['Chemistry', true],
                            'uce_physics' => ['Physics', true],
                            'uce_history' => ['History and Political Education', true],
                            'uce_geography' => ['Geography', true],
                            'uce_cre' => ['Christian Religious Education', false],
                            'uce_literature' => ['Literature in English', false],
                            'uce_french' => ['French', false],
                            'uce_luganda' => ['Luganda', false],
                            'uce_fine_art' => ['Fine Art', false],
                            'uce_kiswahili' => ['Kiswahili', false],
                            'uce_ict' => ['ICT', false],
                            'uce_entrepreneurship' => ['Entrepreneurship', false],
                            'uce_physical_education' => ['Physical Education', false],
                            'uce_ire' => ['Islamic Religious Education', false],
                            'uce_nutrition' => ['Nutrition and Food Technology', false],
                            'uce_agriculture' => ['Agriculture', false],
                            'uce_technical_drawing' => ['Technical Drawing', false],
                        ] as $field => [$label, $required])
                        <div class="form-group">
                            <label for="{{ $field }}">{{ $label }}@if($required) <span class="required">*</span>@endif</label>
                            <input type="text" id="{{ $field }}" name="{{ $field }}" class="form-control" value="{{ old($field) }}" @if($required) required @endif>
                            @error($field)<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        @endforeach
                    </div>

                    <div class="form-grid form-grid--2">
                        <div class="form-group">
                            <label for="uce_project_work">Project Work <span class="required">*</span></label>
                            <input type="text" id="uce_project_work" name="uce_project_work" class="form-control" value="{{ old('uce_project_work') }}" required>
                            @error('uce_project_work')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <span class="form-label">Result <span class="required">*</span></span>
                            <div class="radio-group">
                                @foreach($uceResults as $result)
                                <label class="radio-option"><input type="radio" name="uce_result" value="{{ $result }}" @checked(old('uce_result') === $result) @if($loop->first) required @endif> {{ $result }}</label>
                                @endforeach
                            </div>
                            @error('uce_result')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-grid form-grid--2">
                        <div class="form-group">
                            <label for="ple_aggregates">PLE Aggregates <span class="required">*</span></label>
                            <input type="text" id="ple_aggregates" name="ple_aggregates" class="form-control" value="{{ old('ple_aggregates') }}" required>
                            @error('ple_aggregates')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <span class="form-label">Division <span class="required">*</span></span>
                            <div class="radio-group">
                                @foreach($divisions as $div)
                                <label class="radio-option"><input type="radio" name="division" value="{{ $div }}" @checked(old('division') === $div) @if($loop->first) required @endif> {{ $div }}</label>
                                @endforeach
                            </div>
                            @error('division')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </fieldset>

                <fieldset class="s1-form-section">
                    <p class="field-hint" style="margin-top: 0;"><strong>NB:</strong> Preferred Combinations — Should have at least obtained a B in the subject</p>
                    <div class="form-group">
                        <label for="preferred_combinations">Preferred Combinations <span class="required">*</span></label>
                        <textarea id="preferred_combinations" name="preferred_combinations" class="form-control" rows="3" required>{{ old('preferred_combinations') }}</textarea>
                        @error('preferred_combinations')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="career_interests">What are your career interests?</label>
                        <textarea id="career_interests" name="career_interests" class="form-control" rows="3">{{ old('career_interests') }}</textarea>
                        @error('career_interests')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="co_curricular_activities">What co-curricular activities do you participate in?</label>
                        <textarea id="co_curricular_activities" name="co_curricular_activities" class="form-control" rows="3">{{ old('co_curricular_activities') }}</textarea>
                        @error('co_curricular_activities')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="former_school_responsibilities">Responsibilities held in former school</label>
                        <textarea id="former_school_responsibilities" name="former_school_responsibilities" class="form-control" rows="3">{{ old('former_school_responsibilities') }}</textarea>
                        @error('former_school_responsibilities')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </fieldset>

                <fieldset class="s1-form-section">
                    <h3 class="s1-form-section__heading">PARENT'S/GUARDIAN'S DETAILS</h3>
                    <div class="form-group">
                        <label for="guardian_name">Parent's/Guardian's Name <span class="required">*</span></label>
                        <input type="text" id="guardian_name" name="guardian_name" class="form-control" value="{{ old('guardian_name') }}" required>
                        @error('guardian_name')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="guardian_address">Address</label>
                        <input type="text" id="guardian_address" name="guardian_address" class="form-control" value="{{ old('guardian_address') }}">
                        @error('guardian_address')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="guardian_phone">Phone Numbers <span class="required">*</span></label>
                        <input type="text" id="guardian_phone" name="guardian_phone" class="form-control" value="{{ old('guardian_phone') }}" required>
                        @error('guardian_phone')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="result_slip">Attach a Photocopy of Result Slip</label>
                        <input type="file" id="result_slip" name="result_slip" class="form-control form-control--file" accept="image/*,.pdf">
                        @error('result_slip')<span class="field-error">{{ $message }}</span>@enderror
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
