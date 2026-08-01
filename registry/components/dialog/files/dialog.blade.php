@props([
    'title' => null,
    'description' => null,
])

@php
    // A native dialog element opened with showModal() gives us the top
    // layer (so no
    // ancestor transform or backdrop-filter can clip it), a focus trap, Esc to
    // close and an inert page for free. The script below only handles opening,
    // the exit animation and the scroll lock.
    $id = 'ui-dialog-' . bin2hex(random_bytes(4));

    $overlay = 'absolute inset-0 bg-black/50 opacity-0 transition-opacity duration-200 group-data-[state=open]/dialog:opacity-100';

    $panel = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'absolute left-1/2 top-1/2 grid w-full max-w-[calc(100%-2rem)] -translate-x-1/2 -translate-y-1/2 scale-95 gap-4 rounded-lg border bg-background p-6 opacity-0 shadow-lg transition-all duration-200 group-data-[state=open]/dialog:scale-100 group-data-[state=open]/dialog:opacity-100 sm:max-w-lg',
        $attributes->get('class'),
    );
@endphp

<div data-ui-dialog-trigger aria-controls="{{ $id }}" aria-haspopup="dialog"
    {{ $attributes->except('class') }}>
    {{ $trigger }}
</div>

<dialog id="{{ $id }}" data-ui-dialog data-state="closed"
    class="group/dialog m-0 h-full max-h-none w-full max-w-none bg-transparent p-0 text-foreground backdrop:bg-transparent"
    @if ($title) aria-labelledby="{{ $id }}-title" @endif
    @if ($description) aria-describedby="{{ $id }}-description" @endif>
    <div class="{{ $overlay }}" data-ui-dialog-close></div>

    <div class="{{ $panel }}">
        @if ($title || $description)
            <div class="flex flex-col gap-2 text-center sm:text-left">
                @if ($title)
                    <h2 id="{{ $id }}-title"
                        class="text-lg font-semibold leading-none">
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
            <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                {{ $footer }}
            </div>
        @endisset

        <button type="button" data-ui-dialog-close
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
            if (window.__laralcnDialog) return;
            window.__laralcnDialog = true;

            function open(dialog) {
                // The top layer does not rescue a display:none ancestor, so if
                // the trigger sits inside a responsive wrapper, move the dialog
                // out to the body before showing it.
                if (dialog.parentElement !== document.body) document.body.appendChild(dialog);

                dialog.showModal();
                document.documentElement.style.overflow = 'hidden';
                // Flush the closed frame, then flip the state in the same tick.
                // requestAnimationFrame would not fire in a background tab and
                // the panel would sit open but transformed off-screen.
                dialog.getBoundingClientRect();
                dialog.dataset.state = 'open';
            }

            function close(dialog) {
                if (dialog.dataset.state === 'closed') return;

                dialog.dataset.state = 'closed';
                document.documentElement.style.overflow = '';
                // Let the exit transition play out before leaving the top layer.
                setTimeout(function() {
                    dialog.close();
                }, 200);
            }

            document.addEventListener('click', function(event) {
                var trigger = event.target.closest('[data-ui-dialog-trigger]');
                if (trigger) {
                    var dialog = document.getElementById(trigger.getAttribute('aria-controls'));
                    if (dialog) open(dialog);
                    return;
                }

                var closer = event.target.closest('[data-ui-dialog-close]');
                if (closer) close(closer.closest('[data-ui-dialog]'));
            });

            // Esc: animate out instead of the instant native dismissal.
            document.addEventListener('cancel', function(event) {
                if (!event.target.matches('[data-ui-dialog]')) return;
                event.preventDefault();
                close(event.target);
            });
        })();
    </script>
@endonce
