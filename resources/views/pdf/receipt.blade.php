<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt - Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; line-height: 1.6; margin: 0; padding: 20px; }
        .header { border-bottom: 2px solid #6366f1; padding-bottom: 20px; margin-bottom: 30px; }
        .logo { font-size: 28px; font-weight: bold; color: #111; letter-spacing: 1px; }
        .logo span { color: #6366f1; }
        .receipt-info { float: right; text-align: right; font-size: 14px; color: #666; }
        .customer-info { margin-bottom: 30px; padding: 15px; background: #f9fafb; border-radius: 5px; border: 1px solid #e5e7eb; }
        .customer-info h3 { margin-top: 0; font-size: 16px; margin-bottom: 5px; color: #111; }
        .customer-info p { margin: 0; font-size: 14px; color: #444; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th { background: #f3f4f6; padding: 12px; text-align: left; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #4b5563; border-bottom: 2px solid #e5e7eb; }
        td { padding: 15px 12px; border-bottom: 1px solid #e5e7eb; vertical-align: top; }
        .game-title { font-weight: bold; font-size: 16px; color: #111; margin-bottom: 5px; }
        .game-platform { font-size: 12px; color: #6b7280; text-transform: uppercase; }
        
        .key-box { display: inline-block; background: #f8fafc; border: 1px dashed #94a3b8; padding: 8px 12px; border-radius: 4px; font-family: monospace; font-size: 16px; color: #0f172a; font-weight: bold; letter-spacing: 2px; }
        
        .totals { float: right; width: 300px; padding: 15px 0; border-top: 2px solid #111; overflow: hidden; }
        .totals-row { overflow: hidden; margin-bottom: 10px; font-size: 14px; }
        .totals-row span.label { float: left; color: #666; }
        .totals-row span.value { float: right; font-weight: bold; }
        .totals-row.grand { font-size: 20px; font-weight: bold; color: #111; margin-top: 10px; border-top: 1px solid #e5e7eb; padding-top: 10px; }
        
        .footer { clear: both; margin-top: 60px; padding-top: 20px; text-align: center; font-size: 12px; color: #9ca3af; border-top: 1px solid #f3f4f6; }
    </style>
</head>
<body>

    <div class="header">
        <div class="receipt-info">
            <strong>Receipt #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</strong><br>
            Date: {{ $order->created_at->format('M d, Y') }}
        </div>
        <div class="logo">Games<span>Shop</span></div>
    </div>

    <div class="customer-info">
        <h3>Billed To:</h3>
        <p>{{ $order->user->name }}</p>
        <p>{{ $order->user->email }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 50%;">Game Details</th>
                <th style="width: 50%;">Your Game Key</th>
            </tr>
        </thead>
        <tbody>
            @foreach($keys as $key)
            <tr>
                <td>
                    <div class="game-title">{{ $key->game->title ?? 'Game' }}</div>
                    <div class="game-platform">{{ $key->game->platform ?? 'Platform' }}</div>
                </td>
                <td>
                    <div class="key-box">{{ $key->key_code }}</div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <div class="totals-row">
            <span class="label">Total Paid:</span>
            <span class="value">${{ number_format($order->total_price, 2) }}</span>
        </div>
    </div>

    <div class="footer">
        Thank you for choosing GamesShop!<br>
        If you experience any issues redeeming your keys, please contact support.
    </div>

</body>
</html>
