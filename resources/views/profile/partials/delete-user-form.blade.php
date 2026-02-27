<section>
    <div class="space-y-6">
        <!-- Form Header -->
        <div class="text-center md:text-left">
            <h2 class="text-lg font-semibold text-gray-900 mb-2">Account Actions</h2>
            <p class="text-sm text-gray-600">Manage your account settings and data</p>
        </div>

        <!-- Delete Account Section -->
        <div class="bg-gradient-to-br from-red-50 to-pink-50 border border-red-200 rounded-2xl p-6">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </div>
                </div>
                
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-red-900 mb-2">Delete Account</h3>
                    <p class="text-red-700 text-sm mb-4">
                        Once your account is deleted, all of its resources and data will be permanently deleted. 
                        Before deleting your account, please download any data or information that you wish to retain.
                    </p>
                    
                    <div class="bg-white rounded-xl p-4 border border-red-200 mb-4">
                        <div class="flex items-center space-x-3 text-sm text-red-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span><strong>Warning:</strong> This action cannot be undone</span>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <button
                            x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                            class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-500 to-pink-600 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                        >
                            <span class="absolute inset-0 w-full h-full bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity"></span>
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Account
                        </button>
                        
                        <button
                            class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-all duration-300"
                            onclick="showDataExportModal()"
                        >
                            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Export Data
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Information Summary -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-3">Account Summary</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div class="bg-white rounded-lg p-3 border border-blue-200">
                    <span class="text-blue-600 font-medium">Member Since:</span>
                    <span class="ml-2 text-gray-700">{{ Auth::user()->created_at->format('F j, Y') }}</span>
                </div>
                <div class="bg-white rounded-lg p-3 border border-blue-200">
                    <span class="text-blue-600 font-medium">Last Login:</span>
                    <span class="ml-2 text-gray-700">{{ Auth::user()->last_login_at?->diffForHumans() ?? 'Not available' }}</span>
                </div>
                <div class="bg-white rounded-lg p-3 border border-blue-200">
                    <span class="text-blue-600 font-medium">Account Status:</span>
                    <span class="ml-2 text-green-600 font-medium">Active</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <div class="p-6 bg-white rounded-2xl">
            <div class="flex items-start space-x-4 mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-2">Confirm Account Deletion</h2>
                    <p class="text-gray-600">
                        Once your account is deleted, all of its resources and data will be permanently deleted. 
                        Please enter your password to confirm you would like to permanently delete your account.
                    </p>
                </div>
            </div>

            <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
                @csrf
                @method('delete')

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300"
                        placeholder="Enter your password"
                    />
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" x-on:click="$dispatch('close')" 
                            class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-all duration-300">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-500 to-pink-600 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        <span class="absolute inset-0 w-full h-full bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity"></span>
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete Account
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Data Export Modal -->
    <div id="data-export-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Export Your Data</h3>
                <button onclick="hideDataExportModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="space-y-4">
                <p class="text-sm text-gray-600">Download your account data before deletion:</p>
                
                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">Profile Information</span>
                        <span class="text-xs text-gray-500">JSON</span>
                    </div>
                    <button class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        Download Profile Data
                    </button>
                </div>

                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">Chat History</span>
                        <span class="text-xs text-gray-500">JSON</span>
                    </div>
                    <button class="w-full px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                        Download Chat Data
                    </button>
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <button onclick="hideDataExportModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal JavaScript -->
<script>
function showDataExportModal() {
    document.getElementById('data-export-modal').classList.remove('hidden');
}

function hideDataExportModal() {
    document.getElementById('data-export-modal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('data-export-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideDataExportModal();
    }
});

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        hideDataExportModal();
    }
});
</script>
