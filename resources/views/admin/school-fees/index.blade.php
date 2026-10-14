@extends('layouts.admin')

@section('title', 'School Fees')

@section('content')
<div class="admin-header">
    <h1 style="margin: 0;">School Fees</h1>
    <a href="{{ route('admin.school-fees.create') }}" class="btn btn-primary">Add Fee Row</a>
</div>

<div class="admin-card">
    <p style="color: var(--gray); font-size: 0.9rem; margin-top: 0;">These rows appear on the public <strong>School Fees</strong> page under Academics.</p>
    <table class="admin-table" style="margin-top: 1rem;">
        <thead>
            <tr>
                <th>Class</th>
                <th>Item</th>
                <th>Day Students</th>
                <th>Boarding Students</th>
                <th>Order</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($fees as $fee)
            <tr>
                <td>{{ $fee->class }}</td>
                <td>{{ $fee->item }}</td>
                <td>{{ $fee->day_students ?: '—' }}</td>
                <td>{{ $fee->boarding_students ?: '—' }}</td>
                <td>{{ $fee->sort_order }}</td>
                <td>
                    <a href="{{ route('admin.school-fees.edit', $fee) }}">Edit</a>
                    <form action="{{ route('admin.school-fees.destroy', $fee) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this row?')" style="background:none;border:none;cursor:pointer;color:var(--red);">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6">No fee rows yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
