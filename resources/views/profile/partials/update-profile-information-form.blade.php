<section>
    <div class="space-y-6">
        <!-- Form Header -->
        <div class="text-center md:text-left">
            <h2 class="text-lg font-semibold text-gray-900 mb-2">Personal Details</h2>
            <p class="text-sm text-gray-600">Keep your information up to date for the best experience</p>
        </div>

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf
            @method('patch')

            <!-- Name Field -->
            <div class="group">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Full Name
                    </span>
                </label>
                <div class="relative">
                    <input id="name" name="name" type="text" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 bg-white/50 backdrop-blur-sm group-hover:border-indigo-300"
                           :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-indigo-500/0 to-purple-500/0 group-hover:from-indigo-500/10 group-hover:to-purple-500/10 transition-all duration-300 pointer-events-none"></div>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Email Field -->
            <div class="group">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Email Address
                    </span>
                </label>
                <div class="relative">
                    <input id="email" name="email" type="email" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 bg-white/50 backdrop-blur-sm group-hover:border-indigo-300"
                           :value="old('email', $user->email)" required autocomplete="username" />
                    <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-blue-500/0 to-purple-500/0 group-hover:from-blue-500/10 group-hover:to-purple-500/10 transition-all duration-300 pointer-events-none"></div>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-yellow-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-yellow-800">Email Verification Required</p>
                                <p class="text-sm text-yellow-700 mt-1">Your email address is unverified. Please check your inbox for a verification link.</p>
                                <button form="send-verification" class="mt-2 inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full text-yellow-700 bg-yellow-100 hover:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-colors">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Resend Verification
                                </button>
                            </div>
                        </div>
                    </div>

                    @if (session('status') === 'verification-link-sent')
                        <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                            <p class="text-sm text-green-700 font-medium">✅ Verification link sent! Check your email.</p>
                        </div>
                    @endif
                @endif
            </div>

            <!-- Save Button -->
            <div class="flex items-center justify-between pt-4">
                <div class="flex items-center space-x-3">
                    <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                    <span class="text-xs text-gray-500">Your information is secure</span>
                </div>
                
                <div class="flex items-center space-x-3">
                    <button type="submit" 
                            class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <span class="absolute inset-0 w-full h-full bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity"></span>
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Save Changes
                    </button>
                    
                    @if (session('status') === 'profile-updated')
                        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" 
                             class="flex items-center space-x-2 text-green-600 bg-green-50 border border-green-200 rounded-full px-3 py-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-sm font-medium">Saved successfully!</span>
                        </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
</section>
