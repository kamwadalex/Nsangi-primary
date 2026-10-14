@props(['staff', 'category' => 'teaching'])

@php
    $thirdColumn = $category === 'teaching' ? 'Subjects Taught' : 'Position';
@endphp

<div class="staff-table-wrap">
    <table class="staff-table">
        <thead>
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Name</th>
                <th scope="col">{{ $thirdColumn }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staff as $index => $member)
            <tr>
                <td data-label="No.">{{ $index + 1 }}</td>
                <td data-label="Name">{{ $member->name }}</td>
                <td data-label="{{ $thirdColumn }}">
                    @if($category === 'teaching')
                        {{ $member->subjects_taught ?: $member->position ?: '—' }}
                    @else
                        {{ $member->position ?: '—' }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
