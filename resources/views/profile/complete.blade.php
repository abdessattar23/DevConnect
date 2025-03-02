<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevConnect - Complete Your Profile</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-[#f3f2ee]">
    <!-- Navigation -->
    <x-navigation></x-navigation>
        <!-- success message  -->
        @if(session('success'))
          <div class="bg-green-100 border-l-4 border-green-400 text-green-700 px-4 py-2 rounded-r relative mb-3 shadow-2xl">
              <span class="block sm:inline">{{ session('success') }}</span>
              <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                  <svg class="fill-current h-4 w-4 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 8.586l-4.95-4.95a1 1 0 10-1.414 1.415L8.586 10l-4.95 4.95a1 1 0 101.414 1.415L10 11.414l4.95 4.95a1 1 0 101.415-1.415L11.414 10l4.95-4.95a1 1 0 10-1.414-1.415L10 8.586z" clip-rule="evenodd"/>
                  </svg>
              </button>
          </div>
        @endif
      <!-- error message  -->
      @if(session('error'))
          <div class="bg-green-100 border-l-4 border-red-400 text-red-700 px-4 py-2 rounded-r relative mb-3 shadow-2xl">
              <span class="block sm:inline">{{ session('error') }}</span>
              <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                  <svg class="fill-current h-4 w-4 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 8.586l-4.95-4.95a1 1 0 10-1.414 1.415L8.586 10l-4.95 4.95a1 1 0 101.414 1.415L10 11.414l4.95 4.95a1 1 0 101.415-1.414L11.414 10l4.95-4.95a1 1 0 10-1.414-1.415L10 8.586z" clip-rule="evenodd"/>
                  </svg>
              </button>
          </div>
      @endif

      <!-- error message  -->
      @if ($errors->any())
          <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-2 rounded-r flex">
              <ul class="mt-1 ml-6 list-disc text-red-700">
                  @foreach ($errors->all() as $error)
                      <li class="mt-1">{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
    <!-- Profile Form Section -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Complete Your Profile</h1>
                <p class="text-gray-600 mb-8">Help us personalize your experience and connect you with the right opportunities.</p>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Cover Picture Upload -->
                    <div class="space-y-2 mb-6">
                        <label class="block text-sm font-medium text-gray-700">Cover Picture</label>
                        <div class="relative w-full h-48 bg-gray-100 rounded-lg overflow-hidden">
                            @if($user->cover_picture)
                                <img src="{{ Storage::url($user->cover_picture) }}" alt="Cover Picture" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                    <span class="text-gray-500">No cover image uploaded</span>
                                </div>
                            @endif
                            <label for="cover_picture" class="absolute bottom-4 right-4 cursor-pointer bg-blue-600 text-white px-3 py-2 rounded shadow-md hover:bg-blue-700 transition-colors">
                                <i class="fas fa-camera mr-2"></i>Change Cover
                            </label>
                            <input type="file" id="cover_picture" name="cover_picture" class="hidden" accept="image/*">
                        </div>
                    </div>

                    <!-- Profile Picture Upload -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Profile Picture</label>
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                @if($user->profile_picture)
                                    <img src="{{ Storage::url($user->profile_picture) }}" alt="Profile preview" class="w-24 h-24 rounded-full object-cover">
                                @else
                                    <img src="https://avatar.iran.liara.run/public/boy" alt="Profile preview" class="w-24 h-24 rounded-full object-cover">
                                @endif
                                <label for="profile_picture" class="absolute bottom-0 right-0 bg-blue-600 text-white p-1.5 rounded-full cursor-pointer hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-camera text-sm"></i>
                                </label>
                                <input type="file" id="profile_picture" name="profile_picture" class="hidden" accept="image/*">
                            </div>
                        </div>
                    </div>

                        <!-- Full Name & Bio -->
                        <div class="w-full md:w-2/3">
                            <div class="mb-6">
                                <label for="fullName" class="block text-gray-700 font-medium mb-2">Full Name*</label>
                                <input value="{{$user->fullname}}" type="text" id="fullName" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-colors duration-300" placeholder="e.g., John Doe" name="fullname" required>
                            </div>

                            <div class="mb-6">
                                <label for="bio" class="block text-gray-700 font-medium mb-2">Bio*</label>
                                <textarea id="bio" rows="4" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-colors duration-300" name="bio" placeholder="Tell us about yourself, your experience, and what you're passionate about..." required>{{$user->bio ?? 'no bio yet, try to express yourself'}}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Technical Details -->
                    <div class="mb-6">
                        <label for="languages" class="block text-gray-700 font-medium mb-2">Programming Languages*</label>
                        <input value="{{$user->language ?? 'no programming languages to display try to add some'}}" type="text" id="languages" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-colors duration-300" name="language" placeholder="e.g., JavaScript, Python, Java (comma separated)" required>
                        <p class="text-gray-500 text-sm mt-1">Enter the programming languages you're proficient in, separated by commas</p>
                    </div>

                    <div class="mb-8">
                        <label for="githubUrl" class="block text-gray-700 font-medium mb-2">GitHub URL</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500">
                                <i class="fab fa-github"></i>
                            </span>
                            <input value="{{$user->github_url ?? ''}}" name="github_url" type="url" id="githubUrl" class="flex-grow px-4 py-3 rounded-r-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-colors duration-300" placeholder="https://github.com/username">
                        </div>
                    </div>

                    <div class="mb-8">
                        <label for="linkedinUrl" class="block text-gray-700 font-medium mb-2">LinkedIn URL</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500">
                                <i class="fab fa-linkedin"></i>
                            </span>
                            <input value="{{$user->linkedin_url ?? ''}}" name="linkedin_url" type="url" id="linkedinUrl" class="flex-grow px-4 py-3 rounded-r-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-colors duration-300" placeholder="https://linkedin.com/in/username">
                        </div>
                    </div>

                    <div class="mb-8">
                        <label for="website" class="block text-gray-700 font-medium mb-2">Personal Website</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500">
                                <i class="fas fa-globe"></i>
                            </span>
                            <input value="{{$user->website ?? ''}}" name="website" type="url" id="website" class="flex-grow px-4 py-3 rounded-r-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-colors duration-300" placeholder="https://yourdomain.com">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            Save Profile
                        </button>
                    </div>
                </form>
            </div>

            <div class="text-center mt-8 text-gray-600">
                <p>Need help setting up your profile? <a href="#" class="text-blue-500 hover:text-blue-600">Check our guide</a></p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-2 mb-4 md:mb-0">
                    <i class="fas fa-code text-blue-400 text-xl"></i>
                    <span class="text-white font-bold">DevConnect</span>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300">Terms of Service</a>
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300">Help</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Profile image upload preview
        document.querySelector('.group').addEventListener('click', function() {
            document.getElementById('profile-upload').click();
        });

        document.getElementById('profile-upload').addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const preview = document.getElementById('profile-preview');
                    preview.style.backgroundImage = `url(${e.target.result})`;
                    preview.classList.remove('hidden');
                    document.querySelector('.group .fa-user').classList.add('hidden');
                }

                reader.readAsDataURL(file);
            }
        });

        // Cover image upload preview
        document.querySelector('.border-dashed').addEventListener('click', function() {
            document.getElementById('cover-upload').click();
        });

        document.getElementById('cover-upload').addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const preview = document.getElementById('cover-preview');
                    preview.style.backgroundImage = `url(${e.target.result})`;
                    preview.classList.remove('hidden');
                }

                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
