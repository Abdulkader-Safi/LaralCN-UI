@props([
    'side' => 'right',
    'title' => null,
    'description' => null,
])

@php
    // Same approach as the dialog component: a native dialog element in
    // the top layer, so a
    // sheet triggered from inside a sticky, backdrop-blurred header still
    // covers the viewport instead of being trapped by that ancestor.
    $id = 'ui-sheet-' . bin2hex(random_bytes(4));

    // shadcn SheetContent per-side positioning, size and border.
    $sideClasses = match ($side) {
        'top' => 'inset-x-0 top-0 h-auto border-b',
        'bottom' => 'inset-x-0 bottom-0 h-auto border-t',
        'left' => 'inset-y-0 left-0 h-full w-3/4 border-r sm:max-w-sm',
        default => 'inset-y-0 right-0 h-full w-3/4 border-l sm:max-w-sm',
    };

    // Where the panel sits while closed; it slides to 0 when open.
    $offscreen = match ($side) {
        'top' => '-translate-y-full group-data-[state=open]/sheet:translate-y-0',
        'bottom' => 'translate-y-full group-data-[state=open]/sheet:translate-y-0',
        'left' => '-translate-x-full group-data-[state=open]/sheet:translate-x-0',
        default => 'translate-x-full group-data-[state=open]/sheet:translate-x-0',
    };

    $overlay = 'absolute inset-0 bg-black/50 opacity-0 transition-opacity duration-300 group-data-[state=open]/sheet:opacity-100';

    $panel = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'absolute flex flex-col gap-4 bg-background shadow-lg transition-transform duration-300 ease-in-out',
        $sideClasses,
        $offscreen,
        $attributes->get('class'),
    );
@endphp

<div data-ui-sheet-trigger aria-controls="{{ $id }}" aria-haspopup="dialog"
    {{ $attributes->except('class') }}>
    {{ $trigger }}
</div>

<dialog id="{{ $id }}" data-ui-sheet data-state="closed"
    class="group/sheet m-0 h-full max-h-none w-full max-w-none bg-transparent p-0 text-foreground backdrop:bg-transparent"
    @if ($title) aria-labelledby="{{ $id }}-title" @endif
    @if ($description) aria-describedby="{{ $id }}-description" @endif>
    <div class="{{ $overlay }}" data-ui-sheet-close></div>

    <div class="{{ $panel }}">
        @if ($title || $description)
            <div class="flex flex-col gap-1.5 p-4">
                @if ($title)
                    <h2 id="{{ $id }}-title"
                        class="font-semibold text-foreground">
                        {{ $title }}
                    </h2>
                @endif
                @if ($description)
                    <p id="{{ $id }}-description"
                        class="text-sm text-muted-foreground">
                        {{ $description }}
                    </p>
                @endif
            </div>
        @endif

        {{ $slot }}

        @isset($footer)
            <div class="mt-auto flex flex-col gap-2 p-4">
                {{ $footer }}
            </div>
        @endisset

        <button type="button" data-ui-sheet-close
            class="absolute right-4 top-4 rounded-xs opacity-70 outline-none transition-opacity hover:opacity-100 focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] disabled:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0"
            aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                aria-hidden="true">
                <path d="M18 6 6 18" />
                <path d="m6 6 12 12" />
            </svg>
        </button>
    </div>
</dialog>

@once
    <script>
        (function() {
            // The Blade once-directive above keeps this to a single copy per
            // page, except when a component is rendered into a slot that is
            // echoed twice, the way the sidebar does for its desktop and its
            // mobile panel. Then the markup ships twice and every click would
            // fire the handler twice, so this flag is the real guard.
            if (window.__laralcnSheet) return;
            window.__laralcnSheet = true;

            function open(sheet) {
                // The top layer does not rescue a display:none ancestor, and a
                // sheet is usually triggered from inside one (a `lg:hidden`
                // mobile wrapper), so move it to the body first.
                if (sheet.parentElement !== document.body) document.body.appendChild(sheet);

                sheet.showModal();
                document.documentElement.style.overflow = 'hidden';
                // Flush the closed frame, then flip the state in the same tick.
                // requestAnimationFrame would not fire in a background tab and
                // the panel would sit open but transformed off-screen.
                sheet.getBoundingClientRect();
                sheet.dataset.state = 'open';
            }

            function close(sheet) {
                if (sheet.dataset.state === 'closed') return;

                sheet.dataset.state = 'closed';
                document.documentElement.style.overflow = '';
                // Let the slide-out finish before leaving the top layer.
                setTimeout(function() {
                    sheet.close();
                }, 300);
            }

            document.addEventListener('click', function(event) {
                var trigger = event.target.closest('[data-ui-sheet-trigger]');
                if (trigger) {
                    var sheet = document.getElementById(trigger.getAttribute('aria-controls'));
                    if (sheet) open(sheet);
                    return;
                }

                var closer = event.target.closest('[data-ui-sheet-close]');
                if (closer) close(closer.closest('[data-ui-sheet]'));
            });

            // Esc: animate out instead of the instant native dismissal.
            document.addEventListener('cancel', function(event) {
                if (!event.target.matches('[data-ui-sheet]')) return;
                event.preventDefault();
                close(event.target);
            });
        })();
    </script>
@endonce
