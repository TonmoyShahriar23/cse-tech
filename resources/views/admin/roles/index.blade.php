@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Animated Background Header -->
        <div class="relative mb-10 overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 p-8 shadow-2xl">
            <div class="absolute inset-0 bg-grid-white/[0.2] bg-grid"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 opacity-90"></div>
            <div class="relative flex flex-col md:flex-row justify-between items-center">
                <div class="text-center md:text-left mb-4 md:mb-0">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-2 animate-fade-in-down">
                        Access Control Hub
                    </h1>
                    <p class="text-indigo-100 text-lg max-w-2xl animate-fade-in-up">
                        Manage roles and permissions with precision. Control who has access to what with our advanced permission system.
                    </p>
                </div>
                <button onclick="document.getElementById('createRoleModal').classList.remove('hidden')" 
                        class="group relative inline-flex items-center px-8 py-4 bg-white text-gray-800 font-semibold rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 animate-bounce-slow">
                    <span class="absolute inset-0 w-full h-full bg-white rounded-2xl opacity-0 group-hover:opacity-20 transition-opacity"></span>
                    <svg class="w-6 h-6 mr-2 text-indigo-600 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Create New Role
                </button>
            </div>
            
            <!-- Floating Stats -->
            <div class="relative mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-4 border border-white/20 animate-float">
                    <div class="flex items-center">
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-indigo-200 text-sm">Total Roles</p>
                            <p class="text-2xl font-bold text-white">{{ $roles->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-4 border border-white/20 animate-float" style="animation-delay: 0.2s">
                    <div class="flex items-center">
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-indigo-200 text-sm">Permissions</p>
                            <p class="text-2xl font-bold text-white">{{ $permissions->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-4 border border-white/20 animate-float" style="animation-delay: 0.4s">
                    <div class="flex items-center">
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-indigo-200 text-sm">System Roles</p>
                            <p class="text-2xl font-bold text-white">{{ $roles->where('is_system_role', true)->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-4 border border-white/20 animate-float" style="animation-delay: 0.6s">
                    <div class="flex items-center">
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-indigo-200 text-sm">Active Roles</p>
                            <p class="text-2xl font-bold text-white">{{ $roles->where('is_system_role', false)->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Bar -->
        <div class="mb-8 flex flex-wrap gap-3 justify-end">
            <button class="group inline-flex items-center px-4 py-2 bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-200 transition-all duration-300 hover:border-indigo-300">
                <svg class="w-5 h-5 text-gray-500 group-hover:text-indigo-600 mr-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                <span class="text-gray-700 group-hover:text-indigo-600">Export Report</span>
            </button>
            <button class="group inline-flex items-center px-4 py-2 bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-200 transition-all duration-300 hover:border-indigo-300">
                <svg class="w-5 h-5 text-gray-500 group-hover:text-indigo-600 mr-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                <span class="text-gray-700 group-hover:text-indigo-600">Sync Permissions</span>
            </button>
        </div>

        <!-- Tabs Navigation -->
        <div class="mb-6 border-b border-gray-200">
            <nav class="flex space-x-8" aria-label="Tabs">
                <button onclick="switchTab('roles')" id="tab-roles-btn" class="tab-button active py-4 px-1 border-b-2 border-indigo-600 font-medium text-sm text-indigo-600">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Roles
                    </span>
                </button>
                <button onclick="switchTab('permissions')" id="tab-permissions-btn" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Permissions
                    </span>
                </button>
                <button onclick="switchTab('matrix')" id="tab-matrix-btn" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        Permission Matrix
                    </span>
                </button>
            </nav>
        </div>

        <!-- Roles Tab Content -->
        <div id="roles-tab" class="tab-content">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($roles as $index => $role)
                    <div class="group relative bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden animate-fade-in-up" style="animation-delay: {{ $index * 0.1 }}s">
                        <!-- Role Type Indicator -->
                        <div class="absolute top-0 left-0 w-2 h-full {{ $role->is_system_role ? 'bg-amber-500' : 'bg-indigo-500' }}"></div>
                        
                        <!-- Role Header -->
                        <div class="px-6 py-5 bg-gradient-to-br from-gray-50 to-white border-b border-gray-100">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        @if($role->is_system_role)
                                            <span class="flex items-center justify-center w-8 h-8 bg-amber-100 rounded-xl mr-3">
                                                <svg class="w-5 h-5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        @else
                                            <span class="flex items-center justify-center w-8 h-8 bg-indigo-100 rounded-xl mr-3">
                                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </span>
                                        @endif
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900">{{ $role->display_name }}</h3>
                                            <p class="text-sm text-gray-500">{{ $role->name }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <button onclick="openEditModal('{{ $role->id }}', '{{ $role->display_name }}', '{{ $role->description }}')" 
                                            class="p-2 text-yellow-600 hover:text-yellow-700 hover:bg-yellow-50 rounded-xl transition-all duration-200 transform hover:scale-110"
                                            title="Edit Role">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    @if(!$role->is_system_role)
                                        <form action="{{ route('admin.roles.delete', $role) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-xl transition-all duration-200 transform hover:scale-110"
                                                    onclick="return confirm('Are you sure you want to delete this role?')"
                                                    title="Delete Role">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            
                            @if($role->description)
                                <p class="text-sm text-gray-600 mt-3 pl-11">{{ $role->description }}</p>
                            @endif
                        </div>
                        
                        <!-- Permissions Section -->
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Assigned Permissions</span>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    {{ $role->permissions->count() }} permissions
                                </span>
                            </div>
                            
                            <div class="flex flex-wrap gap-2 min-h-[80px]">
                                @forelse($role->permissions as $permission)
                                    <span class="group/permission relative inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-medium bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 border border-indigo-200 shadow-sm hover:shadow-md transition-all duration-200 hover:scale-105 cursor-default">
                                        <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl opacity-0 group-hover/permission:opacity-10 transition-opacity"></span>
                                        {{ $permission->display_name }}
                                        <span class="ml-1.5 text-indigo-400 group-hover/permission:text-indigo-600 transition-colors" title="{{ $permission->name }}">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </span>
                                    </span>
                                @empty
                                    <div class="flex items-center justify-center w-full h-16 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                                        <span class="text-sm text-gray-400">No permissions assigned yet</span>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        
                        <!-- Footer -->
                        <div class="px-6 py-3 bg-gray-50 border-t border-gray-100">
                            <div class="flex items-center text-xs text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Last updated: {{ $role->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Permissions Tab Content -->
        <div id="permissions-tab" class="tab-content hidden">
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <!-- Search and Filter Bar -->
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6 space-y-4 sm:space-y-0">
                    <div class="relative w-full sm:w-96">
                        <input type="text" 
                               placeholder="Search permissions..." 
                               class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                               id="permissionSearch">
                        <svg class="w-5 h-5 text-gray-400 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    
                    <div class="flex space-x-3">
                        <select class="px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent" id="resourceFilter">
                            <option value="">All Resources</option>
                            @foreach($permissions->pluck('resource')->unique()->filter() as $resource)
                                <option value="{{ $resource }}">{{ ucfirst($resource) }}</option>
                            @endforeach
                        </select>
                        
                        <button class="px-4 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-colors duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Permissions Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" id="permissionsGrid">
                    @foreach($permissions->groupBy('resource') as $resource => $resourcePermissions)
                        <div class="col-span-full">
                            <div class="flex items-center mt-4 first:mt-0">
                                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider">{{ $resource ?: 'General Permissions' }}</h3>
                                <div class="ml-3 flex-1 h-px bg-gradient-to-r from-gray-300 to-transparent"></div>
                                <span class="ml-3 text-xs text-gray-500">{{ $resourcePermissions->count() }} permissions</span>
                            </div>
                        </div>
                        @foreach($resourcePermissions as $permission)
                            <div class="group permission-card bg-gradient-to-br from-gray-50 to-white rounded-xl border border-gray-200 p-4 hover:shadow-xl hover:border-indigo-300 transition-all duration-300 hover:scale-105">
                                <div class="flex items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center">
                                            <h4 class="font-semibold text-gray-900">{{ $permission->display_name }}</h4>
                                            <span class="ml-2 px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 opacity-0 group-hover:opacity-100 transition-opacity">
                                                {{ $permission->name }}
                                            </span>
                                        </div>
                                        @if($permission->description)
                                            <p class="text-xs text-gray-600 mt-1">{{ $permission->description }}</p>
                                        @endif
                                        <div class="mt-2 flex items-center text-xs text-gray-400">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-gray-100">
                                                {{ $permission->resource ?? 'general' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Matrix Tab Content -->
        <div id="matrix-tab" class="tab-content hidden">
            <div class="bg-white rounded-2xl shadow-xl p-6 overflow-x-auto">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Permission Assignment Matrix</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Permission / Role
                            </th>
                            @foreach($roles as $role)
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex flex-col items-center">
                                        <span class="font-bold">{{ $role->display_name }}</span>
                                        <span class="text-gray-400 text-xs">{{ $role->name }}</span>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($permissions as $permission)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-900">{{ $permission->display_name }}</span>
                                        <span class="text-xs text-gray-500">{{ $permission->name }}</span>
                                    </div>
                                </td>
                                @foreach($roles as $role)
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($role->permissions->contains('id', $permission->id))
                                            <span class="inline-flex items-center justify-center w-8 h-8 bg-green-100 rounded-full">
                                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Role Modal (Cinematic) -->

<div id="createRoleModal" class="fixed inset-0 z-50 hidden">
    <!-- Backdrop Layer (blurred) -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
    
    <!-- Modal Content Layer (solid white) -->
    <div class="fixed inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-500 animate-slideIn">
                <!-- Modal Header with Gradient -->
                <div class="relative h-32 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-t-2xl overflow-hidden">
                    <div class="absolute inset-0 bg-grid-white/[0.2] bg-grid"></div>
                    <div class="absolute bottom-0 left-0 p-6">
                        <h3 class="text-2xl font-bold text-white">Create New Role</h3>
                        <p class="text-indigo-100 text-sm mt-1">Define a new role and assign permissions</p>
                    </div>
                    <button onclick="document.getElementById('createRoleModal').classList.add('hidden')" 
                            class="absolute top-4 right-4 text-white/80 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Modal Body -->
                <div class="p-6 bg-white rounded-b-2xl">
                    <form action="{{ route('admin.roles.create') }}" method="POST" class="space-y-5">
                        @csrf
                        
                        <div class="space-y-4">
                            <!-- Role Name -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    Role Name <span class="text-red-500">*</span>
                                    <span class="text-xs text-gray-500 ml-2">(internal name, no spaces)</span>
                                </label>
                                <div class="relative">
                                    <input type="text" name="name" required 
                                           class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                           placeholder="e.g., content_editor">
                                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Display Name -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    Display Name <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" name="display_name" required 
                                           class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                           placeholder="e.g., Content Editor">
                                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Description -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                                <textarea name="description" rows="3"
                                          class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                          placeholder="Describe the role's purpose and responsibilities..."></textarea>
                            </div>
                            
                            <!-- Permissions -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Assign Permissions</label>
                                <div class="bg-gray-50 rounded-xl p-4 border-2 border-gray-100">
                                    <div class="mb-3">
                                        <input type="text" 
                                               placeholder="Filter permissions..." 
                                               class="w-full px-4 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                               id="filterPermissions">
                                    </div>
                                    <div class="space-y-2 max-h-48 overflow-y-auto custom-scrollbar">
                                        @foreach($permissions as $permission)
                                            <label class="flex items-center p-3 hover:bg-white rounded-xl transition-all duration-200 cursor-pointer group permission-item">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                       class="w-5 h-5 text-indigo-600 border-2 border-gray-300 rounded-lg focus:ring-indigo-500 focus:ring-offset-0 transition-all duration-200 group-hover:border-indigo-300">
                                                <span class="ml-3">
                                                    <span class="text-sm font-medium text-gray-700 group-hover:text-indigo-600 transition-colors">{{ $permission->display_name }}</span>
                                                    <span class="text-xs text-gray-500 block">{{ $permission->name }}</span>
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal Footer -->
                        <div class="flex justify-end space-x-3 pt-5 border-t border-gray-100">
                            <button type="button" 
                                    onclick="document.getElementById('createRoleModal').classList.add('hidden')"
                                    class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 transition-all duration-200 hover:shadow-md">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                                Create Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Role Modal (Cinematic) -->
<div id="editRoleModal" class="fixed inset-0 bg-gray-900 bg-opacity-70 overflow-y-auto h-full w-full hidden z-50 backdrop-blur-sm">
    <div class="relative top-20 mx-auto p-0 border-0 w-full max-w-md">
        <div class="relative bg-white rounded-2xl shadow-2xl transform transition-all duration-500 animate-slideIn">
            <!-- Modal Header with Gradient -->
            <div class="relative h-32 bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 rounded-t-2xl overflow-hidden">
                <div class="absolute inset-0 bg-grid-white/[0.2] bg-grid"></div>
                <div class="absolute bottom-0 left-0 p-6">
                    <h3 class="text-2xl font-bold text-white">Edit Role</h3>
                    <p class="text-amber-100 text-sm mt-1">Modify role details and permissions</p>
                </div>
                <button onclick="document.getElementById('editRoleModal').classList.add('hidden')" 
                        class="absolute top-4 right-4 text-white/80 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <form id="editRoleForm" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editRoleId" name="role_id">
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Display Name</label>
                            <input type="text" id="editDisplayName" name="display_name" required 
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                            <textarea id="editDescription" name="description" rows="3"
                                      class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent"></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Permissions</label>
                            <div class="bg-gray-50 rounded-xl p-4 border-2 border-gray-100">
                                <div class="space-y-2 max-h-48 overflow-y-auto custom-scrollbar">
                                    @foreach($permissions as $permission)
                                        <label class="flex items-center p-3 hover:bg-white rounded-xl transition-all duration-200 cursor-pointer">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                   class="w-5 h-5 text-amber-600 border-2 border-gray-300 rounded-lg focus:ring-amber-500 permission-checkbox">
                                            <span class="ml-3">
                                                <span class="text-sm font-medium text-gray-700">{{ $permission->display_name }}</span>
                                                <span class="text-xs text-gray-500 block">{{ $permission->name }}</span>
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 pt-5 border-t border-gray-100">
                        <button type="button" 
                                onclick="document.getElementById('editRoleModal').classList.add('hidden')"
                                class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 transition-all duration-200">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-6 py-3 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                            Update Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Animations */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-10px);
        }
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(50px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    
    .animate-fade-in-down {
        animation: fadeInDown 1s ease-out;
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 1s ease-out;
    }
    
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
    
    .animate-bounce-slow {
        animation: bounce 2s infinite;
    }
    
    .animate-slideIn {
        animation: slideIn 0.5s ease-out;
    }
    
    /* Grid Background Pattern */
    .bg-grid {
        background-image: linear-gradient(to right, rgba(255,255,255,0.1) 1px, transparent 1px),
                          linear-gradient(to bottom, rgba(255,255,255,0.1) 1px, transparent 1px);
        background-size: 20px 20px;
    }
    
    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #a0aec0;
    }
    
    /* Loading Skeleton Animation */
    .skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
    }
    
    @keyframes loading {
        0% {
            background-position: 200% 0;
        }
        100% {
            background-position: -200% 0;
        }
    }
</style>

<script>
    // Tab Switching Functionality
    function switchTab(tabName) {
        // Hide all tabs
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });
        
        // Show selected tab
        document.getElementById(tabName + '-tab').classList.remove('hidden');
        
        // Update button styles
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active', 'text-indigo-600', 'border-indigo-600');
            btn.classList.add('text-gray-500', 'border-transparent');
        });
        
        // Style active button
        const activeBtn = document.getElementById('tab-' + tabName + '-btn');
        activeBtn.classList.add('active', 'text-indigo-600', 'border-indigo-600');
        activeBtn.classList.remove('text-gray-500', 'border-transparent');
    }
    
    // Edit Modal Function
    function openEditModal(roleId, displayName, description) {
        document.getElementById('editRoleId').value = roleId;
        document.getElementById('editDisplayName').value = displayName;
        document.getElementById('editDescription').value = description;
        document.getElementById('editRoleForm').action = '/admin/roles/' + roleId;
        document.getElementById('editRoleModal').classList.remove('hidden');
    }
    
    // Permission Search
    document.getElementById('permissionSearch')?.addEventListener('keyup', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        document.querySelectorAll('.permission-card').forEach(card => {
            const text = card.textContent.toLowerCase();
            card.style.display = text.includes(searchTerm) ? 'block' : 'none';
        });
    });
    
    // Resource Filter
    document.getElementById('resourceFilter')?.addEventListener('change', function(e) {
        const filterValue = e.target.value.toLowerCase();
        document.querySelectorAll('.permission-card').forEach(card => {
            const resource = card.querySelector('.bg-gray-100')?.textContent.toLowerCase() || '';
            if (!filterValue || resource.includes(filterValue)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
    
    // Modal Permission Filter
    document.getElementById('filterPermissions')?.addEventListener('keyup', function(e) {
        const filter = e.target.value.toLowerCase();
        document.querySelectorAll('.permission-item').forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(filter) ? 'flex' : 'none';
        });
    });
    
    // Click outside to close modal
    window.onclick = function(event) {
        const createModal = document.getElementById('createRoleModal');
        const editModal = document.getElementById('editRoleModal');
        
        if (event.target === createModal) {
            createModal.classList.add('hidden');
        }
        if (event.target === editModal) {
            editModal.classList.add('hidden');
        }
    }
    
    // Escape key to close modals
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.getElementById('createRoleModal').classList.add('hidden');
            document.getElementById('editRoleModal').classList.add('hidden');
        }
    });
    
    // Loading animation for delete buttons
    document.querySelectorAll('form[action*="delete"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            const btn = this.querySelector('button[type="submit"]');
            btn.innerHTML = '<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            btn.disabled = true;
        });
    });
</script>
@endsection