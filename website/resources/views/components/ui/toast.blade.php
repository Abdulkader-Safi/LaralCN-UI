@props([
    'position' => 'bottom-right',
])

@php
    $anchor = match ($position) {
        'top-right' => 'top-4 right-4',
        'top-left' => 'top-4 left-4',
        'bottom-left' => 'bottom-4 left-4',
        default => 'bottom-4 right-4',
    };

    $regionClasses = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'fixed z-[100] flex flex-col gap-2 w-full max-w-sm',
        $anchor,
        $attributes->get('class'),
    );
@endphp

<div data-ui-toast-region class="{{ $regionClasses }}" role="region"
    aria-live="polite" {{ $attributes->except('class') }}>
    {{-- Cloned once per toast; edit the markup here to restyle them. --}}
    <template data-ui-toast-template>
        <div role="status"
            class="pointer-events-auto flex translate-y-1 items-start gap-3 rounded-lg border bg-background p-4 text-foreground opacity-0 shadow-lg transition-all duration-200 data-[state=visible]:translate-y-0 data-[state=visible]:opacity-100">
            <div class="flex-1">
                <p class="text-sm font-semibold" data-ui-toast-title></p>
                <p class="hidden text-sm text-muted-foreground"
                    data-ui-toast-description></p>
            </div>
            <button type="button"
                class="text-muted-foreground hover:text-foreground"
                aria-label="Dismiss" data-ui-toast-close>&times;</button>
        </div>
    </template>
</div>

@once
    <script>
        (function() {
            function dismiss(toast) {
                toast.dataset.state = 'hidden';
                setTimeout(function() {
                    toast.remove();
                }, 200);
            }

            function show(region, detail) {
                var template = region.querySelector('[data-ui-toast-template]');
                var toast = template.content.firstElementChild.cloneNode(true);

                toast.querySelector('[data-ui-toast-title]').textContent = detail.title || '';

                var description = toast.querySelector('[data-ui-toast-description]');
                description.textContent = detail.description || '';
                description.classList.toggle('hidden', !detail.description);

                region.appendChild(toast);
                requestAnimationFrame(function() {
                    toast.dataset.state = 'visible';
                });

                setTimeout(function() {
                    dismiss(toast);
                }, detail.duration || 4000);
            }

            window.addEventListener('toast', function(event) {
                document.querySelectorAll('[data-ui-toast-region]').forEach(function(region) {
                    show(region, event.detail || {});
                });
            });

            document.addEventListener('click', function(event) {
                var close = event.target.closest('[data-ui-toast-close]');
                if (close) dismiss(close.closest('[role="status"]'));
            });
        })();
    </script>
@endonce
