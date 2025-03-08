<div>
    <div class="mb-4">
        <input wire:model.live="search" type="text" placeholder="Search posts..." class="form-input w-full">
    </div>

    @foreach($posts as $post)
        <div class="card mb-4">
            <div class="flex justify-between items-start mb-4">
                <div class="flex items-center gap-3">
                    <img class="w-10 h-10 rounded-full border-2 border-vintage-accent" src="{{ asset('storage/' . $post->user->profile_picture) }}" alt="Profile Picture">
                    <div>
                        <h3 class="text-lg font-medium text-vintage-dark">{{ $post->title }}</h3>
                        <p class="text-sm text-vintage-brown">{{ $post->user->name }} · {{ $post->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            <p class="text-vintage-text mb-4">{{ $post->content }}</p>
            
            @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" class="rounded-lg mb-4 border border-vintage-border">
            @endif

            <div class="flex items-center space-x-4 mb-4">
                <button onclick="toggleLike({{ $post->id }})" class="nav-link flex items-center">
                    <i class="fas fa-heart mr-1"></i>
                    <span id="likes-count-{{ $post->id }}">{{ $post->likes_count }}</span>
                </button>
                
                <button onclick="toggleCommentSection({{ $post->id }})" class="nav-link flex items-center">
                    <i class="fas fa-comment mr-1"></i>
                    <span>{{ $post->comments_count }}</span>
                </button>

                <button onclick="sharePost({{ $post->id }})" class="nav-link flex items-center">
                    <i class="fas fa-share mr-1"></i>
                    <span>{{ $post->shares_count }}</span>
                </button>
            </div>

            <div id="comment-section-{{ $post->id }}" class="hidden mt-4 space-y-4">
                @foreach($post->comments as $comment)
                    <div class="pl-4 border-l-2 border-vintage-border">
                        <div class="flex items-start gap-3">
                            <img class="w-8 h-8 rounded-full border border-vintage-accent" src="{{ asset('storage/' . $comment->user->profile_picture) }}" alt="Profile Picture">
                            <div>
                                <p class="text-vintage-text">{{ $comment->content }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-vintage-brown text-sm">{{ $comment->user->name }}</span>
                                    <span class="text-vintage-accent text-sm">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <form wire:submit.prevent="addComment({{ $post->id }})" class="mt-4">
                    <textarea wire:model="newComment" class="form-input w-full" rows="2" placeholder="Add a comment..."></textarea>
                    <button type="submit" class="btn-primary mt-2">Comment</button>
                </form>
            </div>

            @if($post->hashtags->count() > 0)
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach($post->hashtags as $hashtag)
                        <span class="skill-badge">#{{ $hashtag->name }}</span>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
</div>