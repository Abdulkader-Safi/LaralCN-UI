@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'relative',
        $attributes->get('class'),
    );

    $arrow =
        'absolute top-1/2 z-10 flex size-8 -translate-y-1/2 items-center justify-center rounded-full border border-input bg-background shadow-xs outline-none transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] disabled:pointer-events-none disabled:opacity-50 dark:bg-input/30 dark:hover:bg-input/50';
@endphp

{{-- Scroll-snap carries the whole interaction: swipe, trackpad, scrollbar
     dragging and keyboard scrolling are the browser's, not ours. The only
     thing script is needed for is the two arrow buttons, which have no
     declarative equivalent. Strip the script and everything else still
     works. --}}
<div data-ui-carousel
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    <div data-ui-carousel-track
        class="flex snap-x snap-mandatory gap-4 overflow-x-auto scroll-smooth [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
        {{ $slot }}
    </div>

    <button type="button" data-ui-carousel-prev aria-label="Previous slide"
        class="{{ $arrow }} -left-4">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" class="size-4" aria-hidden="true">
            <path d="m15 18-6-6 6-6" />
        </svg>
    </button>

    <button type="button" data-ui-carousel-next aria-label="Next slide"
        class="{{ $arrow }} -right-4">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" class="size-4" aria-hidden="true">
            <path d="m9 18 6-6-6-6" />
        </svg>
    </button>
</div>

@once
    <script>
        (function() {
            // The Blade once-directive above keeps this to a single copy per
            // page, except when a component is rendered into a slot that is
            // echoed twice, the way the sidebar does for its desktop and its
            // mobile panel. Then the markup ships twice and every click would
            // fire the handler twice, so this flag is the real guard.
            if (window.__laralcnCarousel) return;
            window.__laralcnCarousel = true;

            document.addEventListener('click', function(event) {
                var button = event.target.closest(
                    '[data-ui-carousel-prev], [data-ui-carousel-next]');
                if (!button) return;

                var root = button.closest('[data-ui-carousel]');
                var track = root.querySelector('[data-ui-carousel-track]');
                var back = button.hasAttribute('data-ui-carousel-prev');

                // Scroll to the next item's own edge, not by one viewport
                // width. Slides are separated by a gap, so a viewport-sized
                // step drifts by that gap every press and scroll-snap
                // eventually resolves the drift by skipping a slide.
                var origin = track.getBoundingClientRect().left;
                var edges = Array.prototype.map.call(track.children, function(item) {
                    return Math.round(
                        track.scrollLeft + item.getBoundingClientRect().left - origin);
                });

                // The 1px slack absorbs sub-pixel scroll positions, which would
                // otherwise make the current slide look like a valid target.
                var here = Math.round(track.scrollLeft);
                var target = back ?
                    edges.filter(function(edge) {
                        return edge < here - 1;
                    }).pop() :
                    edges.filter(function(edge) {
                        return edge > here + 1;
                    })[0];

                // Already at the first or last slide.
                if (target === undefined) return;

                track.scrollTo({
                    left: target,
                    behavior: 'smooth'
                });
            });
        })();
    </script>
@endonce
