/* ══ Helper Functions ══ */

function getProduct(id) {
    return products.find(p => p.id == id) || cartProducts[id] || null;
}

function calcCartTotals() {
    let totalItems = 0;
    let subtotal = 0;

    Object.entries(cart).forEach(([id, qty]) => {
        const p = getProduct(id);
        if (!p) return;
        totalItems += qty;
        subtotal += parseFloat(p.price) * qty;
    });

    return { totalItems, subtotal, total: subtotal };
}

function cardImageHtml(p) {
    const tagHtml = p.tag && tagMeta[p.tag]
        ? `<div class="absolute top-2 left-2 tag-badge z-10" style="background:${tagMeta[p.tag].bg};color:${tagMeta[p.tag].color}">${p.tag}</div>`
        : '';
    const hasImage = p.image && p.image !== 'YOUR_IMAGE_PATH_HERE';
    const imgContent = hasImage
        ? `<img src="${p.image}" alt="${p.name}" class="w-full h-full object-cover block">`
        : placeholderHTML;
    return `<div class="product-img-wrap bg-gray-50 h-[140px] flex items-center justify-center relative overflow-hidden">${tagHtml}${imgContent}</div>`;
}

function cartThumbHtml(p) {
    return p.image
        ? `<img src="${p.image}" alt="${p.name}" class="w-full h-full object-cover">`
        : cartPlaceholderSVG;
}
