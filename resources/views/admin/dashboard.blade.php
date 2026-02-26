@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ Auth::user()->name }}! </h1>
            <p class="text-gray-600 mt-2">Here's what's happening with your platform today.</p>
        </div>

        <!-- Dashboard Stats with Icons -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Users Card -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg overflow-hidden transform transition-all hover:scale-105 hover:shadow-xl">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium uppercase tracking-wider">Total Users</p>
                            <p class="text-4xl font-bold text-white mt-2">{{ $statistics['total_users'] ?? 0 }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-blue-100">
                        <span class="text-sm">↑ 12% from last month</span>
                    </div>
                </div>
            </div>

            <!-- Active Users Card -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg overflow-hidden transform transition-all hover:scale-105 hover:shadow-xl">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium uppercase tracking-wider">Active Users</p>
                            <p class="text-4xl font-bold text-white mt-2">{{ $statistics['active_users'] ?? 0 }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-green-100">
                        <span class="text-sm">Currently online: 234</span>
                    </div>
                </div>
            </div>

            <!-- Premium Users Card -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg overflow-hidden transform transition-all hover:scale-105 hover:shadow-xl">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium uppercase tracking-wider">Premium Users</p>
                            <p class="text-4xl font-bold text-white mt-2">{{ $statistics['premium_users'] ?? 0 }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-purple-100">
                        <span class="text-sm">↑ 8% conversion rate</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions with Modern Cards -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Quick Actions</h2>
                <span class="text-sm text-gray-500">Most used tools</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Manage Users Card -->
                <a href="{{ route('admin.users.index') }}" class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-blue-200">
                    <div class="flex flex-col items-center text-center">
                        <div class="bg-blue-100 group-hover:bg-blue-600 rounded-full p-4 mb-4 transition-colors duration-300">
                            <svg class="w-6 h-6 text-blue-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-800 group-hover:text-blue-600 transition-colors duration-300">Manage Users</h3>
                        <p class="text-sm text-gray-500 mt-2">View, edit, and manage user accounts</p>
                    </div>
                </a>

                <!-- View Analytics Card -->
                <a href="{{ route('admin.analytics.index') }}" class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-green-200">
                    <div class="flex flex-col items-center text-center">
                        <div class="bg-green-100 group-hover:bg-green-600 rounded-full p-4 mb-4 transition-colors duration-300">
                            <svg class="w-6 h-6 text-green-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-800 group-hover:text-green-600 transition-colors duration-300">View Analytics</h3>
                        <p class="text-sm text-gray-500 mt-2">Track platform performance metrics</p>
                    </div>
                </a>

                <!-- Manage Subscriptions Card -->
                <a href="{{ route('admin.subscriptions.index') }}" class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-purple-200">
                    <div class="flex flex-col items-center text-center">
                        <div class="bg-purple-100 group-hover:bg-purple-600 rounded-full p-4 mb-4 transition-colors duration-300">
                            <svg class="w-6 h-6 text-purple-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-800 group-hover:text-purple-600 transition-colors duration-300">Manage Subscriptions</h3>
                        <p class="text-sm text-gray-500 mt-2">Oversee plans and billing</p>
                    </div>
                </a>

                <!-- Manage Roles Card -->
                <a href="{{ route('admin.roles.index') }}" class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-yellow-200">
                    <div class="flex flex-col items-center text-center">
                        <div class="bg-yellow-100 group-hover:bg-yellow-600 rounded-full p-4 mb-4 transition-colors duration-300">
                            <svg class="w-6 h-6 text-yellow-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-800 group-hover:text-yellow-600 transition-colors duration-300">Manage Roles</h3>
                        <p class="text-sm text-gray-500 mt-2">Configure permissions & access</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Activity Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Activity List -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Recent Activity</h2>
                    <button class="text-sm text-blue-600 hover:text-blue-800 font-medium">View All →</button>
                </div>
                <div class="space-y-4">
                    <!-- Activity Item 1 -->
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="bg-green-100 rounded-full p-2 mr-4">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">New user registered</p>
                            <p class="text-xs text-gray-500">5 minutes ago</p>
                        </div>
                        <span class="text-xs text-gray-400">#USR-001</span>
                    </div>

                    <!-- Activity Item 2 -->
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="bg-purple-100 rounded-full p-2 mr-4">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Premium subscription upgraded</p>
                            <p class="text-xs text-gray-500">1 hour ago</p>
                        </div>
                        <span class="text-xs text-gray-400">#SUB-123</span>
                    </div>

                    <!-- Activity Item 3 -->
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="bg-blue-100 rounded-full p-2 mr-4">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">New chat conversation</p>
                            <p class="text-xs text-gray-500">3 hours ago</p>
                        </div>
                        <span class="text-xs text-gray-400">#CHT-456</span>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Quick Stats</h2>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Today's Signups</span>
                            <span class="font-semibold text-gray-900">24</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 rounded-full h-2" style="width: 65%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Subscription Rate</span>
                            <span class="font-semibold text-gray-900">78%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 rounded-full h-2" style="width: 78%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Engagement Rate</span>
                            <span class="font-semibold text-gray-900">92%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-purple-600 rounded-full h-2" style="width: 92%"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Server Status</span>
                        <span class="flex items-center text-green-600">
                            <span class="w-2 h-2 bg-green-600 rounded-full mr-2"></span>
                            Online
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection