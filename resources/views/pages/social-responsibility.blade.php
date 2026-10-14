@extends('layouts.app')

@section('title', 'Social Responsibility — ' . ($school['school_name'] ?? "Nsangi Parents' Primary School"))

@section('content')
@include('partials.page-hero', [
    'title' => 'Social Responsibility',
    'subtitle' => 'Helping pupils grow into responsible members of the community',
])

<section class="page-content">
    <div class="container">
        <p class="students-intro">At {{ $school['school_name'] ?? "Nsangi Parents' Primary School" }}, social responsibility helps pupils become disciplined, caring, and productive citizens who contribute positively to society.</p>

        <div class="grid-2 student-activity-grid">
            <div class="card student-activity-card">
                @if(!empty($labImage))
                    <div class="student-activity-card__media">
                        <x-school-image
                            :src="$labImage"
                            variant="landscape"
                            label="Pupils learning together"
                            alt="Pupils learning together"
                        />
                    </div>
                @endif
                <div class="feature-card__icon feature-card__icon--green" aria-hidden="true">
                    <x-icons name="flask" />
                </div>
                <h3>Learning Together</h3>
                <p>Our pupils learn through practical activities that build curiosity, teamwork, careful observation, and respect for their school and community.</p>
            </div>

            <div class="card student-activity-card">
                <div class="feature-card__icon feature-card__icon--red" aria-hidden="true">
                    <x-icons name="church" />
                </div>
                <h3>Community Values</h3>
                <p>Pupils take part in activities that nurture respect, kindness, discipline, and a spirit of service to their families, school, and wider community.</p>
            </div>

            <div class="card student-activity-card">
                <div class="feature-card__icon feature-card__icon--green" aria-hidden="true">
                    <x-icons name="heart" />
                </div>
                <h3>Community Outreach</h3>
                <p>Students participate in outreach programmes that support vulnerable members of the community through charity visits, donations, and voluntary service. These activities help learners develop empathy, leadership, and a lifelong commitment to helping others.</p>
            </div>

            <div class="card student-activity-card">
                <div class="feature-card__icon feature-card__icon--red" aria-hidden="true">
                    <x-icons name="compass" />
                </div>
                <h3>Environmental Stewardship</h3>
                <p>Through tree planting, clean-up campaigns, and conservation projects, pupils learn to care for the environment around Nsangi and beyond. We encourage responsibility by promoting cleanliness, sustainability, and respect for the world around us.</p>
            </div>
        </div>
    </div>
</section>
@endsection
