@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Welcome Header with Gradient -->
        <div class="mb-8">
            <div class="relative overflow-hidden bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 rounded-2xl shadow-xl p-8">
                <div class="absolute inset-0 bg-black opacity-10"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-2">Welcome back, {{ Auth::user()->name ?? 'User' }}! 👋</h1>
                            <p class="text-purple-100 text-lg">Here's what's happening with your account today</p>
                        </div>
                        <div class="hidden md:block">
                            <div class="flex space-x-2">
                                <span class="w-3 h-3 bg-yellow-400 rounded-full animate-pulse"></span>
                                <span class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></span>
                                <span class="w-3 h-3 bg-blue-400 rounded-full animate-pulse"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards Row -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Students Card -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl hover:shadow-2xl transition-shadow duration-300 transform hover:-translate-y-1">
                <div class="p-6">
                    <div class="flex items-center gap-6">
                        <div class="flex-shrink-0 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl p-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <!-- <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Total Students</p> -->
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Total Students</p>
                            <p class="text-2xl font-bold text-gray-900">10</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Chats Card -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl hover:shadow-2xl transition-shadow duration-300 transform hover:-translate-y-1">
                <div class="p-6">
                    <div class="flex items-center gap-6">
                        <div class="flex-shrink-0 bg-gradient-to-br from-green-400 to-green-600 rounded-xl p-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Active Chats</p>
                            <p class="text-2xl font-bold text-gray-900">12</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Tasks Card -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl hover:shadow-2xl transition-shadow duration-300 transform hover:-translate-y-1">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl p-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Pending Tasks</p>
                            <p class="text-2xl font-bold text-gray-900">5</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Messages Card -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl hover:shadow-2xl transition-shadow duration-300 transform hover:-translate-y-1">
                <div class="p-6">
                    <div class="flex items-center gap-6">
                        <div class="flex-shrink-0 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl p-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Unread Messages</p>
                            <p class="text-2xl font-bold text-gray-900">8</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Quick Actions -->
            <div class="lg:col-span-2">
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                            <span class="bg-gradient-to-r from-purple-600 to-pink-600 text-white p-2 rounded-lg mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </span>
                            Quick Actions
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Start Chat Button -->
                            <a href="{{ route('chat.index') }}" class="group relative overflow-hidden bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 hover:from-blue-600 hover:to-blue-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl">
                                <div class="absolute top-0 right-0 w-20 h-20 bg-white opacity-10 rounded-full -mr-10 -mt-10"></div>
                                <div class="absolute bottom-0 left-0 w-20 h-20 bg-white opacity-10 rounded-full -ml-10 -mb-10"></div>
                                <div class="relative flex items-center space-x-4">
                                    <div class="bg-white bg-opacity-20 rounded-xl p-3">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-white">Start a New Chat</h3>
                                        <p class="text-blue-100 text-sm">Connect with students instantly</p>
                                    </div>
                                </div>
                                <div class="mt-4 flex justify-end">
                                    <span class="inline-flex items-center text-white text-sm font-medium">
                                        Get Started
                                        <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </span>
                                </div>
                            </a>

                            <!-- Manage Students Button -->
                            <a href="{{ route('students.index') }}" class="group relative overflow-hidden bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl">
                                <div class="absolute top-0 right-0 w-20 h-20 bg-white opacity-10 rounded-full -mr-10 -mt-10"></div>
                                <div class="absolute bottom-0 left-0 w-20 h-20 bg-white opacity-10 rounded-full -ml-10 -mb-10"></div>
                                <div class="relative flex items-center space-x-4">
                                    <div class="bg-white bg-opacity-20 rounded-xl p-3">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-white">Manage Students</h3>
                                        <p class="text-green-100 text-sm">View and edit student profiles</p>
                                    </div>
                                </div>
                                <div class="mt-4 flex justify-end">
                                    <span class="inline-flex items-center text-white text-sm font-medium">
                                        View All
                                        <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </span>
                                </div>
                            </a>

                            <!-- Schedule Meeting Button -->
                            <a href="#" class="group relative overflow-hidden bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 hover:from-purple-600 hover:to-purple-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl">
                                <div class="absolute top-0 right-0 w-20 h-20 bg-white opacity-10 rounded-full -mr-10 -mt-10"></div>
                                <div class="absolute bottom-0 left-0 w-20 h-20 bg-white opacity-10 rounded-full -ml-10 -mb-10"></div>
                                <div class="relative flex items-center space-x-4">
                                    <div class="bg-white bg-opacity-20 rounded-xl p-3">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-white">Schedule Meeting</h3>
                                        <p class="text-purple-100 text-sm">Plan virtual sessions</p>
                                    </div>
                                </div>
                                <div class="mt-4 flex justify-end">
                                    <span class="inline-flex items-center text-white text-sm font-medium">
                                        Schedule
                                        <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </span>
                                </div>
                            </a>

                            <!-- Reports Button -->
                            <a href="#" class="group relative overflow-hidden bg-gradient-to-r from-pink-500 to-pink-600 rounded-xl p-6 hover:from-pink-600 hover:to-pink-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl">
                                <div class="absolute top-0 right-0 w-20 h-20 bg-white opacity-10 rounded-full -mr-10 -mt-10"></div>
                                <div class="absolute bottom-0 left-0 w-20 h-20 bg-white opacity-10 rounded-full -ml-10 -mb-10"></div>
                                <div class="relative flex items-center space-x-4">
                                    <div class="bg-white bg-opacity-20 rounded-xl p-3">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-white">View Reports</h3>
                                        <p class="text-pink-100 text-sm">Analytics & insights</p>
                                    </div>
                                </div>
                                <div class="mt-4 flex justify-end">
                                    <span class="inline-flex items-center text-white text-sm font-medium">
                                        Analyze
                                        <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Recent Activity -->
            <div class="lg:col-span-1">
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                            <span class="bg-gradient-to-r from-green-400 to-green-600 text-white p-2 rounded-lg mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </span>
                            Recent Activity
                        </h2>
                        
                        <div class="space-y-4">
                            <!-- Activity Item 1 -->
                            <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">New student registered</p>
                                    <p class="text-xs text-gray-500">2 minutes ago</p>
                                </div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    New
                                </span>
                            </div>

                            <!-- Activity Item 2 -->
                            <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">New message in General Chat</p>
                                    <p class="text-xs text-gray-500">1 hour ago</p>
                                </div>
                            </div>

                            <!-- Activity Item 3 -->
                            <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Meeting scheduled for tomorrow</p>
                                    <p class="text-xs text-gray-500">3 hours ago</p>
                                </div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Upcoming
                                </span>
                            </div>

                            <!-- View All Link -->
                            <a href="#" class="block mt-6 text-center text-sm text-gray-600 hover:text-gray-900 font-medium">
                                View all activity →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection