<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DevConnect - Professional Developer Network</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hover-scale { transition: transform 0.2s; }
        .hover-scale:hover { transform: scale(1.02); }
        .feature-card { transition: all 0.3s ease; }
        .feature-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px -4px rgba(0, 0, 0, 0.1);
        }
        .glass-nav {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-[#F3F2EF]">
    <!-- Hero Section -->
    <div class="relative bg-[#0A66C2] min-h-screen overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-[#0A66C2] to-[#0073B1] opacity-90"></div>
        <div class="absolute inset-0 opacity-10 bg-pattern"></div>
        <nav class="fixed top-0 left-0 right-0 z-50 glass-nav">
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <x-devconnect-logo class="w-48 h-12 text-white devconnect-logo" />
                    <div class="space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-white hover:text-[#E7E7E7] nav-item">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-white hover:text-[#E7E7E7] nav-item">Sign in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-white text-[#0A66C2] px-6 py-2 rounded-full font-medium hover:bg-[#E7E7E7] transition-colors nav-item">Join now</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
            
            
            <div class="text-center">
                <h1 class="text-4xl sm:text-6xl font-bold text-white mb-8 hero-text">Welcome to your professional developer community</h1>
                <p class="text-xl text-[#E7E7E7] mb-12 max-w-3xl mx-auto">Connect with fellow developers, showcase your work, and unlock career opportunities in tech.</p>
                <a href="{{ route('register') }}" class="bg-white text-[#0A66C2] px-8 py-4 rounded-full text-lg font-medium hover:bg-[#E7E7E7] transition-colors inline-block shadow-lg">Get Started</a>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center mb-4 text-[#0A66C2]">Grow your developer network</h2>
            <p class="text-[#666666] text-center mb-16 text-lg">Join thousands of tech professionals advancing their careers</p>
            <div class="grid md:grid-cols-3 gap-12">
                <div class="feature-card bg-white p-8 rounded-xl shadow-sm border border-[#E7E7E7]">
                    <div class="text-center">
                        <div class="bg-[#EEF3F8] rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-[#0A66C2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-4 text-[#333333]">Build Your Network</h3>
                        <p class="text-[#666666]">Connect with developers, tech leads, and industry experts who share your interests.</p>
                    </div>
                </div>

                <div class="feature-card bg-white p-8 rounded-xl shadow-sm border border-[#E7E7E7]">
                    <div class="text-center">
                        <div class="bg-[#EEF3F8] rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-[#0A66C2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-4 text-[#333333]">Advance Your Career</h3>
                        <p class="text-[#666666]">Access exclusive job opportunities and get discovered by top tech companies.</p>
                    </div>
                </div>

                <div class="feature-card bg-white p-8 rounded-xl shadow-sm border border-[#E7E7E7]">
                    <div class="text-center">
                        <div class="bg-[#EEF3F8] rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-[#0A66C2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-4 text-[#333333]">Share Knowledge</h3>
                        <p class="text-[#666666]">Showcase your expertise, learn from peers, and contribute to the developer community.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="py-24 bg-[#F3F2EF]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center mb-4 text-[#0A66C2]">Success Stories</h2>
            <p class="text-[#666666] text-center mb-16 text-lg">Hear from developers who found success through DevConnect</p>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-sm border border-[#E7E7E7]">
                    <div class="flex items-center mb-6">
                        <img src="https://avatar.iran.liara.run/public/boy" alt="User" class="w-14 h-14 rounded-full mr-4"/>
                        <div>
                            <h4 class="font-semibold text-[#333333]">David Chen</h4>
                            <p class="text-[#666666] text-sm">Senior Software Engineer at Google</p>
                        </div>
                    </div>
                    <p class="text-[#666666]">"Through DevConnect's network, I connected with industry leaders and landed my dream role at Google. The platform's professional community made all the difference."</p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm border border-[#E7E7E7]">
                    <div class="flex items-center mb-6">
                        <img src="https://avatar.iran.liara.run/public/girl" alt="User" class="w-14 h-14 rounded-full mr-4"/>
                        <div>
                            <h4 class="font-semibold text-[#333333]">Emily Rodriguez</h4>
                            <p class="text-[#666666] text-sm">Tech Lead at Microsoft</p>
                        </div>
                    </div>
                    <p class="text-[#666666]">"DevConnect helped me showcase my expertise and connect with other tech leaders. The opportunities for growth and networking are invaluable."</p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm border border-[#E7E7E7]">
                    <div class="flex items-center mb-6">
                        <img src="https://avatar.iran.liara.run/public/boy" alt="User" class="w-14 h-14 rounded-full mr-4"/>
                        <div>
                            <h4 class="font-semibold text-[#333333]">James Wilson</h4>
                            <p class="text-[#666666] text-sm">Startup Founder & Developer</p>
                        </div>
                    </div>
                    <p class="text-[#666666]">"As a startup founder, DevConnect has been crucial in finding talented developers and building meaningful professional relationships."</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-[#0A66C2] py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-white mb-8">Join the DevConnect Community</h2>
            <p class="text-xl text-[#E7E7E7] mb-12">Take the next step in your professional journey</p>
            <a href="{{ route('register') }}" class="hover-scale bg-white text-[#0A66C2] px-8 py-4 rounded-full text-lg font-medium hover:bg-[#E7E7E7] transition-colors inline-block shadow-lg hover:shadow-xl">
                Create Your Profile
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-[#0A66C2] text-white py-12 border-t border-[#0073B1]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <x-devconnect-logo class="w-40 h-10 mb-4" />
                    <p class="text-sm text-[#E7E7E7]">Empowering developers worldwide.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">General</h4>
                    <ul class="space-y-2 text-sm text-[#E7E7E7]">
                        <li><a href="#" class="hover:text-white">Sign Up</a></li>
                        <li><a href="#" class="hover:text-white">Help Center</a></li>
                        <li><a href="#" class="hover:text-white">About</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Browse DevConnect</h4>
                    <ul class="space-y-2 text-sm text-[#E7E7E7]">
                        <li><a href="#" class="hover:text-white">Learning</a></li>
                        <li><a href="#" class="hover:text-white">Jobs</a></li>
                        <li><a href="#" class="hover:text-white">Developers</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Business Solutions</h4>
                    <ul class="space-y-2 text-sm text-[#E7E7E7]">
                        <li><a href="#" class="hover:text-white">Talent</a></li>
                        <li><a href="#" class="hover:text-white">Marketing</a></li>
                        <li><a href="#" class="hover:text-white">Advertising</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-[#0073B1] mt-12 pt-8 text-sm text-center text-[#E7E7E7]">
                <p>&copy; {{ date('Y') }} DevConnect. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>