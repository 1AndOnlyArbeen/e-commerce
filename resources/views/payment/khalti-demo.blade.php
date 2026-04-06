<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Khalti Payment (Demo)</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Nunito', sans-serif;
            background: #f5f3ff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(92, 45, 145, 0.1);
            width: 400px;
            max-width: 100%;
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #5C2D91, #7B3FA0);
            padding: 24px;
            text-align: center;
            color: #fff;
        }
        .header h1 { font-size: 20px; font-weight: 800; margin-bottom: 4px; }
        .header p { font-size: 12px; opacity: 0.8; font-weight: 600; }
        .demo-badge {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            color: #fff;
            font-size: 10px;
            font-weight: 800;
            padding: 3px 10px;
            border-radius: 20px;
            margin-bottom: 12px;
            letter-spacing: 0.5px;
        }
        .body { padding: 28px 24px; }
        .amount-box {
            background: #f9f7ff;
            border: 1px solid #e8e0f5;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            margin-bottom: 24px;
        }
        .amount-label { font-size: 12px; color: #8b7aaa; font-weight: 700; margin-bottom: 4px; }
        .amount { font-size: 32px; font-weight: 800; color: #5C2D91; }
        .amount span { font-size: 16px; color: #8b7aaa; }
        .info { font-size: 13px; color: #6b7280; font-weight: 600; margin-bottom: 8px; display: flex; justify-content: space-between; }
        .info-val { color: #374151; font-weight: 700; }
        .divider { border: none; border-top: 1px solid #f0f0f0; margin: 16px 0; }
        .pin-section { margin-bottom: 24px; }
        .pin-label { font-size: 12px; font-weight: 700; color: #5C2D91; margin-bottom: 8px; }
        .pin-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e8e0f5;
            border-radius: 10px;
            font-size: 18px;
            font-family: 'Nunito', sans-serif;
            font-weight: 700;
            text-align: center;
            letter-spacing: 8px;
            outline: none;
            transition: border-color 0.2s;
        }
        .pin-input:focus { border-color: #5C2D91; }
        .pin-hint { font-size: 11px; color: #9ca3af; font-weight: 600; margin-top: 6px; text-align: center; }
        .btn-pay {
            width: 100%;
            padding: 14px;
            background: #5C2D91;
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 800;
            font-family: 'Nunito', sans-serif;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
        }
        .btn-pay:hover { background: #4a2277; }
        .btn-pay:active { transform: scale(0.98); }
        .btn-pay:disabled { background: #c4b5d9; cursor: not-allowed; }
        .success-state { display: none; text-align: center; padding: 40px 24px; }
        .success-icon { font-size: 48px; margin-bottom: 12px; }
        .success-text { font-size: 18px; font-weight: 800; color: #16a34a; margin-bottom: 4px; }
        .success-sub { font-size: 13px; color: #6b7280; font-weight: 600; }
        .footer { padding: 16px 24px; background: #faf8ff; text-align: center; border-top: 1px solid #f0ecf7; }
        .footer p { font-size: 11px; color: #9ca3af; font-weight: 600; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <div class="demo-badge">DEMO MODE</div>
            <h1>Khalti Payment</h1>
            <p>Simulated payment — no real money charged</p>
        </div>

        <div class="body" id="payForm">
            <div class="amount-box">
                <div class="amount-label">Amount to Pay</div>
                <div class="amount"><span>RS </span>{{ $amountRS }}</div>
            </div>

            <div class="info">
                <span>Merchant</span>
                <span class="info-val">ArbeenStore</span>
            </div>
            <div class="info">
                <span>Order</span>
                <span class="info-val">ARB-{{ strtoupper(substr(md5($orderId), 0, 6)) }}</span>
            </div>

            <hr class="divider">

            <div class="pin-section">
                <div class="pin-label">Enter Khalti MPIN</div>
                <input type="password" class="pin-input" id="demoPin" maxlength="4" placeholder="····" autocomplete="off">
                <div class="pin-hint">Enter any 4 digits to simulate payment</div>
            </div>

            <button class="btn-pay" id="payBtn" onclick="confirmDemoPayment()">
                Pay RS {{ $amountRS }}
            </button>
        </div>

        <div class="success-state" id="successState">
            <div class="success-icon">✅</div>
            <div class="success-text">Payment Successful!</div>
            <div class="success-sub">You can close this window now.<br>The checkout page will update automatically.</div>
        </div>

        <div class="footer">
            <p>This is a demo simulation. No real Khalti transaction is made.</p>
        </div>
    </div>

    <script>
        const pidx = '{{ $pidx }}';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        async function confirmDemoPayment() {
            const pin = document.getElementById('demoPin').value;
            if (pin.length < 4) {
                document.getElementById('demoPin').style.borderColor = '#ef4444';
                return;
            }

            const btn = document.getElementById('payBtn');
            btn.textContent = 'Processing...';
            btn.disabled = true;

            try {
                const res = await fetch('/payment/khalti/demo/confirm', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ pidx: pidx }),
                });
                const data = await res.json();

                if (data.success) {
                    document.getElementById('payForm').style.display = 'none';
                    document.getElementById('successState').style.display = 'block';
                } else {
                    btn.textContent = 'Pay RS {{ $amountRS }}';
                    btn.disabled = false;
                    alert('Payment failed. Try again.');
                }
            } catch (e) {
                btn.textContent = 'Pay RS {{ $amountRS }}';
                btn.disabled = false;
                alert('Network error.');
            }
        }

        // Allow Enter key to submit
        document.getElementById('demoPin').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') confirmDemoPayment();
        });
    </script>
</body>
</html>
