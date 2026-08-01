@props([
    'open' => false,
])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'group/collapsible',
        $attributes->get('class'),
    );
@endphp

<div data-ui-collapsible data-state="{{ $open ? 'open' : 'closed' }}"
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
            if (window.__laralcnCollapsible) return;
            window.__laralcnCollapsible = true;

            var reduce = window.matchMedia('(prefers-reduced-motion: reduce)');

            function slide(el, show) {
                el.getAnimations().forEach(function(a) {
                    a.cancel();
                });
                el.classList.remove('hidden');

                if (reduce.matches) {
                    el.classList.toggle('hidden', !show);
                    return;
                }

                var height = el.scrollHeight;
                el.style.overflow = 'hidden';

                var animation = el.animate([{
                    height: (show ? 0 : height) + 'px',
                    opacity: show ? 0 : 1
                }, {
                    height: (show ? height : 0) + 'px',
                    opacity: show ? 1 : 0
                }], {
                    duration: 200,
                    easing: 'ease-out'
                });

                animation.onfinish = function() {
                    el.style.overflow = '';
                    el.classList.toggle('hidden', !show);
                };
            }

            function own(root, selector) {
                return Array.prototype.filter.call(
                    root.querySelectorAll(selector),
                    function(el) {
                        return el.closest('[data-ui-collapsible]') === root;
                    }
                );
            }

            // Seed each trigger from the state its parent rendered with.
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('[data-ui-collapsible]').forEach(function(root) {
                    own(root, '[data-ui-collapsible-trigger]').forEach(function(trigger) {
                        trigger.setAttribute('aria-expanded', String(root.dataset.state === 'open'));
                    });
                });
            });

            document.addEventListener('click', function(event) {
                var trigger = event.target.closest('[data-ui-collapsible-trigger]');
                if (!trigger) return;

                var root = trigger.closest('[data-ui-collapsible]');
                var open = root.dataset.state !== 'open';

                root.dataset.state = open ? 'open' : 'closed';
                trigger.setAttribute('aria-expanded', String(open));

                own(root, '[data-ui-collapsible-content]').forEach(function(content) {
                    slide(content, open);
                });
            });
        })();
    </script>
@endonce
