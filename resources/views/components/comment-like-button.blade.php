@props(['comment', 'size' => 'md'])

@php
    $liked = Auth::check() && $comment->likes()->where('user_id', Auth::id())->exists();
    $likesCount = $comment->likes()->count();
    $iconClass = $size === 'sm' ? 'h-3 w-3 mr-1' : 'h-4 w-4 mr-1';
    $textClass = $size === 'sm' ? 'text-xs' : 'text-sm';
@endphp

<div 
    x-data="{ 
        liked: {{ $liked ? 'true' : 'false' }}, 
        likesCount: {{ $likesCount }},
        toggleLike() {
            const url = '{{ route('likes.comment.toggle', $comment) }}';
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                this.liked = data.liked;
                this.likesCount = data.likesCount;
            })
            .catch(error => console.error('Error:', error));
        }
    }"
    class="inline-flex"
>
    <button 
        @click="toggleLike" 
        type="button"
        class="flex items-center transition-colors"
        :class="liked ? 'text-blue-600 hover:text-blue-700' : 'text-gray-500 hover:text-blue-600'"
    >
        <svg 
            xmlns="http://www.w3.org/2000/svg" 
            :class="'{{ $iconClass }}'"
            viewBox="0 0 20 20" 
            fill="currentColor"
        >
            <path 
                d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"
            />
        </svg>
        <span 
            :class="'{{ $textClass }}'"
            x-text="likesCount === 1 ? '1 Like' : likesCount + ' Likes'"
        ></span>
    </button>
    
    <template x-if="likesCount > 0">
        <a 
            href="{{ route('likes.comment.likers', $comment) }}" 
            class="ml-1 hover:underline"
            :class="'{{ $textClass }} ' + (liked ? 'text-blue-600 hover:text-blue-700' : 'text-gray-500 hover:text-blue-600')"
        >
            (View)
        </a>
    </template>
</div>
