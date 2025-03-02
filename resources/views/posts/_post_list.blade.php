@foreach ($posts as $post)
<div class="bg-white rounded-xl shadow-sm p-4">
    <div class="flex items-start space-x-4">
        <div class="flex-shrink-0">
            @if($post->user->profile_picture)
                <img src="{{ Storage::url($post->user->profile_picture) }}" alt="{{ $post->user->fullname }}" class="w-12 h-12 rounded-full object-cover"/>
            @else
                <img src="https://avatar.iran.liara.run/public/boy" alt="{{ $post->user->fullname }}" class="w-12 h-12 rounded-full"/>
            @endif
        </div>
        <div class="flex-grow">
            <div class="flex justify-between">
                <div>
                    <h3 class="font-semibold text-gray-900">{{ $post->user->fullname }}</h3>
                    <p class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</p>
                </div>
                @if(Auth::id() === $post->user_id)
                <div class="flex space-x-2">
                    <a href="{{ route('post.edit', $post->id) }}" class="text-gray-500 hover:text-blue-600 transition-colors">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('post.destroy', $post->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-500 hover:text-red-600 transition-colors" 
                                onclick="return confirm('Are you sure you want to delete this post?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
                @endif
            </div>
            <div class="mt-2">
                <p class="text-gray-800">{{ $post->content }}</p>
                @if($post->image_url)
                    <img src="{{ $post->image_url }}" alt="Post image" class="mt-3 rounded-lg max-h-96 w-auto">
                @endif
                @if($post->code_snippet)
                    <div class="mt-3 bg-gray-100 p-4 rounded-lg overflow-x-auto">
                        <pre><code class="language-javascript">{{ $post->code_snippet }}</code></pre>
                    </div>
                @endif
            </div>
            <div class="mt-4 flex items-center space-x-4">
                <x-like-button :post="$post" />
                <x-inline-comment-form :post="$post" />
                <a href="{{ route('comments.index', $post) }}" class="flex items-center text-gray-500 hover:text-blue-600 transition-colors">
                    <i class="far fa-comment-dots mr-1"></i>
                    <span>View comments</span>
                </a>
                <button class="flex items-center text-gray-500 hover:text-blue-600 transition-colors">
                    <i class="far fa-share-square mr-1"></i>
                    <span>Share</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endforeach