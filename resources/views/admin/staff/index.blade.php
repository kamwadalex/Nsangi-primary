@extends('layouts.admin')

@section('title', 'Staff')

@section('content')
<div class="admin-header">
    <h1 style="margin: 0;">Staff</h1>
</div>

@foreach($categories as $key => $label)
    @php $members = $staffByCategory->get($key, collect()); @endphp
    <div class="admin-card" style="margin-bottom: 1.5rem;">
        <div class="admin-header" style="margin-bottom: 1rem;">
            <h2 style="margin: 0; font-size: 1.1rem;">{{ $label }}</h2>
            <a href="{{ route('admin.staff.create', ['category' => $key]) }}" class="btn btn-primary">Add {{ $label }}</a>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    @if($key === 'teaching')
                        <th>Subjects Taught</th>
                    @else
                        <th>Position</th>
                    @endif
                    @if($key === 'administration')
                        <th>Photo</th>
                    @endif
                    <th>Order</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                <tr>
                    <td>{{ $member->name }}</td>
                    <td>
                        @if($key === 'teaching')
                            {{ $member->subjects_taught ?: '—' }}
                        @else
                            {{ $member->position }}
                        @endif
                    </td>
                    @if($key === 'administration')
                        <td>{{ $member->image ? 'Yes' : 'No' }}</td>
                    @endif
                    <td>{{ $member->sort_order }}</td>
                    <td>
                        <a href="{{ route('admin.staff.edit', $member) }}">Edit</a>
                        <form action="{{ route('admin.staff.destroy', $member) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete?')" style="background:none;border:none;cursor:pointer;color:var(--red);">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ $key === 'administration' ? 5 : 4 }}">No {{ strtolower($label) }} listed yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endforeach
@endsection
