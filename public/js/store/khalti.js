/* ══ Khalti Payment Integration ══ */

let khaltiPollTimer = null;
let khaltiPidx = null;
let khaltiOrderId = null;

/**
 * Initiate Khalti payment after order is placed.
 * Shows QR code step for user to scan and pay.
 */
async function initiateKhaltiPayment(orderId) {
    const btn = document.getElementById('placeOrderBtn');

    try {
        const res = await fetch('/payment/khalti/initiate', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ order_id: orderId }),
        });
        const data = await res.json();

        if (!data.success) {
            alert(data.message || 'Could not initiate payment. Try again.');
            btn.innerHTML = 'Place Order';
            btn.disabled = false;
            return;
        }

        khaltiPidx = data.pidx;
        khaltiOrderId = orderId;

        // Show the Khalti payment step
        showKhaltiPaymentStep(data.payment_url, data.pidx);

        // Start polling for payment verification
        startKhaltiPolling();

    } catch (e) {
        alert('Network error. Please try again.');
        btn.innerHTML = 'Place Order';
        btn.disabled = false;
    }
}

/**
 * Show the Khalti QR / payment step in the checkout modal.
 */
function showKhaltiPaymentStep(paymentUrl, pidx) {
    // Hide all checkout steps
    [1, 2, 3, 4].forEach(s => {
        const el = document.getElementById('checkStep' + s);
        if (el) el.classList.add('hidden');
    });

    const khaltiStep = document.getElementById('checkStepKhalti');
    khaltiStep.classList.remove('hidden');

    // Generate QR code
    const qrContainer = document.getElementById('khaltiQrCode');
    qrContainer.innerHTML = '';

    if (typeof QRCode !== 'undefined') {
        new QRCode(qrContainer, {
            text: paymentUrl,
            width: 200,
            height: 200,
            colorDark: '#5C2D91',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.M,
        });
    } else {
        // Fallback: show link
        qrContainer.innerHTML = `<div class="text-sm text-gray-500 text-center p-4">QR library not loaded.<br>Use the button below to pay.</div>`;
    }

    // Set the payment link
    const payLink = document.getElementById('khaltiPayLink');
    payLink.href = paymentUrl;

    // Update status
    document.getElementById('khaltiStatus').textContent = 'Waiting for payment...';
    document.getElementById('khaltiStatus').className = 'text-sm font-semibold text-yellow-600';

    // Update step indicators to show we're between step 3 and 4
    for (let i = 1; i <= 3; i++) {
        const dot = document.getElementById('step' + i + 'dot');
        dot.classList.remove('active');
        dot.classList.add('done');
    }
}

/**
 * Poll the server every 3 seconds to check if Khalti payment completed.
 */
function startKhaltiPolling() {
    stopKhaltiPolling(); // clear any existing

    khaltiPollTimer = setInterval(async () => {
        if (!khaltiPidx || !khaltiOrderId) {
            stopKhaltiPolling();
            return;
        }

        try {
            const res = await fetch('/payment/khalti/verify', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ pidx: khaltiPidx, order_id: khaltiOrderId }),
            });
            const data = await res.json();

            if (data.paid) {
                stopKhaltiPolling();
                onKhaltiPaymentSuccess(data.order_number);
            }
        } catch (e) {
            // Silently continue polling
        }
    }, 3000);

    // Stop polling after 10 minutes
    setTimeout(() => {
        if (khaltiPollTimer) {
            stopKhaltiPolling();
            document.getElementById('khaltiStatus').textContent = 'Payment session expired. Please try again.';
            document.getElementById('khaltiStatus').className = 'text-sm font-semibold text-red-500';
        }
    }, 600000);
}

function stopKhaltiPolling() {
    if (khaltiPollTimer) {
        clearInterval(khaltiPollTimer);
        khaltiPollTimer = null;
    }
}

/**
 * Called when Khalti payment is verified as completed.
 */
function onKhaltiPaymentSuccess(orderNumber) {
    // Update status display
    document.getElementById('khaltiStatus').textContent = 'Payment successful!';
    document.getElementById('khaltiStatus').className = 'text-sm font-bold text-green-600';

    // Hide QR, show success after brief delay
    setTimeout(() => {
        document.getElementById('checkStepKhalti').classList.add('hidden');
        document.getElementById('orderNumber').textContent = 'Order #' + orderNumber;
        document.getElementById('checkStep4').classList.remove('hidden');

        // Clear cart
        cart = {};
        cartProducts = {};
        saveLocalCart({});
        updateCartUI();
        renderProducts(products);
    }, 1000);
}

/**
 * Cancel Khalti payment and go back.
 */
function cancelKhaltiPayment() {
    stopKhaltiPolling();
    khaltiPidx = null;
    khaltiOrderId = null;

    document.getElementById('checkStepKhalti').classList.add('hidden');
    goToStep(3, false);
}
