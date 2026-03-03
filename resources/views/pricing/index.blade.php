<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upgrade your plan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        body {
            background: #0b0d10;
            color: #ececf1;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 60px;
        }

        .header h1 {
            font-size: 48px;
            font-weight: 800;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #ffffff, #a0a0a0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header p {
            font-size: 18px;
            color: #8e8ea0;
            max-width: 600px;
            margin: 0 auto;
        }

        .plan-selector {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 60px;
        }

        .plan-option {
            background: #111316;
            border: 1px solid #2a2d33;
            border-radius: 12px;
            padding: 16px 24px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .plan-option:hover {
            border-color: #40414f;
            background: #15171b;
        }

        .plan-option.active {
            border-color: #10a37f;
            background: #0f1a16;
            color: #10a37f;
        }

        .plan-option input {
            display: none;
        }

        .plan-option .check {
            width: 20px;
            height: 20px;
            border: 2px solid #40414f;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .plan-option.active .check {
            border-color: #10a37f;
            background: #10a37f;
        }

        .plan-option.active .check::after {
            content: '✓';
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .plans-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        /* Center business plans */
        .business-plans .plans-grid {
            grid-template-columns: repeat(2, 1fr);
            max-width: 800px;
            margin: 0 auto;
        }

        .plan-card {
            background: #111316;
            border: 1px solid #2a2d33;
            border-radius: 16px;
            padding: 40px 30px;
            position: relative;
            transition: all 0.3s ease;
        }

        .plan-card:hover {
            border-color: #40414f;
            transform: translateY(-4px);
        }

        .plan-card.recommended {
            border-color: #10a37f;
            background: linear-gradient(145deg, #0f1a16, #0d1512);
        }

        .plan-card.recommended::before {
            content: 'RECOMMENDED';
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: #10a37f;
            color: white;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Business plan specific styling */
        .plan-card.business-plan {
            border-color: #10a37f;
            background: linear-gradient(145deg, #0f1a16, #0d1512);
        }

        .plan-card.business-plan::before {
            content: 'RECOMMENDED';
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: #10a37f;
            color: white;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .plan-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .plan-name {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 16px;
            color: #ffffff;
        }

        .plan-price {
            font-size: 48px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .plan-price span {
            font-size: 18px;
            font-weight: 400;
            color: #8e8ea0;
        }

        /* Special styling for Pro plan $200 price */
        .plan-card.pro-special .plan-name + .plan-price {
            font-size: 48px;
            font-weight: 800;
            letter-spacing: 0;
            line-height: 1.2;
            margin-bottom: 8px;
        }

        .plan-card.pro-special .plan-name + .plan-price span {
            font-size: 18px;
            font-weight: 400;
            position: static;
            top: 0;
            margin-right: 0;
        }

        .plan-description {
            font-size: 14px;
            color: #8e8ea0;
            margin-bottom: 30px;
            line-height: 1.6;
        }


        .current-plan-badge {
            background: #2a2d33;
            color: #8e8ea0;
            border: 1px solid #40414f;
            padding: 10px 20px;
            border-radius: 24px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 auto 30px auto;
            display: block;
            text-align: center;
            cursor: not-allowed;
            opacity: 0.6;
            width: fit-content;
        }

        .upgrade-btn {
            width: 100%;
            padding: 10px 20px;
            border-radius: 24px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid #40414f;
            background: #2a2d33;
            color: #8e8ea0;
            margin-bottom: 30px;
            text-align: center;
        }

        .upgrade-btn:hover {
            background: #343541;
            color: #ececf1;
            border-color: #565869;
        }

        .upgrade-btn.current-plan {
            background: #2a2d33;
            color: #8e8ea0;
            border: 1px solid #40414f;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .upgrade-btn.current-plan:hover {
            background: #2a2d33;
            color: #8e8ea0;
            border-color: #40414f;
            cursor: not-allowed;
            opacity: 0.6;
        }

        /* Different colors for each plan button */
        .plan-card:nth-child(1) .upgrade-btn:not(.current-plan) {
            background: #3b82f6;
            border-color: #2563eb;
            color: white;
        }

        .plan-card:nth-child(1) .upgrade-btn:not(.current-plan):hover {
            background: #2563eb;
            border-color: #1d4ed8;
        }

        .plan-card:nth-child(2) .upgrade-btn:not(.current-plan) {
            background: #10b981;
            border-color: #059669;
            color: white;
        }

        .plan-card:nth-child(2) .upgrade-btn:not(.current-plan):hover {
            background: #059669;
            border-color: #047857;
        }

        .plan-card:nth-child(3) .upgrade-btn:not(.current-plan) {
            background: #f59e0b;
            border-color: #d97706;
            color: white;
        }

        .plan-card:nth-child(3) .upgrade-btn:not(.current-plan):hover {
            background: #d97706;
            border-color: #b45309;
        }

        .plan-card:nth-child(4) .upgrade-btn:not(.current-plan) {
            background: #3b82f6;
            border-color: #2563eb;
            color: white;
        }

        .plan-card:nth-child(4) .upgrade-btn:not(.current-plan):hover {
            background: #2563eb;
            border-color: #1d4ed8;
        }

        /* Business plan button styling */
        .business-upgrade {
            background: #10a37f !important;
            border-color: #059669 !important;
            color: white !important;
            width: fit-content;
            margin: 0 auto 30px auto;
        }

        .business-upgrade:hover {
            background: #059669 !important;
            border-color: #047857 !important;
        }

        .features-list {
            list-style: none;
        }

        .features-list li {
            padding: 12px 0;
            border-bottom: 1px solid #2a2d33;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            color: #8e8ea0;
        }

        .features-list li:last-child {
            border-bottom: none;
        }

        .features-list li .icon {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: white;
        }

        .features-list li.included .icon {
            background: #10a37f;
        }

        .features-list li.not-included .icon {
            background: #40414f;
            color: #8e8ea0;
        }

        .footer {
            text-align: center;
            margin-top: 80px;
            padding: 40px;
            background: #0b0d10;
            border-top: 1px solid #2a2d33;
        }

        .footer p {
            font-size: 16px;
            color: #8e8ea0;
            margin-bottom: 20px;
        }

        .footer a {
            color: #10a37f;
            text-decoration: none;
            font-weight: 600;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .plans-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 36px;
            }

            .plans-grid {
                grid-template-columns: 1fr;
            }

            .plan-card {
                padding: 30px 20px;
            }

            .plan-price {
                font-size: 36px;
            }
        }

        /* Personal plans visibility */
        .personal-plans {
            display: block;
        }

        .business-plans {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Upgrade your plan</h1>
            <p>Choose the perfect plan for your needs and unlock the full potential of AI</p>
        </div>

        <div class="plan-selector">
            <label class="plan-option active" data-plan="personal">
                <span class="check"></span>
                <span>Personal</span>
            </label>
            <label class="plan-option" data-plan="business">
                <span class="check"></span>
                <span>Business</span>
            </label>
        </div>

        <!-- Personal Plans -->
        <div class="personal-plans">
            <div class="plans-grid">
                <!-- Free Plan -->
                <div class="plan-card">
                    <div class="plan-header">
                        <div class="plan-name">Free</div>
                        <div class="plan-price">$0<span>USD / month</span></div>
                        <div class="plan-description">See what AI can do</div>
                        <button class="upgrade-btn current-plan">Your current plan</button>
                        <div class="plan-description">What's included:</div>
                    </div>
                    <ul class="features-list">
                        <li class="included"><span class="icon">✓</span> Core model</li>
                        <li class="included"><span class="icon">✓</span> Limited messages and uploads</li>
                        <li class="included"><span class="icon">✓</span> Limited image creation</li>
                        <li class="included"><span class="icon">✓</span> Limited memory</li>
                    </ul>
                </div>

                <!-- Go Plan -->
                <div class="plan-card">
                    <div class="plan-header">
                        <div class="plan-name">Go</div>
                        <div class="plan-price">$5<span>USD / month</span></div>
                        <div class="plan-description">Keep chatting with expanded access</div>
                        <button class="upgrade-btn secondary">Upgrade to Go</button>
                        <div class="plan-description">Everything in Free and:</div>
                    </div>
                    <ul class="features-list">
                        <li class="included"><span class="icon">✓</span> More messages</li>
                        <li class="included"><span class="icon">✓</span> More file uploads</li>
                        <li class="included"><span class="icon">✓</span> More image creation</li>
                        <li class="included"><span class="icon">✓</span> Longer memory</li>
                        <li class="included"><span class="icon">✓</span> Expanded voice mode</li>
                    </ul>
                </div>

                <!-- Plus Plan -->
                <div class="plan-card recommended">
                    <div class="plan-header">
                        <div class="plan-name">Plus</div>
                        <div class="plan-price">$20<span>USD / month</span></div>
                        <div class="plan-description">Unlock the full experience</div>
                        <button class="upgrade-btn primary">Upgrade to Plus</button>
                        <div class="plan-description">Everything in Go and:</div>
                    </div>
                    <ul class="features-list">
                        <li class="included"><span class="icon">✓</span> Advanced models</li>
                        <li class="included"><span class="icon">✓</span> Even more messages and file uploads</li>
                        <li class="included"><span class="icon">✓</span> Even more image creation</li>
                        <li class="included"><span class="icon">✓</span> Expanded memory across chats</li>
                        <li class="included"><span class="icon">✓</span> Expanded deep research and agent mode</li>
                        <li class="included"><span class="icon">✓</span> Projects and custom GPTs</li>
                        <li class="included"><span class="icon">✓</span> Sora video generation</li>
                        <li class="included"><span class="icon">✓</span> Limited access to Codex</li>
                    </ul>
                </div>

                <!-- Pro Plan -->
                <div class="plan-card pro-special">
                    <div class="plan-header">
                        <div class="plan-name">Pro</div>
                        <div class="plan-price">$200<span>USD / month</span></div>
                        <div class="plan-description">Maximize your productivity</div>
                        <button class="upgrade-btn secondary">Upgrade to Pro</button>
                        <div class="plan-description">Everything in Plus and:</div>
                    </div>
                    <ul class="features-list">
                        <li class="included"><span class="icon">✓</span> Maximum Codex usage</li>
                        <li class="included"><span class="icon">✓</span> Maximum agent mode</li>
                        <li class="included"><span class="icon">✓</span> GPT-5.2 Pro research model</li>
                        <li class="included"><span class="icon">✓</span> Unlimited messages with GPT-5</li>
                        <li class="included"><span class="icon">✓</span> Unlimited and faster image creation</li>
                        <li class="included"><span class="icon">✓</span> Maximum memory and context</li>
                        <li class="included"><span class="icon">✓</span> Expanded projects, tasks, and custom GPTs</li>
                        <li class="included"><span class="icon">✓</span> Early access to experimental features</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Business Plans -->
        <div class="business-plans">
            <div class="plans-grid">
                <!-- Free Plan -->
                <div class="plan-card">
                    <div class="plan-header">
                        <div class="plan-name">Free</div>
                        <div class="plan-price">$0<span>USD / month</span></div>
                        <div class="plan-description">See what AI can do</div>
                        <button class="current-plan-badge">Your current plan</button>
                        <div class="plan-description">What's included:</div>
                    </div>
                    <ul class="features-list">
                        <li class="included"><span class="icon">✓</span> Core model</li>
                        <li class="included"><span class="icon">✓</span> Limited messages and uploads</li>
                        <li class="included"><span class="icon">✓</span> Limited image creation</li>
                        <li class="included"><span class="icon">✓</span> Limited memory</li>
                    </ul>
                </div>

                <!-- Business Plan -->
                <div class="plan-card business-plan">
                    <div class="plan-header">
                        <div class="plan-name">Business</div>
                        <div class="plan-price">$30<span>USD / month</span></div>
                        <div class="plan-description">Get more work done with AI for teams</div>
                        <button class="upgrade-btn business-upgrade">Upgrade to Business</button>
                        <div class="plan-description">What's included:</div>
                    </div>
                    <ul class="features-list">
                        <li class="included"><span class="icon">✓</span> Conduct professional analysis</li>
                        <li class="included"><span class="icon">✓</span> Get unlimited messages with GPT-5</li>
                        <li class="included"><span class="icon">✓</span> Produce images, videos, slides, & more</li>
                        <li class="included"><span class="icon">✓</span> Secure your space with SSO, MFA, & more</li>
                        <li class="included"><span class="icon">✓</span> Protect privacy; data never used for training</li>
                        <li class="included"><span class="icon">✓</span> Share projects & custom GPTs</li>
                        <li class="included"><span class="icon">✓</span> Integrate with SharePoint & other tools</li>
                        <li class="included"><span class="icon">✓</span> Simplify billing and user management</li>
                        <li class="included"><span class="icon">✓</span> Capture meeting notes with transcription</li>
                        <li class="included"><span class="icon">✓</span> Deploy agents to code and research</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>Need more capabilities for your business?</p>
            <a href="https://jolly-gumption-c7955e.netlify.app" target="_blank">Contact with me</a>
        </div>
    </div>

    <script>
        // Plan selector functionality
        const planOptions = document.querySelectorAll('.plan-option');
        const personalPlans = document.querySelector('.personal-plans');
        const businessPlans = document.querySelector('.business-plans');
        
        planOptions.forEach(option => {
            option.addEventListener('click', () => {
                // Remove active class from all options
                planOptions.forEach(opt => opt.classList.remove('active'));
                
                // Add active class to clicked option
                option.classList.add('active');
                
                // Show/hide appropriate plan sections
                if (option.dataset.plan === 'personal') {
                    personalPlans.style.display = 'block';
                    businessPlans.style.display = 'none';
                } else if (option.dataset.plan === 'business') {
                    personalPlans.style.display = 'none';
                    businessPlans.style.display = 'block';
                }
            });
        });

        // Upgrade button functionality
        const upgradeButtons = document.querySelectorAll('.upgrade-btn');
        
        upgradeButtons.forEach(button => {
            button.addEventListener('click', () => {
                const planName = button.closest('.plan-card').querySelector('.plan-name').textContent;
                const planPrice = button.closest('.plan-card').querySelector('.plan-price').textContent.trim();
                
                if (button.classList.contains('business-upgrade')) {
                    // Special handling for business plan
                    alert(`Proceeding to upgrade to ${planName} plan for ${planPrice}\n\nThis will redirect you to the payment processing page where you can complete your subscription for $30/month.`);
                    // In a real implementation, this would redirect to payment processing
                    // window.location.href = '/checkout/business';
                } else {
                    alert(`Upgrade to ${planName} plan would be processed here.`);
                    // In a real implementation, this would redirect to payment processing
                }
            });
        });
    </script>
</body>
</html>