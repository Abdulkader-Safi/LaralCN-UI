@props([
    'open' => true,
])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'group/sidebar-wrapper flex min-h-svh w-full has-data-[variant=inset]:bg-sidebar',
        $attributes->get('class'),
    );
@endphp

<div x-data="{
    open: @js((bool) $open),
    openMobile: false,
    isMobile: false,
    get state() { return this.open ? 'expanded' : 'collapsed' },
    toggleSidebar() {
        if (this.isMobile) { this.openMobile = !this.openMobile; }
        else { this.open = !this.open; }
    },
    init() {
        const mq = window.matchMedia('(max-width: 767px)');
        this.isMobile = mq.matches;
        mq.addEventListener('change', e => { this.isMobile = e.matches });
        this.$watch('open', v => {
            document.cookie = `sidebar_state=${v}; path=/; max-age=604800`;
        });
        window.addEventListener('keydown', e => {
            if (e.key === 'b' && (e.metaKey || e.ctrlKey)) {
                e.preventDefault();
                this.toggleSidebar();
            }
        });
    },
}"
    style="--sidebar-width: 16rem; --sidebar-width-icon: 3rem; --sidebar-width-mobile: 18rem;"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
