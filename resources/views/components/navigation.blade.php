<nav class="bg-white border-b border-gray-200 fixed w-full z-30 top-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-blue-600 font-bold text-xl">
                        DevConnect
                    </a>
                </div>

                <!-- Navigation Links (visible on larger screens) -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('dashboard') }}" 
                        class="inline-flex items-center px-1 pt-1 border-b-2 
                        {{ request()->routeIs('dashboard') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                        text-sm font-medium leading-5">
                        Home
                    </a>
                    <a href="{{ route('connections.index') }}" 
                        class="inline-flex items-center px-1 pt-1 border-b-2 
                        {{ request()->routeIs('connections.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                        text-sm font-medium leading-5">
                        Connections
                    </a>
                </div>
            </div>

            <!-- Search (visible on larger screens) -->
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-center">
                <div class="max-w-lg w-full">
                    <form action="#" method="GET" class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" id="search" 
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white 
                            placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 
                            focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                            placeholder="Search for developers, posts, or topics">
                    </form>
                </div>
            </div>

            <!-- Right side navigation items -->
            <div class="flex items-center">
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    
                    <!-- Notifications dropdown -->
                    <div class="ml-3 relative" x-data="{ open: false }">
                        <button @click="open = !open" class="p-1 text-gray-500 rounded-full hover:bg-gray-100 focus:outline-none">
                            <span class="sr-only">View notifications</span>
                            <svg class="h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" 
                            class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" 
                            style="display: none;" 
                            x-transition:enter="transition ease-out duration-100" 
                            x-transition:enter-start="transform opacity-0 scale-95" 
                            x-transition:enter-end="transform opacity-100 scale-100" 
                            x-transition:leave="transition ease-in duration-75" 
                            x-transition:leave-start="transform opacity-100 scale-100" 
                            x-transition:leave-end="transform opacity-0 scale-95">
                            <div class="py-1">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-700">Notifications</p>
                                </div>
                                <div class="max-h-64 overflow-y-auto">
                                    <a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 border-b border-gray-100">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <img class="h-10 w-10 rounded-full" src="https://avatar.iran.liara.run/public/boy" alt="User avatar">
                                            </div>
                                            <div class="ml-3">
                                                <p class="font-medium">John Smith connected with you</p>
                                                <p class="text-xs text-gray-500">2 hours ago</p>
                                            </div>
                                        </div>
                                    </a>
                                    <!-- Add more notifications here -->
                                </div>
                                <a href="#" class="block text-center px-4 py-2 text-sm text-blue-600 hover:bg-gray-100 border-t border-gray-100">
                                    View all notifications
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Profile dropdown -->
                    <div class="ml-3 relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex text-sm rounded-full focus:outline-none">
                            <span class="sr-only">Open user menu</span>
                            @if(Auth::user()->profile_picture)
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="{{ Auth::user()->fullname }}">
                            @else
                                <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center">
                                    <span class="text-white font-medium">{{ substr(Auth::user()->fullname, 0, 1) }}</span>
                                </div>
                            @endif
                        </button>
                        
                        <div x-show="open" @click.away="open = false" 
                            class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" 
                            style="display: none;" 
                            x-transition:enter="transition ease-out duration-100" 
                            x-transition:enter-start="transform opacity-0 scale-95" 
                            x-transition:enter-end="transform opacity-100 scale-100" 
                            x-transition:leave="transition ease-in duration-75" 
                            x-transition:leave-start="transform opacity-100 scale-100" 
                            x-transition:leave-end="transform opacity-0 scale-95">
                            <div class="py-1">
                                <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your Profile</a>
                                <a href="{{ route('profile.edit.custom') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile menu button -->
                <div class="-mr-2 flex items-center sm:hidden" x-data="{ open: false }">
                    <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                        <svg :class="{'hidden': open, 'inline-flex': !open }" class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg :class="{'hidden': !open, 'inline-flex': open }" class="hidden h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-data="{ open: false }" :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('dashboard') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium focus:outline-none">
                Home
            </a>
            <a href="{{ route('connections.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('connections.*') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium focus:outline-none">
                Connections
            </a>
        </div>
        
        <!-- Mobile profile dropdown -->
        <div class="pt-4 pb-3 border-t border-gray-200">
            <div class="flex items-center px-4">
                <div class="flex-shrink-0">
                    @if(Auth::user()->profile_picture)
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="{{ Auth::user()->fullname }}">
                    @else
                        <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                            <span class="text-white font-medium">{{ substr(Auth::user()->fullname, 0, 1) }}</span>
                        </div>
                    @endif
                </div>
                <div class="ml-3">
                    <div class="text-base font-medium text-gray-800">{{ Auth::user()->fullname }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <a href="{{ route('profile') }}" class="block px-4 py-2 text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-100">
                    Your Profile
                </a>
                <a href="{{ route('profile.edit.custom') }}" class="block px-4 py-2 text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-100">
                    Settings
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-4 py-2 text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-100">
                        Sign out
                    </button>
                </form>
            </div>
        </div>
        <!-- Mobile search -->
        <div class="px-4 py-4 bg-gray-50 border-t border-gray-200">
            <form action="#" method="GET">
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input type="text" name="mobile-search" id="mobile-search" 
                        class="form-input block w-full pl-10 sm:text-sm sm:leading-5 border border-gray-300 rounded-md py-2" 
                        placeholder="Search...">
                </div>
            </form>
        </div>
    </div>
</nav>
<div class="pt-16"><!-- Spacer for fixed navbar --></div>
