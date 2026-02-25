@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <!-- Enhanced Header with Avatar -->
        <div class="mb-10 text-center md:text-left md:flex md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-gray-800 to-gray-600">Profile Settings</h1>
                <p class="mt-2 text-gray-500 flex items-center justify-center md:justify-start">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Manage your account preferences and security
                </p>
            </div>
            
            <!-- Enhanced User Profile Card -->
            <div class="mt-4 md:mt-0">
                <div class="bg-white rounded-2xl shadow-sm px-6 py-3 border border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold text-lg shadow-md">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="absolute -bottom-1 -right-1 h-4 w-4 bg-green-400 rounded-full border-2 border-white"></div>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                {{ Auth::user()->email }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Settings Cards -->
        <div class="space-y-6">
            <!-- Profile Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-50 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h2 class="text-sm font-semibold text-gray-900">Profile information</h2>
                            <p class="text-xs text-gray-500">Update your name and email address</p>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-5 bg-white">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Password Update -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                    <div class="flex items-center">
                        <div class="p-2 bg-yellow-50 rounded-lg">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h2 class="text-sm font-semibold text-gray-900">Password</h2>
                            <p class="text-xs text-gray-500">Ensure your account is using a strong password</p>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-5 bg-white">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
                <div class="px-6 py-4 bg-gradient-to-r from-red-50 to-white border-b border-gray-100">
                    <div class="flex items-center">
                        <div class="p-2 bg-red-50 rounded-lg">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h2 class="text-sm font-semibold text-gray-900">Delete account</h2>
                            <p class="text-xs text-gray-500">Permanently delete your account and all associated data</p>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-5 bg-white">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>

        <!-- Optional: Add a small footer note -->
        <div class="mt-8 text-center">
            <p class="text-xs text-gray-400">
                Last updated: {{ now()->format('F j, Y') }}
            </p>
        </div>
    </div>
</div>

<!-- Optional: Add custom styles for form enhancements -->
@push('styles')
<style>
    /* Smooth transitions */
    .transition-shadow {
        transition: box-shadow 0.3s ease-in-out;
    }
    
    /* Custom gradient text */
    .bg-clip-text {
        -webkit-background-clip: text;
        background-clip: text;
    }
    
    /* Hover effects for cards */
    .hover\:shadow-md:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
</style>
@endpush
@endsection