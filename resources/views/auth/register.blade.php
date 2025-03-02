<x-guest-layout>
<div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Welcome back</h2>
        <p class="text-gray-600 mt-2">Sign in to continue to DevConnect</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
 
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="fullname" :value="__('Full Name')" class="text-gray-300" />
                    <x-text-input id="fullname" 
                        class="block mt-1 w-full bg-gray-700 border-gray-600 text-gray-200 focus:border-blue-500 focus:ring-blue-500" 
                        type="text" 
                        name="fullname" 
                        :value="old('fullname')" 
                        required 
                        autofocus 
                        autocomplete="name" />
                    <x-input-error :messages="$errors->get('fullname')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-gray-300" />
                    <x-text-input id="email" 
                        class="block mt-1 w-full bg-gray-700 border-gray-600 text-gray-200 focus:border-blue-500 focus:ring-blue-500" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-gray-300" />
                    <x-text-input id="password" 
                        class="block mt-1 w-full bg-gray-700 border-gray-600 text-gray-200 focus:border-blue-500 focus:ring-blue-500"
                        type="password"
                        name="password"
                        required 
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-300" />
                    <x-text-input id="password_confirmation" 
                        class="block mt-1 w-full bg-gray-700 border-gray-600 text-gray-200 focus:border-blue-500 focus:ring-blue-500"
                        type="password"
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-6">
                    <a class="text-sm text-gray-300 hover:text-blue-400 transition-colors duration-200" href="{{ route('login') }}">
                        {{ __('Already have an account?') }}
                    </a>

                    <x-primary-button class="bg-blue-600 hover:bg-blue-700 focus:ring-blue-500">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
