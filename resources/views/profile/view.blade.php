<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-medium text-xl text-vintage-dark">
                {{ __('Profile') }}
            </h2>
            <a href="{{ route('profile.edit') }}" class="btn-primary">Edit Profile</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card mb-6">
                <div class="flex items-start space-x-6">
                    <div class="flex-shrink-0">
                        <img class="w-24 h-24 rounded-full border-2 border-vintage-accent" src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture">
                    </div>
                    <div>
                        <h3 class="text-2xl font-medium text-vintage-dark">{{ $user->name }}</h3>
                        <p class="text-vintage-brown">{{ $user->email }}</p>
                        <p class="mt-2 text-vintage-dark">{{ $user->bio }}</p>
                    </div>
                </div>
            </div>

            <!-- Skills Section -->
            <div class="card mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-medium text-vintage-dark">Skills</h3>
                    <a href="{{ route('profile.edit') }}" class="btn-primary">Add Skill</a>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach($user->skills as $skill)
                        <span class="skill-badge">{{ $skill->name }}</span>
                    @endforeach
                </div>
            </div>

            <!-- Projects Section -->
            <div class="card mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-medium text-vintage-dark">Projects</h3>
                    <a href="{{ route('projects.create') }}" class="btn-primary">Add Project</a>
                </div>
                <div class="space-y-4">
                    @foreach($user->projects as $project)
                        <div class="border-b border-vintage-border pb-4">
                            <h4 class="text-lg font-medium text-vintage-dark">{{ $project->title }}</h4>
                            <p class="text-vintage-brown">{{ $project->description }}</p>
                            <div class="mt-2">
                                <a href="{{ $project->link }}" class="nav-link" target="_blank">View Project</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Posts Section -->
            <div class="card">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-medium text-vintage-dark">Posts</h3>
                    <a href="{{ route('posts.create') }}" class="btn-primary">Add Post</a>
                </div>
                <div class="space-y-4">
                    @foreach($user->posts as $post)
                        <div class="border-b border-vintage-border pb-4">
                            <h4 class="text-lg font-medium text-vintage-dark">{{ $post->title }}</h4>
                            <p class="text-vintage-brown">{{ $post->content }}</p>
                            <div class="mt-2 flex items-center space-x-4">
                                <span class="text-vintage-accent">
                                    <i class="fas fa-heart mr-1"></i>{{ $post->likes_count }}
                                </span>
                                <span class="text-vintage-accent">
                                    <i class="fas fa-comment mr-1"></i>{{ $post->comments_count }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>