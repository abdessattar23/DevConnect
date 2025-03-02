@props(['comment', 'post'])

<div 
    class="comment-item p-4 rounded-lg border border-gray-200 bg-white shadow-sm mb-4" 
    id="comment-{{ $comment->id }}"
    x-data="{ showReplies: false, replyOpen: false }"
>
    <div class="flex">
        <!-- User Avatar -->
        <div class="h-10 w-10 rounded-full overflow-hidden mr-3 flex-shrink-0 border-2 border-white shadow-sm">
            @if($comment->user->profile_picture)
                <img src="{{ asset('storage/' . $comment->user->profile_picture) }}" alt="{{ $comment->user->fullname }}" class="h-full w-full object-cover">
            @else
                <div class="h-full w-full flex items-center justify-center bg-blue-500">
                    <span class="text-lg font-bold text-white">{{ substr($comment->user->fullname, 0, 1) }}</span>
                </div>
            @endif
        </div>
        
        <!-- Comment Content -->
        <div class="flex-1">
            <div class="flex justify-between items-start">
                <div>
                    <a href="{{ route('profile.user', $comment->user->id) }}" class="font-semibold text-blue-600 hover:underline">{{ $comment->user->fullname }}</a>
                    <span class="text-gray-500 text-sm ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                </div>
                
                <!-- Dropdown for comment actions -->
                @if(Auth::check() && (Auth::id() === $comment->user_id || Auth::user()->isAdmin()))
                    <div class="relative" x-data="{ open: false }">
                        <button 
                            @click="open = !open" 
                            class="text-gray-500 hover:text-gray-700"
                            type="button"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                            </svg>
                        </button>
                        
                        <div 
                            x-show="open" 
                            @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 overflow-hidden border border-gray-200"
                            style="display: none;"
                        >
                            <button 
                                type="button"
                                @click="$dispatch('edit-comment', { commentId: {{ $comment->id }} }); open = false"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            >
                                Edit Comment
                            </button>
                            
                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="block w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Delete Comment
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Comment text content -->
            <div class="comment-content mt-1 text-gray-700">
                <p>{{ $comment->content }}</p>
            </div>
            
            <!-- Comment metadata and actions -->
            <div class="mt-2 flex items-center space-x-4 text-sm">
                <x-comment-like-button :comment="$comment" />
                
                <button 
                    @click="replyOpen = !replyOpen; $nextTick(() => $refs.replyInput.focus())"
                    type="button" 
                    class="text-gray-500 hover:text-blue-600 transition-colors flex items-center"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.707 3.293a1 1 0 010 1.414L5.414 7H11a7 7 0 017 7v2a1 1 0 11-2 0v-2a5 5 0 00-5-5H5.414l2.293 2.293a1 1 0 11-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Reply
                </button>
                
                @if($comment->replies_count > 0)
                    <button 
                        @click="showReplies = !showReplies" 
                        type="button"
                        class="text-gray-500 hover:text-blue-600 transition-colors flex items-center"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor" x-show="!showReplies">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor" x-show="showReplies" style="display: none;">
                            <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        <span x-text="showReplies ? 'Hide Replies' : 'Show Replies (' + {{ $comment->replies_count }} + ')'"></span>
                    </button>
                @endif
            </div>
            
            <!-- Reply form -->
            <div x-show="replyOpen" class="mt-3" style="display: none;">
                <div 
                    x-data="{ 
                        content: '',
                        submitting: false,
                        error: null,
                        submitReply() {
                            if (!this.content.trim()) {
                                this.error = 'Please enter a reply';
                                return;
                            }
                            
                            this.submitting = true;
                            this.error = null;
                            
                            const formData = new FormData();
                            formData.append('content', this.content);
                            
                            fetch('{{ route('comments.reply', $comment) }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                },
                                body: formData
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                // Reset the form and close it
                                this.content = '';
                                this.submitting = false;
                                
                                // Show success message and reload after delay
                                this.$dispatch('reply-added', {
                                    commentId: {{ $comment->id }},
                                    reply: data.reply
                                });
                                
                                // Close the reply form and show success message
                                setTimeout(() => {
                                    replyOpen = false;
                                    showReplies = true; // Show replies including the new one
                                    
                                    // Reload the page to show the new reply
                                    window.location.reload();
                                }, 2000);
                            })
                            .catch(error => {
                                this.submitting = false;
                                this.error = 'An error occurred while submitting your reply';
                                console.error('Error:', error);
                            });
                        }
                    }"
                    @reply-added.window="
                        if ($event.detail.commentId === {{ $comment->id }}) {
                            $refs.replySuccessMessage.classList.remove('hidden');
                            setTimeout(() => {
                                $refs.replySuccessMessage.classList.add('hidden');
                            }, 2000);
                        }
                    "
                    class="pl-3 border-l-2 border-gray-200"
                >
                    <form @submit.prevent="submitReply">
                        <textarea 
                            x-model="content" 
                            x-ref="replyInput"
                            x-bind:disabled="submitting"
                            class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                            placeholder="Write your reply..."
                            rows="2"
                        ></textarea>
                        <div class="mt-2 flex space-x-2 justify-end">
                            <button 
                                @click="replyOpen = false" 
                                type="button"
                                x-bind:disabled="submitting"
                                class="px-3 py-1 text-sm text-gray-600 hover:text-gray-800 transition-colors"
                            >
                                Cancel
                            </button>
                            <button 
                                type="submit"
                                x-bind:disabled="submitting"
                                class="px-3 py-1 text-sm bg-blue-500 hover:bg-blue-600 text-white rounded-md transition-colors flex items-center disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <span x-show="!submitting">Reply</span>
                                <span x-show="submitting" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-3 w-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Posting...
                                </span>
                            </button>
                        </div>
                        <div x-show="error" x-text="error" class="mt-2 text-sm text-red-500" style="display: none;"></div>
                        <div x-ref="replySuccessMessage" class="hidden mt-2 text-sm text-green-600 bg-green-50 p-2 rounded">
                            Reply added successfully! The page will refresh shortly.
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Replies container -->
            @if($comment->replies_count > 0)
                <div x-show="showReplies" class="mt-4 pl-6 space-y-4 border-l-2 border-gray-200" style="display: none;">
                    @foreach($comment->replies as $reply)
                        <div class="reply-item" id="reply-{{ $reply->id }}">
                            <div class="flex">
                                <div class="h-8 w-8 rounded-full overflow-hidden mr-2 flex-shrink-0 border-2 border-white shadow-sm">
                                    @if($reply->user->profile_picture)
                                        <img src="{{ asset('storage/' . $reply->user->profile_picture) }}" alt="{{ $reply->user->fullname }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center bg-blue-500">
                                            <span class="text-sm font-bold text-white">{{ substr($reply->user->fullname, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <a href="{{ route('profile.user', $reply->user->id) }}" class="font-semibold text-blue-600 hover:underline text-sm">{{ $reply->user->fullname }}</a>
                                            <span class="text-gray-500 text-xs ml-2">{{ $reply->created_at->diffForHumans() }}</span>
                                        </div>
                                        
                                        <!-- Dropdown for reply actions -->
                                        @if(Auth::check() && (Auth::id() === $reply->user_id || Auth::user()->isAdmin()))
                                            <div class="relative" x-data="{ open: false }">
                                                <button 
                                                    @click="open = !open" 
                                                    class="text-gray-500 hover:text-gray-700"
                                                    type="button"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                                    </svg>
                                                </button>
                                                
                                                <div 
                                                    x-show="open" 
                                                    @click.away="open = false"
                                                    class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 overflow-hidden border border-gray-200"
                                                    style="display: none;"
                                                >
                                                    <button 
                                                        type="button"
                                                        @click="$dispatch('edit-reply', { replyId: {{ $reply->id }} }); open = false"
                                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                    >
                                                        Edit Reply
                                                    </button>
                                                    
                                                    <form action="{{ route('comments.destroy', $reply) }}" method="POST" class="block w-full">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                                            Delete Reply
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="reply-content mt-1 text-gray-700 text-sm">
                                        <p>{{ $reply->content }}</p>
                                    </div>
                                    
                                    <div class="mt-2 flex items-center space-x-3 text-xs">
                                        <x-comment-like-button :comment="$reply" size="sm" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
