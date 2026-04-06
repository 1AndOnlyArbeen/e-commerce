{{-- ══ Product Detail Modal ══ --}}
<div id="productModal" class="modal-backdrop" onclick="handleModalBackdropClick(event)">
    <div class="modal-box">
        <div class="flex items-center justify-between px-6 py-3.5 border-b border-gray-100">
            <div class="modal-breadcrumb">
                Home › <span id="modalBreadCat"></span> › <span id="modalBreadName" class="text-gray-600 font-semibold"></span>
            </div>
            <button onclick="closeProductModal()"
                class="bg-gray-100 hover:bg-gray-200 border-none rounded-full w-8 h-8 text-base cursor-pointer font-[Nunito] flex items-center justify-center transition-colors">✕</button>
        </div>
        <div class="modal-body">
            <div class="thumb-strip" id="thumbStrip"></div>
            <div class="w-[280px] shrink-0 bg-[#f8fafb] modal-img-wrap flex items-center justify-center">
                <img id="modalImg" src="" alt="" class="w-full h-full object-contain max-h-[420px]" style="padding:12px;">
                <div id="modalImgPlaceholder" class="hidden w-full h-[320px] flex items-center justify-center">
                    <div class="text-7xl opacity-20">🛒</div>
                </div>
            </div>
            <div class="flex-1 flex flex-col px-7 py-5 overflow-y-auto">
                <div id="modalCategory"
                    class="inline-flex items-center gap-1.5 bg-[#e8f5ee] text-[#0c7a3e] text-[11px] font-extrabold px-3 py-1 rounded-full mb-2.5 self-start">
                </div>
                <h2 id="modalName" class="text-xl font-black text-gray-900 leading-snug mb-1.5"></h2>
                <div class="flex items-center gap-2 mb-3">
                    <span class="stars">★★★★☆</span>
                    <span class="text-xs text-gray-400 font-semibold">(42 reviews)</span>
                    <span class="text-xs text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded-full">✓ Verified</span>
                </div>
                <div class="flex items-baseline gap-3 mb-1">
                    <div id="modalPrice" class="text-3xl font-black text-gray-900"></div>
                    <div id="modalPricePerUnit" class="text-sm text-gray-400 font-semibold"></div>
                </div>
                <div id="modalTag" class="hidden tag-badge mb-3 self-start"></div>
                <div id="modalStock" class="mb-4 mt-1"></div>
                <div class="grid grid-cols-2 gap-2 mb-5 p-3.5 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="text-xs text-gray-500 font-semibold">📦 Unit</div>
                    <div id="modalUnit" class="text-xs text-gray-700 font-bold"></div>
                    <div class="text-xs text-gray-500 font-semibold">🚚 Delivery</div>
                    <div class="text-xs text-gray-700 font-bold">Within 30 minutes</div>
                    <div class="text-xs text-gray-500 font-semibold">🔄 Returns</div>
                    <div class="text-xs text-gray-700 font-bold">7-day easy return</div>
                    <div class="text-xs text-gray-500 font-semibold">✅ Freshness</div>
                    <div class="text-xs text-gray-700 font-bold">Farm fresh, daily</div>
                </div>
                <div id="modalDescWrap" class="mb-5 hidden">
                    <div class="text-xs font-black text-gray-400 tracking-widest uppercase mb-2">About this product</div>
                    <p id="modalDesc" class="text-sm text-gray-600 font-semibold leading-relaxed"></p>
                </div>
                <div class="border-t border-gray-100 mb-4"></div>
                <div class="mt-auto">
                    <div class="text-xs font-black text-gray-400 tracking-widest uppercase mb-2.5">Quantity</div>
                    <div class="flex items-center gap-4 mb-4">
                        <button class="qty-btn" onclick="modalDecreaseQty()">−</button>
                        <span id="modalQty" class="text-xl font-black text-gray-900 min-w-[32px] text-center">1</span>
                        <button class="qty-btn" onclick="modalIncreaseQty()">+</button>
                        <span class="text-sm text-gray-400 font-semibold">× <span id="modalUnitSmall"></span></span>
                    </div>
                    <button id="modalAddBtn" onclick="modalAddToCart()"
                        class="w-full bg-[#0c7a3e] hover:bg-[#0a6633] text-white border-none rounded-2xl py-3.5 text-[15px] font-extrabold cursor-pointer font-[Nunito] transition-colors flex items-center justify-center gap-2 mb-2">
                        🛒 Add to Cart — RS <span id="modalTotalPrice"></span>
                    </button>
                    <button onclick="closeProductModal()"
                        class="w-full bg-transparent border border-gray-200 hover:border-[#0c7a3e] hover:text-[#0c7a3e] rounded-2xl py-3 text-[13px] font-extrabold text-gray-400 cursor-pointer font-[Nunito] transition-colors">
                        Continue Shopping
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
