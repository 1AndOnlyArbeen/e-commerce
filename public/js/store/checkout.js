/* ══ Checkout Modal & Steps ══ */

function buildSummaryHtml() {
    return Object.entries(cart).map(([id, qty]) => {
        const p = getProduct(id);
        if (!p) return '';
        const lineTotal = (parseFloat(p.price) * qty).toFixed(2);
        return `
<div class="flex items-center justify-between text-xs text-gray-600 font-semibold gap-2">
    <span class="truncate flex-1">${p.name}</span>
    <span class="text-gray-400 shrink-0">× ${qty}</span>
    <span class="font-extrabold text-gray-800 shrink-0 min-w-[70px] text-right">RS ${lineTotal}</span>
</div>`;
    }).join('');
}

function populateCheckoutSummary() {
    const { subtotal, total } = calcCartTotals();
    const html = buildSummaryHtml();

    document.getElementById('checkoutSummaryItems').innerHTML = html;
    document.getElementById('checkoutTotal').textContent = `RS ${total.toFixed(2)}`;

    document.getElementById('confirmItems').innerHTML = html;
    document.getElementById('confirm_sub').textContent = `RS ${subtotal.toFixed(2)}`;
    document.getElementById('confirm_total').textContent = `RS ${total.toFixed(2)}`;
}

async function openCheckout() {
    if (!isAuth) {
        window.location.href = '/login';
        return;
    }
    closeCart();
    populateCheckoutSummary();
    goToStep(1, false);
    document.getElementById('checkoutModal').classList.add('open');
    document.body.style.overflow = 'hidden';

    await prefillLastAddress();
}

function closeCheckout() {
    document.getElementById('checkoutModal').classList.remove('open');
    document.body.style.overflow = '';
}

function handleCheckoutBackdropClick(e) {
    if (e.target === document.getElementById('checkoutModal')) closeCheckout();
}

async function prefillLastAddress() {
    try {
        const res = await fetch('/checkout/last-address');
        const data = await res.json();

        if (!data.found) return;

        const a = data.address;
        document.getElementById('addr_name').value = a.firstName || '';
        document.getElementById('addr_last_name').value = a.last_name || '';
        document.getElementById('addr_phone').value = a.phone_number || '';
        document.getElementById('addr_street').value = a.street_address || '';
        document.getElementById('addr_district').value = a.state || '';
        document.getElementById('addr_postal').value = a.zip_code || '';
        document.getElementById('addr_note').value = a.description || '';

        const citySelect = document.getElementById('addr_city');
        if (a.city) {
            for (let i = 0; i < citySelect.options.length; i++) {
                if (citySelect.options[i].value === a.city || citySelect.options[i].text === a.city) {
                    citySelect.selectedIndex = i;
                    break;
                }
            }
        }

        document.getElementById('addrPrefillBanner').classList.add('show');
    } catch (e) {
        // Silently fail — form stays empty
    }
}

async function goToStep(step, validate = true) {
    if (validate && step > currentCheckoutStep) {

        /* Step 1 → 2: save address */
        if (currentCheckoutStep === 1 && step === 2) {
            const firstName = document.getElementById('addr_name').value.trim();
            const phone = document.getElementById('addr_phone').value.trim();
            const street = document.getElementById('addr_street').value.trim();

            if (!firstName || !phone || !street) {
                alert('Please fill in First Name, Phone and Street Address.');
                return;
            }

            const btn = document.getElementById('continueToPaymentBtn');
            btn.textContent = '⏳ Saving...';
            btn.disabled = true;

            try {
                const res = await fetch('/checkout/address', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({
                        firstName: firstName,
                        last_name: document.getElementById('addr_last_name').value.trim(),
                        phone_number: phone,
                        street_address: street,
                        city: document.getElementById('addr_city').value,
                        state: document.getElementById('addr_district').value.trim(),
                        zip_code: document.getElementById('addr_postal').value.trim(),
                        description: document.getElementById('addr_note').value.trim(),
                    }),
                });
                const data = await res.json();

                if (!data.success) {
                    alert(data.message || 'Could not save address. Please try again.');
                    btn.textContent = 'Continue to Payment →';
                    btn.disabled = false;
                    return;
                }
            } catch (e) {
                alert('Network error. Please try again.');
                btn.textContent = 'Continue to Payment →';
                btn.disabled = false;
                return;
            }

            btn.textContent = 'Continue to Payment →';
            btn.disabled = false;
        }

        /* Step 2 → 3: save payment method */
        if (currentCheckoutStep === 2 && step === 3) {
            const btn = document.getElementById('continueToReviewBtn');
            btn.textContent = '⏳ Saving...';
            btn.disabled = true;

            try {
                const res = await fetch('/checkout/payment', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ payment_method: selectedPayMethod }),
                });
                const data = await res.json();

                if (!data.success) {
                    alert(data.message || 'Could not save payment method.');
                    btn.textContent = 'Review Order →';
                    btn.disabled = false;
                    return;
                }
            } catch (e) {
                alert('Network error. Please try again.');
                btn.textContent = 'Review Order →';
                btn.disabled = false;
                return;
            }

            btn.textContent = 'Review Order →';
            btn.disabled = false;
        }
    }

    /* Move to target step */
    currentCheckoutStep = step;

    [1, 2, 3, 4].forEach(s => {
        const el = document.getElementById('checkStep' + s);
        if (el) el.classList.toggle('hidden', s !== step);
    });

    for (let i = 1; i <= 3; i++) {
        const dot = document.getElementById('step' + i + 'dot');
        dot.classList.remove('active', 'done');
        if (i < step) dot.classList.add('done');
        else if (i === step) dot.classList.add('active');
    }
    for (let i = 1; i <= 2; i++) {
        document.getElementById('line' + i).classList.toggle('done', i < step);
    }

    /* Populate confirm step */
    if (step === 3) {
        const firstName = document.getElementById('addr_name').value;
        const lastName = document.getElementById('addr_last_name').value;
        const phone = document.getElementById('addr_phone').value;
        const street = document.getElementById('addr_street').value;
        const city = document.getElementById('addr_city').value;
        const district = document.getElementById('addr_district').value;
        const postal = document.getElementById('addr_postal').value;
        const note = document.getElementById('addr_note').value;

        document.getElementById('confirmAddress').innerHTML =
            `<strong>${firstName} ${lastName}</strong> · ${phone}<br>` +
            `${street}, ${city}` +
            `${district ? ', ' + district : ''}` +
            `${postal ? ' - ' + postal : ''}` +
            `${note ? '<br><em class="text-gray-400">' + note + '</em>' : ''}`;

        const payLabels = {
            cod: '💵 Cash on Delivery',
            esewa: '📱 eSewa',
            khalti: '🟣 Khalti',
            bank: '🏦 Bank Transfer'
        };
        document.getElementById('confirmPayment').textContent = payLabels[selectedPayMethod] || '';

        populateCheckoutSummary();
    }
}

function selectPayment(el, method) {
    selectedPayMethod = method;
    document.querySelectorAll('.pay-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    ['cod', 'esewa', 'khalti', 'bank'].forEach(m => {
        const note = document.getElementById('pay_note_' + m);
        if (note) note.classList.toggle('hidden', m !== method);
    });
}

async function placeOrder() {
    const btn = document.getElementById('placeOrderBtn');
    btn.innerHTML = 'Placing Order...';
    btn.disabled = true;

    try {
        const res = await fetch('/checkout/place', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({}),
        });
        const data = await res.json();

        if (!data.success) {
            alert(data.message || 'Could not place order. Please try again.');
            btn.innerHTML = 'Place Order';
            btn.disabled = false;
            return;
        }

        // If Khalti selected → initiate payment instead of going to success
        if (selectedPayMethod === 'khalti') {
            await initiateKhaltiPayment(data.order_id);
            return;
        }

        // COD and others → go directly to success
        document.getElementById('orderNumber').textContent = 'Order #' + data.order_number;
        goToStep(4, false);

        cart = {};
        cartProducts = {};
        saveLocalCart({});
        updateCartUI();
        renderProducts(products);

    } catch (e) {
        alert('Network error. Please try again.');
        btn.innerHTML = 'Place Order';
        btn.disabled = false;
    }
}
