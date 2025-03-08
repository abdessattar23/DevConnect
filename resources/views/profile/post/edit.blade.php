<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="card">
            <h3 class="text-xl font-medium text-vintage-dark mb-6">Edit Post</h3>
            <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PATCH')
                <div>
                    <x-input-label for="title" :value="__('Title')" required="true" />
                    <x-text-input id="title" name="title" type="text" class="form-input mt-1 w-full" :value="$post->title" required />
                </div>
                <div>
                    <x-input-label for="content" :value="__('Content')" required="true" />
                    <textarea name="content" id="content" class="form-input mt-1 w-full min-h-[120px]" required>{{ $post->content }}</textarea>
                </div>
                <div>
                    <x-input-label for="image" :value="__('Image')" />
                    <input type="file" name="image" id="image" accept="image/*" class="form-input mt-1 w-full">
                    @if($post->image)
                        <div class="mt-4 rounded-lg border border-vintage-border overflow-hidden">
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-full h-auto">
                        </div>
                    @endif
                </div>
                <div>
                    <x-input-label for="hashtags" :value="__('Existing Hashtags')" />
                    <select name="hashtags[]" id="hashtags" class="form-input mt-1 w-full" multiple>
                        @foreach($hashtags as $hashtag)
                            <option value="{{ $hashtag->id }}" @if(in_array($hashtag->id, $post->hashtags->pluck('id')->toArray())) selected @endif>
                                #{{ $hashtag->name }}
                            </option>
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
                        {{ __('Update Post') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>