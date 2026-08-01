@props([
    'open' => true,
])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'group/sidebar-wrapper flex min-h-svh w-full has-data-[variant=inset]:bg-sidebar',
        $attributes->get('class'),
    );
@endphp

<div data-ui-sidebar-provider data-state="{{ $open ? 'expanded' : 'collapsed' }}"
    style="--sidebar-width: 16rem; --sidebar-width-icon: 3rem; --sidebar-width-mobile: 18rem;"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>

@once
    <script>
        (function() {
            // The Blade once-directive above keeps this to a single copy per
            // page, except when a component is rendered into a slot that is
            // echoed twice, the way the sidebar does for its desktop and its
            // mobile panel. Then the markup ships twice and every click would
            // fire the handler twice, so this flag is the real guard.
            if (window.__laralcnSidebar) return;
            window.__laralcnSidebar = true;

            var mobile = window.matchMedia('(max-width: 767px)');

            function sidebars(provider) {
                return provider.querySelectorAll('[data-ui-sidebar]');
            }

            function apply(provider) {
                var expanded = provider.dataset.state === 'expanded';

                sidebars(provider).forEach(function(sidebar) {
                    sidebar.dataset.state = provider.dataset.state;
                    // Children style themselves off data-collapsible, which only
                    // means anything while the sidebar is actually collapsed.
                    sidebar.dataset.collapsible = expanded ? '' : (sidebar.dataset.mode || 'icon');
                });
            }

            function toggle(provider) {
                if (mobile.matches) {
                    var panel = provider.querySelector('[data-ui-sidebar-mobile]');
                    if (!panel) return;

                    if (panel.open) {
                        panel.dataset.state = 'closed';
                        document.documentElement.style.overflow = '';
                        setTimeout(function() {
                            panel.close();
                        }, 300);
                    } else {
                        panel.showModal();
                        document.documentElement.style.overflow = 'hidden';
                        // Flush the closed frame before flipping the state; a
                        // requestAnimationFrame would not fire in a background
                        // tab and the panel would open off-screen.
                        panel.getBoundingClientRect();
                        panel.dataset.state = 'open';
                    }
                    return;
                }

                provider.dataset.state = provider.dataset.state === 'expanded' ? 'collapsed' : 'expanded';
                document.cookie = 'sidebar_state=' + (provider.dataset.state === 'expanded') +
                    '; path=/; max-age=604800';
                apply(provider);
            }

            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('[data-ui-sidebar-provider]').forEach(apply);
            });

            document.addEventListener('click', function(event) {
                var trigger = event.target.closest('[data-ui-sidebar-trigger]');
                if (trigger) {
                    toggle(trigger.closest('[data-ui-sidebar-provider]'));
                    return;
                }

                var backdrop = event.target.closest('[data-ui-sidebar-mobile-close]');
                if (backdrop) toggle(backdrop.closest('[data-ui-sidebar-provider]'));
            });

            document.addEventListener('cancel', function(event) {
                if (!event.target.matches('[data-ui-sidebar-mobile]')) return;
                event.preventDefault();
                toggle(event.target.closest('[data-ui-sidebar-provider]'));
            });

            document.addEventListener('keydown', function(event) {
                if (event.key !== 'b' || !(event.metaKey || event.ctrlKey)) return;

                var provider = document.querySelector('[data-ui-sidebar-provider]');
                if (!provider) return;

                event.preventDefault();
                toggle(provider);
            });
        })();
    </script>
@endonce
