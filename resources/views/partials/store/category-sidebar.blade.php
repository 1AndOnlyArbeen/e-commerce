{{-- Category Sidebar --}}
<aside class="w-[210px] shrink-0 bg-white px-3 py-5 border-r sticky top-14 h-[calc(100vh-56px)] overflow-y-auto" style="border-color: var(--border-light);">
    <div class="text-[10px] font-bold text-gray-400 tracking-widest uppercase mb-2.5 px-2">Categories</div>
    <a href="{{ route('index') }}"
        class="flex items-center gap-2 w-full rounded-lg px-2.5 py-2 text-[13px] font-semibold mb-0.5 transition-colors
        {{ $category === 'All' ? 'bg-[#0c7a3e] text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
        <svg class="w-4 h-4 shrink-0 {{ $category === 'All' ? 'text-white/70' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
        All Products
    </a>
    @foreach ($categories as $cat)
        <a href="{{ route('category', $cat->name) }}"
            class="flex items-center gap-2.5 w-full rounded-lg px-2.5 py-2 text-[13px] font-medium mb-0.5 transition-colors
            {{ $category === $cat->name ? 'bg-[#0c7a3e] text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <div class="w-7 h-7 flex-shrink-0 rounded-md overflow-hidden" style="border: 1px solid var(--border-light);">
                <img src="{{ asset('storage/' . $cat->image) }}" alt="{{ $cat->name }}"
                    class="w-full h-full object-cover">
            </div>
            <span class="flex-1 truncate">{{ $cat->name }}</span>
        </a>
    @endforeach
</aside>
