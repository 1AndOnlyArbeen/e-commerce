/* ══ Cart Drawer (Open / Close / Render) ══ */

function openCart() {
    document.getElementById('cartDrawer').style.right = '0';
    document.getElementById('drawerOverlay').classList.remove('hidden');
    renderCartDrawer();
}

function closeCart() {
    document.getElementById('cartDrawer').style.right = '-420px';
    document.getElementById('drawerOverlay').classList.add('hidden');
}

function renderCartDrawer() {
    const body = document.getElementById('cartBody');
    const footer = document.getElementById('cartFooter');
    const entries = Object.entries(cart);

    if (entries.length === 0) {
        body.innerHTML = `<div class="text-center py-16 px-6">
            <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
            <p class="font-semibold text-sm text-gray-400">Your cart is empty</p>
            <p class="text-xs text-gray-300 mt-1">Add items to get started</p>
        </div>`;
        footer.innerHTML = '';
        return;
    }

    const { subtotal, total } = calcCartTotals();

    body.innerHTML = entries.map(([id, qty]) => {
        const p = getProduct(id);
        if (!p) return '';
        const lineTotal = (parseFloat(p.price) * qty).toFixed(2);
        return `
<div class="flex items-center gap-3 px-5 py-3 border-b" style="border-color: var(--border-light);">
    <div class="w-11 h-11 rounded-lg bg-gray-50 shrink-0 overflow-hidden flex items-center justify-center">
        ${cartThumbHtml(p)}
    </div>
    <div class="flex-1 min-w-0">
        <div class="font-semibold text-[13px] truncate">${p.name}</div>
        <div class="text-gray-400 text-[11px] mt-0.5">${p.unit} · RS ${parseFloat(p.price).toFixed(2)}</div>
    </div>
    <div class="flex items-center gap-1">
        <button class="bg-gray-100 hover:bg-gray-200 border-none rounded-md w-6 h-6 text-sm cursor-pointer font-bold transition-colors flex items-center justify-center"
            onclick="cartRemove(${p.product_id ?? p.id})">−</button>
        <span class="font-bold text-[13px] min-w-[20px] text-center" style="font-variant-numeric: tabular-nums;">${qty}</span>
        <button class="bg-[#0c7a3e] hover:bg-[#0a6633] text-white border-none rounded-md w-6 h-6 text-sm cursor-pointer font-bold transition-colors flex items-center justify-center"
            onclick="cartAdd(${p.product_id ?? p.id})">+</button>
    </div>
    <div class="font-bold text-[13px] min-w-[56px] text-right" style="font-variant-numeric: tabular-nums;">RS ${lineTotal}</div>
    <button onclick="cartDelete(${p.product_id ?? p.id})" title="Remove"
        class="ml-0.5 text-gray-300 hover:text-red-400 bg-transparent border-none cursor-pointer transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
    </button>
</div>`;
    }).join('');

    footer.innerHTML = `
<div class="flex justify-between mb-1"><span class="text-gray-400 text-[13px] font-medium">Subtotal</span><span class="font-semibold text-[13px]">RS ${subtotal.toFixed(2)}</span></div>
<div class="flex justify-between mb-1"><span class="text-gray-400 text-[13px] font-medium">Delivery</span><span class="font-semibold text-[13px] text-[#0c7a3e]">Free</span></div>
<hr class="border-t my-3" style="border-color: var(--border-light);">
<div class="flex justify-between mb-4"><span class="font-bold text-base">Total</span><span class="font-bold text-base">RS ${total.toFixed(2)}</span></div>
<button onclick="openCheckout()" class="bg-[#0c7a3e] hover:bg-[#0a6633] text-white border-none rounded-xl py-3 px-6 w-full text-[14px] font-bold cursor-pointer transition-colors">Checkout</button>`;
}

function cartAdd(id) {
    addToCart(id);
    renderCartDrawer();
}

function cartRemove(id) {
    removeFromCart(id);
    renderCartDrawer();
}

async function cartDelete(id) {
    delete cart[id];
    delete cartProducts[id];
    updateCartUI();
    refreshAction(id);
    renderCartDrawer();

    if (!isAuth) {
        saveLocalCart(cart);
        return;
    }

    await fetch('/cart/remove', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({ product_id: id, quantity: 0 })
    });
}
