<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="user-id" content="{{ auth()->user()->id ?? ''}}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <!-- Pusher  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
const auth_user = document.querySelector('meta[name="user-id"]').content;
            // console.log(typeof auth_user);
            Pusher.logToConsole = true;
            var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                encrypted: true
            });
            // Subscribe to channels
            var comment_Channel = pusher.subscribe('comment-channel');
            var like_Channel = pusher.subscribe('like-channel');
            comment_Channel.bind('comment.notification', function(data) {
                        if (data.state) {
                            if (parseInt(auth_user) === parseInt(data.post_owner_id)) {
                                var oldNotif = parseInt($('.notification-badge').text());
                                var newNotif = oldNotif + 1;
                                document.querySelector('.notification-badge').innerHTML = newNotif;
                            }
                        }
                });


                //like event
                like_Channel.bind('like.notification', function(data) {
                    if (data.actor && data.post) {

                    toastr.info(
                        `<div class="notification-content">
                            <i class="fas fa-book" style="margin-left: 20px;"></i> <span>${data.post} By</span>
                            <i class="fas fa-user"></i> <span>${data.actor}</span>
                        </div>`,
                        'New Like on your post',
                        {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 0,
                            extendedTimeOut: 0,
                            positionClass: 'toast-top-right',
                            enableHtml: true
                        }
                    );
                } else {
                    console.error('Invalid data received:', data);
                }
            });
            pusher.connection.bind('connected', function() {
                console.log('Pusher connected');
            });
</script>
        @livewireStyles

        
        @vite(['resources/css/app.css', 'resources/css/theme.css', 'resources/css/notifications.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-vintage-light">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-vintage-cream border-b border-vintage-border">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <script>

            // Function to update selected skills display
            function updateSelectedSkills() {
                const select = document.getElementById('skills');
                const selectedSkillsContainer = document.getElementById('selectedSkills');
                
                // Clear previous display
                selectedSkillsContainer.innerHTML = '';
                
                // Add selected skills as badges
                for (let option of select.selectedOptions) {
                    let skillBadge = document.createElement('span');
                    skillBadge.textContent = option.text;
                    skillBadge.classList.add('skill-badge', 'px-2', 'py-1', 'rounded-lg', 'text-sm', 'mr-2', 'mb-2', 'inline-block');
                    selectedSkillsContainer.appendChild(skillBadge);
                }
            }

            // Function to toggle comment section
            function toggleCommentSection(postId) {
                const commentSection = document.getElementById(`comment-section-${postId}`);
                commentSection.classList.toggle('hidden');
            }

            // Function to toggle like on a post
            async function toggleLike(postId) {
                try {
                    const response = await fetch(`/posts/${postId}/like`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    });
                    
                    const data = await response.json();
                    if (data.success) {
                        const likeCount = document.querySelector(`#likes-count-${postId}`);
                        if (likeCount) {
                            likeCount.textContent = data.likesCount;
                        }
                        
                        const likeButton = document.querySelector(`[onclick="toggleLike(${postId})"] i`);
                        if (likeButton) {
                            likeButton.style.color = data.isLiked ? 'var(--vintage-accent)' : 'currentColor';
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            }

            // Function to share a post
            function sharePost(postId) {
                const url = `${window.location.origin}/posts/${postId}`;
                if (navigator.share) {
                    navigator.share({
                        title: 'Check out this post on LinkDev',
                        url: url
                    });
                } else {
                    // Fallback to copying to clipboard
                    navigator.clipboard.writeText(url).then(() => {
                        alert('Link copied to clipboard!');
                    });
                }
            }

            // Initialize selected skills display on page load
            document.addEventListener('DOMContentLoaded', function() {
                if (document.getElementById('skills')) {
                    updateSelectedSkills();
                }
                
                // Check likes status for all posts
                document.querySelectorAll('[data-post-id]').forEach(async post => {
                    const postId = post.dataset.postId;
                    try {
                        const response = await fetch(`/posts/${postId}/check-like`);
                        const data = await response.json();
                        const likeButton = post.querySelector('[onclick^="toggleLike"] i');
                        if (likeButton && data.isLiked) {
                            likeButton.style.color = 'var(--vintage-accent)';
                        }
                    } catch (error) {
                        console.error('Error:', error);
                    }
                });
            });
        </script>
        @livewireScripts
    </body>
</html>
