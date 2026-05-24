@props([
    'name' => null,
    'checked' => false,
    'value' => '1',
])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'peer inline-flex h-[1.15rem] w-8 shrink-0 cursor-pointer items-center rounded-full border border-transparent shadow-xs outline-none transition-all focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] disabled:cursor-not-allowed disabled:opacity-50',
        $attributes->get('class'),
    );
@endphp

<button type="button" role="switch" x-data="{ on: @js((bool) $checked) }"
    x-on:click="on = !on" x-bind:aria-checked="on.toString()"
    x-bind:class="on ? 'bg-primary' : 'bg-input dark:bg-input/80'"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    <span
        class="pointer-events-none block size-4 rounded-full bg-background ring-0 transition-transform"
        x-bind:class="on ? 'translate-x-[calc(100%-2px)]' : 'translate-x-0'"></span>
    @if ($name)
        <input type="hidden" :name="on ? @js($name) : ''"
            value="{{ $value }}" />
    @endif
</button>
