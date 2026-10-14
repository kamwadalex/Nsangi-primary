@if(!empty($school['mission']) || !empty($school['vision']) || !empty($school['core_values']) || !empty($school['motto']))
<div class="grid-2 school-values-grid">
    @if(!empty($school['mission']))
    <x-value-box title="Our Mission" icon="compass" color="green">
        {{ $school['mission'] }}
    </x-value-box>
    @endif
    @if(!empty($school['vision']))
    <x-value-box title="Our Vision" icon="target" color="red">
        {{ $school['vision'] }}
    </x-value-box>
    @endif
    @if(!empty($school['core_values']))
    <x-value-box title="Our Core Values" icon="star" color="green">
        {{ $school['core_values'] }}
    </x-value-box>
    @endif
    @if(!empty($school['motto']))
    <x-value-box title="Our Motto" icon="award" color="red">
        {{ $school['motto'] }}
    </x-value-box>
    @endif
</div>
@endif
