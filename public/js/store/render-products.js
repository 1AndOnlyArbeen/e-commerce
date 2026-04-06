/* ══ Render Products Grid ══ */

function renderProducts(list) {
    const grid = document.getElementById('productsGrid');
    const empty = document.getElementById('emptyState');
    document.getElementById('productCount').textContent = `${list.length} products`;

    if (list.length === 0) {
        grid.innerHTML = '';
        empty.classList.remove('hidden');
        return;
    }
    empty.classList.add('hidden');

    grid.innerHTML = list.map(p => {
        const qty = cart[p.id] || 0;
        const actionHtml = qty === 0
            ? `<button class="bg-[#0c7a3e] hover:bg-[#0a6633] text-white border-none rounded-lg px-3.5 py-1.5 text-[12px] font-bold cursor-pointer"
                    onclick="event.stopPropagation(); addToCart(${p.id})">Add</button>`
            : `<div class="flex items-center gap-1.5 bg-[#0c7a3e] rounded-lg px-2 py-1" onclick="event.stopPropagation()">
                   <button class="bg-transparent border-none text-white text-lg cursor-pointer leading-none font-bold p-0" onclick="removeFromCart(${p.id})">−</button>
                   <span class="text-white text-[12px] font-bold min-w-[16px] text-center">${qty}</span>
                   <button class="bg-transparent border-none text-white text-lg cursor-pointer leading-none font-bold p-0" onclick="addToCart(${p.id})">+</button>
               </div>`;

        return `
<div class="product-card overflow-hidden"
     onclick="openProductModal(${JSON.stringify(p).replace(/"/g,'&quot;')})">
    ${cardImageHtml(p)}
    <div class="px-3 pt-2.5 pb-3">
        <div class="font-semibold text-[13px] text-gray-800 leading-tight mb-0.5 truncate">${p.name}</div>
        <div class="text-gray-400 text-[11px] font-medium mb-2">${p.unit}</div>
        <div class="flex items-center justify-between">
            <div class="font-bold text-[15px] text-gray-900">RS ${parseFloat(p.price).toFixed(2)}</div>
            <div id="action-${p.id}">${actionHtml}</div>
        </div>
    </div>
</div>`;
    }).join('');
}

function refreshAction(id) {
    const el = document.getElementById('action-' + id);
    if (!el) return;
    const qty = cart[id] || 0;
    el.innerHTML = qty === 0
        ? `<button class="bg-[#0c7a3e] hover:bg-[#0a6633] text-white border-none rounded-lg px-3.5 py-1.5 text-[12px] font-bold cursor-pointer"
                onclick="event.stopPropagation(); addToCart(${id})">Add</button>`
        : `<div class="flex items-center gap-1.5 bg-[#0c7a3e] rounded-lg px-2 py-1" onclick="event.stopPropagation()">
               <button class="bg-transparent border-none text-white text-lg cursor-pointer leading-none font-bold p-0" onclick="removeFromCart(${id})">−</button>
               <span class="text-white text-[12px] font-bold min-w-[16px] text-center">${qty}</span>
               <button class="bg-transparent border-none text-white text-lg cursor-pointer leading-none font-bold p-0" onclick="addToCart(${id})">+</button>
           </div>`;
}

function updateCartUI() {
    const { totalItems, total } = calcCartTotals();

    const badge = document.getElementById('cartBadge');
    badge.textContent = totalItems;
    totalItems > 0 ? badge.classList.add('visible') : badge.classList.remove('visible');

    const bar = document.getElementById('cartBottomBar');
    if (totalItems > 0) bar.classList.replace('hidden', 'flex');
    else bar.classList.replace('flex', 'hidden');

    document.getElementById('cbbItems').textContent = `${totalItems} item${totalItems !== 1 ? 's' : ''}`;
    document.getElementById('cbbPrice').textContent = `RS ${total.toFixed(2)}`;
}
