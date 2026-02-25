@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800">Analytics Dashboard</h1>
                    <div class="flex space-x-4">
                        <a href="{{ route('admin.analytics.daily_active_users') }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Daily Active Users
                        </a>
                        <a href="{{ route('admin.analytics.api_usage') }}" 
                           class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            API Usage
                        </a>
                        <a href="{{ route('admin.analytics.conversion_rate') }}" 
                           class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                            Conversion Rate
                        </a>
                    </div>
                </div>

                <!-- Statistics Overview -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-blue-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-blue-900 mb-2">Total Users</h3>
                        <p class="text-3xl font-bold text-blue-600">{{ $statistics['total_users'] ?? 0 }}</p>
                    </div>
                    <div class="bg-green-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-green-900 mb-2">Active Users</h3>
                        <p class="text-3xl font-bold text-green-600">{{ $statistics['active_users'] ?? 0 }}</p>
                    </div>
                    <div class="bg-purple-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-purple-900 mb-2">Premium Users</h3>
                        <p class="text-3xl font-bold text-purple-600">{{ $statistics['premium_users'] ?? 0 }}</p>
                    </div>
                </div>

                <!-- Role Usage Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Role Distribution</h3>
                        <div class="space-y-3">
                            @foreach($roleUsage as $roleData)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-700">{{ $roleData['display_name'] }}</span>
                                    <span class="text-sm text-gray-500">{{ $roleData['user_count'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Conversion Statistics</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">Free to Premium</span>
                                <span class="text-sm text-gray-500">{{ $conversionStats['conversion_rate'] ?? 0 }}%</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">Total Conversions</span>
                                <span class="text-sm text-gray-500">{{ $conversionStats['premium_users'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Chat Activity</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Session</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Message</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Messages</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentChats as $chat)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $chat->user?->name ?? 'Anonymous' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $chat->session?->title ?? 'Untitled' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $chat->created_at->diffForHumans() }}
                                        </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $chat->session && $chat->session->chats ? $chat->session->chats->count() : 0 }}
                                    </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection