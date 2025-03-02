<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-blue-600">Comments on Post</h2>
                        <a href="{{ url()->previous() }}" class="text-blue-500 hover:text-blue-700 transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Back to Post
                        </a>
                    </div>
                    
                    <!-- Original Post -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6 border border-gray-200 shadow-sm">
                        <div class="flex items-center mb-4">
                            <div class="h-12 w-12 rounded-full overflow-hidden mr-3 border-2 border-white shadow-sm">
                                @if($post->user->profile_picture)
                                    <img src="{{ asset('storage/' . $post->user->profile_picture) }}" alt="{{ $post->user->fullname }}" class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full flex items-center justify-center bg-blue-500">
                                        <span class="text-lg font-bold text-white">{{ substr($post->user->fullname, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <a href="{{ route('profile.user', $post->user->id) }}" class="font-semibold text-blue-600 hover:underline">{{ $post->user->fullname }}</a>
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
                        
                        @if($post->image)
                            <div class="mt-4">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="rounded-lg max-h-96 w-auto">
                            </div>
                        @endif
                        
                        <div class="mt-4 flex items-center space-x-4">
                            <x-like-button :post="$post" />
                            <span class="text-gray-500 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                                </svg>
                                {{ $comments->count() }} {{ Str::plural('Comment', $comments->count()) }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Comment Form -->
                    <div class="mb-8" x-data="{ commentAdded: false, newComment: null }" @comment-added.window="
                        commentAdded = true;
                        newComment = $event.detail.comment;
                        setTimeout(() => {
                            commentAdded = false;
                            // Add the new comment to the list
                            document.getElementById('comments-container').insertAdjacentHTML('afterbegin', 
                                `<div class='bg-green-50 p-2 mb-2 rounded border border-green-200 text-green-700 text-sm'>
                                    Comment added successfully! Refreshing...
                                </div>`
                            );
                            // Reload the page after a short delay to show the new comment
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        }, 3000);
                    ">
                        <h3 class="text-lg font-semibold mb-2">Add a Comment</h3>
                        <x-comment-form :post="$post" placeholder="Write your comment here..." />
                        
                        <div x-show="commentAdded" class="mt-3 p-3 bg-green-50 text-green-700 rounded border border-green-200" style="display: none;">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Comment added successfully! The page will refresh shortly to show your comment.</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Comments List -->
                    <div id="comments-container">
                        <h3 class="text-lg font-semibold mb-4">{{ $comments->count() }} {{ Str::plural('Comment', $comments->count()) }}</h3>
                        
                        @if($comments->count() > 0)
                            <div class="space-y-6" x-data="{ replyingTo: null, editingComment: null }">
                                @foreach($comments as $comment)
                                    <x-comment :comment="$comment" :post="$post" />
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
    
    <script>
        // Toggle dropdown menus
        document.addEventListener('DOMContentLoaded', function() {
            // Handle dropdowns
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const menu = this.nextElementSibling;
                    menu.classList.toggle('hidden');
                });
            });
            
            // Close all dropdowns when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.dropdown-toggle')) {
                    document.querySelectorAll('.dropdown-menu').forEach(menu => {
                        menu.classList.add('hidden');
                    });
                }
            });
        });
    </script>
</x-app-layout>
