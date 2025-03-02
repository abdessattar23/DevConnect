<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-blue-600">Find Connections</h2>
                        <a href="{{ route('connections.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                            My Connections
                        </a>
                    </div>
                    
                    <!-- Display flash messages -->
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif
                    
                    <!-- User Search Form -->
                    <div class="mb-6">
                        <form action="{{ route('connections.find') }}" method="GET" class="flex">
                            <input 
                                type="text" 
                                name="search" 
                                placeholder="Search by name or bio" 
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-l focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ request('search') }}"
                            >
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-r">
                                Search
                            </button>
                        </form>
                    </div>
                    
                    <!-- Users List -->
                    @if ($suggestedUsers->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($suggestedUsers as $user)
                                <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                                    <div class="flex items-center mb-4">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            @if ($user->profile_picture)
                                                <img class="h-12 w-12 rounded-full object-cover" 
                                                    src="{{ asset('storage/' . $user->profile_picture) }}" 
                                                    alt="{{ $user->fullname }}">
                                            @else
                                                <div class="h-12 w-12 rounded-full bg-blue-500 flex items-center justify-center">
                                                    <span class="text-white text-lg font-bold">
                                                        {{ substr($user->fullname, 0, 1) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-semibold">{{ $user->fullname }}</h3>
                                            <p class="text-gray-600 text-sm truncate">
                                                {{ $user->bio ?? 'No bio provided' }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex space-x-2">
                                        <a href="{{ route('profile', ['id' => $user->id]) }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded flex-1 text-center">
                                            View Profile
                                        </a>
                                        
                                        <form action="{{ route('connections.request', $user) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded">
                                                Connect
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $suggestedUsers->withQueryString()->links() }}
                        </div>
                    @else
                        <p class="text-gray-600">No users found. Try searching with different criteria.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
