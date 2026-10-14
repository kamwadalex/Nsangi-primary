@extends('layouts.admin')

@section('title', 'Admin How-To Guide')

@section('content')
<div class="admin-header">
    <div>
        <h1 style="margin: 0;">Admin How-To Guide</h1>
        <p style="margin: 0.35rem 0 0; color: #666;">Instructions for editing the public school website and managing day-to-day content.</p>
    </div>
</div>

<div class="admin-card admin-help">
    <nav class="admin-help__toc" aria-label="Guide contents">
        <strong>On this page</strong>
        <ol>
            <li><a href="#getting-started">Getting started</a></li>
            <li><a href="#settings">Settings &amp; site images</a></li>
            <li><a href="#updates">News, events, gallery &amp; programme</a></li>
            <li><a href="#pages">Pages</a></li>
            <li><a href="#people">Staff, about profiles &amp; fees</a></li>
            <li><a href="#sensitive">Sensitive information</a></li>
            <li><a href="#messages-admissions">Messages &amp; admissions</a></li>
            <li><a href="#tips">Tips &amp; best practices</a></li>
        </ol>
    </nav>

    <section id="getting-started" class="admin-help__section">
        <h2>1. Getting started</h2>
        <ul>
            <li>Use the left sidebar to open each admin section.</li>
            <li>Click <strong>View Site</strong> anytime to open the public website in a new tab and check your changes.</li>
            <li>After editing, refresh the public page (Ctrl+F5) if you do not see the update immediately.</li>
            <li>Keep your password private. Change it under <a href="{{ route('admin.settings.edit') }}">Settings</a> (account section) when needed.</li>
        </ul>
    </section>

    <section id="settings" class="admin-help__section">
        <h2>2. Settings &amp; site images</h2>
        <p>Open <a href="{{ route('admin.settings.edit') }}">Settings</a> to edit school identity and main photos.</p>
        <ul>
            <li><strong>School Badge / Logo</strong> — appears in the header, forms, and favicon.</li>
            <li><strong>Hero Welcome Background</strong> — large home-page welcome photo.</li>
            <li><strong>Head Teacher Photo</strong> — shown with the head teacher message on home.</li>
            <li><strong>About / Campus Photo</strong> — used in the school story section.</li>
            <li><strong>Default Page Banner</strong> — banner image on inner pages.</li>
            <li>Also edit school name, motto, phones, email, address, mission, vision, values, school story, anthem, and head teacher message here.</li>
        </ul>
        <p><em>Tip:</em> Prefer clear JPG/PNG photos. Large files are resized automatically when uploaded.</p>
    </section>

    <section id="updates" class="admin-help__section">
        <h2>3. News, events, gallery &amp; programme</h2>
        <p>Open <a href="{{ route('admin.updates.index') }}">Updates</a>, then choose the area you need:</p>
        <ul>
            <li><strong>News</strong> — create posts with title, excerpt, content, optional image, and publish date. Unpublished posts stay hidden from the public site.</li>
            <li><strong>Events</strong> — add upcoming events with date/time, location, and description.</li>
            <li><strong>Gallery</strong> — upload photos shown on the Gallery page and home gallery strip. Use a clear title and sort order.</li>
            <li><strong>School Programme</strong> — add calendar/programme entries for the term (assemblies, meetings, clubs, etc.).</li>
        </ul>
    </section>

    <section id="pages" class="admin-help__section">
        <h2>4. Pages</h2>
        <p>Open <a href="{{ route('admin.pages.index') }}">Pages</a> to edit content pages under Academics and Students.</p>
        <ul>
            <li>Keep the <strong>slug</strong> unchanged unless you know it is safe (some slugs link to special forms such as applications).</li>
            <li>Use <strong>section</strong> (academics / students) so the page appears in the correct menu group.</li>
            <li>Uncheck <strong>Published</strong> to hide a page without deleting it.</li>
        </ul>
    </section>

    <section id="people" class="admin-help__section">
        <h2>5. Staff, about profiles &amp; school fees</h2>
        <ul>
            <li><a href="{{ route('admin.staff.index') }}">Staff</a> — add or edit administration, teaching, and non-teaching staff. Upload a photo and set category/sort order.</li>
            <li><a href="{{ route('admin.about-profiles.index') }}">About Profiles</a> — manage people shown on the About page (head teachers, board, PTA, founders).</li>
            <li><a href="{{ route('admin.school-fees.index') }}">School Fees</a> — update fee rows for day and boarding students. Unpublished rows are hidden from the public fees page.</li>
        </ul>
    </section>

    <section id="sensitive" class="admin-help__section">
        <h2>6. Sensitive information</h2>
        <p>Open <a href="{{ route('admin.sensitive-documents.index') }}">Sensitive Information</a> to manage downloadable files such as holiday work, notes, and circulars.</p>
        <ul>
            <li>Create or choose a <strong>section</strong> (for example Holiday Work or School Circular).</li>
            <li>Upload the document file and write a short description parents/students will understand.</li>
            <li>Only published documents appear for download on the public site.</li>
        </ul>
    </section>

    <section id="messages-admissions" class="admin-help__section">
        <h2>7. Messages &amp; enquiries</h2>
        <ul>
            <li><a href="{{ route('admin.messages.index') }}">Messages</a> — contact form submissions from the website. Unread items show a badge in the sidebar.</li>
            <li>Use the contact messages to respond to parents asking about Nursery to P.6 admission, fees, requirements, and school visits.</li>
        </ul>
    </section>

    <section id="tips" class="admin-help__section">
        <h2>8. Tips &amp; best practices</h2>
        <ul>
            <li><strong>Publish carefully</strong> — draft first, then tick Published when the content is ready.</li>
            <li><strong>Images</strong> — use landscape photos for banners/gallery and portrait photos for people. Avoid very dark or blurry images on the home hero.</li>
            <li><strong>Names &amp; phones</strong> — double-check spelling and contact numbers before saving.</li>
            <li><strong>Admissions enquiries</strong> — check messages regularly during admission periods.</li>
        </ul>
        <p style="margin-top: 1.25rem;">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">Back to Dashboard</a>
            <a href="{{ route('home') }}" class="btn btn-primary" target="_blank" rel="noopener">Open Public Site</a>
        </p>
    </section>
</div>
@endsection
