<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }

        .container {
            background: white;
            border-radius: 20px;
            padding: 60px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 90%;
        }

        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #10a37f, #059669);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px auto;
            position: relative;
            box-shadow: 0 10px 30px rgba(16, 163, 127, 0.3);
        }

        .success-icon::before {
            content: '✓';
            color: white;
            font-size: 50px;
            font-weight: bold;
            position: relative;
            z-index: 2;
        }

        .success-icon::after {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10a37f, #059669);
            opacity: 0.3;
            filter: blur(10px);
            z-index: 1;
        }

        h1 {
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 15px;
            color: #1f2937;
        }

        .subtitle {
            font-size: 18px;
            color: #6b7280;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .details-box {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: left;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .detail-label {
            color: #6b7280;
        }

        .detail-value {
            font-weight: 600;
            color: #1f2937;
        }

        .highlight-row {
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
            margin-top: 10px;
            font-size: 20px;
            font-weight: 800;
            color: #10a37f;
        }

        .btn {
            background: linear-gradient(135deg, #10a37f, #059669);
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 50px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            box-shadow: 0 10px 20px rgba(16, 163, 127, 0.3);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(16, 163, 127, 0.4);
        }

        .btn.secondary {
            background: #6b7280;
            box-shadow: 0 10px 20px rgba(107, 114, 128, 0.3);
            margin-left: 15px;
        }

        .btn.secondary:hover {
            background: #4b5563;
            box-shadow: 0 15px 30px rgba(107, 114, 128, 0.4);
        }

        .actions {
            margin-top: 30px;
        }

        .thank-you {
            font-size: 14px;
            color: #9ca3af;
            margin-top: 20px;
            font-style: italic;
        }

        @media (max-width: 600px) {
            .container {
                padding: 40px 20px;
            }
            
            h1 {
                font-size: 28px;
            }
            
            .subtitle {
                font-size: 16px;
            }
            
            .success-icon {
                width: 80px;
                height: 80px;
            }
            
            .success-icon::before {
                font-size: 40px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon"></div>
        
        <h1>Your Payment is Successful! 🎉</h1>
        <p class="subtitle">Your transaction has been completed successfully. Thank you for choosing our service!</p>
        
        <div class="details-box">
            <div class="detail-row">
                <span class="detail-label">Transaction ID</span>
                <span class="detail-value">{{ session('tran_id', 'N/A') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Amount</span>
                <span class="detail-value">{{ session('amount', 'N/A') }} {{ session('currency', 'BDT') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Payment Method</span>
                <span class="detail-value">{{ session('card_type', 'SSLCommerz') }}</span>
            </div>
            <div class="detail-row highlight-row">
                <span class="detail-label">Status</span>
                <span class="detail-value">PAID</span>
            </div>
        </div>

        <div class="actions">
            <a href="{{ url('/dashboard') }}" class="btn">Go to Dashboard</a>
            <a href="{{ url('/pricing') }}" class="btn secondary">View Plans</a>
        </div>

        <p class="thank-you">Thank you for your business! Your subscription is now active.</p>
    </div>
</body>
</html>