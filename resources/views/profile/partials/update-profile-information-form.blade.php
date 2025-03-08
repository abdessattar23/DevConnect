<section>
    <header class="mb-6">
        <h2 class="text-lg font-medium text-vintage-dark">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-2 text-sm text-vintage-brown">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="grid sm:grid-cols-2 gap-6">
            <!-- Cover Photo Preview -->
            <div>
                <div class="mb-2 aspect-video rounded-lg border border-vintage-border overflow-hidden">
                    <img src="{{ asset('storage/' . $user->cover) }}" alt="Cover Photo" class="w-full h-full object-cover">
                </div>
                <div>
                    <x-input-label for="cover" :value="__('Cover Photo')" />
                    <input type="file" name="cover" id="cover" accept="image/*" class="form-input mt-1 w-full">
                </div>
            </div>

            <!-- Profile Picture Preview -->
            <div>
                <div class="mb-2 w-32 h-32 mx-auto rounded-full border border-vintage-border overflow-hidden">
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="w-full h-full object-cover">
                </div>
                <div>
                    <x-input-label for="profile_picture" :value="__('Profile Picture')" />
                    <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="form-input mt-1 w-full">
                </div>
            </div>
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="form-input mt-1 w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="form-input mt-1 w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-vintage-brown">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="nav-link text-sm">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-vintage-accent">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <textarea id="bio" name="bio" class="form-input mt-1 w-full min-h-[120px]">{{ old('bio', $user->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <div>
            <x-input-label for="skills" :value="__('Skills')" />
            <div class="flex flex-wrap gap-2 mt-2">
                @foreach($user->skills as $skill)
                    <span class="skill-badge">{{ $skill->name }}</span>
                @endforeach
            </div>
            <select id="skills" name="skills[]" class="form-input mt-4 w-full" multiple onchange="updateSelectedSkills()">
                @foreach($skills as $skill)
                    <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('skills')" />
        </div>
        
        <div id="selectedSkillsContainer" class="card p-4">
            <div id="selectedSkills" class="flex flex-wrap gap-2"></div>
        </div>

        <div>
            <x-input-label for="website" :value="__('Website')" />
            <x-text-input id="website" name="website" type="url" class="form-input mt-1 w-full" :value="old('website', $user->website)" placeholder="https://example.com" />
            <x-input-error class="mt-2" :messages="$errors->get('website')" />
        </div>

        <div>
            <x-input-label for="github_url" :value="__('GitHub URL')" />
            <x-text-input id="github_url" name="github_url" type="url" class="form-input mt-1 w-full" :value="old('github_url', $user->github_url)" placeholder="https://github.com/username" />
            <x-input-error class="mt-2" :messages="$errors->get('github_url')" />
        </div>

        <div>
            <x-input-label for="linkedin_url" :value="__('LinkedIn URL')" />
            <x-text-input id="linkedin_url" name="linkedin_url" type="url" class="form-input mt-1 w-full" :value="old('linkedin_url', $user->linkedin_url)" placeholder="https://linkedin.com/in/username" />
            <x-input-error class="mt-2" :messages="$errors->get('linkedin_url')" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-vintage-accent"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>