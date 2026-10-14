<div class="admin-tabs" style="margin-bottom: 1.5rem;">
    <a href="{{ route('admin.admissions.index') }}" class="admin-tab @if($active === 'overview') active @endif">Overview</a>
    <a href="{{ route('admin.admissions.primary.index') }}" class="admin-tab @if($active === 'primary') active @endif">Primary Applications</a>
</div>
