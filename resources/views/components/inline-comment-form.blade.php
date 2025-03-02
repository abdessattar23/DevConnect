@props(['post'])

<div 
    x-data="{ 
        showForm: false,
        content: '',
        submitting: false,
        error: null,
        success: false,
        toggleForm() {
            this.showForm = !this.showForm;
            if (this.showForm) {
                this.$nextTick(() => {
                    this.$refs.commentInput.focus();
                });
            }
        },
        submitForm() {
            if (!this.content.trim()) {
                this.error = 'Please enter a comment';
                return;
            }
            
            this.submitting = true;
            this.error = null;

            const formData = new FormData();
            formData.append('content', this.content);
            
            fetch('{{ route('comments.store', $post) }}', {
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
                // Reset the form
                this.content = '';
                this.submitting = false;
                this.success = true;
                
                // Update the comment count without page reload
                const commentCountEl = document.querySelector('#comment-count-{{ $post->id }}');
                if (commentCountEl) {
                    const currentCount = parseInt(commentCountEl.textContent.match(/\d+/)[0] || 0);
                    commentCountEl.textContent = `Comment (${currentCount + 1})`;
                }
                
                // Hide success message after delay
                setTimeout(() => {
                    this.success = false;
                    this.showForm = false;
                }, 2000);
            })
            .catch(error => {
                this.submitting = false;
                this.error = 'An error occurred while submitting your comment';
                console.error('Error:', error);
            });
        }
    }"
>
    <button 
        @click="toggleForm"
        type="button" 
        class="flex items-center text-gray-500 hover:text-blue-600 transition-colors"
        x-show="!showForm"
    >
        <i class="far fa-comment-alt mr-1"></i>
        <span id="comment-count-{{ $post->id }}">Comment ({{ $post->allComments->count() }})</span>
    </button>
    
    <div x-show="showForm" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" style="display: none;" class="mt-3">
        <form @submit.prevent="submitForm" class="flex flex-col">
            <textarea 
                x-model="content" 
                x-ref="commentInput"
                x-bind:disabled="submitting"
                rows="2"
                placeholder="Write your comment..." 
                class="w-full px-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 resize-none transition-colors"
            ></textarea>
            
            <div class="flex justify-between mt-2">
                <div>
                    <div x-show="error" x-text="error" class="text-red-500 text-xs" style="display: none;"></div>
                    <div x-show="success" class="text-green-500 text-xs flex items-center" style="display: none;">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Comment added successfully!
                    </div>
                </div>
                <div class="flex space-x-2">
                    <button 
                        type="button" 
                        @click="showForm = false" 
                        x-bind:disabled="submitting"
                        class="px-3 py-1 text-xs text-gray-600 hover:text-gray-800 transition-colors"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit" 
                        x-bind:disabled="submitting"
                        class="px-3 py-1 text-xs bg-blue-500 text-white font-medium rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center"
                    >
                        <span x-show="!submitting">Comment</span>
                        <span x-show="submitting" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-1 h-3 w-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Posting...
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
