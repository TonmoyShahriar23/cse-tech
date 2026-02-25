@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800">Subscription Management</h1>
                    <div class="flex space-x-4">
                        <form action="{{ route('admin.subscriptions.index') }}" method="GET" class="flex space-x-4">
                            <select name="status" class="border-gray-300 rounded-md shadow-sm">
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Users</option>
                                <option value="free" {{ request('status') == 'free' ? 'selected' : '' }}>Free Users</option>
                                <option value="premium" {{ request('status') == 'premium' ? 'selected' : '' }}>Premium Users</option>
                            </select>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Filter
                            </button>
                        </form>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subscription Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ends At</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $user->name }}<br>
                                        <span class="text-xs text-gray-500">{{ $user->email }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->role?->display_name ?? 'No Role' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $user->subscription_status == 'premium' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($user->subscription_status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->subscription_plan ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->subscription_ends_at ? $user->subscription_ends_at->format('M d, Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        @if($user->subscription_status != 'premium')
                                            <form action="{{ route('admin.subscriptions.upgrade', $user) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm">
                                                    Upgrade to Premium
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.subscriptions.downgrade', $user) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                                    Downgrade to Free
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($user->subscription_status == 'premium')
                                            <form action="{{ route('admin.subscriptions.deactivate', $user) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm">
                                                    Deactivate
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.subscriptions.activate', $user) }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="plan" value="premium">
                                                <input type="hidden" name="duration" value="1_year">
                                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">
                                                    Activate
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection