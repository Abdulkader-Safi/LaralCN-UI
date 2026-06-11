<div x-data="{ dark: false }" :class="{ 'dark': dark }">
    <x-ui.sidebar.provider>
        {{-- Sidebar --}}
        <x-ui.sidebar side="left" collapsible="icon">
            {{-- Header: workspace switcher --}}
            <x-ui.sidebar.header>
                <x-ui.sidebar.menu>
                    <x-ui.sidebar.menu-item>
                        <x-ui.dropdown-menu>
                            <x-slot:trigger>
                                <x-ui.sidebar.menu-button size="lg"
                                    class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground">
                                    <div
                                        class="flex aspect-square size-8 items-center justify-center rounded-lg bg-sidebar-primary text-sidebar-primary-foreground">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="size-4">
                                            <path
                                                d="M12 2 2 7l10 5 10-5-10-5Z" />
                                            <path d="m2 17 10 5 10-5" />
                                            <path d="m2 12 10 5 10-5" />
                                        </svg>
                                    </div>
                                    <div
                                        class="grid flex-1 text-left text-sm leading-tight">
                                        <span class="truncate font-medium">Acme
                                            Inc</span>
                                        <span
                                            class="truncate text-xs text-muted-foreground">Enterprise</span>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="ml-auto size-4">
                                        <path d="m7 15 5 5 5-5" />
                                        <path d="m7 9 5-5 5 5" />
                                    </svg>
                                </x-ui.sidebar.menu-button>
                            </x-slot:trigger>

                            <div
                                class="px-2 py-1.5 text-xs text-muted-foreground">
                                Teams</div>
                            <a href="#"
                                class="flex items-center gap-2 rounded-sm px-2 py-1.5 text-sm hover:bg-accent hover:text-accent-foreground">Acme
                                Inc</a>
                            <a href="#"
                                class="flex items-center gap-2 rounded-sm px-2 py-1.5 text-sm hover:bg-accent hover:text-accent-foreground">Acme
                                Corp.</a>
                            <a href="#"
                                class="flex items-center gap-2 rounded-sm px-2 py-1.5 text-sm hover:bg-accent hover:text-accent-foreground">Evil
                                Corp.</a>
                        </x-ui.dropdown-menu>
                    </x-ui.sidebar.menu-item>
                </x-ui.sidebar.menu>
            </x-ui.sidebar.header>

            {{-- Content --}}
            <x-ui.sidebar.content>
                <x-ui.sidebar.group>
                    <x-ui.sidebar.group-label>Platform</x-ui.sidebar.group-label>
                    <x-ui.sidebar.menu>
                        <x-ui.sidebar.menu-item>
                            <x-ui.sidebar.menu-button :is-active="true"
                                tooltip="Dashboard" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect width="7" height="9" x="3"
                                        y="3" rx="1" />
                                    <rect width="7" height="5" x="14"
                                        y="3" rx="1" />
                                    <rect width="7" height="9" x="14"
                                        y="12" rx="1" />
                                    <rect width="7" height="5" x="3"
                                        y="16" rx="1" />
                                </svg>
                                <span>Dashboard</span>
                            </x-ui.sidebar.menu-button>
                        </x-ui.sidebar.menu-item>

                        <x-ui.sidebar.menu-item>
                            <x-ui.sidebar.menu-button tooltip="Lifecycle"
                                href="#">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M3 3v18h18" />
                                    <path d="m19 9-5 5-4-4-3 3" />
                                </svg>
                                <span>Lifecycle</span>
                            </x-ui.sidebar.menu-button>
                            <x-ui.sidebar.menu-badge>12</x-ui.sidebar.menu-badge>
                        </x-ui.sidebar.menu-item>

                        {{-- Collapsible group with submenu --}}
                        <x-ui.sidebar.menu-item>
                            <x-ui.collapsible :open="true">
                                <x-ui.sidebar.menu-button tooltip="Documents"
                                    @click="open = !open">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                                        <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                    </svg>
                                    <span>Documents</span>
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="ml-auto transition-transform duration-200"
                                        x-bind:class="open ? 'rotate-90' : ''">
                                        <path d="m9 18 6-6-6-6" />
                                    </svg>
                                </x-ui.sidebar.menu-button>
                                <x-ui.collapsible.content>
                                    <x-ui.sidebar.menu-sub>
                                        <x-ui.sidebar.menu-sub-item>
                                            <x-ui.sidebar.menu-sub-button
                                                href="#">Data
                                                Library</x-ui.sidebar.menu-sub-button>
                                        </x-ui.sidebar.menu-sub-item>
                                        <x-ui.sidebar.menu-sub-item>
                                            <x-ui.sidebar.menu-sub-button
                                                href="#">Reports</x-ui.sidebar.menu-sub-button>
                                        </x-ui.sidebar.menu-sub-item>
                                        <x-ui.sidebar.menu-sub-item>
                                            <x-ui.sidebar.menu-sub-button
                                                href="#">Word
                                                Assistant</x-ui.sidebar.menu-sub-button>
                                        </x-ui.sidebar.menu-sub-item>
                                    </x-ui.sidebar.menu-sub>
                                </x-ui.collapsible.content>
                            </x-ui.collapsible>
                        </x-ui.sidebar.menu-item>

                        <x-ui.sidebar.menu-item>
                            <x-ui.sidebar.menu-button tooltip="Team"
                                href="#">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                    <circle cx="9" cy="7"
                                        r="4" />
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                </svg>
                                <span>Team</span>
                            </x-ui.sidebar.menu-button>
                        </x-ui.sidebar.menu-item>
                    </x-ui.sidebar.menu>
                </x-ui.sidebar.group>

                <x-ui.sidebar.group>
                    <x-ui.sidebar.group-label>Loading</x-ui.sidebar.group-label>
                    <x-ui.sidebar.menu>
                        <x-ui.sidebar.menu-item>
                            <x-ui.sidebar.menu-skeleton :show-icon="true" />
                        </x-ui.sidebar.menu-item>
                        <x-ui.sidebar.menu-item>
                            <x-ui.sidebar.menu-skeleton :show-icon="true" />
                        </x-ui.sidebar.menu-item>
                    </x-ui.sidebar.menu>
                </x-ui.sidebar.group>
            </x-ui.sidebar.content>

            {{-- Footer: nav-user --}}
            <x-ui.sidebar.footer>
                <x-ui.sidebar.menu>
                    <x-ui.sidebar.menu-item>
                        <x-ui.dropdown-menu align="end">
                            <x-slot:trigger>
                                <x-ui.sidebar.menu-button size="lg"
                                    class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground">
                                    <x-ui.avatar class="size-8 rounded-lg"
                                        fallback="CN" />
                                    <div
                                        class="grid flex-1 text-left text-sm leading-tight">
                                        <span
                                            class="truncate font-medium">shadcn</span>
                                        <span
                                            class="truncate text-xs text-muted-foreground">m@example.com</span>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="ml-auto size-4">
                                        <path d="m7 15 5 5 5-5" />
                                        <path d="m7 9 5-5 5 5" />
                                    </svg>
                                </x-ui.sidebar.menu-button>
                            </x-slot:trigger>

                            <a href="#"
                                class="flex items-center gap-2 rounded-sm px-2 py-1.5 text-sm hover:bg-accent hover:text-accent-foreground">Account</a>
                            <a href="#"
                                class="flex items-center gap-2 rounded-sm px-2 py-1.5 text-sm hover:bg-accent hover:text-accent-foreground">Billing</a>
                            <a href="#"
                                class="flex items-center gap-2 rounded-sm px-2 py-1.5 text-sm hover:bg-accent hover:text-accent-foreground">Notifications</a>
                            <div class="my-1 h-px bg-border"></div>
                            <a href="#"
                                class="flex items-center gap-2 rounded-sm px-2 py-1.5 text-sm hover:bg-accent hover:text-accent-foreground">Log
                                out</a>
                        </x-ui.dropdown-menu>
                    </x-ui.sidebar.menu-item>
                </x-ui.sidebar.menu>
            </x-ui.sidebar.footer>

            <x-ui.sidebar.rail />
        </x-ui.sidebar>

        {{-- Main content --}}
        <x-ui.sidebar.inset>
            <header
                class="flex h-16 shrink-0 items-center gap-2 border-b border-border px-4">
                <x-ui.sidebar.trigger class="-ml-1" />
                <x-ui.separator orientation="vertical" class="mr-2 h-4" />
                <x-ui.breadcrumb>
                    <x-ui.breadcrumb.list>
                        <x-ui.breadcrumb.item class="hidden md:block">
                            <x-ui.breadcrumb.link href="#">Building Your
                                Application</x-ui.breadcrumb.link>
                        </x-ui.breadcrumb.item>
                        <x-ui.breadcrumb.separator class="hidden md:block" />
                        <x-ui.breadcrumb.item>
                            <x-ui.breadcrumb.page>Data
                                Fetching</x-ui.breadcrumb.page>
                        </x-ui.breadcrumb.item>
                    </x-ui.breadcrumb.list>
                </x-ui.breadcrumb>

                <button type="button" @click="dark = !dark"
                    class="ml-auto rounded-md border border-border px-2 py-1 text-xs">
                    <span x-show="!dark">Dark</span>
                    <span x-show="dark" x-cloak>Light</span>
                </button>
            </header>

            <div class="flex flex-1 flex-col gap-4 p-4">
                <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                    <div class="aspect-video rounded-xl bg-muted/50"></div>
                    <div class="aspect-video rounded-xl bg-muted/50"></div>
                    <div class="aspect-video rounded-xl bg-muted/50"></div>
                </div>
                <div
                    class="min-h-[100vh] flex-1 rounded-xl bg-muted/50 md:min-h-min">
                </div>
            </div>
        </x-ui.sidebar.inset>
    </x-ui.sidebar.provider>
</div>
