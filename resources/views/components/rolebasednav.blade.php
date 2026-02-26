<nav class="bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" 
                       class="text-2xl font-extrabold bg-gradient-to-r from-yellow-300 via-pink-300 to-cyan-300 bg-clip-text text-transparent hover:from-yellow-400 hover:via-pink-400 hover:to-cyan-400 transition-all duration-300 transform hover:scale-105">
                        CSE Tech
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-white bg-opacity-20 rounded-full border-2 border-transparent hover:bg-opacity-30 hover:border-white hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                        <svg class="w-4 h-4 mr-2 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6-1h6m-6-1v-1a2 2 0 012-2h2a2 2 0 012 2v1m-6-1v-1a2 2 0 00-2-2H5a2 2 0 00-2 2v1m4 0h4m-4 0h-1m3 0h1m0 0h1m-1 0v1m0-1v-1"></path>
                        </svg>
                        DASHBOARD
                    </a>

                    @auth
                        @if(auth()->user()->hasPermission('access_chat'))
                            <a href="{{ route('chat.index') }}" 
                               class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-white bg-opacity-20 rounded-full border-2 border-transparent hover:bg-opacity-30 hover:border-white hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                <svg class="w-4 h-4 mr-2 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                AI Chat
                            </a>
                        @endif

                        @if(auth()->user()->hasPermission('manage_users'))
                            <a href="{{ route('admin.dashboard') }}" 
                               class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-white bg-opacity-20 rounded-full border-2 border-transparent hover:bg-opacity-30 hover:border-white hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                <svg class="w-4 h-4 mr-2 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Admin
                            </a>
                        @endif

                        @if(auth()->user()->hasPermission('view_analytics'))
                            <a href="{{ route('admin.analytics.index') }}" 
                               class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-white bg-opacity-20 rounded-full border-2 border-transparent hover:bg-opacity-30 hover:border-white hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                <svg class="w-4 h-4 mr-2 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Analytics
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                @guest
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-white bg-opacity-20 rounded-full border-2 border-transparent hover:bg-opacity-30 hover:border-white hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                        <svg class="w-4 h-4 mr-2 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-pink-500 to-purple-600 rounded-full border-2 border-transparent hover:from-pink-600 hover:to-purple-700 hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                        <svg class="w-4 h-4 mr-2 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Sign Up
                    </a>
                @else
                    <!-- User Menu -->
                    <div class="ml-3 relative">
                        <div class="flex items-center space-x-3">
                            <span class="text-sm font-semibold text-white bg-white bg-opacity-20 px-3 py-1.5 rounded-full border-2 border-transparent hover:bg-opacity-30 hover:border-white hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                {{ auth()->user()->name }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-green-400 to-blue-500 text-white border-2 border-transparent hover:from-green-500 hover:to-blue-600 hover:border-white hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                {{ auth()->user()->role?->name ?? 'No Role' }}
                            </span>
                        </div>
                    </div>

                    <div class="ml-3 space-x-2">
                        <a href="{{ route('profile.edit') }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-blue-500 to-cyan-600 rounded-full border-2 border-transparent hover:from-blue-600 hover:to-cyan-700 hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                            <svg class="w-4 h-4 mr-2 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-red-500 to-pink-600 rounded-full border-2 border-transparent hover:from-red-600 hover:to-pink-700 hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                <svg class="w-4 h-4 mr-2 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Sign Out
                            </button>
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>
