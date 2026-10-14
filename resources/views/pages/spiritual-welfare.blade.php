@extends('layouts.app')

@section('title', 'Spiritual Welfare — ' . ($school['school_name'] ?? "Nsangi Parents' Primary School"))

@section('content')
@include('partials.page-hero', [
    'title' => 'Spiritual Welfare',
    'subtitle' => 'Nurturing character, respect, and moral responsibility',
])

<section class="page-content">
    <div class="container">
        <p class="students-intro">Character development is at the heart of life at {{ $school['school_name'] ?? "Nsangi Parents' Primary School" }}. We guide pupils to grow in respect, honesty, responsibility, and care for others.</p>

        <div class="grid-2 student-activity-grid">
            <div class="card student-activity-card">
                <div class="feature-card__icon feature-card__icon--green" aria-hidden="true">
                    <x-icons name="star" />
                </div>
                <h3>Daily Prayers</h3>
                <p>Each school day begins and ends with prayer, helping students to seek God’s guidance in their studies, relationships, and personal conduct. Morning assembly prayers and classroom devotions create a calm, focused, and God-centred atmosphere.</p>
            </div>

            <div class="card student-activity-card">
                <div class="feature-card__icon feature-card__icon--red" aria-hidden="true">
                    <x-icons name="church" />
                </div>
                <h3>Character Building</h3>
                <p>School activities help pupils practise honesty, kindness, respect, and responsibility in their daily learning and relationships.</p>
            </div>

            <div class="card student-activity-card">
                <div class="feature-card__icon feature-card__icon--green" aria-hidden="true">
                    <x-icons name="compass" />
                </div>
                <h3>Reflection &amp; Guidance</h3>
                <p>Pupils receive guidance that helps them reflect on their choices, solve problems peacefully, and grow into confident and responsible young people.</p>
            </div>

            <div class="card student-activity-card">
                <div class="feature-card__icon feature-card__icon--red" aria-hidden="true">
                    <x-icons name="users" />
                </div>
                <h3>Religious Movements</h3>
                <p>Pupils take part in age-appropriate values activities, songs, stories, and group discussions that promote kindness, cooperation, respect, and care for others.</p>
            </div>

            <div class="card student-activity-card">
                <div class="feature-card__icon feature-card__icon--green" aria-hidden="true">
                    <x-icons name="award" />
                </div>
                <h3>Moral &amp; Pastoral Guidance</h3>
                <p>The school chaplain and religious teachers offer counselling, sacramental preparation, and moral instruction. Students are guided to uphold integrity, respect, and discipline in line with the school’s mission of forming God-fearing citizens.</p>
            </div>

            <div class="card student-activity-card">
                <div class="feature-card__icon feature-card__icon--red" aria-hidden="true">
                    <x-icons name="heart" />
                </div>
                <h3>Acts of Charity</h3>
                <p>Spiritual welfare is expressed through works of mercy and service to others. Students are encouraged to put faith into action by supporting the needy, visiting the sick, and participating in charitable initiatives guided by Christian love.</p>
            </div>
        </div>
    </div>
</section>
@endsection
