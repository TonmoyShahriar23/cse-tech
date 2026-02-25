@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800">Daily Active Users</h1>
                    <form action="{{ route('admin.analytics.daily_active_users') }}" method="GET" class="flex space-x-4">
                        <select name="days" class="border-gray-300 rounded-md shadow-sm">
                            <option value="7" {{ request('days') == 7 ? 'selected' : '' }}>Last 7 days</option>
                            <option value="14" {{ request('days') == 14 ? 'selected' : '' }}>Last 14 days</option>
                            <option value="30" {{ request('days') == 30 ? 'selected' : '' }}>Last 30 days</option>
                            <option value="90" {{ request('days') == 90 ? 'selected' : '' }}>Last 90 days</option>
                        </select>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Update
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Active Users</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($data as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $item->date }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->count }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 text-sm text-gray-600">
                    Showing data for the last {{ $days }} days
                </div>
            </div>
        </div>
    </div>
</div>
@endsection