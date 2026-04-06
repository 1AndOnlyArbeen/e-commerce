{{-- Cart Drawer --}}
<div id="drawerOverlay" onclick="closeCart()" class="hidden fixed inset-0 bg-black/35 z-[300]" style="transition: opacity 0.3s ease;"></div>
<div id="cartDrawer"
    class="drawer fixed top-0 -right-[420px] w-[400px] h-screen bg-white z-[301] flex flex-col">
    <div class="px-5 py-3.5 border-b flex items-center justify-between" style="border-color: var(--border-light);">
        <div class="font-bold text-base">Your Cart</div>
        <button onclick="closeCart()"
            class="bg-gray-100 border-none rounded-lg w-8 h-8 text-sm cursor-pointer hover:bg-gray-200 transition-colors flex items-center justify-center">
            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
    <div id="cartBody" class="flex-1 overflow-y-auto py-1"></div>
    <div id="cartFooter" class="px-5 py-4 border-t" style="border-color: var(--border-light);"></div>
</div>

{{-- Sticky bottom bar --}}
<div id="cartBottomBar"
    class="hidden fixed bottom-0 left-[210px] right-0 bg-[#0c7a3e] px-8 py-3 items-center justify-between z-50" style="box-shadow: 0 -2px 12px rgba(12,122,62,0.15);">
    <div class="text-white">
        <div id="cbbItems" class="text-[13px] opacity-80">0 items</div>
        <div id="cbbPrice" class="text-xl font-bold" style="font-variant-numeric: tabular-nums;">RS 0</div>
    </div>
    <button onclick="openCart()"
        class="bg-white text-[#0c7a3e] border-none rounded-lg px-6 py-2.5 text-[13px] font-bold cursor-pointer hover:bg-white/90 transition-colors">View Cart</button>
</div>
