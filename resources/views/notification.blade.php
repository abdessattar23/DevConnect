<x-app-layout>
    <x-slot name="header">
        <h2 class="font-medium text-xl text-vintage-dark">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                @forelse($receivedConnections as $connection)
                    <div class="flex items-center justify-between border-b border-vintage-border pb-4 mb-4">
                        <div class="flex items-center gap-3">
                            <img class="w-12 h-12 rounded-full border-2 border-vintage-accent" src="{{ asset('storage/' . $connection->sourceUser->profile_picture) }}" alt="Profile Picture">
                            <p class="text-vintage-dark"><span class="font-medium">{{ $connection->sourceUser->name }}</span> wants to connect with you.</p>
                        </div>
                        <div class="flex gap-2">
                            <form action="{{ route('connections.accept') }}" method="POST">
                                @csrf
                                <input type="hidden" name="connection_id" value="{{ $connection->id }}">
                                <button type="submit" class="btn-primary">Accept</button>
                            </form>
                            <form action="{{ route('connections.reject') }}" method="POST">
                                @csrf
                                <input type="hidden" name="connection_id" value="{{ $connection->id }}">
                                <button type="submit" class="btn-primary bg-vintage-dark">Reject</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-vintage-brown text-center">No new connection requests.</p>
                @endforelse
                @forelse ($notifications as $notification)
                    <div class="notification">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-vintage-dark">{{ $notification->data['message'] }}</p>
                                <small class="text-vintage-brown">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                            @if(!$notification->read_at)
                                <form method="POST" action="{{ route('notifications.markAsRead', $notification->id) }}">
                                    @csrf
                                    <button type="submit" class="nav-link">
                                        Mark as read
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-vintage-brown text-center py-4">No notifications yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>