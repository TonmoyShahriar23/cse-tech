<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-purple-400 via-pink-500 to-red-500 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Animated background elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-0 left-0 w-72 h-72 bg-white/10 rounded-full blur-3xl animate-bounce" style="animation-delay: 0s"></div>
            <div class="absolute top-20 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl animate-bounce" style="animation-delay: 2s"></div>
            <div class="absolute bottom-0 left-1/2 w-80 h-80 bg-white/10 rounded-full blur-3xl animate-bounce" style="animation-delay: 4s"></div>
        </div>

        <div class="relative z-10 w-full max-w-md mx-auto">
            <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-8 border border-white/20">
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

                <form method="POST" action="{{ route('otp.verify') }}" class="space-y-6" onsubmit="prepareOtpData()">
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

                    <div class="bg-gradient-to-br from-white/50 to-white/30 rounded-2xl p-6 border border-white/30 shadow-inner">
                        <label for="otp" class="block text-sm font-medium text-gray-700 mb-3 text-center">
                            <span class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent font-semibold">Verification Code</span>
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   id="otpInput"
                                   name="otp_single"
                                   inputmode="numeric"
                                   pattern="[0-9]{6}"
                                   maxlength="6" 
                                   autocomplete="one-time-code"
                                   class="w-full px-6 py-4 text-center text-3xl font-mono font-bold border-4 border-white/40 rounded-xl bg-gradient-to-br from-white to-gray-50 shadow-lg focus:outline-none focus:border-purple-400 focus:ring-2 focus:ring-purple-300 focus:ring-opacity-50 transition-all duration-300 hover:border-pink-300 hover:shadow-xl"
                                   placeholder="Enter 6-digit code"
                                   required>
                            <!-- Hidden inputs for backend compatibility -->
                            <input type="hidden" name="otp[0]" id="otp0">
                            <input type="hidden" name="otp[1]" id="otp1">
                            <input type="hidden" name="otp[2]" id="otp2">
                            <input type="hidden" name="otp[3]" id="otp3">
                            <input type="hidden" name="otp[4]" id="otp4">
                            <input type="hidden" name="otp[5]" id="otp5">
                            <!-- Colorful shadow effect -->
                            <div class="absolute inset-0 rounded-xl bg-gradient-to-br from-purple-400/15 to-pink-400/15 opacity-0 hover:opacity-100 transition-opacity duration-300 blur-md"></div>
                            <!-- Floating animation -->
                            <div class="absolute -inset-1 rounded-xl bg-gradient-to-r from-purple-400 to-pink-400 opacity-0 focus-within:opacity-40 blur-xl transition-opacity duration-300"></div>
                        </div>
                        <div class="mt-2 text-xs text-gray-500 text-center">
                            Enter the 6-digit code sent to your email
                        </div>
                        <x-input-error :messages="$errors->get('otp')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="text-sm">
                            <span class="text-gray-600">Time remaining: </span>
                            <span id="countdown" class="font-mono font-semibold text-indigo-600">02:00</span>
                        </div>
                        <div class="text-sm">
                            <button type="button" onclick="openResendModal()" class="font-medium text-indigo-600 hover:text-indigo-500">
                                Resend code
                            </button>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 rounded-md transition-colors duration-200">
                            Verify & Continue
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

        // Prepare OTP data before form submission
        function prepareOtpData() {
            const otpValue = otpInput.value.replace(/\D/g, '').slice(0, 6);
            
            // Ensure we have exactly 6 digits
            if (otpValue.length === 6) {
                for (let i = 0; i < 6; i++) {
                    hiddenInputs[i].value = otpValue[i];
                }
                return true;
            } else {
                alert('Please enter a valid 6-digit OTP code.');
                return false;
            }
        }
    </script>
</x-guest-layout>