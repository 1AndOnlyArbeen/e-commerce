/* ══ Product Detail Modal ══ */

function openProductModal(p) {
    modalProduct = p;
    modalQtyVal = cart[p.id] || 1;

    const img = document.getElementById('modalImg');
    const placeholder = document.getElementById('modalImgPlaceholder');
    if (p.image) {
        img.src = p.image;
        img.classList.remove('hidden');
        placeholder.classList.add('hidden');
    } else {
        img.classList.add('hidden');
        placeholder.classList.remove('hidden');
    }

    document.getElementById('thumbStrip').innerHTML = p.image
        ? `<div class="thumb active"><img src="${p.image}" alt=""></div>`
        : '';

    document.getElementById('modalBreadCat').textContent = p.category || '';
    document.getElementById('modalBreadName').textContent = p.name;

    const tagEl = document.getElementById('modalTag');
    if (p.tag && tagMeta[p.tag]) {
        tagEl.textContent = p.tag;
        tagEl.style.background = tagMeta[p.tag].bg;
        tagEl.style.color = tagMeta[p.tag].color;
        tagEl.classList.remove('hidden');
    } else {
        tagEl.classList.add('hidden');
    }

    document.getElementById('modalCategory').textContent = '📦  ' + (p.category || '');
    document.getElementById('modalName').textContent = p.name;
    document.getElementById('modalUnit').textContent = p.unit;
    document.getElementById('modalPrice').textContent = `RS ${parseFloat(p.price).toFixed(2)}`;
    document.getElementById('modalPricePerUnit').textContent = `per ${p.unit}`;
    document.getElementById('modalUnitSmall').textContent = p.unit;

    const stockEl = document.getElementById('modalStock');
    const qty = p.stock_quantity ?? null;
    if (qty !== null) {
        const color = qty === 0 ? 'bg-red-100 text-red-600'
            : qty < 10 ? 'bg-orange-100 text-orange-600'
            : 'bg-green-100 text-green-700';
        const label = qty === 0 ? '❌ Out of Stock'
            : qty < 10 ? `⚠️ Only ${qty} left`
            : `✅ In Stock (${qty} available)`;
        stockEl.innerHTML = `<span class="text-xs font-extrabold px-3 py-1 rounded-full ${color}">${label}</span>`;
    } else {
        stockEl.innerHTML = `<span class="text-xs font-extrabold px-3 py-1 rounded-full bg-green-100 text-green-700">✅ In Stock</span>`;
    }

    const descWrap = document.getElementById('modalDescWrap');
    if (p.description) {
        document.getElementById('modalDesc').textContent = p.description;
        descWrap.classList.remove('hidden');
    } else {
        descWrap.classList.add('hidden');
    }

    updateModalQtyDisplay();
    document.getElementById('productModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeProductModal() {
    document.getElementById('productModal').classList.remove('open');
    document.body.style.overflow = '';
    modalProduct = null;
}

function handleModalBackdropClick(e) {
    if (e.target === document.getElementById('productModal')) closeProductModal();
}

function modalIncreaseQty() {
    const max = modalProduct?.stock_quantity ?? 999;
    if (modalQtyVal < max) {
        modalQtyVal++;
        updateModalQtyDisplay();
    }
}

function modalDecreaseQty() {
    if (modalQtyVal > 1) {
        modalQtyVal--;
        updateModalQtyDisplay();
    }
}

function updateModalQtyDisplay() {
    document.getElementById('modalQty').textContent = modalQtyVal;
    const total = (parseFloat(modalProduct?.price || 0) * modalQtyVal).toFixed(2);
    document.getElementById('modalTotalPrice').textContent = total;
}

function modalAddToCart() {
    if (!modalProduct) return;
    addToCart(modalProduct.id, modalQtyVal);
    const btn = document.getElementById('modalAddBtn');
    btn.textContent = '✅ Added to Cart!';
    btn.style.background = '#0a6633';
    setTimeout(() => {
        btn.innerHTML = `🛒 Add to Cart — RS <span id="modalTotalPrice">${(parseFloat(modalProduct.price) * modalQtyVal).toFixed(2)}</span>`;
    }, 1200);
}
