<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $school['school_name'] ?? "Nsangi Parents' Primary School")</title>
    @include('partials.seo')
    @include('partials.favicon')
    <script>document.documentElement.classList.add('js-enabled');</script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ @filemtime(public_path('css/app.css')) ?: '1' }}">
    <style>html { scroll-behavior: smooth; }</style>
</head>
<body>
    @include('partials.header')

    <main>
        @if(session('success'))
            <div class="container" style="padding-top: 1rem;">
                <div class="alert alert-success">{{ session('success') }}</div>
            </div>
        @endif

        @yield('content')
    </main>

    @include('partials.footer')

    <dialog class="gallery-lightbox" id="gallery-lightbox" aria-labelledby="gallery-lightbox-caption">
        <img class="gallery-lightbox__image" alt="">
        <p class="gallery-lightbox__caption" id="gallery-lightbox-caption"></p>
        <button type="button" class="gallery-lightbox__close">Close</button>
    </dialog>

    <script>
        (function () {
            var galleryLightbox = document.querySelector('#gallery-lightbox');
            var galleryLightboxImage = galleryLightbox?.querySelector('.gallery-lightbox__image');
            var galleryLightboxCaption = galleryLightbox?.querySelector('.gallery-lightbox__caption');

            document.querySelectorAll('.gallery-item__trigger').forEach(function (trigger) {
                trigger.addEventListener('click', function () {
                    if (!galleryLightbox || !galleryLightboxImage || !galleryLightboxCaption) return;
                    galleryLightboxImage.src = trigger.dataset.galleryImage || '';
                    galleryLightboxImage.alt = trigger.dataset.galleryTitle || 'School gallery photo';
                    galleryLightboxCaption.textContent = trigger.dataset.galleryTitle || '';
                    galleryLightbox.showModal();
                });
            });

            galleryLightbox?.querySelector('.gallery-lightbox__close')?.addEventListener('click', function () {
                galleryLightbox.close();
            });

            galleryLightbox?.addEventListener('click', function (event) {
                if (event.target === galleryLightbox) galleryLightbox.close();
            });

            var revealItems = document.querySelectorAll(
                '.section, .page-content, .page-hero, .about-section, .contact-page__grid, ' +
                '.grid-2 > *, .grid-3 > *, .grid-4 > *, .gallery-item, .post-card, .event-card, ' +
                '.calendar-card, .staff-member-card, .about-profile-card, .value-box, .prefect-card'
            );
            var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            revealItems.forEach(function (item, index) {
                item.classList.add('reveal');
                item.style.transitionDelay = prefersReducedMotion ? '0ms' : Math.min(index % 6, 5) * 55 + 'ms';
            });

            if (prefersReducedMotion || !('IntersectionObserver' in window)) {
                revealItems.forEach(function (item) {
                    item.classList.add('is-visible');
                });
            } else {
                var revealObserver = new IntersectionObserver(function (entries, observer) {
                    entries.forEach(function (entry) {
                        if (!entry.isIntersecting) return;
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    });
                }, { threshold: 0.12, rootMargin: '0px 0px -40px' });

                revealItems.forEach(function (item) {
                    revealObserver.observe(item);
                });
            }

            var toggle = document.querySelector('.nav-toggle');
            var nav = document.querySelector('.main-nav');
            var mq = window.matchMedia('(max-width: 768px)');

            function isMobileNav() {
                return mq.matches;
            }

            function setNavOpen(open) {
                nav?.classList.toggle('open', open);
                toggle?.setAttribute('aria-expanded', open ? 'true' : 'false');
                document.body.classList.toggle('nav-open', open);
            }

            function closeNav() {
                setNavOpen(false);
            }

            function closeDropdowns() {
                document.querySelectorAll('.main-nav .has-dropdown.dropdown-open').forEach(function (item) {
                    item.classList.remove('dropdown-open');
                });
            }

            toggle?.addEventListener('click', function () {
                var open = !nav?.classList.contains('open');
                if (!open) {
                    closeDropdowns();
                }
                setNavOpen(open);
            });

            document.querySelectorAll('.main-nav .has-dropdown > a').forEach(function (link) {
                link.addEventListener('click', function (event) {
                    if (!isMobileNav()) return;

                    var parent = link.parentElement;
                    if (!parent) return;

                    event.preventDefault();

                    var wasOpen = parent.classList.contains('dropdown-open');
                    closeDropdowns();
                    if (!wasOpen) {
                        parent.classList.add('dropdown-open');
                    }
                });
            });

            nav?.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', function () {
                    if (!isMobileNav()) return;
                    if (link.parentElement?.classList.contains('has-dropdown') && link.nextElementSibling?.classList.contains('dropdown')) {
                        return;
                    }
                    closeDropdowns();
                    closeNav();
                });
            });

            document.addEventListener('click', function (event) {
                if (!isMobileNav() || !nav?.classList.contains('open')) return;
                if (event.target.closest('.site-header')) return;
                closeDropdowns();
                closeNav();
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeDropdowns();
                    closeNav();
                }
            });

            mq.addEventListener('change', function () {
                closeDropdowns();
                closeNav();
            });
        })();

        if (window.location.hash) {
            var target = document.querySelector(window.location.hash);
            if (target) {
                requestAnimationFrame(function () {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            }
        }
    </script>
    @stack('scripts')
    <script src="{{ asset('js/form-clear-on-success.js') }}" defer></script>
</body>
</html>
