<div class="admin-tabs" style="margin-bottom: 1.5rem;">
    <a href="{{ route('admin.updates.index') }}" class="admin-tab @if($active === 'overview') active @endif">Overview</a>
    <a href="{{ route('admin.updates.news.index') }}" class="admin-tab @if($active === 'news') active @endif">School News</a>
    <a href="{{ route('admin.updates.events.index') }}" class="admin-tab @if($active === 'events') active @endif">School Events</a>
    <a href="{{ route('admin.updates.gallery.index') }}" class="admin-tab @if($active === 'gallery') active @endif">Gallery</a>
    <a href="{{ route('admin.updates.programme.index') }}" class="admin-tab @if($active === 'programme') active @endif">School Programme</a>
</div>
