@extends('layouts.app')

@section('title', 'Contact — ' . ($school['school_name'] ?? "Nsangi Parents' Primary School"))
@section('meta_description', 'Contact ' . ($school['school_name'] ?? "Nsangi Parents' Primary School") . ' in Nsangi. Phone, email, location, and message form.')

@php
    $contactPhones = collect([
        $school['phone'] ?? null,
        $school['phone_2'] ?? null,
        $school['phone_3'] ?? null,
    ])->filter();

    $contactCardCount = collect([
        !empty($school['address']),
        $contactPhones->isNotEmpty(),
        !empty($school['email']),
    ])->filter()->count();
@endphp

@section('content')
@include('partials.page-hero', [
    'title' => 'Contact Us',
    'subtitle' => 'Feel free to contact and reach us!',
])

<section class="page-content contact-page" id="admissions-enquiries">
    <div class="container">
        <h2 class="contact-page__heading">Admissions and General Enquiries</h2>
        <div class="contact-page__grid">
        <div class="contact-page__cards" style="--contact-card-count: {{ max($contactCardCount, 1) }};">
                @if(!empty($school['address']))
                <div class="contact-card contact-card--green">
                    <div class="contact-card__icon contact-card__icon--green" aria-hidden="true">
                        <x-icons name="map" />
                    </div>
                    <div class="contact-card__body">
                        <h3 class="contact-card__title">Location</h3>
                        <p class="contact-card__text">{{ $school['address'] }}</p>
                    </div>
                </div>
                @endif

                @if($contactPhones->isNotEmpty())
                <div class="contact-card contact-card--red">
                    <div class="contact-card__icon contact-card__icon--red" aria-hidden="true">
                        <x-icons name="phone" />
                    </div>
                    <div class="contact-card__body">
                        <h3 class="contact-card__title">Phone</h3>
                        <div class="contact-card__text">
                            @foreach($contactPhones as $phone)
                                <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}">{{ $phone }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                @if(!empty($school['email']))
                <div class="contact-card contact-card--green">
                    <div class="contact-card__icon contact-card__icon--green" aria-hidden="true">
                        <x-icons name="mail" />
                    </div>
                    <div class="contact-card__body">
                        <h3 class="contact-card__title">Email</h3>
                        <p class="contact-card__text">
                            <a href="mailto:{{ $school['email'] }}">{{ $school['email'] }}</a>
                        </p>
                    </div>
                </div>
                @endif
        </div>

        <div class="card contact-page__form">
            <h2 class="contact-page__form-title">Send a Message</h2>
            <form action="{{ route('contact.store') }}" method="POST" data-clear-on-success>
                @csrf
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name')<span style="color: var(--red); font-size: 0.85rem;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email')<span style="color: var(--red); font-size: 0.85rem;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" class="form-control" value="{{ old('subject') }}">
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" class="form-control" required>{{ old('message') }}</textarea>
                    @error('message')<span style="color: var(--red); font-size: 0.85rem;">{{ $message }}</span>@enderror
                </div>
                <button type="submit" class="btn btn-dark">Send Message</button>
            </form>
        </div>
        </div>
    </div>
</section>

@php
    $schoolAddress = $school['address'] ?? 'Nsangi Masaka Rd, P.O.Box 89';
    $mapSchoolQuery = trim(($school['school_name'] ?? "Nsangi Parents' Primary School") . ', ' . $schoolAddress);
    $mapOpenUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($mapSchoolQuery);
@endphp

<section class="contact-map section-alt">
    <div class="container">
        <div class="contact-map__header">
            <h2 class="contact-map__title">School Location</h2>
            <p class="contact-map__address">
                {{ $school['school_name'] ?? "Nsangi Parents' Primary School" }} — {{ $schoolAddress }}
            </p>
        </div>
        <div class="contact-map__embed">
            <iframe
                title="Map showing {{ $school['school_name'] ?? 'school' }} in Nsangi"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63836.30556371967!2d32.416428509956205!3d0.2846058604977058!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x177da22e09aaaaab%3A0xdf007243f849c7c3!2sNsangi%20Parents%20Primary%20School!5e0!3m2!1sen!2sug!4v1792020180474!5m2!1sen!2sug"
                width="600"
                height="450"
                style="border:0;"
                loading="lazy"
                allowfullscreen=""
                referrerpolicy="strict-origin-when-cross-origin"
            ></iframe>
        </div>
        <p class="contact-map__link-wrap">
            <a
                class="contact-map__link"
                href="{{ $mapOpenUrl }}"
                target="_blank"
                rel="noopener noreferrer"
            >Open in Google Maps</a>
        </p>
    </div>
</section>
@endsection
