<section>
    <div class="space-y-6">
        <!-- Form Header -->
        <div class="text-center md:text-left">
            <h2 class="text-lg font-semibold text-gray-900 mb-2">Security Settings</h2>
            <p class="text-sm text-gray-600">Keep your account secure with a strong password</p>
        </div>

        <form method="post" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            @method('put')

            <!-- Current Password Field -->
            <div class="group">
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Current Password
                    </span>
                </label>
                <div class="relative">
                    <input id="current_password" name="current_password" type="password" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-300 bg-white/50 backdrop-blur-sm group-hover:border-yellow-300"
                           autocomplete="current-password" />
                    <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-yellow-500/0 to-orange-500/0 group-hover:from-yellow-500/10 group-hover:to-orange-500/10 transition-all duration-300 pointer-events-none"></div>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <!-- New Password Field -->
            <div class="group">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        New Password
                    </span>
                </label>
                <div class="relative">
                    <input id="password" name="password" type="password" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300 bg-white/50 backdrop-blur-sm group-hover:border-green-300"
                           autocomplete="new-password" />
                    <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-green-500/0 to-blue-500/0 group-hover:from-green-500/10 group-hover:to-blue-500/10 transition-all duration-300 pointer-events-none"></div>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password Field -->
            <div class="group">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Confirm New Password
                    </span>
                </label>
                <div class="relative">
                    <input id="password_confirmation" name="password_confirmation" type="password" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 bg-white/50 backdrop-blur-sm group-hover:border-purple-300"
                           autocomplete="new-password" />
                    <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-purple-500/0 to-pink-500/0 group-hover:from-purple-500/10 group-hover:to-pink-500/10 transition-all duration-300 pointer-events-none"></div>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Password Strength Indicator -->
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-medium text-gray-700">Password Strength</span>
                    <span class="text-xs text-gray-500">Must be at least 8 characters</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div id="password-strength-bar" class="h-2 bg-gradient-to-r from-red-500 via-yellow-500 to-green-500 rounded-full w-0 transition-all duration-300"></div>
                </div>
                <div class="mt-2 flex items-center space-x-4 text-xs text-gray-500">
                    <span class="flex items-center">
                        <div class="w-2 h-2 bg-red-500 rounded-full mr-1"></div>
                        Weak
                    </span>
                    <span class="flex items-center">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full mr-1"></div>
                        Medium
                    </span>
                    <span class="flex items-center">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-1"></div>
                        Strong
                    </span>
                </div>
            </div>

            <!-- Save Button -->
            <div class="flex items-center justify-between pt-4">
                <div class="flex items-center space-x-3">
                    <div class="w-3 h-3 bg-blue-400 rounded-full animate-pulse"></div>
                    <span class="text-xs text-gray-500">Your password is encrypted and secure</span>
                </div>
                
                <div class="flex items-center space-x-3">
                    <button type="submit" 
                            class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-600 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                        <span class="absolute inset-0 w-full h-full bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity"></span>
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Update Password
                    </button>
                    
                    @if (session('status') === 'password-updated')
                        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" 
                             class="flex items-center space-x-2 text-green-600 bg-green-50 border border-green-200 rounded-full px-3 py-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-sm font-medium">Password updated!</span>
                        </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Password Strength JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const strengthBar = document.getElementById('password-strength-bar');
    
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = calculatePasswordStrength(password);
            
            // Update progress bar
            strengthBar.style.width = strength + '%';
            
            // Update color based on strength
            if (strength < 30) {
                strengthBar.style.background = 'linear-gradient(90deg, #ef4444, #f59e0b)';
            } else if (strength < 70) {
                strengthBar.style.background = 'linear-gradient(90deg, #f59e0b, #3b82f6)';
            } else {
                strengthBar.style.background = 'linear-gradient(90deg, #3b82f6, #22c55e)';
            }
        });
    }
    
    function calculatePasswordStrength(password) {
        let strength = 0;
        
        // Length check
        if (password.length >= 8) strength += 20;
        if (password.length >= 12) strength += 10;
        
        // Character variety
        if (/[a-z]/.test(password)) strength += 15;
        if (/[A-Z]/.test(password)) strength += 15;
        if (/[0-9]/.test(password)) strength += 15;
        if (/[^a-zA-Z0-9]/.test(password)) strength += 25;
        
        return Math.min(strength, 100);
    }
});
</script>
