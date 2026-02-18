<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 flex items-center justify-center p-4 relative overflow-hidden">
        
        <!-- Animated Background Particles -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-20 left-10 w-72 h-72 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full mix-blend-multiply dark:from-purple-700 dark:to-pink-700 opacity-20 blur-xl animate-pulse"></div>
            <div class="absolute top-40 right-10 w-72 h-72 bg-gradient-to-r from-cyan-400 to-blue-400 rounded-full mix-blend-multiply dark:from-cyan-700 dark:to-blue-700 opacity-20 blur-xl animate-pulse" style="animation-delay: 2s"></div>
            <div class="absolute bottom-20 left-1/2 w-72 h-72 bg-gradient-to-r from-emerald-400 to-teal-400 rounded-full mix-blend-multiply dark:from-emerald-700 dark:to-teal-700 opacity-20 blur-xl animate-pulse" style="animation-delay: 4s"></div>
        </div>

        <!-- Floating Particles Animation -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="particle-container">
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
            </div>
        </div>

        <!-- Main Authentication Card -->
        <div class="w-full max-w-md relative">
            <div class="relative bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-xl border border-white/20 rounded-3xl shadow-2xl overflow-hidden">
                
                <!-- Card Header with Icon -->
                <div class="relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-500/20 to-pink-500/20"></div>
                    <div class="relative p-8 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl shadow-lg mb-4 transform hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-white mb-2 bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                            Secure Verification
                        </h1>
                        <p class="text-white/80 text-sm leading-relaxed">
                            Please enter the 6-digit verification code sent to your email address to complete your registration.
                        </p>
                    </div>
                </div>

                <!-- Success/Error Messages -->
                @if (session('success'))
                    <div class="mx-6 mb-6 bg-gradient-to-r from-green-500/20 to-emerald-500/20 border border-green-500/30 text-green-100 px-6 py-4 rounded-xl flex items-center space-x-4 animate-in slide-in-from-top-2 duration-500">
                        <div class="w-10 h-10 bg-green-500/30 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold">Success</div>
                            <div class="text-green-200 text-sm">{{ session('success') }}</div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mx-6 mb-6 bg-gradient-to-r from-red-500/20 to-pink-500/20 border border-red-500/30 text-red-100 px-6 py-4 rounded-xl flex items-center space-x-4 animate-in slide-in-from-top-2 duration-500">
                        <div class="w-10 h-10 bg-red-500/30 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold">Error</div>
                            <div class="text-red-200 text-sm">{{ session('error') }}</div>
                        </div>
                    </div>
                @endif

                <!-- OTP Form -->
                <form method="POST" action="{{ route('otp.verify') }}" class="space-y-8 p-8">
                    @csrf

                    <!-- Email Display -->
                    <div class="bg-gradient-to-r from-white/5 to-white/10 border border-white/20 rounded-2xl p-6">
                        <label class="block text-white/70 text-sm font-medium mb-3 flex items-center space-x-2">
                            <svg class="w-5 h-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                            <span>Email Address</span>
                        </label>
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 bg-white/5 border border-white/20 rounded-xl px-4 py-3">
                                <input id="email" class="w-full bg-transparent text-white placeholder-white/60 border-0 focus:ring-0 focus:outline-none text-lg" 
                                       type="email" name="email" value="{{ $email ?? old('email') }}" required readonly>
                            </div>
                        </div>
                    </div>

                    <!-- OTP Input Section -->
                    <div>
                        <label class="block text-white/70 text-sm font-medium mb-4 flex items-center space-x-2">
                            <svg class="w-5 h-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <span>Verification Code</span>
                        </label>
                        <div class="grid grid-cols-6 gap-4">
                            @for ($i = 0; $i < 6; $i++)
                                <div class="relative group">
                                    <input type="text" 
                                           name="otp[{{ $i }}]" 
                                           maxlength="1" 
                                           class="w-full h-16 text-center text-3xl font-mono font-bold bg-gradient-to-b from-white/10 to-white/5 border-2 border-white/30 rounded-2xl text-white placeholder-white/40 focus:border-purple-400 focus:outline-none focus:ring-0 transition-all duration-300 hover:border-white/50 group-hover:scale-105"
                                           oninput="moveToNext(this, {{ $i + 1 }})" 
                                           onkeydown="handleBackspace(event, this, {{ $i - 1 }})"
                                           onfocus="this.select()"
                                           required>
                                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-b from-transparent to-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </div>
                            @endfor
                        </div>
                        <x-input-error :messages="$errors->get('otp')" class="mt-2" />
                    </div>

                    <!-- Countdown & Progress -->
                    <div class="flex items-center justify-between bg-gradient-to-r from-white/5 to-white/10 border border-white/20 rounded-2xl p-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-gradient-to-r from-green-400 to-emerald-400 rounded-full animate-pulse shadow-lg"></div>
                            <div class="text-white font-medium">
                                <span class="text-white/70 text-sm">Time remaining:</span>
                                <div id="countdown" class="text-lg font-bold"></div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-right text-white/60 text-xs">
                                <div>Security</div>
                                <div>Timer</div>
                            </div>
                            <div class="w-32 h-3 bg-gradient-to-r from-white/20 to-white/10 rounded-full overflow-hidden">
                                <div id="progressBar" class="h-full bg-gradient-to-r from-purple-400 to-pink-400 transition-all duration-1000 ease-linear shadow-lg" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-4">
                        <button id="verifyBtn" type="submit" class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold py-4 px-6 rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-purple-500/50 group">
                            <span class="flex items-center justify-center space-x-3">
                                <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center group-hover:bg-white/30 transition-colors duration-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-lg font-semibold">Verify & Complete Registration</span>
                            </span>
                        </button>

                        <div class="text-center">
                            <p class="text-white/70 text-sm">
                                Didn't receive the code?
                                <button type="button" id="resendBtn" class="text-white font-semibold hover:text-purple-300 transition-colors duration-300 underline decoration-dotted hover:decoration-solid">
                                    Resend OTP
                                </button>
                            </p>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Footer Info -->
            <div class="text-center mt-6">
                <p class="text-white/50 text-xs leading-relaxed">
                    <span class="block mb-1">🔒 Your security is our priority</span>
                    <span>For security purposes, this verification code expires in 2 minutes</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Resend OTP Modal -->
    <div id="resendModal" class="fixed inset-0 bg-gradient-to-br from-slate-900/80 via-purple-900/80 to-slate-900/80 backdrop-blur-sm flex items-center justify-center p-4 hidden transition-all duration-500">
        <div class="bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-xl border border-white/20 rounded-3xl shadow-2xl p-8 w-full max-w-md transform scale-95 opacity-0 transition-all duration-500">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">Resend Verification Code</h3>
                        <p class="text-white/60 text-sm">We'll send a new code to your email address</p>
                    </div>
                </div>
                <button onclick="closeResendModal()" class="text-white/60 hover:text-white transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="resendForm" method="POST" action="{{ route('otp.resend') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="resendEmail" class="block text-white/70 text-sm font-medium mb-3">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                        <input type="email" id="resendEmail" name="email" value="{{ $email ?? old('email') }}" required 
                               class="w-full pl-12 pr-4 py-4 bg-gradient-to-r from-white/5 to-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 focus:border-purple-400 focus:outline-none focus:ring-0 transition-all duration-300">
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 pt-2">
                    <button type="button" onclick="closeResendModal()" class="px-6 py-3 text-sm font-medium text-white/70 bg-gradient-to-r from-white/5 to-white/10 border border-white/20 rounded-xl hover:bg-gradient-to-r hover:from-white/10 hover:to-white/20 transition-all duration-300">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl hover:shadow-lg hover:-translate-y-1 transition-all duration-300 shadow-lg">
                        Send New Code
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Enhanced OTP input handling with premium UX
        function moveToNext(current, nextIndex) {
            if (current.value.length === 1 && nextIndex < 6) {
                const nextInput = document.querySelector(`input[name="otp[${nextIndex}]"]`);
                if (nextInput) {
                    nextInput.focus();
                    // Add premium animation effect
                    const parent = nextInput.parentElement;
                    parent.classList.add('animate-pulse', 'scale-110');
                    setTimeout(() => {
                        parent.classList.remove('animate-pulse', 'scale-110');
                    }, 200);
                }
            }
        }

        function handleBackspace(event, current, prevIndex) {
            if (event.key === 'Backspace' && current.value === '' && prevIndex >= 0) {
                const prevInput = document.querySelector(`input[name="otp[${prevIndex}]"]`);
                if (prevInput) {
                    prevInput.focus();
                    prevInput.select();
                }
            }
        }

        // Premium countdown timer with enhanced progress bar
        let countdownTime = 120; // 2 minutes in seconds
        const countdownElement = document.getElementById('countdown');
        const progressBar = document.getElementById('progressBar');
        const verifyBtn = document.getElementById('verifyBtn');
        const initialTime = countdownTime;

        function updateCountdown() {
            const minutes = Math.floor(countdownTime / 60);
            const seconds = countdownTime % 60;
            const timeString = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            countdownElement.textContent = timeString;
            
            // Update progress bar with gradient animation
            const progress = ((initialTime - countdownTime) / initialTime) * 100;
            progressBar.style.width = `${progress}%`;
            
            if (countdownTime <= 0) {
                countdownElement.innerHTML = '<span class="text-red-400 font-bold">EXPIRED</span>';
                progressBar.style.background = 'linear-gradient(90deg, #ef4444, #dc2626)';
                progressBar.style.boxShadow = '0 0 15px rgba(239, 68, 68, 0.5)';
                verifyBtn.disabled = true;
                verifyBtn.classList.add('opacity-50', 'cursor-not-allowed', 'hover:transform-none', 'bg-gradient-to-r', 'from-gray-600', 'to-gray-700');
                verifyBtn.classList.remove('hover:-translate-y-1', 'from-purple-600', 'to-pink-600');
                verifyBtn.innerHTML = `
                    <span class="flex items-center justify-center space-x-3">
                        <div class="w-6 h-6 bg-red-500/30 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <span class="text-lg font-semibold">Time Expired</span>
                    </span>
                `;
            } else {
                countdownTime--;
                setTimeout(updateCountdown, 1000);
            }
        }

        // Start countdown when page loads
        updateCountdown();

        // Premium modal functions with smooth animations
        function openResendModal() {
            const modal = document.getElementById('resendModal');
            const modalContent = modal.querySelector('.bg-gradient-to-br');
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeResendModal() {
            const modal = document.getElementById('resendModal');
            const modalContent = modal.querySelector('.bg-gradient-to-br');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 500);
        }

        // Event listeners with premium interactions
        document.getElementById('resendBtn').addEventListener('click', openResendModal);
        
        // Close modal when clicking outside or pressing Escape
        document.getElementById('resendModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeResendModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeResendModal();
            }
        });

        // Enhanced focus effects for OTP inputs
        document.querySelectorAll('input[name^="otp"]').forEach(input => {
            input.addEventListener('focus', function() {
                const parent = this.parentElement;
                parent.classList.add('ring-2', 'ring-purple-400/50', 'scale-105', 'shadow-lg');
                parent.style.zIndex = '10';
            });
            
            input.addEventListener('blur', function() {
                const parent = this.parentElement;
                parent.classList.remove('ring-2', 'ring-purple-400/50', 'scale-105', 'shadow-lg');
                parent.style.zIndex = '1';
            });
        });

        // Floating particles animation
        function createParticles() {
            const container = document.querySelector('.particle-container');
            if (!container) return;

            for (let i = 0; i < 20; i++) {
                const particle = document.createElement('div');
                particle.className = 'floating-particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 5 + 's';
                particle.style.animationDuration = (Math.random() * 3 + 2) + 's';
                container.appendChild(particle);
            }
        }

        // Initialize particles
        createParticles();
    </script>

    <style>
        .floating-particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: radial-gradient(circle, rgba(255,255,255,0.8) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
            animation: float 3s ease-in-out infinite;
            opacity: 0.3;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .particle-container {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
        }

        .animate-in {
            animation: slideIn 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</x-guest-layout>