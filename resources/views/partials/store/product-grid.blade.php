{{-- Product Grid --}}
<div class="flex items-center justify-between mb-4">
    <div>
        <h2 class="font-bold text-lg text-gray-800">All Products</h2>
        <p id="productCount" class="text-[13px] text-gray-400 font-medium mt-0.5"></p>
    </div>
</div>

<div id="productsGrid" class="grid gap-3.5 grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5"></div>

<div class="flex justify-center mt-6 py-3">
    {{ $products->links() }}
</div>

<div id="emptyState" class="hidden text-center py-16">
    <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
    <p class="font-semibold text-sm text-gray-400">No products found</p>
</div>
