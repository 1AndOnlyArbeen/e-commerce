{{-- Navbar --}}
<nav class="bg-[#0c7a3e] px-8 h-14 flex items-center justify-between sticky top-0 z-[100]" style="box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <div class="flex items-center gap-3">
        <a href="/" class="flex items-center gap-2 no-underline">
            <div class="bg-white rounded-lg w-8 h-8 flex items-center justify-center text-lg font-black text-[#0c7a3e]">A</div>
            <div>
                <div class="text-white font-extrabold text-base leading-none tracking-tight">ArbeenStore</div>
                <div class="text-white/60 text-[10px] font-semibold">Fresh groceries, fast delivery</div>
            </div>
        </a>
    </div>

    <div class="flex-1 max-w-[460px] mx-8">
        <div class="bg-white/95 rounded-lg flex items-center px-3.5 py-2 gap-2" style="box-shadow: 0 1px 4px rgba(0,0,0,0.08);">
            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" id="searchInput" placeholder="Search products..."
                oninput="filterProducts()"
                class="border-none outline-none text-[13px] font-semibold text-gray-700 bg-transparent w-full placeholder-gray-400">
        </div>
    </div>

    <div class="flex items-center gap-2">
        @guest
            <a href="{{ route('login') }}"
                class="flex items-center gap-1.5 px-3 py-1.5 text-[13px] font-bold text-white/90 hover:text-white hover:bg-white/10 rounded-lg transition-colors">
                Log in</a>
            <a href="{{ route('showregisterUser') }}"
                class="flex items-center gap-1.5 px-3 py-1.5 text-[13px] font-bold bg-white text-[#0c7a3e] rounded-lg transition-colors hover:bg-white/90">
                Sign up</a>
            <button onclick="toggleDarkMode()" id="dmBtn"
                class="rounded-lg px-2.5 py-1.5 text-[12px] font-bold cursor-pointer flex items-center border border-white/20 bg-white/10 text-white/80 hover:text-white transition-colors">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/></svg>
            </button>
        @endguest

        @auth
            <div class="relative" id="accountWrapper">
                <button id="accountBtn" onclick="toggleAccountMenu()"
                    class="bg-white/15 border border-white/10 rounded-lg px-3 py-1.5 text-white text-[13px] font-bold cursor-pointer flex items-center gap-1.5 hover:bg-white/20 transition-colors">
                    <div class="w-5 h-5 rounded-full bg-white/25 flex items-center justify-center text-[10px] font-black">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</div>
                    {{ auth()->user()->name ?? 'Account' }}
                    <svg class="w-3 h-3 opacity-60" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                </button>
                <div id="accountMenu"
                    class="hidden absolute top-[calc(100%+8px)] right-0 bg-white rounded-xl min-w-[200px] z-[200] overflow-hidden" style="box-shadow: var(--shadow-lg); border: 1px solid var(--border-light);">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <div class="font-bold text-[13px] text-gray-800">{{ auth()->user()->name ?? 'My Account' }}</div>
                        <div class="text-[11px] text-gray-400 font-medium">{{ auth()->user()->email ?? '' }}</div>
                    </div>
                    <button onclick="openOrdersModal(); toggleAccountMenu();"
                        class="flex items-center gap-2.5 px-4 py-2.5 text-[13px] font-semibold text-gray-600 cursor-pointer hover:bg-gray-50 w-full text-left border-none bg-transparent">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        My Orders
                    </button>
                    <hr class="border-t border-gray-100 m-0">
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-2.5 px-4 py-2.5 text-[13px] font-semibold text-red-500 cursor-pointer hover:bg-red-50 w-full text-left border-none bg-transparent">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Sign out</button>
                    </form>
                    <hr class="border-t border-gray-100 m-0">
                    <button onclick="toggleDarkMode()" id="dmBtn"
                        class="flex items-center gap-2.5 px-4 py-2.5 text-[13px] font-semibold text-gray-600 cursor-pointer hover:bg-gray-50 w-full border-none bg-transparent">
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/></svg>
                        Toggle theme</button>
                </div>
            </div>
        @endauth

        <button onclick="openCart()"
            class="bg-white text-[#0c7a3e] border-none rounded-lg px-3.5 py-1.5 text-[13px] font-bold cursor-pointer flex items-center gap-2 relative hover:bg-white/95 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
            Cart
            <div id="cartBadge"
                class="cart-badge bg-red-500 text-white rounded-full w-[18px] h-[18px] text-[10px] font-bold items-center justify-center absolute -top-1 -right-1">
                0</div>
        </button>
    </div>
</nav>
