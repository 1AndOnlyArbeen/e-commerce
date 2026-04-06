/* ══ My Orders Modal ══ */

function openOrdersModal() {
    renderOrdersList(ordersData);
    showOrdersListView();
    document.getElementById('ordersModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeOrdersModal() {
    document.getElementById('ordersModal').classList.remove('open');
    document.body.style.overflow = '';
}

function handleOrdersBackdropClick(e) {
    if (e.target === document.getElementById('ordersModal')) closeOrdersModal();
}

function showOrdersListView() {
    document.getElementById('ordersListView').classList.remove('hidden');
    document.getElementById('orderDetailView').classList.add('hidden');
}

function backToOrdersList() {
    showOrdersListView();
}

function renderOrdersList(list) {
    const body  = document.getElementById('ordersListBody');
    const empty = document.getElementById('ordersEmptyState');
    if (list.length === 0) {
        body.innerHTML = '';
        body.classList.add('hidden');
        empty.classList.remove('hidden');
        return;
    }
    body.classList.remove('hidden');
    empty.classList.add('hidden');
    body.innerHTML = list.map(order => {
        const sm         = statusMeta[order.status] || statusMeta.pending;
        const itemsCount = order.items.reduce((s, i) => s + i.qty, 0);
        const firstItem  = order.items[0];
        const moreCount  = order.items.length - 1;
        return `
<div class="order-row" onclick="openOrderDetail(${order.id})">
    <div class="w-[52px] h-[52px] rounded-xl bg-[#f0faf4] shrink-0 flex items-center justify-center overflow-hidden">
        ${firstItem.image ? `<img src="${firstItem.image}" class="w-full h-full object-cover">` : `<div class="text-2xl opacity-30">🛒</div>`}
    </div>
    <div class="flex-1 min-w-0">
        <div class="flex items-center gap-2 mb-0.5">
            <span class="font-extrabold text-sm text-gray-900">${order.order_number}</span>
            <span class="status-pill ${sm.cls}">${sm.icon} ${sm.label}</span>
        </div>
        <div class="text-xs text-gray-400 font-semibold">
            ${formatOrderDate(order.placed_at)} · ${itemsCount} item${itemsCount !== 1 ? 's' : ''}
            · ${firstItem.name}${moreCount > 0 ? ` +${moreCount} more` : ''}
        </div>
    </div>
    <div class="text-right shrink-0">
        <div class="font-extrabold text-base text-gray-900">RS ${order.total.toFixed(2)}</div>
        <div class="text-xs text-gray-400 font-semibold">${payMeta[order.payment_method]?.icon} ${payMeta[order.payment_method]?.label}</div>
    </div>
    <div class="text-gray-300 text-lg shrink-0">›</div>
</div>`;
    }).join('');
}

function filterOrders(status, btn) {
    document.querySelectorAll('.orders-tab-btn').forEach(b => {
        b.classList.remove('bg-[#0c7a3e]', 'text-white');
        b.classList.add('bg-gray-100', 'text-gray-500');
    });
    btn.classList.remove('bg-gray-100', 'text-gray-500');
    btn.classList.add('bg-[#0c7a3e]', 'text-white');
    const filtered = status === 'all' ? ordersData : ordersData.filter(o => o.status === status);
    renderOrdersList(filtered);
}

function openOrderDetail(id) {
    const order = ordersData.find(o => o.id === id);
    if (!order) return;
    currentOrderId = id;
    const sm = statusMeta[order.status] || statusMeta.pending;

    document.getElementById('detailOrderNumber').textContent = order.order_number;
    document.getElementById('detailOrderDate').textContent   = 'Placed on ' + formatOrderDate(order.placed_at);
    const pill = document.getElementById('detailStatusPill');
    pill.textContent = sm.icon + ' ' + sm.label;
    pill.className   = 'status-pill ' + sm.cls;

    document.getElementById('detailItemsList').innerHTML = order.items.map(item => `
<div class="flex items-center gap-3">
    <div class="w-10 h-10 rounded-lg bg-[#f0faf4] shrink-0 flex items-center justify-center overflow-hidden">
        ${item.image ? `<img src="${item.image}" class="w-full h-full object-cover">` : `<div class="text-lg opacity-25">🛒</div>`}
    </div>
    <div class="flex-1 min-w-0">
        <div class="font-bold text-sm text-gray-900 truncate">${item.name}</div>
        <div class="text-xs text-gray-400 font-semibold">${item.unit} × ${item.qty}</div>
    </div>
    <div class="font-extrabold text-sm text-gray-800 shrink-0">RS ${(item.price * item.qty).toFixed(2)}</div>
</div>`).join('');

    document.getElementById('detailSubtotal').textContent = 'RS ' + order.subtotal.toFixed(2);
    document.getElementById('detailTotal').textContent    = 'RS ' + order.total.toFixed(2);

    const pm = payMeta[order.payment_method] || payMeta.cod;
    document.getElementById('detailPayIcon').textContent  = pm.icon;
    document.getElementById('detailPayLabel').textContent = pm.label;
    const payStatusEl = document.getElementById('detailPayStatus');
    payStatusEl.textContent = order.payment_status === 'paid' ? '✅ Paid' : '⏳ Pending';
    payStatusEl.className   = 'status-pill ' + (order.payment_status === 'paid' ? 'status-delivered' : 'status-pending');

    const a = order.address;
    document.getElementById('detailAddrName').textContent = a.name;
    document.getElementById('detailAddrBody').textContent =
        `${a.street}, ${a.city}${a.state ? ', ' + a.state : ''}${a.postal ? ' – ' + a.postal : ''}`;
    document.getElementById('detailAddrPhone').textContent = '📞 ' + a.phone;

    const noteWrap = document.getElementById('detailNoteWrap');
    if (a.note) {
        document.getElementById('detailNote').textContent = a.note;
        noteWrap.classList.remove('hidden');
    } else {
        noteWrap.classList.add('hidden');
    }

    const steps      = timelineSteps[order.status] || [true, false, false, false];
    const activeIdx  = steps.lastIndexOf(true);
    document.getElementById('detailTimeline').innerHTML = timelineLabels.map((tl, i) => {
        const done   = steps[i];
        const active = i === activeIdx && order.status !== 'cancelled';
        return `
<div class="timeline-item">
    <div class="timeline-dot ${done ? 'done' : active ? 'active' : ''}"></div>
    <div class="pl-1">
        <div class="text-sm font-extrabold ${done ? 'text-gray-900' : 'text-gray-300'}">${tl.label}</div>
        <div class="text-xs font-semibold ${done ? 'text-gray-400' : 'text-gray-200'}">${tl.sub}</div>
    </div>
</div>`;
    }).join('');

    document.getElementById('detailReorderBtn').classList.toggle('hidden', !['delivered','cancelled'].includes(order.status));
    document.getElementById('detailCancelBtn').classList.toggle('hidden',  !['pending','processing'].includes(order.status));

    document.getElementById('ordersListView').classList.add('hidden');
    document.getElementById('orderDetailView').classList.remove('hidden');
}

function reorderItems() {
    const order = ordersData.find(o => o.id === currentOrderId);
    if (!order) return;
    closeOrdersModal();
    openCart();
}

function cancelOrder() {
    if (!confirm('Are you sure you want to cancel this order?')) return;
}

function formatOrderDate(dateStr) {
    try {
        const d = new Date(dateStr);
        return d.toLocaleDateString('en-US', { day: 'numeric', month: 'short', year: 'numeric' });
    } catch (e) { return dateStr; }
}
