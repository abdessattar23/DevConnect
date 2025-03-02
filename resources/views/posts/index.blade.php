<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Posts') }}
            </h2>
            <a href="{{ route('post.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create Post
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div id="posts-container" class="space-y-6" data-next-page="{{ $posts->nextPageUrl() }}">
                @foreach ($posts as $post)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class="flex justify-between items-start">
                                <div class="flex items-center space-x-4">
                                    <div class="font-medium text-gray-900">
                                        {{ $post->user->name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $post->published_date->diffForHumans() }}
                                    </div>
                                </div>
                                @if (Auth::id() === $post->user_id)
                                    <div class="flex space-x-2">
                                        <a href="{{ route('post.edit', $post) }}"
                                            class="text-blue-600 hover:text-blue-900">Edit</a>
                                        <form action="{{ route('post.destroy', $post) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900"
                                                onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                                        </form>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-4">
                                <p class="text-gray-800">{{ $post->content }}</p>
                                @if ($post->image_url)
                                    <img src="{{ $post->image_url }}" alt="Post image" class="mt-4 rounded-lg max-h-96 w-auto">
                                @endif
                                @if ($post->code_snippet)
                                    <pre
                                        class="mt-4 p-4 bg-gray-100 rounded-lg overflow-x-auto"><code>{{ $post->code_snippet }}</code></pre>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="loading-indicator" class="hidden mt-4 flex justify-center items-center w-full" role="status">
                <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin fill-blue-600"
                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>
                <span class="sr-only">Loading...</span>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let nextPage = null;
            let loading = false;
            const postsContainer = document.getElementById('posts-container');
            const loadingIndicator = document.getElementById('loading-indicator');

            function loadMorePosts() {
                if (loading || !nextPage) return;

                loading = true;
                if (loadingIndicator) loadingIndicator.classList.remove('hidden');

                fetch(nextPage, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        postsContainer.insertAdjacentHTML('beforeend', data.html);
                        nextPage = data.nextPage;
                        if (!nextPage) {
                            window.removeEventListener('scroll', handleScroll);
                        }
                    })
                    .catch(error => console.error('Error loading posts:', error))
                    .finally(() => {
                        loading = false;
                        if (loadingIndicator) loadingIndicator.classList.add('hidden');
                    });
            }

            function handleScroll() {
                const scrollPosition = window.innerHeight + window.scrollY;
                const scrollThreshold = document.documentElement.scrollHeight - 800;

                if (scrollPosition >= scrollThreshold) {
                    loadMorePosts();
                }
            }
            if (postsContainer) {
                nextPage = postsContainer.dataset.nextPage;
                if (nextPage) {
                    window.addEventListener('scroll', handleScroll);
                }
            }
        });
    </script>
</x-app-layout>