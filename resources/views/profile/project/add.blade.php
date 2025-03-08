<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="card">
            <h3 class="text-xl font-medium text-vintage-dark mb-6">Add Project</h3>
            <form action="{{ route('projects.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <x-input-label for="title" :value="__('Title')" required="true" />
                    <x-text-input id="title" name="title" type="text" class="form-input mt-1 w-full" required />
                </div>
                <div>
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea name="description" id="description" class="form-input mt-1 w-full min-h-[120px]"></textarea>
                </div>
                <div>
                    <x-input-label for="repo_link" :value="__('Repository Link')" />
                    <x-text-input type="url" name="repo_link" id="repo_link" class="form-input mt-1 w-full" placeholder="https://github.com/username/repo" />
                </div>
                <div class="flex justify-end gap-4">
                    <button type="button" onclick="history.back()" class="btn-primary bg-vintage-cream text-vintage-brown border-vintage-border hover:bg-vintage-light">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" class="btn-primary">
                        {{ __('Create Project') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>