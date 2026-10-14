@php
    $topBarContacts = array_values(array_filter([
        !empty($school['phone']) ? [
            'icon' => 'phone',
            'href' => 'tel:'.preg_replace('/\s+/', '', $school['phone']),
            'label' => $school['phone'],
        ] : null,
        !empty($school['email']) ? [
            'icon' => 'mail',
            'href' => 'mailto:'.$school['email'],
            'label' => $school['email'],
        ] : null,
        !empty($school['address']) ? [
            'icon' => 'map',
            'href' => null,
            'label' => $school['address'],
        ] : null,
    ]));
@endphp

<div class="top-bar">
    <div class="container top-bar__desktop">
        <div class="top-bar__grid">
            @if(!empty($school['phone']))
            <div class="top-bar__item top-bar__item--start">
                <span class="top-bar__icon" aria-hidden="true"><x-icons name="phone" /></span>
                <a href="tel:{{ preg_replace('/\s+/', '', $school['phone']) }}">{{ $school['phone'] }}</a>
            </div>
            @else
            <div class="top-bar__item top-bar__item--start"></div>
            @endif

            @if(!empty($school['email']))
            <div class="top-bar__item top-bar__item--center">
                <span class="top-bar__icon" aria-hidden="true"><x-icons name="mail" /></span>
                <a href="mailto:{{ $school['email'] }}">{{ $school['email'] }}</a>
            </div>
            @endif

            @if(!empty($school['address']))
            <div class="top-bar__item top-bar__item--end">
                <span class="top-bar__icon" aria-hidden="true"><x-icons name="map" /></span>
                <span>{{ $school['address'] }}</span>
            </div>
            @endif
        </div>
    </div>

    @if(count($topBarContacts))
    <div class="top-bar__ticker" aria-label="School contact information">
        <div class="top-bar__ticker-viewport">
            <div class="top-bar__ticker-track">
                @for ($copy = 0; $copy < 2; $copy++)
                <div class="top-bar__ticker-set" @if($copy > 0) aria-hidden="true" @endif>
                    @foreach($topBarContacts as $contact)
                    <span class="top-bar__ticker-item">
                        <span class="top-bar__icon" aria-hidden="true"><x-icons :name="$contact['icon']" /></span>
                        @if($contact['href'])
                            <a href="{{ $contact['href'] }}">{{ $contact['label'] }}</a>
                        @else
                            <span>{{ $contact['label'] }}</span>
                        @endif
                    </span>
                    @if(!$loop->last)
                        <span class="top-bar__ticker-sep" aria-hidden="true">•</span>
                    @endif
                    @endforeach
                </div>
                @endfor
            </div>
        </div>
    </div>
    @endif
</div>

<header class="site-header">
    <div class="container header-inner">
        <a href="{{ route('home') }}" class="logo-block">
            <x-school-image
                :src="$school['logo'] ?? null"
                variant="badge"
                label="School Badge"
                alt="{{ $school['school_name'] ?? 'School logo' }}"
            />
            <div>
                <h1>{{ $school['school_name'] ?? "Nsangi Parents' Primary School" }}</h1>
                @if(!empty($school['motto']))
                    <p class="motto">{{ $school['motto'] }}</p>
                @endif
            </div>
        </a>

        <button class="nav-toggle" type="button" aria-label="Toggle menu" aria-expanded="false">
            <span class="nav-toggle__icon" aria-hidden="true">
                <span></span>
                <span></span>
                <span></span>
            </span>
            <span class="nav-toggle__label">Menu</span>
        </button>

        <nav class="main-nav" aria-label="Main navigation">
            <ul>
                <li><a href="{{ route('home') }}" @if(request()->routeIs('home')) class="active" @endif>Home</a></li>
                <li class="has-dropdown">
                    <a href="{{ route('about') }}" @if(request()->routeIs('about') || request()->routeIs('staff.*')) class="active" @endif>About</a>
                    <ul class="dropdown">
                        <li><a href="{{ route('about') }}#about-school">About the School</a></li>
                        <li><a href="{{ route('staff.index') }}#staff-content">Staff</a></li>
                        <li><a href="{{ route('about') }}#our-values">Mission &amp; Vision</a></li>
                    </ul>
                </li>
                <li class="has-dropdown">
                    <a href="{{ route('contact') }}#admissions-enquiries">Admissions</a>
                    <ul class="dropdown">
                        <li><a href="{{ route('academics.school-fees') }}">School Fees</a></li>
                        <li><a href="{{ route('applications.primary.create') }}">Online Application</a></li>
                        <li><a href="{{ route('about') }}#about-school">Boarding/Day Information</a></li>
                        <li><a href="{{ route('contact') }}#admissions-enquiries">Contact Admissions</a></li>
                    </ul>
                </li>
                <li class="has-dropdown">
                    <a href="{{ route('academics') }}" @if(request()->routeIs('academics')) class="active" @endif>Academics</a>
                    <ul class="dropdown">
                        <li><a href="{{ route('academics.school-fees') }}">School Fees</a></li>
                        <li><a href="{{ route('pages.show', 'school-curriculum') }}">School Curriculum</a></li>
                        <li><a href="{{ route('pages.show', 'co-curricular-activities') }}">Co-curricular Activities</a></li>
                        <li><a href="{{ route('academics.sensitive-information') }}">School Documents</a></li>
                    </ul>
                </li>
                <li class="has-dropdown">
                    <a href="{{ route('students') }}" @if(request()->routeIs('students') || request()->routeIs('prefects.*') || request()->routeIs('clubs.*')) class="active" @endif>Student Life</a>
                    <ul class="dropdown">
                        <li><a href="{{ route('staff.index') }}">School Leadership</a></li>
                        <li><a href="{{ route('clubs.index') }}">Clubs</a></li>
                        <li><a href="{{ route('prefects.index') }}">Prefects</a></li>
                        <li><a href="{{ route('pages.show', 'social-responsibility') }}">Social Responsibility</a></li>
                        <li><a href="{{ route('pages.show', 'spiritual-welfare') }}">Spiritual Welfare</a></li>
                    </ul>
                </li>
                <li class="has-dropdown">
                    <a href="{{ route('news.index') }}" @if(request()->routeIs('news.*') || request()->routeIs('events.*') || request()->routeIs('gallery.*') || request()->routeIs('school-programme')) class="active" @endif>News &amp; Events</a>
                    <ul class="dropdown">
                        <li><a href="{{ route('gallery.index') }}">Gallery</a></li>
                        <li><a href="{{ route('news.index') }}">School News</a></li>
                        <li><a href="{{ route('events.index') }}">School Events</a></li>
                        <li><a href="{{ route('school-programme') }}">School Programme</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('contact') }}" @if(request()->routeIs('contact')) class="active" @endif>Contact</a></li>
            </ul>
        </nav>
    </div>
</header>
