<x-app-layout>
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">My Connections</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($connections as $user)
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
                            @foreach($user->skills as $skill)
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">
                                    {{ $skill->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('profile.view', $user->id) }}" 
                       class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        View Profile
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    @if($connections->isEmpty())
        <div class="text-center py-8">
            <p class="text-gray-600">You don't have any connections yet.</p>
            <a href="{{ route('connections.explore') }}" 
               class="mt-4 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Explore Users
            </a>
        </div>
    @endif
</div>
</x-app-layout>