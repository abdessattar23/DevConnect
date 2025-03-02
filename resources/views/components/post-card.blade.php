@props(['post'])

<div class="bg-white rounded-xl shadow-sm p-4">
    <div class="flex items-start space-x-4">
        <div class="flex-shrink-0">
            @if($post->user->profile_picture)
                <img src="{{ asset('storage/' . $post->user->profile_picture) }}" alt="{{ $post->user->fullname }}" class="w-12 h-12 rounded-full object-cover"/>
            @else
                <img src="https://avatar.iran.liara.run/public/boy" alt="{{ $post->user->fullname }}" class="w-12 h-12 rounded-full"/>
            @endif
        </div>
        <div class="flex-grow">
            <div class="flex justify-between">
                <div>
                    <a href="{{ route('profile.user', $post->user->id) }}" class="font-semibold text-gray-900 hover:underline">{{ $post->user->fullname }}</a>
                    <p class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</p>
                </div>
                @if(Auth::id() === $post->user_id)
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                        <div class="py-1">
                            <a href="{{ route('post.edit', $post->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Edit
                            </a>
                            <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100" 
                                        onclick="return confirm('Are you sure you want to delete this post?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="mt-2">
                <p class="text-gray-800">{{ $post->content }}</p>
                @if($post->image_url)
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $post->image_url) }}" alt="Post image" class="rounded-lg max-w-full max-h-96 object-contain">
                    </div>
                @endif
                @if($post->code_snippet)
                    <div class="mt-3 bg-gray-800 p-4 rounded-lg overflow-x-auto">
                        <pre class="text-gray-100 font-mono text-sm leading-relaxed whitespace-pre-wrap"><code>{{ $post->code_snippet }}</code></pre>
                    </div>
                @endif
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-6">
                        <x-like-button :post="$post" />
                        
                        <a href="{{ route('comments.index', $post) }}" class="flex items-center text-gray-600 hover:text-blue-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <span>{{ $post->comments->count() }}</span>
                        </a>
                    </div>
                    
                    <div>
                        <button class="text-gray-600 hover:text-blue-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                        </button>
                    </div>
                </div>
                
                @if($post->comments->count() > 0)
                <div class="mt-4">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Recent Comments</h4>
                    @foreach($post->comments->take(2) as $comment)
                        <div class="pl-4 border-l-2 border-gray-200 mb-3">
                            <div class="flex items-center">
                                <a href="{{ route('profile.user', $comment->user) }}" class="font-semibold text-sm text-blue-600 hover:underline">
                                    {{ $comment->user->fullname }}
                                </a>
                                <span class="text-xs text-gray-500 ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-gray-800 mt-1">{{ $comment->content }}</p>
                        </div>
                    @endforeach
                    
                    @if($post->comments->count() > 2)
                        <a href="{{ route('comments.index', $post) }}" class="text-sm text-blue-500 hover:underline">
                            View all {{ $post->comments->count() }} comments
                        </a>
                    @endif
                </div>
                @endif
                
                <div class="mt-4">
                    <form action="{{ route('comments.store', $post) }}" method="POST" class="flex items-center">
                        @csrf
                        <div class="flex-grow mr-2">
                            <input type="text" name="content" placeholder="Add a comment..." required
                                   class="w-full px-4 py-2 text-sm bg-gray-100 border border-transparent rounded-lg focus:outline-none focus:border-blue-500 focus:bg-white">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            Post
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
