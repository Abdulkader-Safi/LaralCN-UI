@props([
    'name' => null,
    'checked' => false,
    'value' => '1',
])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'peer inline-flex h-6 w-11 shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 ring-offset-background',
        $attributes->get('class'),
    );
@endphp

<button type="button" role="switch" x-data="{ on: @js((bool) $checked) }" x-on:click="on = !on"
    x-bind:aria-checked="on.toString()"
    x-bind:class="on ? 'bg-primary' : 'bg-input'"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    <span
        class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform"
        x-bind:class="on ? 'translate-x-5' : 'translate-x-0'"></span>
    @if ($name)
        <input type="hidden" :name="on ? @js($name) : ''"
            value="{{ $value }}" />
    @endif
</button>
