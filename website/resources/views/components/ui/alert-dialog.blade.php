@props([
    'title' => null,
    'description' => null,
])

@php
    // Same native dialog element as the dialog component: top layer, focus
    // trap, Esc and an inert page for free. The differences are deliberate,
    // an alert dialog is dismissed by choosing an action, so there is no close
    // button and clicking the overlay does nothing.
    //
    // This cannot borrow the dialog component's script. A copied file has to
    // work on its own (AUTHORING §1), so the handler below is a separate copy
    // under its own data-ui-alert-dialog names and its own guard flag.
    $id = 'ui-alert-dialog-' . bin2hex(random_bytes(4));

    // Not bg-black/50. Tailwind v4 compiles that to oklab(0 0 0 / 0.5), and
    // Chrome does not paint a modern colour function with alpha inside the
    // dialog top layer, so the scrim silently renders as nothing. A legacy
    // rgb() with alpha composites correctly in the same place.
    $overlay = 'absolute inset-0 bg-[rgb(0_0_0/0.5)] opacity-0 transition-opacity duration-200 group-data-[state=open]/alert:opacity-100';

    $panel = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'absolute left-1/2 top-1/2 grid w-full max-w-[calc(100%-2rem)] -translate-x-1/2 -translate-y-1/2 scale-95 gap-4 rounded-lg border bg-background p-6 opacity-0 shadow-lg transition-all duration-200 group-data-[state=open]/alert:scale-100 group-data-[state=open]/alert:opacity-100 sm:max-w-lg',
        $attributes->get('class'),
    );
@endphp

<div data-ui-alert-dialog-trigger aria-controls="{{ $id }}"
    aria-haspopup="dialog" {{ $attributes->except('class') }}>
    {{ $trigger }}
</div>

<dialog id="{{ $id }}" data-ui-alert-dialog data-state="closed"
    role="alertdialog"
    class="group/alert m-0 h-full max-h-none w-full max-w-none bg-transparent p-0 text-foreground backdrop:bg-transparent"
    @if ($title) aria-labelledby="{{ $id }}-title" @endif
    @if ($description) aria-describedby="{{ $id }}-description" @endif>
    {{-- No data-ui-alert-dialog-close here: the overlay is not a dismiss
         target, the footer actions are. --}}
    <div class="{{ $overlay }}"></div>

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
            if (window.__laralcnAlertDialog) return;
            window.__laralcnAlertDialog = true;

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
                var trigger = event.target.closest('[data-ui-alert-dialog-trigger]');
                if (trigger) {
                    var dialog = document.getElementById(trigger.getAttribute('aria-controls'));
                    if (dialog) open(dialog);
                    return;
                }

                var closer = event.target.closest('[data-ui-alert-dialog-close]');
                if (closer) close(closer.closest('[data-ui-alert-dialog]'));
            });

            // Esc: animate out instead of the instant native dismissal.
            document.addEventListener('cancel', function(event) {
                if (!event.target.matches('[data-ui-alert-dialog]')) return;
                event.preventDefault();
                close(event.target);
            });
        })();
    </script>
@endonce
