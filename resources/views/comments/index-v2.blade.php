<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-blue-600">Comments on Post</h2>
                        <a href="{{ url()->previous() }}" class="text-blue-500 hover:underline">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Back to Post
                        </a>
                    </div>
                    
                    <!-- Original Post -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <div class="flex items-center mb-4">
                            <div class="h-10 w-10 rounded-full overflow-hidden mr-3">
                                @if($post->user->profile_picture)
                                    <img src="{{ asset('storage/' . $post->user->profile_picture) }}" alt="Profile Picture" class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full flex items-center justify-center bg-blue-500">
                                        <span class="text-lg font-bold text-white">{{ substr($post->user->fullname, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <a href="{{ route('profile.user', $post->user->id) }}" class="font-semibold hover:underline">{{ $post->user->fullname }}</a>
                                <p class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        
                        @if($post->title)
                            <h3 class="text-xl font-bold mb-2">{{ $post->title }}</h3>
                        @endif
                        
                        <p class="text-gray-700 mb-4">{{ $post->content }}</p>
                        
                        @if($post->code_snippet)
                            <div class="bg-gray-800 text-white p-4 rounded-lg mb-4 overflow-x-auto">
                                <pre><code>{{ $post->code_snippet }}</code></pre>
                            </div>
                        @endif
                        
                        @if($post->image_url)
                            <div class="mt-4">
                                <img src="{{ asset('storage/' . $post->image_url) }}" alt="Post Image" class="rounded-lg max-h-96">
                            </div>
                        @endif
                        
                        <!-- Likes -->
                        <div class="mt-4 pt-3 border-t border-gray-200">
                            <x-like-button :post="$post" />
                        </div>
                    </div>
                    
                    <!-- Comment Form -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-2">Add a Comment</h3>
                        <x-comment-form :post="$post" placeholder="Write your comment here..." />
                    </div>
                    
                    <!-- Comments List -->
                    <div id="comments-container">
                        <h3 class="text-lg font-semibold mb-4">{{ $comments->count() }} {{ Str::plural('Comment', $comments->count()) }}</h3>
                        
                        @if($comments->count() > 0)
                            <div class="space-y-6" 
                                 x-data="{ 
                                    replyToComment: null,
                                    editComment: null,
                                 }"
                                 @reply-to-comment.window="
                                    replyToComment = $event.detail.commentId;
                                    $nextTick(() => {
                                        document.getElementById('reply-form-' + replyToComment).querySelector('textarea').focus();
                                    });
                                 "
                                 @edit-comment.window="
                                    editComment = $event.detail.commentId;
                                    $nextTick(() => {
                                        document.getElementById('edit-form-' + editComment).querySelector('textarea').focus();
                                    });
                                 "
                            >
                                @foreach($comments as $comment)
                                    <x-comment :comment="$comment" :post="$post" />
                                    
                                    <div x-show="replyToComment === {{ $comment->id }}" class="ml-12 mt-3" id="reply-form-{{ $comment->id }}">
                                        <x-comment-form :post="$post" :parentId="$comment->id" placeholder="Reply to {{ $comment->user->fullname }}..." />
                                        <button @click="replyToComment = null" class="text-sm text-gray-500 mt-1 hover:text-gray-700">
                                            Cancel
                                        </button>
                                    </div>
                                    
                                    <div x-show="editComment === {{ $comment->id }}" class="mt-3" id="edit-form-{{ $comment->id }}">
                                        <form action="{{ route('comments.update', $comment) }}" method="POST" class="flex items-start space-x-2">
                                            @csrf
                                            @method('PATCH')
                                            <div class="flex-grow">
                                                <textarea name="content" rows="2" required class="w-full px-4 py-2 text-sm bg-gray-100 border border-transparent rounded-lg focus:outline-none focus:border-blue-500 focus:bg-white resize-none"></textarea>
                                            </div>
                                            <div class="flex flex-col space-y-2">
                                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                                                    Update
                                                </button>
                                                <button type="button" @click="editComment = null" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 focus:outline-none">
                                                    Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-600">No comments yet. Be the first to comment!</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
