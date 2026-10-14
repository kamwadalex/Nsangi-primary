@extends('layouts.admin')

@section('title', $fee->exists ? 'Edit Fee Row' : 'Add Fee Row')

@section('content')
<div class="admin-header">
    <h1 style="margin: 0;">{{ $fee->exists ? 'Edit Fee Row' : 'Add Fee Row' }}</h1>
</div>

<div class="admin-card">
    <form action="{{ $fee->exists ? route('admin.school-fees.update', $fee) : route('admin.school-fees.store') }}" method="POST">
        @csrf
        @if($fee->exists) @method('PUT') @endif

        <div class="form-group">
            <label for="class">Class</label>
            <input type="text" id="class" name="class" class="form-control" value="{{ old('class', $fee->class) }}" required placeholder="e.g. Nursery, P.1, P.2">
        </div>
        <div class="form-group">
            <label for="item">Item</label>
            <input type="text" id="item" name="item" class="form-control" value="{{ old('item', $fee->item) }}" required placeholder="e.g. Tuition, Development Fee">
        </div>
        <div class="form-group">
            <label for="day_students">Day Students</label>
            <input type="text" id="day_students" name="day_students" class="form-control" value="{{ old('day_students', $fee->day_students) }}" placeholder="e.g. UGX 500,000">
        </div>
        <div class="form-group">
            <label for="boarding_students">Boarding Students</label>
            <input type="text" id="boarding_students" name="boarding_students" class="form-control" value="{{ old('boarding_students', $fee->boarding_students) }}" placeholder="e.g. UGX 900,000">
        </div>
        <div class="form-group">
            <label for="sort_order">Sort Order</label>
            <input type="number" id="sort_order" name="sort_order" class="form-control" value="{{ old('sort_order', $fee->sort_order ?? 0) }}" min="0">
        </div>
        <div class="form-group">
            <label><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $fee->is_published ?? true))> Published</label>
        </div>
        <button type="submit" class="btn btn-dark">Save</button>
        <a href="{{ route('admin.school-fees.index') }}">Cancel</a>
    </form>
</div>
@endsection
