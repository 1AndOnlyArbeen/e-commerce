<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArbeenStore</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        nunito: ['Nunito', 'sans-serif']
                    },
                    colors: {
                        green: {
                            brand: '#0c7a3e',
                            dark: '#0a6633',
                            light: '#1aad5e',
                            pale: '#f0faf4',
                            muted: '#a8e6c1'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        .cart-badge {
            display: none;
        }

        .cart-badge.visible {
            display: flex;
        }

        .drawer {
            transition: right 0.3s ease;
        }

        .product-img-wrap {
            overflow: hidden;
        }

        .product-img-wrap img {
            transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            will-change: transform;
        }

        .product-img-wrap:hover img {
            transform: scale(1.12);
        }

        .product-card {
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(12, 122, 62, 0.12);
        }

        .modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            z-index: 500;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
        }

        .modal-backdrop.open {
            display: flex;
        }

        .modal-box {
            background: #fff;
            border-radius: 20px;
            width: 820px;
            max-width: 96vw;
            max-height: 92vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            animation: modalIn 0.28s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.22);
        }

        @keyframes modalIn {
            from {
                transform: scale(0.9) translateY(16px);
                opacity: 0;
            }

            to {
                transform: scale(1) translateY(0);
                opacity: 1;
            }
        }

        .modal-body {
            display: flex;
            flex: 1;
            overflow: hidden;
        }

        .modal-img-wrap {
            overflow: hidden;
        }

        .modal-img-wrap img {
            transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .modal-img-wrap:hover img {
            transform: scale(1.07);
        }

        .thumb-strip {
            display: flex;
            flex-direction: column;
            gap: 6px;
            padding: 10px 8px;
            background: #fafafa;
            border-right: 1px solid #f0f0f0;
        }

        .thumb {
            width: 52px;
            height: 52px;
            border-radius: 8px;
            border: 2px solid transparent;
            cursor: pointer;
            overflow: hidden;
            background: #f0faf4;
        }

        .thumb.active {
            border-color: #0c7a3e;
        }

        .thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .modal-breadcrumb {
            font-size: 11px;
            color: #9ca3af;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .modal-breadcrumb span {
            color: #0c7a3e;
        }

        .stars {
            color: #f59e0b;
            font-size: 14px;
        }

        .qty-btn {
            width: 34px;
            height: 34px;
            border: 2px solid #0c7a3e;
            border-radius: 10px;
            background: transparent;
            color: #0c7a3e;
            font-size: 20px;
            font-weight: 900;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s;
            font-family: 'Nunito', sans-serif;
        }

        .qty-btn:hover {
            background: #0c7a3e;
            color: #fff;
        }

        .tag-badge {
            display: inline-block;
            font-size: 10px;
            font-weight: 800;
            border-radius: 6px;
            padding: 2px 8px;
        }

        #checkoutModal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 600;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(5px);
        }

        #checkoutModal.open {
            display: flex;
        }

        .checkout-box {
            background: #fff;
            border-radius: 20px;
            width: 860px;
            max-width: 96vw;
            max-height: 93vh;
            overflow-y: auto;
            animation: modalIn 0.28s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.25);
        }

        .step-dot {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 900;
            border: 2px solid #d1d5db;
            color: #9ca3af;
            transition: all 0.2s;
        }

        .step-dot.active {
            background: #0c7a3e;
            border-color: #0c7a3e;
            color: #fff;
        }

        .step-dot.done {
            background: #e8f5ee;
            border-color: #0c7a3e;
            color: #0c7a3e;
        }

        .step-line {
            flex: 1;
            height: 2px;
            background: #e5e7eb;
            margin: 0 4px;
        }

        .step-line.done {
            background: #0c7a3e;
        }

        .pay-card {
            border: 2px solid #e5e7eb;
            border-radius: 14px;
            padding: 14px 18px;
            cursor: pointer;
            transition: all 0.15s;
            display: flex;
            flex-direction: column;
        }

        .pay-card:hover {
            border-color: #0c7a3e;
            background: #f0faf4;
        }

        .pay-card.selected {
            border-color: #0c7a3e;
            background: #f0faf4;
        }

        /* ── Prefill banner ── */
        #addrPrefillBanner {
            display: none;
            background: #f0faf4;
            border: 1.5px solid #a8e6c1;
            border-radius: 12px;
            padding: 10px 14px;
            margin-bottom: 16px;
            font-size: 13px;
            font-weight: 700;
            color: #0c7a3e;
            align-items: center;
            gap-8px;
        }

        #addrPrefillBanner.show {
            display: flex;
        }

        :root {
            --bg: #f3f4f6;
            --surface: #ffffff;
            --surface-2: #f9fafb;
            --border: #e5e7eb;
            --text-primary: #111827;
            --text-secondary: #6b7280;
            --text-muted: #9ca3af;
            --input-bg: #ffffff;
            --input-text: #374151;
        }

        [data-theme="dark"] {
            --bg: #1c2333;
            --surface: #263044;
            --surface-2: #202a3c;
            --border: #3a4a60;
            --text-primary: #f0f4ff;
            --text-secondary: #a0aec0;
            --text-muted: #6b7a99;
            --input-bg: #263044;
            --input-text: #e8edf8;
        }

        [data-theme="dark"] body {
            background: var(--bg);
        }

        [data-theme="dark"] .text-gray-900 {
            color: var(--text-primary) !important;
        }

        [data-theme="dark"] .text-gray-700 {
            color: var(--text-primary) !important;
        }

        [data-theme="dark"] .text-gray-600 {
            color: var(--text-secondary) !important;
        }

        [data-theme="dark"] .text-gray-500 {
            color: var(--text-secondary) !important;
        }

        [data-theme="dark"] .text-gray-400 {
            color: var(--text-muted) !important;
        }

        [data-theme="dark"] .bg-white {
            background: var(--surface) !important;
        }

        [data-theme="dark"] .bg-gray-100 {
            background: var(--surface-2) !important;
        }

        [data-theme="dark"] .bg-gray-50 {
            background: var(--surface-2) !important;
        }

        [data-theme="dark"] .border-gray-100,
        [data-theme="dark"] .border-gray-200 {
            border-color: var(--border) !important;
        }

        [data-theme="dark"] aside {
            background: var(--surface);
            border-color: var(--border);
        }

        [data-theme="dark"] .product-card {
            background: var(--surface);
        }

        [data-theme="dark"] .product-img-wrap {
            background: var(--surface-2);
        }

        [data-theme="dark"] .modal-box {
            background: var(--surface);
            color: var(--text-primary);
        }

        [data-theme="dark"] .modal-img-wrap {
            background: var(--surface-2);
        }

        [data-theme="dark"] .thumb-strip {
            background: var(--surface-2);
            border-color: var(--border);
        }

        [data-theme="dark"] #cartDrawer {
            background: var(--surface);
            color: var(--text-primary);
        }

        [data-theme="dark"] #accountMenu {
            background: var(--surface);
        }

        [data-theme="dark"] .checkout-box {
            background: var(--surface);
            color: var(--text-primary);
        }

        [data-theme="dark"] nav .bg-white {
            background: var(--input-bg) !important;
            box-shadow: none;
        }

        [data-theme="dark"] nav input {
            color: var(--input-text);
        }

        [data-theme="dark"] .pay-card {
            border-color: var(--border);
        }

        [data-theme="dark"] .pay-card:hover,
        [data-theme="dark"] .pay-card.selected {
            background: rgba(12, 122, 62, 0.15);
            border-color: #0c7a3e;
        }

        [data-theme="dark"] #addrPrefillBanner {
            background: rgba(12, 122, 62, 0.15);
            border-color: #0c7a3e;
        }


        /* ── Order Details shown */

        #ordersModal {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,0.55); z-index: 600;
    align-items: center; justify-content: center;
    backdrop-filter: blur(4px);
}
#ordersModal.open { display: flex; }

.orders-box {
    background: #fff; border-radius: 20px;
    width: 780px; max-width: 96vw; max-height: 90vh;
    overflow: hidden; display: flex; flex-direction: column;
    animation: modalIn 0.28s cubic-bezier(0.34, 1.56, 0.64, 1);
    box-shadow: 0 40px 80px rgba(0,0,0,0.22);
}
.order-row {
    display: flex; align-items: center;
    padding: 16px 24px; border-bottom: 1px solid #f3f4f6;
    cursor: pointer; transition: background 0.15s; gap: 16px;
}
.order-row:hover { background: #f9fafb; }
.order-row:last-child { border-bottom: none; }

.status-pill {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 11px; font-weight: 800; border-radius: 8px;
    padding: 3px 10px; white-space: nowrap;
}
.status-delivered  { background: #e8f5ee; color: #0c7a3e; }
.status-transit    { background: #fff3e0; color: #e65100; }
.status-processing { background: #e3f2fd; color: #0d47a1; }
.status-cancelled  { background: #fce4ec; color: #880e4f; }
.status-pending    { background: #f3e5f5; color: #6a1b9a; }

.order-detail-box {
    background: #fff; border-radius: 20px;
    width: 820px; max-width: 96vw; max-height: 92vh;
    overflow: hidden; display: flex; flex-direction: column;
    animation: modalIn 0.28s cubic-bezier(0.34, 1.56, 0.64, 1);
    box-shadow: 0 40px 80px rgba(0,0,0,0.22);
}
.timeline { position: relative; padding-left: 28px; }
.timeline::before {
    content: ''; position: absolute; left: 9px; top: 6px; bottom: 6px;
    width: 2px; background: #e5e7eb; border-radius: 2px;
}
.timeline-item { position: relative; margin-bottom: 20px; }
.timeline-item:last-child { margin-bottom: 0; }
.timeline-dot {
    position: absolute; left: -23px; top: 3px;
    width: 14px; height: 14px; border-radius: 50%;
    border: 2px solid #e5e7eb; background: #fff;
}
.timeline-dot.done   { background: #0c7a3e; border-color: #0c7a3e; }
.timeline-dot.active { background: #fff; border-color: #0c7a3e; box-shadow: 0 0 0 3px rgba(12,122,62,0.15); }

[data-theme="dark"] .orders-box,
[data-theme="dark"] .order-detail-box { background: var(--surface); color: var(--text-primary); }
[data-theme="dark"] .order-row        { border-color: var(--border); }
[data-theme="dark"] .order-row:hover  { background: var(--surface-2); }


        /* ── Order Details end  */

        
    </style>
    <!-- in <head> -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-100 min-h-screen font-nunito">

    <!-- ══ NAVBAR ══ -->
    <nav class="bg-[#0c7a3e] px-10 h-16 flex items-center justify-between sticky top-0 z-[100] shadow-lg">
        <div class="flex items-center gap-4">
            <a href="/" class="flex items-center gap-2.5 no-underline">
                <div class="bg-white rounded-xl w-10 h-10 flex items-center justify-center text-2xl">🌿</div>
                <div>
                    <div class="text-white font-black text-xl leading-none">Arbeen</div>
                    <div class="text-[#a8e6c1] text-[11px] font-semibold">Store</div>
                </div>
            </a>
            <div
                class="bg-white/15 rounded-full px-3.5 py-1.5 flex items-center gap-1.5 text-white text-[13px] font-bold">
                Welcome to Arbeen Store &nbsp;·&nbsp; 📍 Head Office Kathmandu, NP
            </div>
        </div>

        <div class="flex-1 max-w-[500px] mx-10">
            <div class="bg-white rounded-xl flex items-center px-4 py-2.5 gap-2.5 shadow-md">
                <span class="text-lg">🔍</span>
                <input type="text" id="searchInput" placeholder="Search for groceries, vegetables, snacks..."
                    oninput="filterProducts()"
                    class="border-none outline-none text-sm font-[Nunito] text-gray-700 bg-transparent w-full placeholder-gray-400">
            </div>
        </div>

        <div class="flex items-center gap-3">
            <div class="relative" id="accountWrapper">
                @guest
                    <div class="flex flex-row gap-2">
                        <a href="{{ route('login') }}"
                            class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-white hover:bg-white/10 rounded-xl transition-colors">🔑
                            Login</a>
                        <a href="{{ route('showregisterUser') }}"
                            class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-white hover:bg-white/10 rounded-xl transition-colors">📝
                            Register</a>
                        <button onclick="toggleDarkMode()" id="dmBtn"
                            class="rounded-xl px-3.5 py-2 text-[13px] font-bold cursor-pointer font-nunito flex items-center gap-1.5 border border-white/20 bg-white/10 text-white">🌙</button>
                    </div>
                @endguest

                @auth
                    <button id="accountBtn" onclick="toggleAccountMenu()"
                        class="bg-white/15 border-none rounded-xl px-4 py-2 text-white text-[13px] font-bold cursor-pointer font-[Nunito] flex items-center gap-1.5">
                        👤 Account ▾
                    </button>
                    <div id="accountMenu"
                        class="hidden absolute top-[calc(100%+10px)] right-0 bg-white rounded-xl shadow-2xl min-w-[190px] z-[200] overflow-hidden">
                        <div class="px-4 py-3.5 border-b border-gray-100 font-black text-[13px] text-gray-700 bg-gray-50">
                            👤 {{ auth()->user()->name ?? 'My Account' }}
                        </div>
                        <button
                            class="flex items-center gap-2.5 px-4 py-3 text-sm font-bold text-gray-600 cursor-pointer hover:bg-gray-50 w-full text-left border-none bg-transparent font-[Nunito]">🙍
                            Profile</button>
                       <button onclick="openOrdersModal(); toggleAccountMenu();"
    class="flex items-center gap-2.5 px-4 py-3 text-sm font-bold text-gray-600 cursor-pointer hover:bg-gray-50 w-full text-left border-none bg-transparent font-[Nunito]">
    📦 My Orders
</button>


                        <hr class="border-t border-gray-100 m-0">
                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-2.5 px-4 py-3 text-sm font-bold text-red-600 cursor-pointer hover:bg-red-50 w-full text-left border-none bg-transparent font-[Nunito]">🚪
                                Logout</button>
                        </form>
                        <button onclick="toggleDarkMode()" id="dmBtn"
                            class="flex items-center gap-2.5 px-4 py-3 text-sm font-bold text-gray-600 cursor-pointer hover:bg-gray-50 w-full border-none bg-transparent font-[Nunito]">🌙
                            Toggle Dark Mode</button>
                    </div>
                @endauth
            </div>

            <button onclick="openCart()"
                class="bg-white text-[#0c7a3e] border-none rounded-xl px-4 py-2 text-[13px] font-extrabold cursor-pointer font-[Nunito] flex items-center gap-2 relative">
                🛒 Cart
                <div id="cartBadge"
                    class="cart-badge bg-red-500 text-white rounded-full w-5 h-5 text-[11px] font-extrabold items-center justify-center">
                    0</div>
            </button>
        </div>
    </nav>

    <!-- ══ PAGE LAYOUT ══ -->
    <div class="flex min-h-[calc(100vh-64px)]">

        <!-- Category Sidebar -->
        <aside
            class="w-[220px] shrink-0 bg-white px-4 py-6 border-r border-gray-100 sticky top-16 h-[calc(100vh-64px)] overflow-y-auto">
            <div class="text-xs font-black text-gray-400 tracking-widest uppercase mb-3">Categories</div>
            <a href="{{ route('index') }}"
                class="cat-btn {{ $category === 'All' ? 'bg-[#0c7a3e] text-white' : 'bg-transparent text-gray-600 hover:bg-[#f0faf4] hover:text-[#0c7a3e]' }} flex items-center gap-2.5 w-full rounded-xl px-3 py-2.5 text-sm font-bold mb-1">
                <span class="text-lg w-6 text-center">🏪</span> All Products
            </a>
            @foreach ($categories as $cat)
                <a href="{{ route('category', $cat->name) }}"
                    class="cat-btn {{ $category === $cat->name ? 'bg-[#0c7a3e] text-white' : 'bg-transparent text-gray-600 hover:bg-[#f0faf4] hover:text-[#0c7a3e]' }} flex items-center gap-3 w-full rounded-xl px-3 py-2.5 text-sm font-semibold mb-1 transition">
                    <div class="w-9 h-9 flex-shrink-0">
                        <img src="{{ asset('storage/' . $cat->image) }}" alt="{{ $cat->name }}"
                            class="w-full h-full object-cover rounded-md border border-gray-200">
                    </div>
                    <span class="flex-1 truncate">{{ $cat->name }}</span>
                </a>
            @endforeach
        </aside>

        <!-- Main Content -->
        <main class="flex-1 px-8 pt-7 pb-28 overflow-y-auto">

            <!-- Promo Banner -->
            <div
                class="bg-gradient-to-br from-[#0c7a3e] to-[#1aad5e] rounded-2xl px-10 py-8 flex items-center justify-between mb-8 relative overflow-hidden">
                <div class="absolute -right-8 -top-8 w-44 h-44 bg-white/[0.07] rounded-full"></div>
                <div class="absolute right-24 -bottom-10 w-28 h-28 bg-white/[0.05] rounded-full"></div>
                <div class="relative z-10">
                    <div class="text-yellow-300 text-xs font-extrabold tracking-widest mb-2">🎉 LIMITED TIME OFFER
                    </div>
                    <div class="text-white text-3xl font-black leading-tight mb-4">Fresh Vegetables<br>Up to 30% Off
                    </div>
                    <button
                        class="bg-white text-[#0c7a3e] border-none rounded-xl px-6 py-2.5 text-sm font-extrabold cursor-pointer font-[Nunito]">Shop
                        Now →</button>
                </div>
            </div>

            <div class="flex items-center justify-between mb-5">
                <div class="font-black text-xl text-yellow-500">
                    All Products <span id="productCount" class="font-semibold text-sm text-gray-400 ml-2"></span>
                </div>
            </div>

            <div id="productsGrid" class="grid gap-4 grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5"></div>

            <div class="flex justify-center mt-8 py-4">
                {{ $products->links() }}
            </div>

            <div id="emptyState" class="hidden text-center py-16 text-gray-300">
                <div class="text-6xl">🔍</div>
                <p class="mt-3 font-bold text-base">No products found</p>
            </div>
        </main>
    </div>


    <!-- ══ PRODUCT DETAIL MODAL ══ -->
    <div id="productModal" class="modal-backdrop" onclick="handleModalBackdropClick(event)">
        <div class="modal-box">
            <div class="flex items-center justify-between px-6 py-3.5 border-b border-gray-100">
                <div class="modal-breadcrumb">
                    Home › <span id="modalBreadCat"></span> › <span id="modalBreadName"
                        class="text-gray-600 font-semibold"></span>
                </div>
                <button onclick="closeProductModal()"
                    class="bg-gray-100 hover:bg-gray-200 border-none rounded-full w-8 h-8 text-base cursor-pointer font-[Nunito] flex items-center justify-center transition-colors">✕</button>
            </div>
            <div class="modal-body">
                <div class="thumb-strip" id="thumbStrip"></div>
                <div class="w-[280px] shrink-0 bg-[#f8fafb] modal-img-wrap flex items-center justify-center">
                    <img id="modalImg" src="" alt=""
                        class="w-full h-full object-contain max-h-[420px]" style="padding:12px;">
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
                        <span class="text-xs text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded-full">✓
                            Verified</span>
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
                        <div class="text-xs font-black text-gray-400 tracking-widest uppercase mb-2">About this product
                        </div>
                        <p id="modalDesc" class="text-sm text-gray-600 font-semibold leading-relaxed"></p>
                    </div>
                    <div class="border-t border-gray-100 mb-4"></div>
                    <div class="mt-auto">
                        <div class="text-xs font-black text-gray-400 tracking-widest uppercase mb-2.5">Quantity</div>
                        <div class="flex items-center gap-4 mb-4">
                            <button class="qty-btn" onclick="modalDecreaseQty()">−</button>
                            <span id="modalQty"
                                class="text-xl font-black text-gray-900 min-w-[32px] text-center">1</span>
                            <button class="qty-btn" onclick="modalIncreaseQty()">+</button>
                            <span class="text-sm text-gray-400 font-semibold">× <span
                                    id="modalUnitSmall"></span></span>
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


    <!-- ══ CART DRAWER ══ -->
    <div id="drawerOverlay" onclick="closeCart()" class="hidden fixed inset-0 bg-black/45 z-[300]"></div>
    <div id="cartDrawer"
        class="drawer fixed top-0 -right-[420px] w-[400px] h-screen bg-white z-[301] flex flex-col shadow-2xl">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="font-black text-xl">🛒 Your Cart</div>
            <button onclick="closeCart()"
                class="bg-gray-100 border-none rounded-full w-9 h-9 text-lg cursor-pointer font-[Nunito] hover:bg-gray-200 transition-colors">✕</button>
        </div>
        <div id="cartBody" class="flex-1 overflow-y-auto py-2"></div>
        <div id="cartFooter" class="px-6 py-5 border-t border-gray-100"></div>
    </div>

    <!-- Sticky bottom bar -->
    <div id="cartBottomBar"
        class="hidden fixed bottom-0 left-[220px] right-0 bg-[#0c7a3e] px-10 py-3.5 items-center justify-between z-50 shadow-[0_-4px_20px_rgba(12,122,62,0.3)]">
        <div class="text-white">
            <div id="cbbItems" class="text-sm opacity-85">0 items</div>
            <div id="cbbPrice" class="text-2xl font-black">RS 0</div>
        </div>
        <button onclick="openCart()"
            class="bg-white text-[#0c7a3e] border-none rounded-xl px-7 py-3 text-[15px] font-extrabold cursor-pointer font-[Nunito]">View
            Cart &amp; Checkout →</button>
    </div>


    <!-- ══ CHECKOUT MODAL ══ -->
    <div id="checkoutModal" onclick="handleCheckoutBackdropClick(event)">
        <div class="checkout-box">

            <!-- Header -->
            <div
                class="px-8 py-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white z-10">
                <div class="font-black text-xl text-gray-900">🧾 Checkout</div>
                <button onclick="closeCheckout()"
                    class="bg-gray-100 hover:bg-gray-200 border-none rounded-full w-9 h-9 text-base cursor-pointer flex items-center justify-center">✕</button>
            </div>

            <!-- Step indicator -->
            <div class="flex items-center px-8 py-4 border-b border-gray-50">
                <div class="step-dot active" id="step1dot">1</div>
                <div class="text-xs font-bold text-gray-500 ml-2 mr-3">Delivery</div>
                <div class="step-line" id="line1"></div>
                <div class="step-dot" id="step2dot">2</div>
                <div class="text-xs font-bold text-gray-500 ml-2 mr-3">Payment</div>
                <div class="step-line" id="line2"></div>
                <div class="step-dot" id="step3dot">3</div>
                <div class="text-xs font-bold text-gray-500 ml-2">Confirm</div>
            </div>

            <!-- ── Step 1: Delivery Address ── -->
            <div id="checkStep1" class="px-8 py-6">

                <!-- Pre-fill banner — shown when last address is loaded -->
                <div id="addrPrefillBanner" class="gap-2">
                    <span>✅</span>
                    <span>We've filled in your last delivery address. Edit if needed.</span>
                </div>

                <div class="text-lg font-black text-gray-800 mb-5">📍 Delivery Address</div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-wider mb-1.5">First
                            Name *</label>
                        <input name="firstName" id="addr_name" type="text" placeholder="e.g. Arbeen"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-[#0c7a3e] focus:ring-2 focus:ring-[#0c7a3e]/20 transition-all font-[Nunito]">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-wider mb-1.5">Last Name
                            *</label>
                        <input name="last_name" id="addr_last_name" type="text" placeholder="e.g. Shrestha"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-[#0c7a3e] focus:ring-2 focus:ring-[#0c7a3e]/20 transition-all font-[Nunito]">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-wider mb-1.5">Phone
                            *</label>
                        <input name="phone_number" id="addr_phone" type="tel" placeholder="98XXXXXXXX"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-[#0c7a3e] focus:ring-2 focus:ring-[#0c7a3e]/20 transition-all font-[Nunito]">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-black text-gray-500 uppercase tracking-wider mb-1.5">Street
                        Address *</label>
                    <input name="street_address" id="addr_street" type="text"
                        placeholder="House No., Street name, Area"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-[#0c7a3e] focus:ring-2 focus:ring-[#0c7a3e]/20 transition-all font-[Nunito]">
                </div>
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-wider mb-1.5">City
                            *</label>
                        <select name="city" id="addr_city"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-[#0c7a3e] font-[Nunito] bg-white">
                            <option>Kathmandu</option>
                            <option>Lalitpur</option>
                            <option>Bhaktapur</option>
                            <option>Pokhara</option>
                            <option>Biratnagar</option>
                            <option>Birgunj</option>
                            <option>Butwal</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-wider mb-1.5">District
                            / State</label>
                        <input name="state" id="addr_district" type="text" placeholder="Bagmati"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-[#0c7a3e] font-[Nunito]">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-wider mb-1.5">Postal
                            Code</label>
                        <input name="zip_code" id="addr_postal" type="text" placeholder="44600"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-[#0c7a3e] font-[Nunito]">
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-xs font-black text-gray-500 uppercase tracking-wider mb-1.5">Delivery Note
                        (optional)</label>
                    <textarea name="description" id="addr_note" placeholder="Landmark, gate color, floor number..." rows="2"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-[#0c7a3e] transition-all font-[Nunito] resize-none"></textarea>
                </div>

                <!-- Mini order summary -->
                <div class="bg-gray-50 rounded-xl p-4 mb-5 border border-gray-100">
                    <div class="text-xs font-black text-gray-400 uppercase tracking-wider mb-3">Order Summary</div>
                    <div id="checkoutSummaryItems" class="space-y-2 max-h-36 overflow-y-auto mb-3"></div>
                    <div
                        class="flex justify-between text-sm font-extrabold text-gray-800 border-t border-gray-200 pt-2">
                        <span>Total</span><span id="checkoutTotal">RS 0.00</span>
                    </div>
                </div>

                <button id="continueToPaymentBtn" onclick="goToStep(2)"
                    class="w-full bg-[#0c7a3e] hover:bg-[#0a6633] text-white border-none rounded-2xl py-4 text-[15px] font-extrabold cursor-pointer font-[Nunito] transition-colors">
                    Continue to Payment →
                </button>
            </div>

            <!-- ── Step 2: Payment Method ── -->
            <div id="checkStep2" class="hidden px-8 py-6">
                <div class="text-lg font-black text-gray-800 mb-5">💳 Payment Method</div>
                <div class="grid grid-cols-2 gap-3 mb-6">
                    <div class="pay-card selected" onclick="selectPayment(this,'cod')" id="pay_cod">
                        <div class="text-2xl mb-1">💵</div>
                        <div class="font-black text-sm text-gray-800">Cash on Delivery</div>
                        <div class="text-xs text-gray-400 font-semibold mt-0.5">Pay when you receive</div>
                    </div>
                    <div class="pay-card" onclick="selectPayment(this,'esewa')" id="pay_esewa">
                        <div class="text-2xl mb-1">📱</div>
                        <div class="font-black text-sm text-gray-800">eSewa</div>
                        <div class="text-xs text-gray-400 font-semibold mt-0.5">Digital wallet</div>
                    </div>
                    <div class="pay-card" onclick="selectPayment(this,'khalti')" id="pay_khalti">
                        <div class="text-2xl mb-1">🟣</div>
                        <div class="font-black text-sm text-gray-800">Khalti</div>
                        <div class="text-xs text-gray-400 font-semibold mt-0.5">Digital wallet</div>
                    </div>
                    <div class="pay-card" onclick="selectPayment(this,'bank')" id="pay_bank">
                        <div class="text-2xl mb-1">🏦</div>
                        <div class="font-black text-sm text-gray-800">Bank Transfer</div>
                        <div class="text-xs text-gray-400 font-semibold mt-0.5">Direct bank payment</div>
                    </div>
                </div>
                <div id="pay_note_cod"
                    class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-sm text-yellow-700 font-semibold mb-6">
                    💡 Keep exact change ready. Our delivery partner will collect payment at your door.
                </div>
                <div id="pay_note_esewa"
                    class="hidden bg-green-50 border border-green-200 rounded-xl p-4 text-sm text-green-700 font-semibold mb-6">
                    📲 You'll be redirected to eSewa to complete payment after placing the order.
                </div>
                <div id="pay_note_khalti"
                    class="hidden bg-purple-50 border border-purple-200 rounded-xl p-4 text-sm text-purple-700 font-semibold mb-6">
                    📲 You'll be redirected to Khalti to complete payment after placing the order.
                </div>
                <div id="pay_note_bank"
                    class="hidden bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm text-blue-700 font-semibold mb-6">
                    🏦 Bank details will be shown after order placement. Transfer within 24 hours to confirm.
                </div>
                <div class="flex gap-3">
                    <button onclick="goToStep(1, false)"
                        class="flex-1 border border-gray-200 text-gray-500 rounded-2xl py-3.5 text-[14px] font-extrabold cursor-pointer font-[Nunito] bg-transparent transition-colors">←
                        Back</button>
                    <button id="continueToReviewBtn" onclick="goToStep(3)"
                        class="flex-[2] bg-[#0c7a3e] hover:bg-[#0a6633] text-white border-none rounded-2xl py-4 text-[15px] font-extrabold cursor-pointer font-[Nunito] transition-colors">Review
                        Order →</button>
                </div>
            </div>

            <!-- ── Step 3: Review & Confirm ── -->
            <div id="checkStep3" class="hidden px-8 py-6">
                <div class="text-lg font-black text-gray-800 mb-5">✅ Review &amp; Confirm</div>
                <div class="bg-gray-50 rounded-xl p-4 mb-4 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-xs font-black text-gray-400 uppercase tracking-wider">Delivery Address</div>
                        <button onclick="goToStep(1, false)"
                            class="text-xs text-[#0c7a3e] font-extrabold bg-transparent border-none cursor-pointer">Edit</button>
                    </div>
                    <div id="confirmAddress" class="text-sm font-semibold text-gray-700 leading-relaxed"></div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 mb-4 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-xs font-black text-gray-400 uppercase tracking-wider">Payment Method</div>
                        <button onclick="goToStep(2, false)"
                            class="text-xs text-[#0c7a3e] font-extrabold bg-transparent border-none cursor-pointer">Edit</button>
                    </div>
                    <div id="confirmPayment" class="text-sm font-semibold text-gray-700"></div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 mb-5 border border-gray-100">
                    <div class="text-xs font-black text-gray-400 uppercase tracking-wider mb-3">Items</div>
                    <div id="confirmItems" class="space-y-2 max-h-44 overflow-y-auto mb-3"></div>
                    <div class="border-t border-gray-200 pt-3 space-y-1.5">
                        <div class="flex justify-between text-sm text-gray-500 font-semibold">
                            <span>Subtotal</span><span id="confirm_sub">RS 0.00</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-500 font-semibold">
                            <span>Delivery</span><span class="text-green-600 font-bold">FREE</span>
                        </div>
                        <div
                            class="flex justify-between text-base font-extrabold text-gray-900 border-t border-gray-200 pt-2 mt-1">
                            <span>Total</span><span id="confirm_total">RS 0.00</span>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button onclick="goToStep(2, false)"
                        class="flex-1 border border-gray-200 text-gray-500 rounded-2xl py-3.5 text-[14px] font-extrabold cursor-pointer font-[Nunito] bg-transparent">←
                        Back</button>
                    <button id="placeOrderBtn" onclick="placeOrder()"
                        class="flex-[2] bg-[#0c7a3e] hover:bg-[#0a6633] text-white border-none rounded-2xl py-4 text-[15px] font-extrabold cursor-pointer font-[Nunito] transition-colors flex items-center justify-center gap-2">🎉
                        Place Order</button>
                </div>
            </div>

            <!-- ── Step 4: Order Success ── -->
            <div id="checkStep4" class="hidden px-8 py-14 text-center">
                <div class="text-6xl mb-4">🎉</div>
                <div class="text-2xl font-black text-gray-900 mb-2">Order Placed!</div>
                <div class="text-sm text-gray-500 font-semibold mb-6">Your order has been received. We'll deliver
                    within 30 minutes.</div>
                <div id="orderNumber"
                    class="inline-block bg-green-50 border border-green-200 text-green-700 font-extrabold text-sm px-5 py-2.5 rounded-xl mb-8">
                </div>
                <br>
                <button onclick="closeCheckout()"
                    class="bg-[#0c7a3e] text-white border-none rounded-2xl px-10 py-4 text-[15px] font-extrabold cursor-pointer font-[Nunito]">
                    Back to Shopping
                </button>
            </div>
        </div>
    </div>

    <!-- ══ MY ORDERS MODAL ══ -->
    <div id="ordersModal" onclick="handleOrdersBackdropClick(event)">

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


    <!-- ══ JAVASCRIPT ══ -->
    <script>
        /* ── SVG placeholder for products without images ── */
        const placeholderHTML = `
<div class="w-full h-full flex flex-col items-center justify-center gap-1.5">
  <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11 opacity-35">
    <rect width="48" height="48" rx="6" fill="#e8f5e9"/>
    <path d="M8 36L18 20L26 30L32 22L42 36H8Z" fill="#a5d6a7"/>
    <circle cx="34" cy="14" r="5" fill="#a5d6a7"/>
  </svg>
  <span class="text-[11px] font-bold text-gray-300">No image</span>
</div>`;

        const cartPlaceholderSVG = `
<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 opacity-35">
  <path d="M8 36L18 20L26 30L32 22L42 36H8Z" fill="#a5d6a7"/>
  <circle cx="34" cy="14" r="5" fill="#a5d6a7"/>
</svg>`;

        const tagMeta = {
            'Fresh': {
                bg: '#e8f5e9',
                color: '#2e7d32'
            },
            'New': {
                bg: '#e3f2fd',
                color: '#0d47a1'
            },
            'Organic': {
                bg: '#f3e5f5',
                color: '#6a1b9a'
            },
            'Best Seller': {
                bg: '#fff3e0',
                color: '#e65100'
            },
            'Popular': {
                bg: '#fce4ec',
                color: '#880e4f'
            },
            'Healthy': {
                bg: '#e0f2f1',
                color: '#004d40'
            },
        };

        /* Products on the current paginated page */
        const products = @json($products->items());

        let cart = {};
        let cartProducts = {}; // cache for products NOT on this page

        let modalProduct = null;
        let modalQtyVal = 1;

        let selectedPayMethod = 'cod';
        let currentCheckoutStep = 1;

        const isAuth = {{ auth()->check() ? 'true' : 'false' }};
        const csrfToken = '{{ csrf_token() }}';


        /* ══ HELPER: find a product by id ══
           First checks the current page, then the cartProducts cache.
           This is why the cart drawer works even when browsing page 2+. */
        function getProduct(id) {
            return products.find(p => p.id == id) || cartProducts[id] || null;
        }


        /* ══ CART TOTALS — single source of truth ══ */
        function calcCartTotals() {
            let totalItems = 0;
            let subtotal = 0;

            Object.entries(cart).forEach(([id, qty]) => {
                const p = getProduct(id);
                if (!p) return;
                totalItems += qty;
                subtotal += parseFloat(p.price) * qty;
            });

            return {
                totalItems,
                subtotal,
                total: subtotal
            }; // no tax
        }


        /* ══ PRODUCT DETAIL MODAL ══ */
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

            document.getElementById('thumbStrip').innerHTML = p.image ?
                `<div class="thumb active"><img src="${p.image}" alt=""></div>` :
                '';

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
                const color = qty === 0 ? 'bg-red-100 text-red-600' : qty < 10 ? 'bg-orange-100 text-orange-600' :
                    'bg-green-100 text-green-700';
                const label = qty === 0 ? '❌ Out of Stock' : qty < 10 ? `⚠️ Only ${qty} left` :
                    `✅ In Stock (${qty} available)`;
                stockEl.innerHTML = `<span class="text-xs font-extrabold px-3 py-1 rounded-full ${color}">${label}</span>`;
            } else {
                stockEl.innerHTML =
                    `<span class="text-xs font-extrabold px-3 py-1 rounded-full bg-green-100 text-green-700">✅ In Stock</span>`;
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
                btn.innerHTML =
                    `🛒 Add to Cart — RS <span id="modalTotalPrice">${(parseFloat(modalProduct.price) * modalQtyVal).toFixed(2)}</span>`;
            }, 1200);
        }


        /* ══ DARK MODE ══ */
        function toggleDarkMode() {
            const html = document.documentElement;
            const isDark = html.getAttribute('data-theme') === 'dark';
            html.setAttribute('data-theme', isDark ? 'light' : 'dark');
            localStorage.setItem('theme', isDark ? 'light' : 'dark');
            document.querySelectorAll('#dmBtn').forEach(b => {
                b.textContent = isDark ? '🌙 Dark' : '☀️ Light';
            });
        }
        (function() {
            const saved = localStorage.getItem('theme');
            if (saved) {
                document.documentElement.setAttribute('data-theme', saved);
                document.querySelectorAll('#dmBtn').forEach(b => {
                    b.textContent = saved === 'dark' ? '☀️ Light' : '🌙 Dark';
                });
            }
        })();


        /* ══ ACCOUNT DROPDOWN ══ */
        function toggleAccountMenu() {
            document.getElementById('accountMenu').classList.toggle('hidden');
        }
        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('accountWrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                const menu = document.getElementById('accountMenu');
                if (menu) menu.classList.add('hidden');
            }
        });


        /* ══ SEARCH FILTER ══ */
        function filterProducts() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const filtered = products.filter(p => p.name.toLowerCase().includes(search));
            renderProducts(filtered);
        }


        /* ══ RENDER HELPERS ══ */
        function cardImageHtml(p) {
            const tagHtml = p.tag && tagMeta[p.tag] ?
                `<div class="absolute top-2.5 left-2.5 tag-badge z-10" style="background:${tagMeta[p.tag].bg};color:${tagMeta[p.tag].color}">${p.tag}</div>` :
                '';
            const hasImage = p.image && p.image !== 'YOUR_IMAGE_PATH_HERE';
            const imgContent = hasImage ?
                `<img src="${p.image}" alt="${p.name}" class="w-full h-full object-cover block">` :
                placeholderHTML;
            return `<div class="product-img-wrap bg-[#f0faf4] h-[150px] flex items-center justify-center relative overflow-hidden">${tagHtml}${imgContent}</div>`;
        }

        function cartThumbHtml(p) {
            return p.image ?
                `<img src="${p.image}" alt="${p.name}" class="w-full h-full object-cover">` :
                cartPlaceholderSVG;
        }


        /* ══ RENDER PRODUCTS GRID ══ */
        function renderProducts(list) {
            const grid = document.getElementById('productsGrid');
            const empty = document.getElementById('emptyState');
            document.getElementById('productCount').textContent = `(${list.length})`;

            if (list.length === 0) {
                grid.innerHTML = '';
                empty.classList.remove('hidden');
                return;
            }
            empty.classList.add('hidden');

            grid.innerHTML = list.map(p => {
                const qty = cart[p.id] || 0;
                const actionHtml = qty === 0 ?
                    `<button class="bg-[#0c7a3e] hover:bg-[#0a6633] text-white border-none rounded-lg px-4 py-1.5 text-[13px] font-extrabold cursor-pointer font-[Nunito]"
                            onclick="event.stopPropagation(); addToCart(${p.id})">ADD</button>` :
                    `<div class="flex items-center gap-2 bg-[#0c7a3e] rounded-lg px-2 py-1.5" onclick="event.stopPropagation()">
                           <button class="bg-transparent border-none text-white text-xl cursor-pointer leading-none font-black font-[Nunito] p-0" onclick="removeFromCart(${p.id})">−</button>
                           <span class="text-white text-sm font-extrabold min-w-[18px] text-center">${qty}</span>
                           <button class="bg-transparent border-none text-white text-xl cursor-pointer leading-none font-black font-[Nunito] p-0" onclick="addToCart(${p.id})">+</button>
                       </div>`;

                return `
<div class="product-card bg-white rounded-2xl overflow-hidden shadow-sm"
     onclick="openProductModal(${JSON.stringify(p).replace(/"/g,'&quot;')})">
    ${cardImageHtml(p)}
    <div class="px-3.5 pt-3 pb-3.5">
        <div class="font-bold text-sm text-gray-900 leading-tight mb-0.5 truncate">${p.name}</div>
        <div class="text-gray-400 text-xs mb-2.5">${p.unit}</div>
        <div class="flex items-center justify-between">
            <div class="font-black text-[17px] text-gray-900">RS ${parseFloat(p.price).toFixed(2)}</div>
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
            el.innerHTML = qty === 0 ?
                `<button class="bg-[#0c7a3e] hover:bg-[#0a6633] text-white border-none rounded-lg px-4 py-1.5 text-[13px] font-extrabold cursor-pointer font-[Nunito]"
                        onclick="event.stopPropagation(); addToCart(${id})">ADD</button>` :
                `<div class="flex items-center gap-2 bg-[#0c7a3e] rounded-lg px-2 py-1.5" onclick="event.stopPropagation()">
                       <button class="bg-transparent border-none text-white text-xl cursor-pointer leading-none font-black font-[Nunito] p-0" onclick="removeFromCart(${id})">−</button>
                       <span class="text-white text-sm font-extrabold min-w-[18px] text-center">${qty}</span>
                       <button class="bg-transparent border-none text-white text-xl cursor-pointer leading-none font-black font-[Nunito] p-0" onclick="addToCart(${id})">+</button>
                   </div>`;
        }


        /* ══ UPDATE CART BADGE + BOTTOM BAR ══ */
        function updateCartUI() {
            const {
                totalItems,
                total
            } = calcCartTotals();

            const badge = document.getElementById('cartBadge');
            badge.textContent = totalItems;
            totalItems > 0 ? badge.classList.add('visible') : badge.classList.remove('visible');

            const bar = document.getElementById('cartBottomBar');
            if (totalItems > 0) bar.classList.replace('hidden', 'flex');
            else bar.classList.replace('flex', 'hidden');

            document.getElementById('cbbItems').textContent = `${totalItems} item${totalItems !== 1 ? 's' : ''} in cart`;
            document.getElementById('cbbPrice').textContent = `RS ${total.toFixed(2)}`;
        }


        /* ══ CART DRAWER ══ */
        function openCart() {
            document.getElementById('cartDrawer').style.right = '0';
            document.getElementById('drawerOverlay').classList.remove('hidden');
            renderCartDrawer();
        }

        function closeCart() {
            document.getElementById('cartDrawer').style.right = '-420px';
            document.getElementById('drawerOverlay').classList.add('hidden');
        }

        function renderCartDrawer() {
            const body = document.getElementById('cartBody');
            const footer = document.getElementById('cartFooter');
            const entries = Object.entries(cart);

            if (entries.length === 0) {
                body.innerHTML =
                    `<div class="text-center py-16 px-6 text-gray-300"><div class="text-6xl">🛒</div><p class="mt-3 font-bold text-base">Your cart is empty</p></div>`;
                footer.innerHTML = '';
                return;
            }

            const {
                subtotal,
                total
            } = calcCartTotals();

            body.innerHTML = entries.map(([id, qty]) => {
                const p = getProduct(id);
                if (!p) return '';
                const lineTotal = (parseFloat(p.price) * qty).toFixed(2);
                return `
<div class="flex items-center gap-3 px-5 py-3.5 border-b border-gray-50">
    <div class="w-[50px] h-[50px] rounded-xl bg-[#f0faf4] shrink-0 overflow-hidden flex items-center justify-center">
        ${cartThumbHtml(p)}
    </div>
    <div class="flex-1 min-w-0">
        <div class="font-bold text-sm truncate">${p.name}</div>
        <div class="text-gray-400 text-xs mt-0.5">${p.unit} · RS ${parseFloat(p.price).toFixed(2)}</div>
    </div>
    <div class="flex items-center gap-1.5">
        <button class="bg-gray-100 hover:bg-gray-200 border-none rounded-lg w-7 h-7 text-base cursor-pointer font-extrabold font-[Nunito] transition-colors"
            onclick="cartRemove(${p.product_id ?? p.id})">−</button>
        <span class="font-extrabold text-[14px] min-w-[20px] text-center">${qty}</span>
        <button class="bg-[#0c7a3e] hover:bg-[#0a6633] text-white border-none rounded-lg w-7 h-7 text-base cursor-pointer font-extrabold font-[Nunito] transition-colors"
            onclick="cartAdd(${p.product_id ?? p.id})">+</button>
    </div>
    <div class="font-extrabold text-sm min-w-[60px] text-right">RS ${lineTotal}</div>
    <button onclick="cartDelete(${p.product_id ?? p.id})" title="Remove"
        class="ml-1 text-gray-300 hover:text-red-500 bg-transparent border-none cursor-pointer text-lg transition-colors">🗑</button>
</div>`;
            }).join('');

            footer.innerHTML =
                `
<div class="flex justify-between mb-1.5"><span class="text-gray-400 text-sm font-semibold">Subtotal</span><strong class="font-bold text-sm">RS ${subtotal.toFixed(2)}</strong></div>
<div class="flex justify-between mb-1.5"><span class="text-gray-400 text-sm font-semibold">Delivery</span><strong class="font-bold text-sm text-[#0c7a3e]">FREE</strong></div>
<hr class="border-t border-gray-100 my-3">
<div class="flex justify-between mb-4"><span class="font-extrabold text-base">Total</span><span class="font-extrabold text-base">RS ${total.toFixed(2)}</span></div>
<button onclick="openCheckout()" class="bg-[#0c7a3e] hover:bg-[#0a6633] text-white border-none rounded-xl py-4 px-6 w-full font-[Nunito] text-base font-extrabold cursor-pointer transition-colors">Proceed to Checkout →</button>`;
        }

        function cartAdd(id) {
            addToCart(id);
            renderCartDrawer();
        }

        function cartRemove(id) {
            removeFromCart(id);
            renderCartDrawer();
        }

        async function cartDelete(id) {
            delete cart[id];
            delete cartProducts[id];
            updateCartUI();
            refreshAction(id);
            renderCartDrawer();

            if (!isAuth) {
                saveLocalCart(cart);
                return;
            }

            await fetch('/cart/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    product_id: id,
                    quantity: 0
                })
            });
        }


        /* ══ ORDER SUMMARY — used by Steps 1 and 3 ══ */
        function buildSummaryHtml() {
            return Object.entries(cart).map(([id, qty]) => {
                const p = getProduct(id);
                if (!p) return '';
                const lineTotal = (parseFloat(p.price) * qty).toFixed(2);
                return `
<div class="flex items-center justify-between text-xs text-gray-600 font-semibold gap-2">
    <span class="truncate flex-1">${p.name}</span>
    <span class="text-gray-400 shrink-0">× ${qty}</span>
    <span class="font-extrabold text-gray-800 shrink-0 min-w-[70px] text-right">RS ${lineTotal}</span>
</div>`;
            }).join('');
        }

        function populateCheckoutSummary() {
            const {
                subtotal,
                total
            } = calcCartTotals();
            const html = buildSummaryHtml();

            // Step 1 mini summary
            document.getElementById('checkoutSummaryItems').innerHTML = html;
            document.getElementById('checkoutTotal').textContent = `RS ${total.toFixed(2)}`;

            // Step 3 full summary
            document.getElementById('confirmItems').innerHTML = html;
            document.getElementById('confirm_sub').textContent = `RS ${subtotal.toFixed(2)}`;
            document.getElementById('confirm_total').textContent = `RS ${total.toFixed(2)}`;
        }


        /* ══ CHECKOUT MODAL ══ */
        async function openCheckout() {
            if (!isAuth) {
                window.location.href = '/login';
                return;
            }
            closeCart();
            populateCheckoutSummary();
            goToStep(1, false);
            document.getElementById('checkoutModal').classList.add('open');
            document.body.style.overflow = 'hidden';

            // Pre-fill address from last order
            await prefillLastAddress();
        }

        function closeCheckout() {
            document.getElementById('checkoutModal').classList.remove('open');
            document.body.style.overflow = '';
        }

        function handleCheckoutBackdropClick(e) {
            if (e.target === document.getElementById('checkoutModal')) closeCheckout();
        }

        /* Fetch last address and fill the form */
        async function prefillLastAddress() {
            try {
                const res = await fetch('/checkout/last-address');
                const data = await res.json();

                if (!data.found) return;

                const a = data.address;
                document.getElementById('addr_name').value = a.firstName || '';
                document.getElementById('addr_last_name').value = a.last_name || '';
                document.getElementById('addr_phone').value = a.phone_number || '';
                document.getElementById('addr_street').value = a.street_address || '';
                document.getElementById('addr_district').value = a.state || '';
                document.getElementById('addr_postal').value = a.zip_code || '';
                document.getElementById('addr_note').value = a.description || '';

                // Set the city select to match
                const citySelect = document.getElementById('addr_city');
                if (a.city) {
                    for (let i = 0; i < citySelect.options.length; i++) {
                        if (citySelect.options[i].value === a.city || citySelect.options[i].text === a.city) {
                            citySelect.selectedIndex = i;
                            break;
                        }
                    }
                }

                // Show the green pre-fill banner
                document.getElementById('addrPrefillBanner').classList.add('show');
            } catch (e) {
                // Silently fail — form just stays empty
            }
        }


        /* ══ STEP NAVIGATION — async, validates & saves at each boundary ══ */
        async function goToStep(step, validate = true) {

            if (validate && step > currentCheckoutStep) {

                /* Step 1 → 2: save address */
                if (currentCheckoutStep === 1 && step === 2) {
                    const firstName = document.getElementById('addr_name').value.trim();
                    const phone = document.getElementById('addr_phone').value.trim();
                    const street = document.getElementById('addr_street').value.trim();

                    if (!firstName || !phone || !street) {
                        alert('Please fill in First Name, Phone and Street Address.');
                        return;
                    }

                    const btn = document.getElementById('continueToPaymentBtn');
                    btn.textContent = '⏳ Saving...';
                    btn.disabled = true;

                    try {
                        const res = await fetch('/checkout/address', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                firstName: firstName,
                                last_name: document.getElementById('addr_last_name').value.trim(),
                                phone_number: phone,
                                street_address: street,
                                city: document.getElementById('addr_city').value,
                                state: document.getElementById('addr_district').value.trim(),
                                zip_code: document.getElementById('addr_postal').value.trim(),
                                description: document.getElementById('addr_note').value.trim(),
                            }),
                        });
                        const data = await res.json();

                        if (!data.success) {
                            alert(data.message || 'Could not save address. Please try again.');
                            btn.textContent = 'Continue to Payment →';
                            btn.disabled = false;
                            return;
                        }
                    } catch (e) {
                        alert('Network error. Please try again.');
                        btn.textContent = 'Continue to Payment →';
                        btn.disabled = false;
                        return;
                    }

                    btn.textContent = 'Continue to Payment →';
                    btn.disabled = false;
                }

                /* Step 2 → 3: save payment method */
                if (currentCheckoutStep === 2 && step === 3) {
                    const btn = document.getElementById('continueToReviewBtn');
                    btn.textContent = '⏳ Saving...';
                    btn.disabled = true;

                    try {
                        const res = await fetch('/checkout/payment', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                payment_method: selectedPayMethod
                            }),
                        });
                        const data = await res.json();

                        if (!data.success) {
                            alert(data.message || 'Could not save payment method.');
                            btn.textContent = 'Review Order →';
                            btn.disabled = false;
                            return;
                        }
                    } catch (e) {
                        alert('Network error. Please try again.');
                        btn.textContent = 'Review Order →';
                        btn.disabled = false;
                        return;
                    }

                    btn.textContent = 'Review Order →';
                    btn.disabled = false;
                }
            }

            /* Actually move to the target step */
            currentCheckoutStep = step;

            [1, 2, 3, 4].forEach(s => {
                const el = document.getElementById('checkStep' + s);
                if (el) el.classList.toggle('hidden', s !== step);
            });

            for (let i = 1; i <= 3; i++) {
                const dot = document.getElementById('step' + i + 'dot');
                dot.classList.remove('active', 'done');
                if (i < step) dot.classList.add('done');
                else if (i === step) dot.classList.add('active');
            }
            for (let i = 1; i <= 2; i++) {
                document.getElementById('line' + i).classList.toggle('done', i < step);
            }

            /* Populate confirm step */
            if (step === 3) {
                const firstName = document.getElementById('addr_name').value;
                const lastName = document.getElementById('addr_last_name').value;
                const phone = document.getElementById('addr_phone').value;
                const street = document.getElementById('addr_street').value;
                const city = document.getElementById('addr_city').value;
                const district = document.getElementById('addr_district').value;
                const postal = document.getElementById('addr_postal').value;
                const note = document.getElementById('addr_note').value;

                document.getElementById('confirmAddress').innerHTML =
                    `<strong>${firstName} ${lastName}</strong> · ${phone}<br>` +
                    `${street}, ${city}` +
                    `${district ? ', ' + district : ''}` +
                    `${postal ? ' - ' + postal : ''}` +
                    `${note ? '<br><em class="text-gray-400">' + note + '</em>' : ''}`;

                const payLabels = {
                    cod: '💵 Cash on Delivery',
                    esewa: '📱 eSewa',
                    khalti: '🟣 Khalti',
                    bank: '🏦 Bank Transfer'
                };
                document.getElementById('confirmPayment').textContent = payLabels[selectedPayMethod] || '';

                populateCheckoutSummary();
            }
        }


        /* ══ PAYMENT CARD SELECTION ══ */
        function selectPayment(el, method) {
            selectedPayMethod = method;
            document.querySelectorAll('.pay-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            ['cod', 'esewa', 'khalti', 'bank'].forEach(m => {
                const note = document.getElementById('pay_note_' + m);
                if (note) note.classList.toggle('hidden', m !== method);
            });
        }


        /* ══ PLACE ORDER ══ */
        async function placeOrder() {
            const btn = document.getElementById('placeOrderBtn');
            btn.innerHTML = '⏳ Placing Order...';
            btn.disabled = true;

            try {
                const res = await fetch('/checkout/place', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({}),
                });
                const data = await res.json();

                if (!data.success) {
                    alert(data.message || 'Could not place order. Please try again.');
                    btn.innerHTML = '🎉 Place Order';
                    btn.disabled = false;
                    return;
                }

                document.getElementById('orderNumber').textContent = '🧾 Order #' + data.order_number;
                goToStep(4, false);

                // Clear local cart state
                cart = {};
                cartProducts = {};
                saveLocalCart({});
                updateCartUI();
                renderProducts(products);

            } catch (e) {
                alert('Network error. Please try again.');
                btn.innerHTML = '🎉 Place Order';
                btn.disabled = false;
            }
        }


        /* ══ AUTH + CART SYNC ══ */
        function getLocalCart() {
            return JSON.parse(localStorage.getItem('cart') || '{}');
        }

        function saveLocalCart(c) {
            localStorage.setItem('cart', JSON.stringify(c));
        }

        async function addToCart(productId, quantity = 1) {
            cart[productId] = (cart[productId] || 0) + quantity;
            updateCartUI();
            refreshAction(productId);

            if (!isAuth) {
                saveLocalCart(cart);
                return;
            }

            await fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: cart[productId]
                })
            });
        }

        async function removeFromCart(id) {
            if (!cart[id]) return;
            cart[id]--;
            if (cart[id] === 0) delete cart[id];
            updateCartUI();
            refreshAction(id);

            if (!isAuth) {
                saveLocalCart(cart);
                return;
            }

            const newQty = cart[id] || 0;
            await fetch('/cart/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    product_id: id,
                    quantity: newQty
                })
            });
        }

        async function loadCart() {
            if (!isAuth) {
                cart = getLocalCart();
                const normalized = {};
                Object.entries(cart).forEach(([k, v]) => {
                    normalized[parseInt(k)] = v;
                });
                cart = normalized;
                updateCartUI();
                renderProducts(products);
                return;
            }

            try {
                const res = await fetch('/cart');
                const data = await res.json();
                cart = {};
                cartProducts = {};
                if (Array.isArray(data)) {
                    data.forEach(item => {
                        cart[item.product_id] = item.quantity;
                        cartProducts[item.product_id] = item;
                    });
                }
            } catch (e) {
                console.error('Cart load failed:', e);
            }

            updateCartUI();
            renderProducts(products);
        }

        async function mergeCartAfterLogin() {
            const localCart = getLocalCart();
            if (Object.keys(localCart).length === 0) return;

            const items = Object.entries(localCart).map(([product_id, quantity]) => ({
                product_id,
                quantity
            }));

            await fetch('/cart/merge', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    cart: items
                })
            });

            localStorage.removeItem('cart');
            await loadCart();
        }

        @if (session('just_logged_in'))
            mergeCartAfterLogin();
        @endif

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                closeProductModal();
                closeCheckout();
            }
        });

        loadCart();


        // my order js 

const ordersData = @json($orders);

const statusMeta = {
    delivered:  { label: 'Delivered',  cls: 'status-delivered',  icon: '✅' },
    transit:    { label: 'In Transit', cls: 'status-transit',    icon: '🚚' },
    processing: { label: 'Processing', cls: 'status-processing', icon: '⏳' },
    pending:    { label: 'Pending',    cls: 'status-pending',    icon: '🕐' },
    cancelled:  { label: 'Cancelled',  cls: 'status-cancelled',  icon: '❌' },
};
const payMeta = {
    cod:   { label: 'Cash on Delivery', icon: '💵' },
    esewa: { label: 'eSewa',            icon: '📱' },
    khalti:{ label: 'Khalti',           icon: '🟣' },
    bank:  { label: 'Bank Transfer',    icon: '🏦' },
};
const timelineSteps = {
    pending:    [true,  false, false, false],
    processing: [true,  true,  false, false],
    transit:    [true,  true,  true,  false],
    delivered:  [true,  true,  true,  true ],
    cancelled:  [false, false, false, false],
};
const timelineLabels = [
    { label: 'Order Placed',      sub: 'We received your order' },
    { label: 'Confirmed',         sub: 'Order verified & packed' },
    { label: 'Out for Delivery',  sub: 'Rider is on the way' },
    { label: 'Delivered',         sub: 'Order delivered successfully' },
];

let currentOrderId = null;

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
function backToOrdersList() { showOrdersListView(); }

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
    // TODO: optionally fetch('/orders/' + id + '/json') for fresh data
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
    // TODO: order.items.forEach(item => addToCart(item.product_id, item.qty));
    closeOrdersModal();
    openCart();
}

function cancelOrder() {
    if (!confirm('Are you sure you want to cancel this order?')) return;
    // TODO: POST /orders/' + currentOrderId + '/cancel
}

function formatOrderDate(dateStr) {
    try {
        const d = new Date(dateStr);
        return d.toLocaleDateString('en-US', { day: 'numeric', month: 'short', year: 'numeric' });
    } catch(e) { return dateStr; }
}

//my order details end here 
    </script>
</body>

</html>
