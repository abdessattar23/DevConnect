<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 bg-white">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-blue-600">People who liked this post</h2>
                        <a href="{{ url()->previous() }}" class="text-blue-500 hover:text-blue-700 transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Back
                        </a>
                    </div>
                    
                    @if($likers->count() > 0)
                        <div class="divide-y divide-gray-200">
                            @foreach($likers as $liker)
                                <div class="flex items-center py-4">
                                    <div class="h-12 w-12 rounded-full overflow-hidden mr-4 border-2 border-white shadow-sm flex-shrink-0">
                                        @if($liker->profile_picture)
                                            <img src="{{ asset('storage/' . $liker->profile_picture) }}" alt="{{ $liker->fullname }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center bg-blue-500">
                                                <span class="text-lg font-bold text-white">{{ substr($liker->fullname, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('profile.user', $liker->id) }}" class="font-medium text-blue-600 hover:underline text-lg">{{ $liker->fullname }}</a>
                                        <p class="text-gray-500">{{ $liker->bio ? Str::limit($liker->bio, 100) : 'No bio' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10">
                            <p class="text-gray-600">No one has liked this post yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
