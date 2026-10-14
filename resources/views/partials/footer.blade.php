@php
    $contactPhones = collect([
        $school['phone'] ?? null,
        $school['phone_2'] ?? null,
        $school['phone_3'] ?? null,
    ])->filter()->implode(' | ');
@endphp

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <h4>About Us</h4>
                <p>{{ Str::limit($school['tagline'] ?? 'Nsangi Parents\' Primary School — providing quality education from Nursery to P.6.', 160) }}</p>
            </div>
            <div>
                <h4>Explore</h4>
                <ul>
                    <li><a href="{{ route('about') }}#about-school">About the School</a></li>
                    <li><a href="{{ route('academics') }}">Academics</a></li>
                    <li><a href="{{ route('staff.index') }}">School Staff</a></li>
                    <li><a href="{{ route('clubs.index') }}">Clubs &amp; Activities</a></li>
                    <li><a href="{{ route('gallery.index') }}">Gallery</a></li>
                </ul>
            </div>
            <div>
                <h4>Contact Information</h4>
                <ul class="footer-contact">
                    @if(!empty($school['address']))
                        <li class="footer-contact__item">
                            <span class="footer-contact__icon" aria-hidden="true"><x-icons name="map" /></span>
                            <span>{{ $school['address'] }}</span>
                        </li>
                    @endif
                    @if(!empty($school['email']))
                        <li class="footer-contact__item">
                            <span class="footer-contact__icon" aria-hidden="true"><x-icons name="mail" /></span>
                            <a href="mailto:{{ $school['email'] }}">{{ $school['email'] }}</a>
                        </li>
                    @endif
                    @if($contactPhones)
                        <li class="footer-contact__item">
                            <span class="footer-contact__icon" aria-hidden="true"><x-icons name="phone" /></span>
                            <span>{{ $contactPhones }}</span>
                        </li>
                    @endif
                </ul>
            </div>
            <div>
                <h4>Parents</h4>
                <ul>
                    <li><a href="{{ route('academics.school-fees') }}">School Fees</a></li>
                    <li><a href="{{ route('applications.primary.create') }}">Online Application</a></li>
                    <li><a href="{{ route('about') }}#about-school">Day &amp; Boarding</a></li>
                    <li><a href="{{ route('school-programme') }}">School Programme</a></li>
                    <li><a href="{{ route('contact') }}">Contact the School</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} {{ $school['school_name'] ?? "Nsangi Parents' Primary School" }}. All rights reserved.</p>
        </div>
    </div>
</footer>
