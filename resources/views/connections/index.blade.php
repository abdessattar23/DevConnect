<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Connection Requests Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-4 text-blue-600">Connection Requests</h2>
                    
                    @if ($pendingRequests->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($pendingRequests as $request)
                                <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                                    <div class="flex items-center mb-4">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            @if ($request->requester->profile_picture)
                                                <img class="h-12 w-12 rounded-full object-cover" 
                                                    src="{{ asset('storage/' . $request->requester->profile_picture) }}" 
                                                    alt="{{ $request->requester->fullname }}">
                                            @else
                                                <div class="h-12 w-12 rounded-full bg-blue-500 flex items-center justify-center">
                                                    <span class="text-white text-lg font-bold">
                                                        {{ substr($request->requester->fullname, 0, 1) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-semibold">{{ $request->requester->fullname }}</h3>
                                            <p class="text-gray-600 text-sm truncate">
                                                {{ $request->requester->bio ?? 'No bio provided' }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex justify-between">
                                        <form action="{{ route('connections.accept', $request) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                                                Accept
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('connections.decline', $request) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
                                                Decline
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600">You don't have any pending connection requests.</p>
                    @endif
                </div>
            </div>
            
            <!-- My Connections Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-bold text-blue-600">My Connections</h2>
                        <a href="{{ route('connections.find') }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                            Find Connections
                        </a>
                    </div>
                    
                    @if ($connectedUsers->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($connectedUsers as $user)
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
                                        
                                        @php
                                            $connection = App\Models\Connection::where(function($query) use ($user) {
                                                $query->where('requester_id', auth()->id())
                                                      ->where('receiver_id', $user->id)
                                                      ->where('status', 'accepted');
                                            })->orWhere(function($query) use ($user) {
                                                $query->where('requester_id', $user->id)
                                                      ->where('receiver_id', auth()->id())
                                                      ->where('status', 'accepted');
                                            })->first();
                                        @endphp
                                        
                                        <form action="{{ route('connections.remove', $connection) }}" method="POST" class="flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600">You don't have any connections yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
