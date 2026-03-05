<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing Payment...</title>
    <style>
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin: 0;
        }
        
        .container {
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }
        
        .loader {
            width: 50px;
            height: 50px;
            border: 5px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
            margin: 0 auto 20px auto;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        h1 {
            font-size: 24px;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        p {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 30px;
        }
        
        .status {
            font-size: 14px;
            opacity: 0.8;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="loader"></div>
        <h1>Processing Payment...</h1>
        <p>Please wait while we complete your payment verification.</p>
        <div class="status" id="status">Redirecting to success page...</div>
    </div>

    <script>
        // JavaScript redirect to avoid about:blank#blocked issues
        document.addEventListener('DOMContentLoaded', function() {
            const statusEl = document.getElementById('status');
            let counter = 3;
            
            const countdown = setInterval(function() {
                counter--;
                statusEl.textContent = `Redirecting to success page in ${counter} seconds...`;
                
                if (counter <= 0) {
                    clearInterval(countdown);
                    statusEl.textContent = 'Redirecting now...';
                    
                    // Use window.location.href for reliable redirect
                    window.location.href = "{{ $success_url }}";
                }
            }, 1000);
            
            // Also try immediate redirect after a short delay
            setTimeout(function() {
                window.location.href = "{{ $success_url }}";
            }, 1000);
        });
    </script>
</body>
</html>