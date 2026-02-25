@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800">API Usage Statistics</h1>
                    <form action="{{ route('admin.analytics.api_usage') }}" method="GET" class="flex space-x-4">
                        <select name="days" class="border-gray-300 rounded-md shadow-sm">
                            <option value="1" {{ request('days') == 1 ? 'selected' : '' }}>Last 1 day</option>
                            <option value="7" {{ request('days') == 7 ? 'selected' : '' }}>Last 7 days</option>
                            <option value="14" {{ request('days') == 14 ? 'selected' : '' }}>Last 14 days</option>
                            <option value="30" {{ request('days') == 30 ? 'selected' : '' }}>Last 30 days</option>
                        </select>
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Update
                        </button>
                    </form>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-green-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-green-900 mb-2">Total Messages</h3>
                        <p class="text-3xl font-bold text-green-600">{{ $totalMessages }}</p>
                    </div>
                    <div class="bg-blue-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-blue-900 mb-2">Average per Day</h3>
                        <p class="text-3xl font-bold text-blue-600">{{ round($totalMessages / $days, 1) }}</p>
                    </div>
                    <div class="bg-purple-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-purple-900 mb-2">Days Analyzed</h3>
                        <p class="text-3xl font-bold text-purple-600">{{ $days }}</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Messages</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($data as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $item->date }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->message_count }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 text-sm text-gray-600">
                    Showing AI assistant message count for the last {{ $days }} days
                </div>
            </div>
        </div>
    </div>
</div>
@endsection