@props([
    'multiple' => false,
    'name' => 'toggle-group',
    'variant' => 'default',
    'size' => 'md',
])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'flex w-fit items-center rounded-md',
        $variant === 'outline' ? 'shadow-xs' : '',
        $attributes->get('class'),
    );
@endphp

{{-- variant, size, multiple and name are read by the items through @aware.
     Note the Laravel caveat: @aware only sees attributes actually passed to
     this tag, never its defaults, so every default here is repeated as the
     fallback in item.blade.php. Keep the two lists in step. --}}
<div role="group"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
