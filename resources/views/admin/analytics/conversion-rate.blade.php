@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800">Conversion Rate Analytics</h1>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-purple-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-purple-900 mb-2">Conversion Rate</h3>
                        <p class="text-3xl font-bold text-purple-600">{{ $conversionStats['conversion_rate'] ?? 0 }}%</p>
                    </div>
                    <div class="bg-blue-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-blue-900 mb-2">Premium Users</h3>
                        <p class="text-3xl font-bold text-blue-600">{{ $conversionStats['premium_users'] ?? 0 }}</p>
                    </div>
                    <div class="bg-green-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-green-900 mb-2">Free Users</h3>
                        <p class="text-3xl font-bold text-green-600">{{ $conversionStats['free_users'] ?? 0 }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Conversion Trends</h3>
                        <div class="space-y-3">
                            @foreach($trends as $trend)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-700">{{ $trend->date }}</span>
                                    <span class="text-sm text-gray-500">{{ $trend->new_users }} new users</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">User Distribution</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">Total Users</span>
                                <span class="text-sm text-gray-500">{{ $conversionStats['total_users'] ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">Free Users</span>
                                <span class="text-sm text-gray-500">{{ $conversionStats['free_users'] ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">Premium Users</span>
                                <span class="text-sm text-gray-500">{{ $conversionStats['premium_users'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-sm text-gray-600">
                    Conversion rate calculated based on free users who upgraded to premium within the last 30 days
                </div>
            </div>
        </div>
    </div>
</div>
@endsection