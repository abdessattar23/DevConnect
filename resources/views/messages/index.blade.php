<x-app-layout>
    <x-slot name="header">
        <h2 class="font-medium text-xl text-[#2c1810]">
            {{ __('Messages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#f5ebe0] shadow-sm rounded-lg">
                <div class="p-6 text-[#2c1810]">
                    <h3 class="text-lg font-medium mb-4">Connected Users</h3>
                    
                    <div class="space-y-4">
                        @forelse($connectedUsers as $user)
                            <div class="flex items-center justify-between p-4 bg-[#e3d5ca] rounded-lg hover:bg-[#f5ebe0] transition-colors">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-full border border-[#d6ccc2]">
                                    <div>
                                        <h4 class="font-medium">{{ $user->name }}</h4>
                                        <p class="text-sm text-[#967259]">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('messages.show', $user->id) }}" class="px-4 py-2 bg-[#c7b7a3] text-white rounded-md hover:bg-[#967259] transition-colors">
                                    Message
                                </a>
                            </div>
                        @empty
                            <p class="text-center text-[#967259]">You don't have any connections yet. <a href="{{ route('connections.explore') }}" class="text-[#967259] hover:underline">Explore users</a> to connect.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>