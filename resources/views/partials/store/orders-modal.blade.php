{{-- ══ My Orders Modal ══ --}}
<div id="ordersModal" onclick="handleOrdersBackdropClick(event)">

    {{-- Orders List View --}}
    <div id="ordersListView" class="orders-box">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 shrink-0">
            <div class="font-black text-xl text-gray-900">📦 My Orders</div>
            <button onclick="closeOrdersModal()"
                class="bg-gray-100 hover:bg-gray-200 border-none rounded-full w-9 h-9 text-base cursor-pointer flex items-center justify-center transition-colors">✕</button>
        </div>
        <div class="flex gap-1 px-6 py-3 border-b border-gray-100 shrink-0 overflow-x-auto">
            <button onclick="filterOrders('all',this)"
                class="orders-tab-btn bg-[#0c7a3e] text-white border-none rounded-xl px-4 py-1.5 text-xs font-extrabold cursor-pointer font-[Nunito] whitespace-nowrap">All</button>
            <button onclick="filterOrders('processing',this)"
                class="orders-tab-btn bg-gray-100 text-gray-500 border-none rounded-xl px-4 py-1.5 text-xs font-extrabold cursor-pointer font-[Nunito] whitespace-nowrap">Processing</button>
            <button onclick="filterOrders('transit',this)"
                class="orders-tab-btn bg-gray-100 text-gray-500 border-none rounded-xl px-4 py-1.5 text-xs font-extrabold cursor-pointer font-[Nunito] whitespace-nowrap">In Transit</button>
            <button onclick="filterOrders('delivered',this)"
                class="orders-tab-btn bg-gray-100 text-gray-500 border-none rounded-xl px-4 py-1.5 text-xs font-extrabold cursor-pointer font-[Nunito] whitespace-nowrap">Delivered</button>
            <button onclick="filterOrders('cancelled',this)"
                class="orders-tab-btn bg-gray-100 text-gray-500 border-none rounded-xl px-4 py-1.5 text-xs font-extrabold cursor-pointer font-[Nunito] whitespace-nowrap">Cancelled</button>
        </div>
        <div id="ordersListBody" class="flex-1 overflow-y-auto"></div>
        <div id="ordersEmptyState" class="hidden flex-1 text-center py-20 text-gray-300">
            <div class="text-6xl">📦</div>
            <p class="mt-3 font-bold text-base">No orders found</p>
        </div>
    </div>

    {{-- Order Detail View --}}
    <div id="orderDetailView" class="order-detail-box hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 shrink-0">
            <div class="flex items-center gap-3">
                <button onclick="backToOrdersList()"
                    class="bg-gray-100 hover:bg-gray-200 border-none rounded-xl w-9 h-9 text-base cursor-pointer flex items-center justify-center transition-colors">←</button>
                <div>
                    <div class="font-black text-base text-gray-900" id="detailOrderNumber">Order #</div>
                    <div class="text-xs text-gray-400 font-semibold" id="detailOrderDate"></div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div id="detailStatusPill" class="status-pill"></div>
                <button onclick="closeOrdersModal()"
                    class="bg-gray-100 hover:bg-gray-200 border-none rounded-full w-9 h-9 text-base cursor-pointer flex items-center justify-center transition-colors">✕</button>
            </div>
        </div>
        <div class="flex-1 overflow-y-auto">
            <div class="grid grid-cols-2 divide-x divide-gray-100">
                <div class="px-6 py-5">
                    <div class="text-xs font-black text-gray-400 uppercase tracking-wider mb-3">Items Ordered</div>
                    <div id="detailItemsList" class="space-y-3 mb-5 max-h-[260px] overflow-y-auto pr-1"></div>
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 mb-4">
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between text-gray-500 font-semibold">
                                <span>Subtotal</span><span id="detailSubtotal">RS 0.00</span>
                            </div>
                            <div class="flex justify-between text-gray-500 font-semibold">
                                <span>Delivery</span><span class="text-[#0c7a3e] font-bold">FREE</span>
                            </div>
                            <div class="flex justify-between font-extrabold text-gray-900 text-base border-t border-gray-200 pt-2 mt-1">
                                <span>Total</span><span id="detailTotal">RS 0.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-3.5 rounded-xl border border-gray-100 bg-gray-50 flex items-center gap-3">
                        <div class="text-xl" id="detailPayIcon">💵</div>
                        <div>
                            <div class="text-xs text-gray-400 font-semibold">Payment Method</div>
                            <div class="text-sm font-extrabold text-gray-800" id="detailPayLabel"></div>
                        </div>
                        <div class="ml-auto">
                            <span id="detailPayStatus" class="status-pill"></span>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-5">
                    <div class="text-xs font-black text-gray-400 uppercase tracking-wider mb-3">Delivery Address</div>
                    <div class="p-3.5 rounded-xl border border-gray-100 bg-gray-50 mb-5">
                        <div class="font-extrabold text-sm text-gray-800 mb-1" id="detailAddrName"></div>
                        <div class="text-xs text-gray-500 font-semibold leading-relaxed" id="detailAddrBody"></div>
                        <div class="text-xs text-gray-400 font-semibold mt-1.5" id="detailAddrPhone"></div>
                    </div>
                    <div class="text-xs font-black text-gray-400 uppercase tracking-wider mb-4">Order Progress</div>
                    <div class="timeline" id="detailTimeline"></div>
                    <div id="detailNoteWrap" class="hidden mt-5 p-3.5 rounded-xl border border-yellow-100 bg-yellow-50">
                        <div class="text-xs font-black text-yellow-600 uppercase tracking-wider mb-1">📝 Delivery Note</div>
                        <div class="text-xs text-yellow-700 font-semibold" id="detailNote"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 flex gap-3 shrink-0">
            <button id="detailReorderBtn" onclick="reorderItems()"
                class="flex-1 bg-[#0c7a3e] hover:bg-[#0a6633] text-white border-none rounded-xl py-3 text-sm font-extrabold cursor-pointer font-[Nunito] transition-colors">
                🔄 Reorder Items
            </button>
            <button id="detailCancelBtn" onclick="cancelOrder()"
                class="hidden flex-1 border border-red-200 text-red-500 hover:bg-red-50 bg-transparent rounded-xl py-3 text-sm font-extrabold cursor-pointer font-[Nunito] transition-colors">
                ✕ Cancel Order
            </button>
            <button onclick="window.print()"
                class="border border-gray-200 text-gray-400 hover:border-gray-300 bg-transparent rounded-xl px-4 py-3 text-sm font-extrabold cursor-pointer font-[Nunito] transition-colors">
                🖨️
            </button>
        </div>
    </div>
</div>
