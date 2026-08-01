@props([
    'tabs' => [],
    'default' => null,
])

@php
    $active = $default ?? array_key_first($tabs);

    $listClasses = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'inline-flex h-9 w-fit items-center justify-center rounded-lg bg-muted p-[3px] text-muted-foreground',
        $attributes->get('class'),
    );

    $tabClasses =
        'inline-flex h-[calc(100%-1px)] flex-1 items-center justify-center gap-1.5 whitespace-nowrap rounded-md border border-transparent px-2 py-1 text-sm font-medium transition-[color,box-shadow] aria-selected:bg-background aria-selected:text-foreground aria-selected:shadow-sm focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50';
@endphp

<div data-ui-tabs class="flex flex-col gap-2" {{ $attributes->except('class') }}>
    <div role="tablist" class="{{ $listClasses }}">
        @foreach ($tabs as $key => $label)
            <button type="button" role="tab" data-ui-tab
                data-tab="{{ $key }}"
                aria-selected="{{ $key === $active ? 'true' : 'false' }}"
                tabindex="{{ $key === $active ? '0' : '-1' }}"
                class="{{ $tabClasses }}">
                {{ $label }}
            </button>
        @endforeach
    </div>

    @foreach ($tabs as $key => $label)
        <div role="tabpanel" data-ui-tabpanel data-tab="{{ $key }}"
            class="flex-1 outline-none {{ $key === $active ? '' : 'hidden' }}">
            {{ ${'tab_' . $key} ?? '' }}
        </div>
    @endforeach
</div>

@once
    <script>
        (function() {
            // The Blade once-directive above keeps this to a single copy per
            // page, except when a component is rendered into a slot that is
            // echoed twice, the way the sidebar does for its desktop and its
            // mobile panel. Then the markup ships twice and every click would
            // fire the handler twice, so this flag is the real guard.
            if (window.__laralcnTabs) return;
            window.__laralcnTabs = true;

            function select(root, key, focus) {
                root.querySelectorAll('[data-ui-tab]').forEach(function(tab) {
                    var current = tab.dataset.tab === key;
                    tab.setAttribute('aria-selected', String(current));
                    tab.tabIndex = current ? 0 : -1;
                    if (current && focus) tab.focus();
                });

                root.querySelectorAll('[data-ui-tabpanel]').forEach(function(panel) {
                    panel.classList.toggle('hidden', panel.dataset.tab !== key);
                });
            }

            document.addEventListener('click', function(event) {
                var tab = event.target.closest('[data-ui-tab]');
                if (tab) select(tab.closest('[data-ui-tabs]'), tab.dataset.tab);
            });

            // Arrow keys move between tabs, Home/End jump to the ends.
            document.addEventListener('keydown', function(event) {
                var tab = event.target.closest('[data-ui-tab]');
                if (!tab) return;

                var root = tab.closest('[data-ui-tabs]');
                var tabs = Array.prototype.slice.call(root.querySelectorAll('[data-ui-tab]'));
                var index = tabs.indexOf(tab);
                var next;

                if (event.key === 'ArrowRight') next = (index + 1) % tabs.length;
                else if (event.key === 'ArrowLeft') next = (index - 1 + tabs.length) % tabs.length;
                else if (event.key === 'Home') next = 0;
                else if (event.key === 'End') next = tabs.length - 1;
                else return;

                event.preventDefault();
                select(root, tabs[next].dataset.tab, true);
            });
        })();
    </script>
@endonce
