<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DevConnect - Social Network for Developers</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // Set up Axios CSRF token
        window.axios = axios;
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        body {
            background-color: #f9fafb;
        }
        pre {
            white-space: pre-wrap;
        }
    </style>
</head>
<body class="bg-[#f3f2ee]">
    <!-- Navigation -->
<x-navigation></x-navigation>
    <div class="max-w-7xl mx-auto pt-5 px-4">
        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif
        
        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Profile Card -->
            <div class="lg:col-span-3 space-y-6">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-[#f3f2ee]">
                    <div class="relative">
                        <div class="h-24 bg-gradient-to-r from-blue-600 to-blue-400"></div>
                        <img src="https://avatar.iran.liara.run/public/boy" alt="Profile" 
                             class="absolute -bottom-6 left-4 w-20 h-20 rounded-full border-4 border-white shadow-md"/>
                    </div>
                    <div class="pt-14 p-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-bold">{{ Auth::user()->fullname }}</h2>
                            <a href="https://github.com" target="_blank" class="text-gray-600 hover:text-black">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                </svg>
                            </a>
                        </div>
                        <p class="text-gray-600 text-sm mt-1">Senior Full Stack Developer</p>
                        <p class="text-gray-500 text-sm mt-2">Building scalable web applications with modern technologies</p>
                        
                        <div class="mt-4 flex flex-wrap gap-2">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">JavaScript</span>
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Node.js</span>
                            <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">React</span>
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Python</span>
                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Docker</span>
                        </div>

                        <div class="mt-4 pt-4 border-t">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Connections</span>
                                <span class="text-blue-600 font-medium">487</span>
                            </div>
                            <div class="flex justify-between text-sm mt-2">
                                <span class="text-gray-500">Posts</span>
                                <span class="text-blue-600 font-medium">52</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Popular Tags -->
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <h3 class="font-semibold mb-4">Trending Tags</h3>
                    <div class="space-y-2">
                        <a href="#" class="flex items-center justify-between hover:bg-gray-50 p-2 rounded">
                            <span class="text-gray-600">#javascript</span>
                            <span class="text-gray-400 text-sm">2.4k</span>
                        </a>
                        <a href="#" class="flex items-center justify-between hover:bg-gray-50 p-2 rounded">
                            <span class="text-gray-600">#react</span>
                            <span class="text-gray-400 text-sm">1.8k</span>
                        </a>
                        <a href="#" class="flex items-center justify-between hover:bg-gray-50 p-2 rounded">
                            <span class="text-gray-600">#webdev</span>
                            <span class="text-gray-400 text-sm">1.2k</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Feed -->
            <div class="lg:col-span-6 space-y-6">
                <!-- Post Creation -->
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data" x-data="{ showCodeEditor: false, showImageUpload: false }">
                        @csrf
                        <div class="flex items-center space-x-4">
                            @if(Auth::user()->profile_picture)
                                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="User" class="w-12 h-12 rounded-full object-cover"/>
                            @else
                                <img src="https://avatar.iran.liara.run/public/boy" alt="User" class="w-12 h-12 rounded-full"/>
                            @endif
                            <input type="text" name="content" placeholder="Share your knowledge or ask a question..." 
                                   class="bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg px-4 py-3 flex-grow transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <!-- Code Editor (hidden by default) -->
                        <div x-show="showCodeEditor" class="mt-4">
                            <textarea name="code_snippet" rows="5" 
                                     class="w-full bg-gray-800 text-gray-100 font-mono text-sm p-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                     placeholder="// Paste your code here"></textarea>
                        </div>
                        
                        <!-- Image Upload (hidden by default) -->
                        <div x-show="showImageUpload" class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Add an image</label>
                            <input type="file" name="image" accept="image/*" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-lg file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100">
                        </div>
                        
                        <div class="flex justify-between mt-4 pt-4 border-t">
                            <div class="flex space-x-3">
                                <button type="button" @click="showCodeEditor = !showCodeEditor" 
                                       class="flex items-center space-x-2 text-gray-500 hover:bg-gray-100 px-4 py-2 rounded-lg transition-colors duration-200"
                                       :class="{'bg-gray-100': showCodeEditor}">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4M6 16l-4-4 4-4"/>
                                    </svg>
                                    <span>Code</span>
                                </button>
                                
                                <button type="button" @click="showImageUpload = !showImageUpload"
                                       class="flex items-center space-x-2 text-gray-500 hover:bg-gray-100 px-4 py-2 rounded-lg transition-colors duration-200"
                                       :class="{'bg-gray-100': showImageUpload}">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>Image</span>
                                </button>
                            </div>
                            
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                                Post
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Posts -->
                <div id="posts-container" class="space-y-6" data-next-page="{{ $posts->nextPageUrl() }}">
                    @include('posts._post_list', ['posts' => $posts])
                </div>
                
                @if($posts->hasMorePages())
                <div class="flex justify-center mt-6 pb-8">
                    <div id="loading-indicator" class="hidden">
                        <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
                @endif

                @if(count($posts) === 0)
                <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                    <p class="text-gray-500">No posts yet. Be the first to share something with the community!</p>
                </div>
                @endif
            </div>

            <!-- Right Sidebar -->
            <div class="lg:col-span-3 space-y-6">
                <!-- Job Recommendations -->
                
        
                <!-- Ad Placeholder -->
                <div class="bg-white rounded-xl shadow-sm p-4 border-2 border-dashed border-gray-300 flex items-center justify-center h-full">
                    <span class="text-gray-400 font-medium">Ad Space</span>
                </div>
        
                <!-- Suggested Connections -->
                
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let nextPage = null;
            let loading = false;
            const postsContainer = document.getElementById('posts-container');
            const loadingIndicator = document.getElementById('loading-indicator');
            let nextPage = postsContainer.dataset.nextPage;
            let loading = false;
            
            // Function to check if we need to load more posts
            function checkScroll() {
                if (loading || !nextPage) return;
                
                const scrollPosition = window.innerHeight + window.scrollY;
                const contentHeight = document.body.offsetHeight - 500; // Load more when 500px from bottom
                
                if (scrollPosition >= contentHeight) {
                    loadMorePosts();
                }
            }
            
            // Function to load more posts
            function loadMorePosts() {
                loading = true;
                loadingIndicator.classList.remove('hidden');
                
                fetch(nextPage)
                    .then(response => response.json())
                    .then(data => {
                        postsContainer.insertAdjacentHTML('beforeend', data.html);
                        nextPage = data.nextPage;
                        initDynamicComponents(); // Re-initialize Alpine components for new content
                        
                        // If no more pages, remove the scroll event listener
                        if (!nextPage) {
                            window.removeEventListener('scroll', checkScroll);
                        }
                    })
                    .catch(error => console.error('Error loading more posts:', error))
                    .finally(() => {
                        loading = false;
                        loadingIndicator.classList.add('hidden');
                    });
            }
            
            // Function to initialize Alpine.js components for dynamically loaded content
            function initDynamicComponents() {
                // If you're using Alpine.js components in the loaded content
                if (typeof Alpine !== 'undefined') {
                    document.querySelectorAll('[x-data]').forEach(el => {
                        if (!el._x_dataStack) {
                            Alpine.initTree(el);
                        }
                    });
                }
            }
            
            // Add scroll event listener
            if (nextPage) {
                window.addEventListener('scroll', checkScroll);
            }
        });
    </script>
</body>
</html>