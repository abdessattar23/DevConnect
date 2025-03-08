<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="card">
            <h3 class="text-xl font-medium text-vintage-dark mb-6">Add Post</h3>
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <x-input-label for="title" :value="__('Title')" required="true" />
                    <x-text-input id="title" name="title" type="text" class="form-input mt-1 w-full" required />
                </div>
                <div>
                    <x-input-label for="content" :value="__('Content')" required="true" />
                    <textarea name="content" id="content" class="form-input mt-1 w-full min-h-[120px]" required></textarea>
                </div>
                <div>
                    <x-input-label for="image" :value="__('Image')" />
                    <input type="file" name="image" id="image" accept="image/*" class="form-input mt-1 w-full">
                </div>
                <div>
                    <x-input-label for="hashtags" :value="__('Existing Hashtags')" />
                    <select name="hashtags[]" id="hashtags" class="form-input mt-1 w-full" multiple>
                        @foreach($hashtags as $hashtag)
                            <option value="{{ $hashtag->id }}">#{{ $hashtag->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <x-input-label for="new_hashtags" :value="__('New Hashtags')" />
                    <x-text-input type="text" name="new_hashtags" id="new_hashtags" class="form-input mt-1 w-full" placeholder="Comma separated: web,dev,coding" />
                </div>
                <div class="flex justify-end gap-4">
                    <button type="button" onclick="history.back()" class="btn-primary bg-vintage-cream text-vintage-brown border-vintage-border hover:bg-vintage-light">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" class="btn-primary">
                        {{ __('Create Post') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>