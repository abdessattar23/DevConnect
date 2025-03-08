<nav x-data="{ open: false }" class="border-b border-[#d6ccc2] bg-[#f5ebe0] shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-[#2c1810] hover:text-[#c7b7a3] transition-colors">
                        <x-application-logo class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('profile.view')" :active="request()->routeIs('profile.view')">
                        {{ __('Profile') }}
                    </x-nav-link>
                    <x-nav-link :href="route('connections.index')" :active="request()->routeIs('connections.index')">
                        {{ __('My Connections') }}
                    </x-nav-link>
                    <x-nav-link :href="route('connections.explore')" :active="request()->routeIs('connections.explore')">
                        {{ __('Explore') }}
                    </x-nav-link>
                    <x-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.*')" class="relative">
                        {{ __('Messages') }}
                        @if(isset($unreadMessages) && $unreadMessages > 0)
                            <span class="absolute -top-1 -right-2 bg-[#c7b7a3] text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                {{ $unreadMessages }}
                            </span>
                        @endif
                    </x-nav-link>
                    <x-nav-link :href="route('my.notification')" :active="request()->routeIs('my.notification')" class="relative">
                        {{ __('Notifications') }}
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute -top-1 -right-2 bg-[#c7b7a3] text-white text-xs rounded-full h-5 w-5 flex items-center justify-center notification-badge">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-[#d6ccc2] text-sm leading-4 font-medium rounded-md text-[#2c1810] bg-[#e3d5ca] hover:bg-[#f5ebe0] hover:text-[#967259] focus:outline-none transition ease-in-out duration-150">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile" class="h-6 w-6 rounded-full border border-[#d6ccc2]">
                                <span>{{ Auth::user()->name }}</span>
                            </div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.view')">
                            {{ __('View Profile') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Settings') }}
                        </x-dropdown-link>
                        <div class="border-t border-[#d6ccc2]"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-[#967259] hover:text-[#2c1810] hover:bg-[#e3d5ca] focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('profile.view')" :active="request()->routeIs('profile.view')">
                {{ __('Profile') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('connections.index')" :active="request()->routeIs('connections.index')">
                {{ __('My Connections') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('connections.explore')" :active="request()->routeIs('connections.explore')">
                {{ __('Explore') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.*')" class="relative">
                {{ __('Messages') }}
                @if(isset($unreadMessages) && $unreadMessages > 0)
                    <span class="ml-2 bg-[#c7b7a3] text-white text-xs rounded-full px-2 py-1">
                        {{ $unreadMessages }}
                    </span>
                @endif
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('my.notification')" :active="request()->routeIs('my.notification')" class="relative">
                {{ __('Notifications') }}
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="ml-2 bg-[#c7b7a3] text-white text-xs rounded-full px-2 py-1 notification-badge">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>
                @endif
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-[#d6ccc2] bg-[#e3d5ca]">
            <div class="px-4 flex items-center gap-3">
                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile" class="h-10 w-10 rounded-full border border-[#d6ccc2]">
                <div>
                    <div class="font-medium text-base text-[#2c1810]">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-[#967259]">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Settings') }}
                </x-responsive-nav-link>
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
