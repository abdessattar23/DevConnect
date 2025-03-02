<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <!-- Cover Image -->
            <div class="w-full h-64 bg-gray-200 relative">
                @if($profileUser->cover_picture)
                    <img src="{{ asset('storage/' . $profileUser->cover_picture) }}" alt="Cover Image" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-r from-blue-400 to-blue-600"></div>
                @endif
                
                <!-- Profile Picture -->
                <div class="absolute -bottom-16 left-8">
                    <div class="h-32 w-32 rounded-full border-4 border-white overflow-hidden bg-white">
                        @if($profileUser->profile_picture)
                            <img src="{{ asset('storage/' . $profileUser->profile_picture) }}" alt="Profile Picture" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-blue-500">
                                <span class="text-3xl font-bold text-white">{{ substr($profileUser->fullname, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Connection Status Button -->
                <div class="absolute bottom-4 right-4">
                    @if(auth()->id() !== $profileUser->id)
                        @if($connectionStatus === 'accepted')
                            <div class="bg-green-500 text-white px-4 py-2 rounded-lg font-medium">
                                Connected
                            </div>
                        @elseif($connectionStatus === 'pending')
                            @php
                                $connection = \App\Models\Connection::where('requester_id', auth()->id())
                                                  ->where('receiver_id', $profileUser->id)
                                                  ->where('status', 'pending')
                                                  ->first();
                            @endphp
                            
                            @if($connection)
                                <div class="bg-yellow-500 text-white px-4 py-2 rounded-lg font-medium">
                                    Request Sent
                                </div>
                            @else
                                <div class="bg-yellow-500 text-white px-4 py-2 rounded-lg font-medium">
                                    Request Received
                                </div>
                            @endif
                        @elseif($connectionStatus === 'declined')
                            <form action="{{ route('connections.request', $profileUser) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium">
                                    Connect
                                </button>
                            </form>
                        @else
                            <form action="{{ route('connections.request', $profileUser) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium">
                                    Connect
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
            
            <!-- Profile Information -->
            <div class="pt-20 px-8 pb-8">
                <h1 class="text-3xl font-bold">{{ $profileUser->fullname }}</h1>
                <p class="text-gray-600 mt-2">{{ $profileUser->bio }}</p>
                
                <div class="mt-4 flex flex-wrap gap-4">
                    <!-- Languages -->
                    @if($profileUser->language)
                        <div class="flex items-center text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                            </svg>
                            <span>{{ $profileUser->language }}</span>
                        </div>
                    @endif
                    
                    <!-- Website -->
                    @if($profileUser->website)
                        <a href="{{ $profileUser->website }}" target="_blank" class="flex items-center text-blue-600 hover:underline">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                            <span>Website</span>
                        </a>
                    @endif
                    
                    <!-- GitHub -->
                    @if($profileUser->github_url)
                        <a href="{{ $profileUser->github_url }}" target="_blank" class="flex items-center text-blue-600 hover:underline">
                            <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                            </svg>
                            <span>GitHub</span>
                        </a>
                    @endif
                    
                    <!-- LinkedIn -->
                    @if($profileUser->linkedin_url)
                        <a href="{{ $profileUser->linkedin_url }}" target="_blank" class="flex items-center text-blue-600 hover:underline">
                            <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                            </svg>
                            <span>LinkedIn</span>
                        </a>
                    @endif
                </div>
                
                <!-- User's Posts Section -->
                <div class="mt-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Latest Posts</h2>
                    
                    @if($profileUser->posts->count() > 0)
                        <div class="space-y-6">
                            @foreach($profileUser->posts as $post)
                                <div class="bg-gray-50 rounded-lg shadow p-6">
                                    <div class="flex items-center mb-4">
                                        <div class="h-10 w-10 rounded-full overflow-hidden mr-3">
                                            @if($profileUser->profile_picture)
                                                <img src="{{ asset('storage/' . $profileUser->profile_picture) }}" alt="Profile Picture" class="h-full w-full object-cover">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center bg-blue-500">
                                                    <span class="text-lg font-bold text-white">{{ substr($profileUser->fullname, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-semibold">{{ $profileUser->fullname }}</p>
                                            <p class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    
                                    <h3 class="text-xl font-bold mb-2">{{ $post->title }}</h3>
                                    <p class="text-gray-700 mb-4">{{ $post->content }}</p>
                                    
                                    @if($post->code_snippet)
                                        <div class="bg-gray-800 text-white p-4 rounded-lg mb-4 overflow-x-auto">
                                            <pre><code>{{ $post->code_snippet }}</code></pre>
                                        </div>
                                    @endif
                                    
                                    @if($post->image)
                                        <div class="mt-4">
                                            <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="rounded-lg max-h-96">
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600">This user hasn't posted anything yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
