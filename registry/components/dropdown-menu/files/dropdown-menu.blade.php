@props([
    'align' => 'start',
])

@php
    $alignment = match ($align) {
        'end' => 'right-0 origin-top-right',
        'center' => 'left-1/2 -translate-x-1/2 origin-top',
        default => 'left-0 origin-top-left',
    };

    $menuClasses = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'absolute z-50 mt-2 hidden min-w-[8rem] overflow-x-hidden overflow-y-auto rounded-md border bg-popover p-1 text-popover-foreground shadow-md',
        $alignment,
        $attributes->get('class'),
    );
@endphp

{{-- `group/dropdown` plus data-state lets whatever you put in the trigger slot
     react to the open state in pure CSS, e.g.
     group-data-[state=open]/dropdown:rotate-180. --}}
<div class="group/dropdown relative inline-block text-left" data-ui-dropdown
    data-state="closed">
    <div data-ui-dropdown-trigger aria-expanded="false" aria-haspopup="menu">
        {{ $trigger }}
    </div>

    <div data-ui-dropdown-menu role="menu" class="{{ $menuClasses }}">
        {{ $slot }}
    </div>
</div>

@once
    <script>
        (function() {
            function setOpen(root, state) {
                root.dataset.state = state ? 'open' : 'closed';
                root.querySelector('[data-ui-dropdown-trigger]')
                    .setAttribute('aria-expanded', String(state));
                root.querySelector('[data-ui-dropdown-menu]')
                    .classList.toggle('hidden', !state);
            }

            function closeAll(except) {
                document.querySelectorAll('[data-ui-dropdown]').forEach(function(root) {
                    if (root !== except) setOpen(root, false);
                });
            }

            document.addEventListener('click', function(event) {
                var trigger = event.target.closest('[data-ui-dropdown-trigger]');

                if (trigger) {
                    var root = trigger.closest('[data-ui-dropdown]');
                    closeAll(root);
                    setOpen(root, root.dataset.state !== 'open');
                    return;
                }

                // A click inside an open menu is a menu item: leave it open and
                // let the item do its job. Anything else closes every menu.
                if (!event.target.closest('[data-ui-dropdown-menu]')) closeAll();
            });

            document.addEventListener('keydown', function(event) {
                if (event.key !== 'Escape') return;

                var root = document.querySelector('[data-ui-dropdown][data-state="open"]');
                if (!root) return;

                setOpen(root, false);
                var trigger = root.querySelector('[data-ui-dropdown-trigger]')
                    .querySelector('button, a, [tabindex]');
                if (trigger) trigger.focus();
            });
        })();
    </script>
@endonce
