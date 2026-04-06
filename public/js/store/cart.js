/* ══ Cart Logic (Add / Remove / Load / Merge) ══ */

function getLocalCart() {
    return JSON.parse(localStorage.getItem('cart') || '{}');
}

function saveLocalCart(c) {
    localStorage.setItem('cart', JSON.stringify(c));
}

async function addToCart(productId, quantity = 1) {
    cart[productId] = (cart[productId] || 0) + quantity;
    updateCartUI();
    refreshAction(productId);

    if (!isAuth) {
        saveLocalCart(cart);
        return;
    }

    await fetch('/cart/add', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({ product_id: productId, quantity: cart[productId] })
    });
}

async function removeFromCart(id) {
    if (!cart[id]) return;
    cart[id]--;
    if (cart[id] === 0) delete cart[id];
    updateCartUI();
    refreshAction(id);

    if (!isAuth) {
        saveLocalCart(cart);
        return;
    }

    const newQty = cart[id] || 0;
    await fetch('/cart/remove', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({ product_id: id, quantity: newQty })
    });
}

async function loadCart() {
    if (!isAuth) {
        cart = getLocalCart();
        const normalized = {};
        Object.entries(cart).forEach(([k, v]) => {
            normalized[parseInt(k)] = v;
        });
        cart = normalized;
        updateCartUI();
        renderProducts(products);
        return;
    }

    try {
        const res = await fetch('/cart');
        const data = await res.json();
        cart = {};
        cartProducts = {};
        if (Array.isArray(data)) {
            data.forEach(item => {
                cart[item.product_id] = item.quantity;
                cartProducts[item.product_id] = item;
            });
        }
    } catch (e) {
        console.error('Cart load failed:', e);
    }

    updateCartUI();
    renderProducts(products);
}

async function mergeCartAfterLogin() {
    const localCart = getLocalCart();
    if (Object.keys(localCart).length === 0) return;

    const items = Object.entries(localCart).map(([product_id, quantity]) => ({
        product_id,
        quantity
    }));

    await fetch('/cart/merge', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({ cart: items })
    });

    localStorage.removeItem('cart');
    await loadCart();
}
