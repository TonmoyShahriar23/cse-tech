<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .otp-container {
            background-color: #f8f9fa;
            border: 2px solid #007bff;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 5px;
            color: #007bff;
            margin: 10px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Verify Your Identity</h1>
    </div>

    <p>Hello,</p>

    <p>Thank you for registering with our service. To complete your registration, please use the following One-Time Password (OTP):</p>

    <div class="otp-container">
        <h2>Your OTP Code</h2>
        <div class="otp-code">{{ $otp }}</div>
        <p><small>This code will expire in 10 minutes for security reasons.</small></p>
    </div>

    <p>If you did not request this code, please ignore this email. Your account is secure and no changes have been made.</p>

    <p>Best regards,<br>
    The Team</p>

    <div class="footer">
        <p>This is an automated message, please do not reply to this email.</p>
        <p>&copy; {{ date('Y') }} Your Application Name. All rights reserved.</p>
    </div>
</body>
</html>