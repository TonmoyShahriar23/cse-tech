<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - ABC AI</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.5; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; }
        .title { font-size: 28px; color: #764ba2; font-weight: bold; }
        .status-paid { 
            color: #10a37f; 
            font-weight: bold; 
            text-transform: uppercase; 
            border: 2px solid #10a37f; 
            padding: 5px 10px; 
            display: inline-block; 
            margin-top: 10px;
        }
        table { width: 100%; text-align: left; border-collapse: collapse; }
        table td { padding: 10px; vertical-align: top; }
        table tr.heading td { background: #f8f8f8; border-bottom: 1px solid #ddd; font-weight: bold; }
        table tr.item td { border-bottom: 1px solid #eee; }
        .total { padding-top: 20px; font-size: 18px; font-weight: bold; text-align: right; }
        .footer { margin-top: 50px; text-align: center; color: #999; font-size: 12px; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table>
            <tr>
                <td class="title">ABC-AI</td>
                <td style="text-align: right;">
                    <strong>Invoice #:</strong> {{ $tran_id }}<br>
                    <strong>Date:</strong> {{ date('F d, Y') }}<br>
                    <div class="status-paid">PAID</div>
                </td>
            </tr>
        </table>

        <table style="margin-top: 40px;">
            <tr class="heading">
                <td>Description</td>
                <td style="text-align: right;">Amount</td>
            </tr>
            <tr class="item">
                <td>AI Agent Subscription Service</td>
                <td style="text-align: right;">{{ $amount }} {{ $currency }}</td>
            </tr>
        </table>

        <div class="total">
            Total Amount Paid: {{ $amount }} {{ $currency }}
        </div>

        <div class="footer">
            Thank you for your business! <br>
            This is a computer-generated invoice and requires no signature.
        </div>
    </div>
</body>
</html>