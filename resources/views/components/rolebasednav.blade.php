<nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-800">
                        CSE Tech
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300">
                        Dashboard
                    </a>

                    @auth
                        @if(auth()->user()->hasPermission('access_chat'))
                            <a href="{{ route('chat.index') }}" 
                               class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300">
                                AI Chat
                            </a>
                        @endif

                        @if(auth()->user()->hasPermission('manage_users'))
                            <a href="{{ route('admin.dashboard') }}" 
                               class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300">
                                Admin Panel
                            </a>
                        @endif

                        @if(auth()->user()->hasPermission('view_analytics'))
                            <a href="{{ route('admin.analytics.index') }}" 
                               class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300">
                                Analytics
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                @guest
                    <a href="{{ route('login') }}" 
                       class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" 
                       class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium">
                        Sign Up
                    </a>
                @else
                    <!-- User Menu -->
                    <div class="ml-3 relative">
                        <div class="flex items-center">
                            <span class="mr-2 text-sm text-gray-700">{{ auth()->user()->name }}</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ auth()->user()->role?->name ?? 'No Role' }}
                            </span>
                        </div>
                    </div>

                    <div class="ml-3 space-x-2">
                        <a href="{{ route('profile.edit') }}" 
                           class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                                Sign Out
                            </button>
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>