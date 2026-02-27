@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Profile Header Section -->
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden mb-8">
            <div class="relative">
                <!-- Decorative Background -->
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/10 to-purple-500/10"></div>
                <div class="relative px-8 py-8">
                    <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
                        <!-- User Avatar Section -->
                        <div class="flex items-center space-x-6">
                            <div class="relative group">
                                <div class="h-24 w-24 rounded-full bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 shadow-2xl flex items-center justify-center text-white text-2xl font-bold transform transition-all duration-300 group-hover:scale-105">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="absolute -bottom-2 -right-2 h-8 w-8 bg-green-400 rounded-full border-4 border-white shadow-lg animate-pulse"></div>
                                <div class="absolute inset-0 rounded-full bg-white/20 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                            
                            <div class="text-center md:text-left">
                                <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 via-gray-700 to-gray-900 bg-clip-text text-transparent">
                                    {{ Auth::user()->name }}
                                </h1>
                                <p class="text-sm text-gray-500 mt-1 flex items-center justify-center md:justify-start">
                                    <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ Auth::user()->email }}
                                </p>
                                <div class="mt-2 flex items-center justify-center md:justify-start space-x-4 text-xs text-gray-400">
                                    <span class="flex items-center">
                                        <svg class="w-3 h-3 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Verified Account
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-3 h-3 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Member since {{ Auth::user()->created_at->format('M Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- User Stats -->
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-gray-50/50 rounded-2xl p-4 border border-gray-100">
                            <div class="text-center">
                                <div class="text-lg font-bold text-indigo-600">{{ Auth::user()->chatSessions?->count() ?? 0 }}</div>
                                <div class="text-xs text-gray-500">Chats</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-bold text-purple-600">{{ Auth::user()->role?->display_name ?? 'User' }}</div>
                                <div class="text-xs text-gray-500">Role</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-bold text-pink-600">{{ Auth::user()->subscription_status ?? 'Free' }}</div>
                                <div class="text-xs text-gray-500">Plan</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-bold text-green-600">Active</div>
                                <div class="text-xs text-gray-500">Status</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Settings Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Profile Information Card -->
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden group hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-bold text-white">Profile Information</h2>
                            <p class="text-indigo-100 text-sm">Update your personal details</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Security & Password Card -->
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden group hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="bg-gradient-to-r from-yellow-400 to-orange-500 p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-bold text-white">Security</h2>
                            <p class="text-yellow-100 text-sm">Manage your password and security</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Account Actions Card -->
            <div class="lg:col-span-2 bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden group hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="bg-gradient-to-r from-red-500 to-pink-600 p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-bold text-white">Account Actions</h2>
                            <p class="text-red-100 text-sm">Manage your account settings</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="mt-8 text-center">
            <p class="text-xs text-gray-400 bg-white rounded-full px-6 py-2 inline-block shadow-sm border border-gray-100">
                Last updated: {{ now()->format('F j, Y \a\t g:i A') }}
            </p>
        </div>
    </div>
</div>

<!-- Enhanced Styles -->
@push('styles')
<style>
    /* Enhanced gradient backgrounds */
    .bg-gradient-to-br {
        background-size: 400% 400%;
        animation: gradient 8s ease infinite;
    }
    
    @keyframes gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    /* Enhanced hover effects */
    .group:hover .bg-gradient-to-r {
        transform: scale(1.02);
    }
    
    /* Custom input styling */
    input[type="text"],
    input[type="email"],
    input[type="password"] {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
    
    /* Enhanced button styling */
    .btn-primary {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
    }
</style>
@endpush
@endsection
