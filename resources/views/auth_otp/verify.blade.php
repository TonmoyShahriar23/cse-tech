<x-guest-layout>
    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Enter OTP</h2>
        
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('otp.verify') }}">
            @csrf

            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ $email ?? old('email') }}" required readonly />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mb-6">
                <x-input-label for="otp" :value="__('OTP Code')" />
                <div class="mt-1 flex space-x-2">
                    @for ($i = 0; $i < 6; $i++)
                        <input type="text" 
                               name="otp[{{ $i }}]" 
                               maxlength="1" 
                               class="w-12 h-12 text-center text-lg font-mono border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                               oninput="moveToNext(this, {{ $i + 1 }})" 
                               onkeydown="handleBackspace(event, this, {{ $i - 1 }})"
                               required>
                    @endfor
                </div>
                <x-input-error :messages="$errors->get('otp')" class="mt-2" />
            </div>

            <div class="flex justify-between items-center">
                <span id="countdown" class="text-sm text-gray-600"></span>
                <x-primary-button id="verifyBtn" class="ms-4">
                    {{ __('Verify and Register') }}
                </x-primary-button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Didn't receive the OTP? 
                <button type="button" id="resendBtn" class="text-indigo-600 hover:text-indigo-900 font-medium">
                    Resend OTP
                </button>
            </p>
        </div>

        <!-- Resend OTP Modal -->
        <div id="resendModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-96">
                <h3 class="text-lg font-semibold mb-4">Resend OTP</h3>
                <form id="resendForm" method="POST" action="{{ route('otp.resend') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="resendEmail" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="resendEmail" name="email" value="{{ $email ?? old('email') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeResendModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                            Send OTP
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // OTP input handling
        function moveToNext(current, nextIndex) {
            if (current.value.length === 1 && nextIndex < 6) {
                document.querySelector(`input[name="otp[${nextIndex}]"]`).focus();
            }
        }

        function handleBackspace(event, current, prevIndex) {
            if (event.key === 'Backspace' && current.value === '' && prevIndex >= 0) {
                document.querySelector(`input[name="otp[${prevIndex}]"]`).focus();
            }
        }

        // Countdown timer
        let countdownTime = 120; // 2 minutes in seconds
        const countdownElement = document.getElementById('countdown');
        const verifyBtn = document.getElementById('verifyBtn');

        function updateCountdown() {
            const minutes = Math.floor(countdownTime / 60);
            const seconds = countdownTime % 60;
            countdownElement.textContent = `Time remaining: ${minutes}:${seconds.toString().padStart(2, '0')}`;
            
            if (countdownTime <= 0) {
                countdownElement.textContent = 'Time expired! Please request a new OTP.';
                verifyBtn.disabled = true;
                verifyBtn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                countdownTime--;
                setTimeout(updateCountdown, 1000);
            }
        }

        // Start countdown when page loads
        updateCountdown();

        // Modal functions
        function openResendModal() {
            document.getElementById('resendModal').classList.remove('hidden');
        }

        function closeResendModal() {
            document.getElementById('resendModal').classList.add('hidden');
        }

        // Event listeners
        document.getElementById('resendBtn').addEventListener('click', openResendModal);
        
        // Close modal when clicking outside
        document.getElementById('resendModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeResendModal();
            }
        });
    </script>
</x-guest-layout>