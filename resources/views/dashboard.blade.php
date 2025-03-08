<x-app-layout>
    <x-slot name="header">
        <h2 class="font-medium text-xl text-vintage-dark">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto space-y-6">
            <div class="card">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <textarea name="content" placeholder="Share something with the community..." class="form-input w-full min-h-[100px]" required></textarea>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <label class="btn-primary bg-vintage-cream text-vintage-brown border-vintage-border hover:bg-vintage-light cursor-pointer">
                                <input type="file" name="image" class="hidden" accept="image/*">
                                <i class="fas fa-image mr-2"></i>Add Image
                            </label>
                            <input type="text" name="new_hashtags" placeholder="Add hashtags (comma separated)" class="form-input">
                        </div>
                        <button type="submit" class="btn-primary">Post</button>
                    </div>
                </form>
            </div>

            @foreach($posts as $post)
                <div class="card" data-post-id="{{ $post->id }}">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('storage/' . $post->user->profile_picture) }}" alt="Avatar" class="w-10 h-10 rounded-full border-2 border-vintage-accent">
                            <div>
                                <h4 class="font-medium text-vintage-dark">{{ $post->user->name }}</h4>
                                <p class="text-sm text-vintage-brown">{{ $post->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @if (Auth::id() === $post->user_id)
                            <div class="flex items-center gap-2">
                                <a href="{{ route('posts.edit', $post->id) }}" class="nav-link">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form method="POST" action="{{ route('posts.destroy', $post->id) }}" onsubmit="return confirm('Are you sure you want to delete this post?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="nav-link text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <p class="text-vintage-text mb-4">{{ $post->content }}</p>

                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="rounded-lg mb-4 border border-vintage-border">
                    @endif

                    @if($post->hashtags->count() > 0)
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($post->hashtags as $hashtag)
                                <span class="skill-badge">#{{ $hashtag->name }}</span>
                            @endforeach
                        </div>
                    @endif

                    <div class="flex items-center justify-between border-t border-vintage-border pt-4">
                        <button onclick="toggleLike({{ $post->id }})" class="nav-link flex items-center gap-1">
                            <i class="fas fa-heart"></i>
                            <span id="likes-count-{{ $post->id }}" class="likes-count">{{ $post->likes->count() }}</span>
                        </button>
                        
                        <button onclick="toggleCommentSection({{ $post->id }})" class="nav-link flex items-center gap-1">
                            <i class="fas fa-comment"></i>
                            <span id="comment-count-{{ $post->id}}">({{ $post->comments->count() }})</span>
                        </button>
                        
                        <button onclick="sharePost({{ $post->id }})" class="nav-link flex items-center gap-1">
                            <i class="fas fa-share"></i>
                            <span>Share</span>
                        </button>
                    </div>
                    
                    <div id="comment-section-{{ $post->id }}" class="hidden mt-4 space-y-4">
                        <div class="max-h-60 overflow-y-auto space-y-4">
                            @foreach($post->comments as $comment)
                                <div class="pl-4 border-l-2 border-vintage-border">
                                    <div class="flex items-start gap-3">
                                        <img src="{{ asset('storage/' . $comment->user->profile_picture) }}" alt="Avatar" class="w-8 h-8 rounded-full border border-vintage-accent">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <p class="text-sm font-medium text-vintage-dark">{{ $comment->user->name }}</p>
                                                @if($comment->user_id == Auth::id())
                                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="nav-link text-sm text-red-600 hover:text-red-800">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                            <p class="text-sm text-vintage-text">{{ $comment->content }}</p>
                                            <p class="text-xs text-vintage-brown">{{ $comment->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <form action="{{ route('comments.store', $post->id) }}" method="POST" class="flex gap-2">
                            @csrf
                            <input type="text" name="content" placeholder="Write a comment..." class="form-input flex-1">
                            <button type="submit" class="btn-primary">Comment</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>