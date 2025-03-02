@props(['post', 'parentId' => null, 'placeholder' => 'Add a comment...', 'rows' => 2, 'buttonText' => 'Post'])

<div 
    x-data="{ 
        content: '',
        submitting: false,
        error: null,
        submitForm() {
            if (!this.content.trim()) {
                this.error = 'Please enter a comment';
                return;
            }
            
            this.submitting = true;
            this.error = null;

            const formData = new FormData();
            formData.append('content', this.content);
            @if($parentId)
            formData.append('parent_id', '{{ $parentId }}');
            @endif
            
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
                
                // Emit an event with the new comment data for the parent to handle
                this.$dispatch('comment-added', data);
            })
            .catch(error => {
                this.submitting = false;
                this.error = 'An error occurred while submitting your comment';
                console.error('Error:', error);
            });
        }
    }"
>
    <form @submit.prevent="submitForm" class="flex flex-col">
        <div class="flex items-start space-x-2">
            <div class="flex-grow">
                <textarea 
                    x-model="content" 
                    x-bind:disabled="submitting"
                    rows="{{ $rows }}"
                    placeholder="{{ $placeholder }}" 
                    class="w-full px-4 py-2 text-sm bg-gray-100 border border-transparent rounded-lg focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 resize-none transition-colors"
                ></textarea>
            </div>
            <button 
                type="submit" 
                x-bind:disabled="submitting"
                class="px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <span x-show="!submitting">{{ $buttonText }}</span>
                <span x-show="submitting" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Posting...
                </span>
            </button>
        </div>
        <div x-show="error" x-text="error" class="text-red-500 text-sm mt-1" style="display: none;"></div>
    </form>
</div>
