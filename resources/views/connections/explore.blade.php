<x-app-layout>
<div class="container mx-auto px-4 py-8">
    @if (session('status'))
        <div class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 px-4 py-2 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Explore Users</h2>
        <a href="{{ route('connections.index') }}" class="text-blue-600 hover:text-blue-800">
            View My Connections
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($users as $user)
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center space-x-4">
                    @if($user->profile_photo_path)
                        <img src="{{ Storage::url($user->profile_photo_path) }}" class="h-12 w-12 rounded-full">
                    @else
                        <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-500 text-lg">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                    @endif
                    <div>
                        <h3 class="text-lg font-semibold">{{ $user->name }}</h3>
                        <p class="text-gray-600">{{ $user->email }}</p>
                    </div>
                </div>

                @if($user->skills->count() > 0)
                    <div class="mt-4">
                        <h4 class="text-sm font-semibold text-gray-600">Skills</h4>
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach($user->skills->take(3) as $skill)
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">
                                    {{ $skill->name }}
                                </span>
                            @endforeach
                            @if($user->skills->count() > 3)
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded">
                                    +{{ $user->skills->count() - 3 }} more
                                </span>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="mt-4 flex space-x-3">
                    @if($user->connection_status === 'pending')
                        <button disabled 
                                class="px-4 py-2 bg-gray-400 text-white rounded cursor-not-allowed">
                            Request Pending
                        </button>
                    @elseif($user->connection_status === 'accepted')
                        <button disabled 
                                class="px-4 py-2 bg-green-600 text-white rounded cursor-not-allowed">
                            Connected
                        </button>
                    @else
                        <form action="{{ route('connections.send-request') }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="target_user_id" value="{{ $user->id }}">
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                Connect
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('profile.view', $user->id) }}" 
                       class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-50 transition">
                        View Profile
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>

    @if($users->isEmpty())
        <div class="text-center py-8">
            <p class="text-gray-600">No new users to connect with at the moment.</p>
        </div>
    @endif
</div>
</x-app-layout>