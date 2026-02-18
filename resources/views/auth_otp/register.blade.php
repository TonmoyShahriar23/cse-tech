<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'AI Agent') }} - Create Your Account</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-100: #eef2ff;
            --primary-200: #e0e7ff;
            --primary-300: #c7d2fe;
            --primary-400: #a5b4fc;
            --primary-500: #818cf8;
            --primary-600: #6366f1;
            --primary-700: #4f46e5;
            --primary-800: #4338ca;
            --primary-900: #3730a3;
            
            --secondary-100: #f3e8ff;
            --secondary-200: #e9d5ff;
            --secondary-300: #d8b4fe;
            --secondary-400: #c084fc;
            --secondary-500: #a855f7;
            --secondary-600: #9333ea;
            --secondary-700: #7e22ce;
            --secondary-800: #6b21a8;
            --secondary-900: #581c87;
            
            --neutral-50: #f8fafc;
            --neutral-100: #f1f5f9;
            --neutral-200: #e2e8f0;
            --neutral-300: #cbd5e1;
            --neutral-400: #94a3b8;
            --neutral-500: #64748b;
            --neutral-600: #475569;
            --neutral-700: #334155;
            --neutral-800: #1e293b;
            --neutral-900: #0f172a;
            
            --success-500: #10b981;
            --error-500: #ef4444;
            --warning-500: #f59e0b;
            --info-500: #3b82f6;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Plus Jakarta Sans', 'Inter', system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: var(--neutral-900);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        
        /* Animated background particles */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }
        
        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        .particle:nth-child(1) { width: 20px; height: 20px; top: 10%; left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 15px; height: 15px; top: 20%; right: 20%; animation-delay: 1s; }
        .particle:nth-child(3) { width: 25px; height: 25px; bottom: 10%; left: 30%; animation-delay: 2s; }
        .particle:nth-child(4) { width: 10px; height: 10px; top: 60%; right: 10%; animation-delay: 3s; }
        .particle:nth-child(5) { width: 30px; height: 30px; bottom: 40%; right: 40%; animation-delay: 4s; }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        /* Floating gradient orbs */
        .gradient-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.6;
            z-index: 0;
        }
        
        .orb-1 {
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, var(--primary-300) 0%, transparent 70%);
            top: -150px;
            right: -150px;
            animation: pulse 8s ease-in-out infinite;
        }
        
        .orb-2 {
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, var(--secondary-300) 0%, transparent 70%);
            bottom: -125px;
            left: -125px;
            animation: pulse 10s ease-in-out infinite reverse;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1) rotate(0deg); opacity: 0.4; }
            50% { transform: scale(1.1) rotate(180deg); opacity: 0.6; }
        }
        
        .container {
            width: 100%;
            max-width: 1000px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 28px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            padding: 0;
            overflow: hidden;
            position: relative;
            z-index: 10;
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 500px;
        }
        
        @media (max-width: 900px) {
            .container {
                grid-template-columns: 1fr;
                min-height: auto;
            }
        }
        
        /* Left side - Visual section */
        .visual-section {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            padding: 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
        }
        
        @media (max-width: 900px) {
            .visual-section {
                border-right: none;
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
                padding: 32px;
            }
        }
        
        .visual-content {
            max-width: 350px;
            z-index: 1;
        }
        
        .logo-container {
            width: 80px;
            height: 80px;
            margin: 0 auto 24px;
            background: linear-gradient(135deg, var(--primary-500), var(--secondary-500));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.4);
            animation: bounce 2s ease-in-out infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }
        
        .logo-icon {
            width: 40px;
            height: 40px;
            fill: none;
            stroke: white;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
        
        .visual-title {
            font-size: 28px;
            font-weight: 700;
            color: white;
            margin-bottom: 12px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .visual-subtitle {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.6;
            font-weight: 400;
        }
        
        .feature-list {
            margin-top: 32px;
            text-align: left;
            width: 100%;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            font-weight: 500;
        }
        
        .feature-icon {
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        /* Right side - Form section */
        .form-section {
            background: rgba(255, 255, 255, 0.95);
            padding: 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }
        
        @media (max-width: 900px) {
            .form-section {
                padding: 32px;
            }
        }
        
        .form-header {
            margin-bottom: 32px;
        }
        
        .form-title {
            font-size: 28px;
            font-weight: 800;
            color: var(--neutral-900);
            margin-bottom: 8px;
            background: linear-gradient(135deg, var(--primary-600), var(--secondary-600));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .form-subtitle {
            font-size: 14px;
            color: var(--neutral-600);
            font-weight: 500;
        }
        
        .form-container {
            width: 100%;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 600;
            color: var(--neutral-600);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: all 0.3s ease;
        }
        
        .required-dot {
            width: 6px;
            height: 6px;
            background: var(--primary-500);
            border-radius: 50%;
            opacity: 0.8;
        }
        
        .input-wrapper {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .input-wrapper:focus-within {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-300);
        }
        
        .input-field {
            width: 100%;
            padding: 18px 20px;
            border: none;
            outline: none;
            font-size: 16px;
            font-weight: 500;
            color: var(--neutral-800);
            background: white;
            transition: all 0.3s ease;
        }
        
        .input-field::placeholder {
            color: var(--neutral-400);
            font-weight: 400;
        }
        
        .input-field:focus {
            background: rgba(248, 250, 252, 0.8);
        }
        
        .input-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--neutral-400);
            transition: all 0.3s ease;
        }
        
        .input-wrapper:focus-within .input-icon {
            color: var(--primary-500);
        }
        
        .error-message {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 10px 14px;
            border-radius: 12px;
            margin-top: 8px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            animation: slideDown 0.3s ease;
        }
        
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .submit-btn {
            width: 100%;
            padding: 18px 24px;
            background: linear-gradient(135deg, var(--primary-600), var(--secondary-600));
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
            margin-top: 8px;
        }
        
        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.7s;
        }
        
        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(99, 102, 241, 0.4);
            background: linear-gradient(135deg, var(--primary-700), var(--secondary-700));
        }
        
        .submit-btn:hover::before {
            left: 100%;
        }
        
        .submit-btn:active {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
        }
        
        .submit-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .divider {
            margin: 24px 0;
            display: flex;
            align-items: center;
            text-align: center;
            color: var(--neutral-500);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--neutral-200);
        }
        
        .login-link {
            margin-top: 16px;
            font-size: 14px;
            color: var(--neutral-600);
            text-align: center;
        }
        
        .login-link a {
            color: var(--primary-600);
            text-decoration: none;
            font-weight: 700;
            transition: all 0.2s ease;
            position: relative;
        }
        
        .login-link a:hover {
            color: var(--primary-700);
            text-decoration: none;
        }
        
        .login-link a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(135deg, var(--primary-500), var(--secondary-500));
            transition: width 0.3s ease;
        }
        
        .login-link a:hover::after {
            width: 100%;
        }
        
        /* Responsive adjustments */
        @media (max-width: 640px) {
            .container {
                border-radius: 20px;
                padding: 0;
            }
            
            .visual-section {
                padding: 24px;
            }
            
            .form-section {
                padding: 24px;
            }
            
            .visual-title {
                font-size: 24px;
            }
            
            .form-title {
                font-size: 24px;
            }
            
            .input-field {
                padding: 16px 18px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <!-- Background Elements -->
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>
    
    <div class="gradient-orb orb-1"></div>
    <div class="gradient-orb orb-2"></div>
    
    <div class="container">
        <!-- Left Visual Section -->
        <div class="visual-section">
            <div class="visual-content">
                <div class="logo-container">
                    <svg class="logo-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 17L12 22L22 17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 12L12 17L22 12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                
                <h1 class="visual-title">Welcome to AI Agent</h1>
                <!-- <p class="visual-subtitle">Join thousands of users who trust our platform for their daily needs. Create your account and unlock a world of possibilities.</p> -->
                
                <div class="feature-list">
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <span>Secure and reliable platform</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <span>24/7 customer support</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <span>Advanced security features</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Form Section -->
        <div class="form-section">
            <div class="form-header">
                <h2 class="form-title">Create Your Account</h2>
                <!-- <p class="form-subtitle">Already have an account? <a href="{{ route('login') }}" style="color: var(--primary-600); text-decoration: none; font-weight: 600;">Sign in here</a></p> -->
            </div>

            <form method="POST" action="{{ route('register.store') }}" class="form-container">
                @csrf

                <div class="form-group">
                    <label class="form-label">
                        <span>Full Name</span>
                        <div class="required-dot"></div>
                    </label>
                    <div class="input-wrapper">
                        <input id="name" class="input-field" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Enter your full name" />
                        <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 21v-2a4 4 0 0 0-3-3.87M4 21v-2a4 4 0 0 1 3-3.87" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    @error('name')
                        <div class="error-message">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" stroke="#dc2626" stroke-width="2"/>
                                <path d="M12 8v4M12 16h.01" stroke="#dc2626" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <span>Email Address</span>
                        <div class="required-dot"></div>
                    </label>
                    <div class="input-wrapper">
                        <input id="email" class="input-field" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Enter your email address" />
                        <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M22 6l-10 7L2 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    @error('email')
                        <div class="error-message">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" stroke="#dc2626" stroke-width="2"/>
                                <path d="M12 8v4M12 16h.01" stroke="#dc2626" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <span>Password</span>
                        <div class="required-dot"></div>
                    </label>
                    <div class="input-wrapper">
                        <input id="password" class="input-field" type="password" name="password" required autocomplete="new-password" placeholder="Create a strong password" />
                        <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="11" width="18" height="11" rx="2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    @error('password')
                        <div class="error-message">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" stroke="#dc2626" stroke-width="2"/>
                                <path d="M12 8v4M12 16h.01" stroke="#dc2626" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <span>Confirm Password</span>
                        <div class="required-dot"></div>
                    </label>
                    <div class="input-wrapper">
                        <input id="password_confirmation" class="input-field" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password" />
                        <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="11" width="18" height="11" rx="2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 16v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    @error('password_confirmation')
                        <div class="error-message">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" stroke="#dc2626" stroke-width="2"/>
                                <path d="M12 8v4M12 16h.01" stroke="#dc2626" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="submit-btn">
                    Create Account
                </button>
            </form>

            <div class="divider">Or continue with</div>
            
            <div class="login-link">
                Already have an account? 
                <a href="{{ route('login') }}">Sign in here</a>
            </div>
        </div>
    </div>

    <script>
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.input-field');
            
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.borderColor = 'var(--primary-300)';
                });
                
                input.addEventListener('blur', function() {
                    if (!this.value) {
                        this.parentElement.style.borderColor = 'transparent';
                    }
                });
            });
            
            // Add floating animation to particles
            const particles = document.querySelectorAll('.particle');
            particles.forEach((particle, index) => {
                particle.style.animationDelay = `${index * 0.5}s`;
            });
        });
    </script>
</body>
</html>