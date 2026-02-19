<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Animated background elements -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Floating particles -->
            <div class="absolute top-10 left-10 w-2 h-2 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full animate-ping opacity-20" style="animation-delay: 0s"></div>
            <div class="absolute top-20 right-10 w-3 h-3 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full animate-pulse opacity-30" style="animation-delay: 1s"></div>
            <div class="absolute bottom-10 left-1/4 w-2 h-2 bg-gradient-to-r from-pink-400 to-red-400 rounded-full animate-bounce opacity-25" style="animation-delay: 2s"></div>
            <div class="absolute top-1/3 right-1/4 w-4 h-4 bg-gradient-to-r from-cyan-400 to-blue-400 rounded-full animate-pulse opacity-20" style="animation-delay: 3s"></div>
            
            <!-- Geometric shapes -->
            <div class="absolute -top-4 -right-4 w-32 h-32 border-2 border-purple-500/30 rounded-lg transform rotate-12 animate-pulse"></div>
            <div class="absolute -bottom-4 -left-4 w-24 h-24 border-2 border-pink-500/30 rounded-lg transform -rotate-12 animate-pulse" style="animation-delay: 2s"></div>
        </div>

        <div class="relative z-10 w-full max-w-md mx-auto">
            <!-- Enhanced card with gradient border -->
            <div class="bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-xl rounded-3xl shadow-2xl p-8 border border-white/20 shadow-purple-500/20 shadow-[0_0_50px_rgba(147,51,234,0.1)]">
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl mb-4 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h2 class="text-4xl font-bold text-white mb-2">
                        Verify Your Email
                    </h2>
                    <p class="text-white/90 text-lg">
                        Enter the 6-digit code sent to your email
                    </p>
                </div>
                @if (session('success'))
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('otp.verify') }}" class="space-y-6" id="otpForm">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email address
                        </label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" value="{{ $email ?? old('email') }}" readonly
                                   class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm bg-gray-50">
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-white/10 to-white/5 rounded-2xl p-8 border border-white/20 shadow-xl shadow-purple-500/10" id="otpContainer">
                        <label for="otp" class="block text-sm font-medium text-white/80 mb-4 text-center">
                            <span class="bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent font-semibold text-lg">Verification Code</span>
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   id="otpInput"
                                   name="otp_single"
                                   inputmode="numeric"
                                   pattern="[0-9]{6}"
                                   maxlength="6" 
                                   autocomplete="one-time-code"
                                   class="w-full px-8 py-6 text-center text-4xl font-mono font-bold tracking-widest border-2 border-white/30 rounded-2xl bg-white/10 backdrop-blur-sm shadow-lg focus:outline-none focus:border-purple-400 focus:ring-4 focus:ring-purple-400/30 transition-all duration-300 hover:border-pink-400/50 hover:shadow-xl hover:shadow-purple-500/20 placeholder:text-white/30 text-white"
                                   placeholder="0 0 0 0 0 0"
                                   required>
                            <!-- Hidden inputs for backend compatibility -->
                            <input type="hidden" name="otp[0]" id="otp0">
                            <input type="hidden" name="otp[1]" id="otp1">
                            <input type="hidden" name="otp[2]" id="otp2">
                            <input type="hidden" name="otp[3]" id="otp3">
                            <input type="hidden" name="otp[4]" id="otp4">
                            <input type="hidden" name="otp[5]" id="otp5">
                            <!-- Floating animation -->
                            <div class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-purple-400/20 to-pink-400/20 opacity-0 focus-within:opacity-60 blur-xl transition-opacity duration-300"></div>
                        </div>
                        <div class="mt-3 text-xs text-white/60 text-center tracking-wide">
                            Enter the 6-digit code sent to your email
                        </div>
                        <x-input-error :messages="$errors->get('otp')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="text-sm">
                            <span class="text-white/70">Time remaining: </span>
                            <span id="countdown" class="font-mono font-semibold text-purple-300 bg-white/10 px-3 py-1 rounded-full border border-white/20">02:00</span>
                        </div>
                        <div class="text-sm">
                            <button type="button" onclick="openResendModal()" class="font-medium text-purple-300 hover:text-purple-100 transition-colors duration-300 hover:underline">
                                Resend code
                            </button>
                        </div>
                    </div>

                    <!-- Beautiful Resend Button -->
                    <div class="relative group">
                        <button type="button" onclick="openResendModal()" class="w-full py-4 px-6 bg-gradient-to-r from-purple-600/20 to-pink-600/20 border border-white/30 rounded-xl text-purple-300 font-semibold tracking-wide hover:from-purple-500/30 hover:to-pink-500/30 hover:border-purple-400/50 transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-purple-500/25 backdrop-blur-sm">
                            <span class="flex items-center justify-center space-x-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                <span>Resend Code</span>
                            </span>
                            <!-- Floating animation -->
                            <div class="absolute -inset-1 bg-gradient-to-r from-purple-400/20 to-pink-400/20 rounded-xl blur opacity-0 group-hover:opacity-60 transition-opacity duration-300"></div>
                        </button>
                    </div>

                    <!-- Beautiful Verify Button -->
                    <div class="relative group">
                        <button type="submit" class="w-full py-4 px-6 bg-gradient-to-r from-purple-500 via-pink-500 to-purple-500 rounded-xl text-white font-bold text-lg tracking-wide shadow-lg shadow-purple-500/30 hover:shadow-purple-500/50 transform hover:scale-105 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <span class="flex items-center justify-center space-x-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Verify & Continue</span>
                            </span>
                            <!-- Animated gradient border -->
                            <div class="absolute -inset-1 rounded-xl bg-gradient-to-r from-purple-400 to-pink-400 opacity-0 group-hover:opacity-75 blur transition-opacity duration-300"></div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Resend Modal -->
    <div id="resendModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-center mx-auto h-12 w-12 rounded-full bg-green-100">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                </div>
                <div class="text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mt-5">Resend Verification Code</h3>
                    <p class="text-sm text-gray-500 mt-2">Send a new verification code to your email address?</p>
                </div>
                <form method="POST" action="{{ route('otp.resend') }}" class="mt-5">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="closeResendModal()" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Send Code
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // OTP input handling for single input with hidden array fields
        const otpInput = document.getElementById('otpInput');
        const hiddenInputs = [
            document.getElementById('otp0'),
            document.getElementById('otp1'),
            document.getElementById('otp2'),
            document.getElementById('otp3'),
            document.getElementById('otp4'),
            document.getElementById('otp5')
        ];

        otpInput.addEventListener('input', function(e) {
            const value = e.target.value.replace(/\D/g, '').slice(0, 6);
            e.target.value = value;

            // Update hidden inputs
            for (let i = 0; i < 6; i++) {
                hiddenInputs[i].value = value[i] || '';
            }
            
            // Enhanced visual feedback for beautiful design
            if (value.length === 6) {
                otpInput.style.borderColor = '#a855f7'; // purple border when complete
                otpInput.style.boxShadow = '0 0 0 4px rgba(168, 85, 247, 0.2), 0 10px 25px rgba(168, 85, 247, 0.3)';
                otpInput.style.transform = 'translateY(-2px)';
            } else {
                otpInput.style.borderColor = 'rgba(255, 255, 255, 0.3)'; // default border
                otpInput.style.boxShadow = 'none';
                otpInput.style.transform = 'translateY(0)';
            }
        });

        otpInput.addEventListener('keydown', function(e) {
            // Allow backspace, delete, tab, escape, enter, and numbers
            if ([46, 8, 9, 27, 13, 110, 190].indexOf(e.keyCode) !== -1 ||
                // Allow: Ctrl+A, Command+A
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

        // Handle paste event
        otpInput.addEventListener('paste', function(e) {
            setTimeout(() => {
                const value = e.target.value.replace(/\D/g, '').slice(0, 6);
                e.target.value = value;
                
                // Update hidden inputs
                for (let i = 0; i < 6; i++) {
                    hiddenInputs[i].value = value[i] || '';
                }
                
                // Visual feedback
                if (value.length === 6) {
                    otpInput.style.borderColor = '#9333ea';
                    otpInput.style.boxShadow = '0 0 0 3px rgba(147, 51, 234, 0.1)';
                } else {
                    otpInput.style.borderColor = '#e5e7eb';
                    otpInput.style.boxShadow = 'none';
                }
            }, 0);
        });

        // Countdown timer
        let countdownTime = 120; // 2 minutes
        const countdownElement = document.getElementById('countdown');

        function updateCountdown() {
            const minutes = Math.floor(countdownTime / 60);
            const seconds = countdownTime % 60;
            const timeString = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            countdownElement.textContent = timeString;
            
            if (countdownTime <= 0) {
                countdownElement.innerHTML = '<span class="text-red-500 font-bold">EXPIRED</span>';
            } else {
                countdownTime--;
                setTimeout(updateCountdown, 1000);
            }
        }

        updateCountdown();

        // Modal functions
        function openResendModal() {
            document.getElementById('resendModal').classList.remove('hidden');
        }

        function closeResendModal() {
            document.getElementById('resendModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('resendModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeResendModal();
            }
        });

        // Form submission handler
        document.getElementById('otpForm').addEventListener('submit', function(e) {
            const otpValue = otpInput.value.replace(/\D/g, '').slice(0, 6);
            
            // Ensure we have exactly 6 digits
            if (otpValue.length !== 6) {
                e.preventDefault();
                alert('Please enter a valid 6-digit OTP code.');
                otpInput.focus();
                return false;
            }
            
            // Update hidden inputs with OTP values
            for (let i = 0; i < 6; i++) {
                hiddenInputs[i].value = otpValue[i];
            }
            
            return true;
        });


        // Focus OTP input on page load
        window.addEventListener('load', function() {
            otpInput.focus();
            
            // Check if there are OTP errors and apply shake animation
            const otpError = document.querySelector('.text-red-600');
            if (otpError && otpError.textContent.includes('wrong')) {
                triggerErrorAnimation();
            }
            
            // Check if new OTP was sent (success message present)
            const successMessage = document.querySelector('.bg-green-50');
            if (successMessage && successMessage.textContent.includes('New OTP sent')) {
                // Don't reset timer - it should continue from the 2-minute window
                // Just clear the input and focus for fresh entry
                otpInput.value = '';
                for (let i = 0; i < 6; i++) {
                    hiddenInputs[i].value = '';
                }
                otpInput.focus();
                
                // Clear any error styling from previous attempts
                otpInput.style.borderColor = 'rgba(255, 255, 255, 0.3)';
                otpInput.style.boxShadow = 'none';
                otpInput.style.transform = 'translateY(0)';
            }
        });

        // Function to trigger error animation
        function triggerErrorAnimation() {
            const otpContainer = document.getElementById('otpContainer');
            const otpInput = document.getElementById('otpInput');
            
            // Add shake animation to container
            otpContainer.classList.add('animate-shake');
            
            // Add error styling to input
            otpInput.style.borderColor = '#ef4444'; // red border
            otpInput.style.boxShadow = '0 0 0 4px rgba(239, 68, 68, 0.2), 0 10px 25px rgba(239, 68, 68, 0.3)';
            
            // Remove animation class after animation completes
            setTimeout(() => {
                otpContainer.classList.remove('animate-shake');
            }, 600);
            
            // Reset styling after a few seconds
            setTimeout(() => {
                if (!otpInput.value || otpInput.value.length !== 6) {
                    otpInput.style.borderColor = 'rgba(255, 255, 255, 0.3)';
                    otpInput.style.boxShadow = 'none';
                }
            }, 3000);
        }

        // Function to reset countdown timer when new OTP is sent
        function resetCountdownTimer() {
            // Reset countdown to 2 minutes
            countdownTime = 120;
            
            // Update the display immediately
            const minutes = Math.floor(countdownTime / 60);
            const seconds = countdownTime % 60;
            const timeString = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            countdownElement.textContent = timeString;
            countdownElement.style.color = '#a855f7'; // purple color
            countdownElement.style.borderColor = 'rgba(255, 255, 255, 0.3)';
            
            // Clear any existing countdown and start new one
            clearInterval(window.countdownInterval);
            window.countdownInterval = setInterval(updateCountdown, 1000);
            
            // Clear any error styling from previous attempts
            otpInput.style.borderColor = 'rgba(255, 255, 255, 0.3)';
            otpInput.style.boxShadow = 'none';
            otpInput.style.transform = 'translateY(0)';
            
            // Clear OTP input to allow fresh entry
            otpInput.value = '';
            for (let i = 0; i < 6; i++) {
                hiddenInputs[i].value = '';
            }
            
            // Focus on OTP input for immediate entry
            otpInput.focus();
        }

        // Add CSS for shake animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-5px); }
                75% { transform: translateX(5px); }
            }
            .animate-shake {
                animation: shake 0.6s cubic-bezier(.36,.07,.19,.97) both;
            }
        `;
        document.head.appendChild(style);
    </script>
</x-guest-layout>