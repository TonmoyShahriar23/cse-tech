<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Laravel') }} - Register</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-hover: #4f46e5;
            --text-color: #1f2937;
            --text-secondary: #6b7280;
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --border-color: #e5e7eb;
            --shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .register-container {
            width: 100%;
            max-width: 420px;
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: var(--shadow);
            padding: 40px;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
        }
        
        .logo-section {
            margin-bottom: 32px;
        }
        
        .logo {
            width: 60px;
            height: 60px;
            margin: 0 auto 16px;
            display: block;
        }
        
        h1 {
            font-size: 24px;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 8px;
        }
        
        .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            font-weight: 400;
        }
        
        .form-group {
            margin-bottom: 24px;
            text-align: left;
        }
        
        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-field {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.2s ease;
            background: #fff;
            outline: none;
        }
        
        .input-field:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            transform: translateY(-1px);
        }
        
        .input-field::placeholder {
            color: #9ca3af;
        }
        
        .submit-btn {
            width: 100%;
            padding: 14px 24px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);
        }
        
        .submit-btn:active {
            transform: translateY(0);
        }
        
        .divider {
            margin: 24px 0;
            display: flex;
            align-items: center;
            text-align: center;
            color: var(--text-secondary);
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.05em;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--border-color);
        }
        
        .login-link {
            margin-top: 16px;
            font-size: 14px;
            color: var(--text-secondary);
        }
        
        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }
        
        .login-link a:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }
        
        .error-message {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
        }
        
        @media (max-width: 480px) {
            .register-container {
                padding: 32px 24px;
                border-radius: 12px;
            }
            
            h1 {
                font-size: 20px;
            }
            
            .input-field {
                padding: 12px 14px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo-section">
            <svg class="logo" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="#6366f1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M2 17L12 22L22 17" stroke="#6366f1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M2 12L12 17L22 12" stroke="#6366f1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <h1>Create Account</h1>
            <p class="subtitle">Join us today and get started</p>
        </div>

        <form method="POST" action="{{ route('register.store') }}">
            @csrf

            <div class="form-group">
                <label for="name">Full Name</label>
                <div class="input-wrapper">
                    <input id="name" class="input-field" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Enter your full name" />
                </div>
                @error('name')
                    <div class="error-message" style="margin-top: 8px; background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 8px; border-radius: 6px; font-size: 12px;">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrapper">
                    <input id="email" class="input-field" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Enter your email address" />
                </div>
                @error('email')
                    <div class="error-message" style="margin-top: 8px; background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 8px; border-radius: 6px; font-size: 12px;">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input id="password" class="input-field" type="password" name="password" required autocomplete="new-password" placeholder="Create a strong password" />
                </div>
                @error('password')
                    <div class="error-message" style="margin-top: 8px; background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 8px; border-radius: 6px; font-size: 12px;">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <div class="input-wrapper">
                    <input id="password_confirmation" class="input-field" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password" />
                </div>
                @error('password_confirmation')
                    <div class="error-message" style="margin-top: 8px; background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 8px; border-radius: 6px; font-size: 12px;">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="submit-btn">
                Create Account
            </button>
        </form>

        <div class="divider">Or</div>
        
        <div class="login-link">
            Already have an account? 
            <a href="{{ route('login') }}">Sign in here</a>
        </div>
    </div>
</body>
</html>
