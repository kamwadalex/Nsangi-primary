@extends('layouts.admin')

@section('title', 'About Profiles')

@section('content')
<div class="admin-header">
    <h1 style="margin: 0;">About Page Profiles</h1>
</div>

@foreach($categories as $key => $label)
    @php $profiles = $profilesByCategory->get($key, collect()); @endphp
    <div class="admin-card" style="margin-bottom: 1.5rem;">
        <div class="admin-header" style="margin-bottom: 1rem;">
            <h2 style="margin: 0; font-size: 1.1rem;">{{ $label }}</h2>
            <a href="{{ route('admin.about-profiles.create', ['category' => $key]) }}" class="btn btn-primary">Add {{ $label }}</a>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Photo</th>
                    <th>Order</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($profiles as $profile)
                <tr>
                    <td>{{ $profile->name }}</td>
                    <td>{{ $profile->position }}</td>
                    <td>{{ $profile->image ? 'Yes' : 'No' }}</td>
                    <td>{{ $profile->sort_order }}</td>
                    <td>
                        <a href="{{ route('admin.about-profiles.edit', $profile) }}">Edit</a>
                        <form action="{{ route('admin.about-profiles.destroy', $profile) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this profile?')" style="background:none;border:none;cursor:pointer;color:var(--red);">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">No {{ strtolower($label) }} listed yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endforeach
@endsection
