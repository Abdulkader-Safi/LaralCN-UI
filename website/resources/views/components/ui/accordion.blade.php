@props([
    'items' => [],
    'multiple' => false,
])

@php
    $rootClasses = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        '',
        $attributes->get('class'),
    );
@endphp

<div data-ui-accordion @if ($multiple) data-multiple @endif
    class="{{ $rootClasses }}" {{ $attributes->except('class') }}>
    @foreach ($items as $key => $label)
        <div class="border-b last:border-b-0">
            <h3 class="flex">
                <button type="button" data-ui-accordion-trigger
                    data-item="{{ $key }}" aria-expanded="false"
                    class="group/trigger flex flex-1 items-start justify-between gap-4 rounded-md py-4 text-left text-sm font-medium outline-none transition-all hover:underline focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] disabled:pointer-events-none disabled:opacity-50">
                    <span>{{ $label }}</span>
                    <svg class="pointer-events-none size-4 shrink-0 translate-y-0.5 text-muted-foreground transition-transform duration-200 group-aria-expanded/trigger:rotate-180"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        aria-hidden="true">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </button>
            </h3>
            <div data-ui-accordion-content data-item="{{ $key }}"
                class="hidden pb-4 pt-0 text-sm text-muted-foreground">
                {{ ${'item_' . $key} ?? '' }}
            </div>
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
            if (window.__laralcnAccordion) return;
            window.__laralcnAccordion = true;

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

            function toggle(root, key, state) {
                root.querySelectorAll('[data-ui-accordion-trigger]').forEach(
                    function(trigger) {
                        if (trigger.closest('[data-ui-accordion]') !== root)
                            return;

                        var own = trigger.dataset.item === key;
                        var next = own ? state : false;
                        if (!own && root.hasAttribute('data-multiple'))
                            return;
                        if (String(next) === trigger.getAttribute(
                                'aria-expanded')) return;

                        trigger.setAttribute('aria-expanded', String(next));
                        slide(trigger.closest('h3').nextElementSibling,
                            next);
                    });
            }

            document.addEventListener('click', function(event) {
                var trigger = event.target.closest(
                    '[data-ui-accordion-trigger]');
                if (!trigger) return;

                toggle(
                    trigger.closest('[data-ui-accordion]'),
                    trigger.dataset.item,
                    trigger.getAttribute('aria-expanded') !== 'true'
                );
            });
        })
        ();
    </script>
@endonce
