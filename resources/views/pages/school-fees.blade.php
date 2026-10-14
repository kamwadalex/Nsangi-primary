@extends('layouts.app')

@section('title', 'School Fees — ' . ($school['school_name'] ?? "Nsangi Parents' Primary School"))

@section('content')
@include('partials.page-hero', ['title' => 'School Fees'])

<section class="page-content">
    <div class="container">
        @if($page?->content)
            <div class="prose" style="margin-bottom: 2rem;">
                <x-plain-text :text="$page->content" />
            </div>
        @endif

        <div class="staff-table-wrap fees-table-wrap">
            <table class="staff-table fees-table">
                <thead>
                    <tr>
                        <th scope="col">Class</th>
                        <th scope="col">Item</th>
                        <th scope="col">Day Students</th>
                        <th scope="col">Boarding Students</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fees as $fee)
                    <tr>
                        <td>{{ $fee->class }}</td>
                        <td>{{ $fee->item }}</td>
                        <td>{{ $fee->day_students ?: '—' }}</td>
                        <td>{{ $fee->boarding_students ?: '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">School fees will be published here soon.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
