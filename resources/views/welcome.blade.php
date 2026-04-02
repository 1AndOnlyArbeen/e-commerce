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
                    fontFamily: { nunito: ['Nunito', 'sans-serif'] },
                    colors: {
                        green: {
                            brand: '#0c7a3e', dark: '#0a6633',
                            light: '#1aad5e', pale: '#f0faf4', muted: '#a8e6c1'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Nunito', sans-serif; }

        /* ── Hide badge by default, show when cart has items ── */
        .cart-badge { display: none; }
        .cart-badge.visible { display: flex; }

        /* ── Smooth cart drawer slide ── */
        .drawer { transition: right 0.3s ease; }

        /* ── Product image zoom on hover ── */
        .product-img-wrap { overflow: hidden; }
        .product-img-wrap img {
            transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            will-change: transform;
        }
        .product-img-wrap:hover img { transform: scale(1.12); }

        /* ── Product card lift on hover ── */
        .product-card {
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(12, 122, 62, 0.12);
        }

        /* ── Product detail modal backdrop ── */
        .modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.55);
            z-index: 500;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
        }
        .modal-backdrop.open { display: flex; }

        /* ── Modal box with spring animation ── */
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
            box-shadow: 0 40px 80px rgba(0,0,0,0.22);
        }
        @keyframes modalIn {
            from { transform: scale(0.9) translateY(16px); opacity: 0; }
            to   { transform: scale(1) translateY(0);      opacity: 1; }
        }
        .modal-body { display: flex; flex: 1; overflow: hidden; }
        .modal-img-wrap { overflow: hidden; }
        .modal-img-wrap img {
            transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .modal-img-wrap:hover img { transform: scale(1.07); }

        /* ── Daraz-style thumbnail strip ── */
        .thumb-strip {
            display: flex; flex-direction: column; gap: 6px;
            padding: 10px 8px; background: #fafafa;
            border-right: 1px solid #f0f0f0;
        }
        .thumb {
            width: 52px; height: 52px; border-radius: 8px;
            border: 2px solid transparent; cursor: pointer;
            overflow: hidden; background: #f0faf4;
        }
        .thumb.active { border-color: #0c7a3e; }
        .thumb img { width: 100%; height: 100%; object-fit: cover; }

        /* ── Breadcrumb inside modal ── */
        .modal-breadcrumb { font-size: 11px; color: #9ca3af; font-weight: 600; margin-bottom: 10px; }
        .modal-breadcrumb span { color: #0c7a3e; }

        /* ── Star rating row ── */
        .stars { color: #f59e0b; font-size: 14px; }

        /* ── Quantity stepper buttons ── */
        .qty-btn {
            width: 34px; height: 34px;
            border: 2px solid #0c7a3e; border-radius: 10px;
            background: transparent; color: #0c7a3e;
            font-size: 20px; font-weight: 900;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.15s;
            font-family: 'Nunito', sans-serif;
        }
        .qty-btn:hover { background: #0c7a3e; color: #fff; }

        /* ── Small tag badge (Fresh, Organic, etc.) ── */
        .tag-badge {
            display: inline-block;
            font-size: 10px; font-weight: 800;
            border-radius: 6px; padding: 2px 8px;
        }

        /* ── Checkout modal ── */
        #checkoutModal {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.6); z-index: 600;
            align-items: center; justify-content: center;
            backdrop-filter: blur(5px);
        }
        #checkoutModal.open { display: flex; }
        .checkout-box {
            background: #fff; border-radius: 20px;
            width: 860px; max-width: 96vw; max-height: 93vh;
            overflow-y: auto;
            animation: modalIn 0.28s cubic-bezier(0.34,1.56,0.64,1);
            box-shadow: 0 40px 80px rgba(0,0,0,0.25);
        }

        /* ── Checkout step indicator dots ── */
        .step-dot {
            width: 28px; height: 28px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 900;
            border: 2px solid #d1d5db; color: #9ca3af;
            transition: all 0.2s;
        }
        .step-dot.active { background: #0c7a3e; border-color: #0c7a3e; color: #fff; }
        .step-dot.done   { background: #e8f5ee; border-color: #0c7a3e; color: #0c7a3e; }
        .step-line { flex: 1; height: 2px; background: #e5e7eb; margin: 0 4px; }
        .step-line.done { background: #0c7a3e; }

        /* ── Payment method selection cards ── */
        .pay-card {
            border: 2px solid #e5e7eb; border-radius: 14px; padding: 14px 18px;
            cursor: pointer; transition: all 0.15s;
            display: flex; flex-direction: column;
        }
        .pay-card:hover  { border-color: #0c7a3e; background: #f0faf4; }
        .pay-card.selected { border-color: #0c7a3e; background: #f0faf4; }

        /* ══════════════════════════════════════
           CSS VARIABLES — light & dark theme
        ══════════════════════════════════════ */
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

        /* ── Dark mode overrides ── */
        [data-theme="dark"] body { background: var(--bg); }
        [data-theme="dark"] .text-gray-900 { color: var(--text-primary) !important; }
        [data-theme="dark"] .text-gray-700 { color: var(--text-primary) !important; }
        [data-theme="dark"] .text-gray-600 { color: var(--text-secondary) !important; }
        [data-theme="dark"] .text-gray-500 { color: var(--text-secondary) !important; }
        [data-theme="dark"] .text-gray-400 { color: var(--text-muted) !important; }
        [data-theme="dark"] .bg-white      { background: var(--surface) !important; }
        [data-theme="dark"] .bg-gray-100   { background: var(--surface-2) !important; }
        [data-theme="dark"] .bg-gray-50    { background: var(--surface-2) !important; }
        [data-theme="dark"] .border-gray-100,
        [data-theme="dark"] .border-gray-200 { border-color: var(--border) !important; }
        [data-theme="dark"] aside { background: var(--surface); border-color: var(--border); }
        [data-theme="dark"] .product-card { background: var(--surface); }
        [data-theme="dark"] .product-img-wrap { background: var(--surface-2); }
        [data-theme="dark"] .modal-box { background: var(--surface); color: var(--text-primary); }
        [data-theme="dark"] .modal-img-wrap { background: var(--surface-2); }
        [data-theme="dark"] .thumb-strip { background: var(--surface-2); border-color: var(--border); }
        [data-theme="dark"] #cartDrawer { background: var(--surface); color: var(--text-primary); }
        [data-theme="dark"] #accountMenu { background: var(--surface); }
        [data-theme="dark"] .checkout-box { background: var(--surface); color: var(--text-primary); }
        [data-theme="dark"] nav .bg-white { background: var(--input-bg) !important; box-shadow: none; }
        [data-theme="dark"] nav input { color: var(--input-text); }
        [data-theme="dark"] .pay-card { border-color: var(--border); }
        [data-theme="dark"] .pay-card:hover,
        [data-theme="dark"] .pay-card.selected { background: rgba(12,122,62,0.15); border-color: #0c7a3e; }
    </style>
</head>

<body class="bg-gray-100 min-h-screen font-nunito">

    <!-- ══════════════════════════════════════
         NAVBAR
    ══════════════════════════════════════ -->
    <nav class="bg-[#0c7a3e] px-10 h-16 flex items-center justify-between sticky top-0 z-[100] shadow-lg">
        <div class="flex items-center gap-4">
            <!-- Logo -->
            <a href="/" class="flex items-center gap-2.5 no-underline">
                <div class="bg-white rounded-xl w-10 h-10 flex items-center justify-center text-2xl">🌿</div>
                <div>
                    <div class="text-white font-black text-xl leading-none">Arbeen</div>
                    <div class="text-[#a8e6c1] text-[11px] font-semibold">Store</div>
                </div>
            </a>
            <!-- Delivery badge -->
            <div class="bg-white/15 rounded-full px-3.5 py-1.5 flex items-center gap-1.5 text-white text-[13px] font-bold">
                ⚡ Delivery in 30 mins &nbsp;·&nbsp; Kathmandu, NP
            </div>
        </div>

        <!-- Search bar -->
        <div class="flex-1 max-w-[500px] mx-10">
            <div class="bg-white rounded-xl flex items-center px-4 py-2.5 gap-2.5 shadow-md">
                <span class="text-lg">🔍</span>
                <input type="text" id="searchInput"
                    placeholder="Search for groceries, vegetables, snacks..."
                    oninput="filterProducts()"
                    class="border-none outline-none text-sm font-[Nunito] text-gray-700 bg-transparent w-full placeholder-gray-400">
            </div>
        </div>

        <!-- Right side: auth buttons + cart -->
        <div class="flex items-center gap-3">
            <div class="relative" id="accountWrapper">

                {{-- Guest: show Login / Register / Dark toggle --}}
                @guest
                <div class="flex flex-row gap-2">
                    <a href="{{ route('login') }}"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-white hover:bg-white/10 rounded-xl transition-colors">🔑 Login</a>
                    <a href="{{ route('showregisterUser') }}"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-white hover:bg-white/10 rounded-xl transition-colors">📝 Register</a>
                    <button onclick="toggleDarkMode()" id="dmBtn"
                        class="rounded-xl px-3.5 py-2 text-[13px] font-bold cursor-pointer font-nunito flex items-center gap-1.5 border border-white/20 bg-white/10 text-white">🌙</button>
                </div>
                @endguest

                {{-- Auth: show account dropdown --}}
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
                    <button class="flex items-center gap-2.5 px-4 py-3 text-sm font-bold text-gray-600 cursor-pointer hover:bg-gray-50 w-full text-left border-none bg-transparent font-[Nunito]">🙍 Profile</button>
                    <button class="flex items-center gap-2.5 px-4 py-3 text-sm font-bold text-gray-600 cursor-pointer hover:bg-gray-50 w-full text-left border-none bg-transparent font-[Nunito]">📦 My Orders</button>
                    <hr class="border-t border-gray-100 m-0">
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-2.5 px-4 py-3 text-sm font-bold text-red-600 cursor-pointer hover:bg-red-50 w-full text-left border-none bg-transparent font-[Nunito]">🚪 Logout</button>
                    </form>
                    <button onclick="toggleDarkMode()" id="dmBtn"
                        class="flex items-center gap-2.5 px-4 py-3 text-sm font-bold text-gray-600 cursor-pointer hover:bg-gray-50 w-full border-none bg-transparent font-[Nunito]">🌙 Toggle Dark Mode</button>
                </div>
                @endauth

            </div>

            <!-- Cart button with badge -->
            <button onclick="openCart()"
                class="bg-white text-[#0c7a3e] border-none rounded-xl px-4 py-2 text-[13px] font-extrabold cursor-pointer font-[Nunito] flex items-center gap-2 relative">
                🛒 Cart
                <div id="cartBadge"
                    class="cart-badge bg-red-500 text-white rounded-full w-5 h-5 text-[11px] font-extrabold items-center justify-center">0</div>
            </button>
        </div>
    </nav>

    <!-- ══════════════════════════════════════
         PAGE LAYOUT — sidebar + main
    ══════════════════════════════════════ -->
    <div class="flex min-h-[calc(100vh-64px)]">

        <!-- ── Category Sidebar ── -->
        <aside class="w-[220px] shrink-0 bg-white px-4 py-6 border-r border-gray-100 sticky top-16 h-[calc(100vh-64px)] overflow-y-auto">
            <div class="text-xs font-black text-gray-400 tracking-widest uppercase mb-3">Categories</div>

            <!-- All Products link — highlighted when no category filter -->
            <a href="{{ route('index') }}"
               class="cat-btn {{ $category === 'All' ? 'bg-[#0c7a3e] text-white' : 'bg-transparent text-gray-600 hover:bg-[#f0faf4] hover:text-[#0c7a3e]' }} flex items-center gap-2.5 w-full rounded-xl px-3 py-2.5 text-sm font-bold mb-1">
                <span class="text-lg w-6 text-center">🏪</span> All Products
            </a>

            <!-- Dynamic category links from DB -->
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

        <!-- ── Main Content ── -->
        <main class="flex-1 px-8 pt-7 pb-28 overflow-y-auto">

            <!-- Promo Banner -->
            <div class="bg-gradient-to-br from-[#0c7a3e] to-[#1aad5e] rounded-2xl px-10 py-8 flex items-center justify-between mb-8 relative overflow-hidden">
                <div class="absolute -right-8 -top-8 w-44 h-44 bg-white/[0.07] rounded-full"></div>
                <div class="absolute right-24 -bottom-10 w-28 h-28 bg-white/[0.05] rounded-full"></div>
                <div class="relative z-10">
                    <div class="text-yellow-300 text-xs font-extrabold tracking-widest mb-2">🎉 LIMITED TIME OFFER</div>
                    <div class="text-white text-3xl font-black leading-tight mb-4">Fresh Vegetables<br>Up to 30% Off</div>
                    <button class="bg-white text-[#0c7a3e] border-none rounded-xl px-6 py-2.5 text-sm font-extrabold cursor-pointer font-[Nunito]">Shop Now →</button>
                </div>
            </div>

            <!-- Products count header -->
            <div class="flex items-center justify-between mb-5">
                <div class="font-black text-xl text-yellow-500">
                    All Products <span id="productCount" class="font-semibold text-sm text-gray-400 ml-2"></span>
                </div>
            </div>

            <!-- Products grid — rendered by JS -->
            <div id="productsGrid" class="grid gap-4 grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5"></div>

            <!-- Pagination links from Laravel -->
            <div class="flex justify-center mt-8 py-4">
                {{ $products->links() }}
            </div>

            <!-- Empty search state -->
            <div id="emptyState" class="hidden text-center py-16 text-gray-300">
                <div class="text-6xl">🔍</div>
                <p class="mt-3 font-bold text-base">No products found</p>
            </div>
        </main>
    </div>


    <!-- ══════════════════════════════════════
         PRODUCT DETAIL MODAL (Daraz-style)
    ══════════════════════════════════════ -->
    <div id="productModal" class="modal-backdrop" onclick="handleModalBackdropClick(event)">
        <div class="modal-box">

            <!-- Breadcrumb bar + close button -->
            <div class="flex items-center justify-between px-6 py-3.5 border-b border-gray-100">
                <div class="modal-breadcrumb">
                    Home › <span id="modalBreadCat"></span> › <span id="modalBreadName" class="text-gray-600 font-semibold"></span>
                </div>
                <button onclick="closeProductModal()"
                    class="bg-gray-100 hover:bg-gray-200 border-none rounded-full w-8 h-8 text-base cursor-pointer font-[Nunito] flex items-center justify-center transition-colors">✕</button>
            </div>

            <!-- Modal body: thumbnails | main image | details -->
            <div class="modal-body">

                <!-- Thumbnail strip (one thumb shown; extend for multi-image products) -->
                <div class="thumb-strip" id="thumbStrip"></div>

                <!-- Main product image -->
                <div class="w-[280px] shrink-0 bg-[#f8fafb] modal-img-wrap flex items-center justify-center">
                    <img id="modalImg" src="" alt=""
                        class="w-full h-full object-contain max-h-[420px]" style="padding:12px;">
                    <div id="modalImgPlaceholder" class="hidden w-full h-[320px] flex items-center justify-center">
                        <div class="text-7xl opacity-20">🛒</div>
                    </div>
                </div>

                <!-- Product details panel -->
                <div class="flex-1 flex flex-col px-7 py-5 overflow-y-auto">

                    <!-- Category pill -->
                    <div id="modalCategory"
                        class="inline-flex items-center gap-1.5 bg-[#e8f5ee] text-[#0c7a3e] text-[11px] font-extrabold px-3 py-1 rounded-full mb-2.5 self-start"></div>

                    <!-- Product name -->
                    <h2 id="modalName" class="text-xl font-black text-gray-900 leading-snug mb-1.5"></h2>

                    <!-- Rating (decorative) -->
                    <div class="flex items-center gap-2 mb-3">
                        <span class="stars">★★★★☆</span>
                        <span class="text-xs text-gray-400 font-semibold">(42 reviews)</span>
                        <span class="text-xs text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded-full">✓ Verified</span>
                    </div>

                    <!-- Price -->
                    <div class="flex items-baseline gap-3 mb-1">
                        <div id="modalPrice" class="text-3xl font-black text-gray-900"></div>
                        <div id="modalPricePerUnit" class="text-sm text-gray-400 font-semibold"></div>
                    </div>
                    <div id="modalTag" class="hidden tag-badge mb-3 self-start"></div>

                    <!-- Stock status -->
                    <div id="modalStock" class="mb-4 mt-1"></div>

                    <!-- Quick info grid (Daraz-style highlights) -->
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

                    <!-- Description (hidden if product has none) -->
                    <div id="modalDescWrap" class="mb-5 hidden">
                        <div class="text-xs font-black text-gray-400 tracking-widest uppercase mb-2">About this product</div>
                        <p id="modalDesc" class="text-sm text-gray-600 font-semibold leading-relaxed"></p>
                    </div>

                    <div class="border-t border-gray-100 mb-4"></div>

                    <!-- Quantity stepper + Add to Cart -->
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


    <!-- ══════════════════════════════════════
         CART DRAWER
    ══════════════════════════════════════ -->
    <!-- Overlay — clicking it closes the drawer -->
    <div id="drawerOverlay" onclick="closeCart()" class="hidden fixed inset-0 bg-black/45 z-[300]"></div>

    <!-- Drawer panel -->
    <div id="cartDrawer" class="drawer fixed top-0 -right-[420px] w-[400px] h-screen bg-white z-[301] flex flex-col shadow-2xl">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="font-black text-xl">🛒 Your Cart</div>
            <button onclick="closeCart()"
                class="bg-gray-100 border-none rounded-full w-9 h-9 text-lg cursor-pointer font-[Nunito] hover:bg-gray-200 transition-colors">✕</button>
        </div>
        <div id="cartBody" class="flex-1 overflow-y-auto py-2"></div>
        <div id="cartFooter" class="px-6 py-5 border-t border-gray-100"></div>
    </div>

    <!-- ── Sticky bottom bar shown when cart has items ── -->
    <div id="cartBottomBar"
        class="hidden fixed bottom-0 left-[220px] right-0 bg-[#0c7a3e] px-10 py-3.5 items-center justify-between z-50 shadow-[0_-4px_20px_rgba(12,122,62,0.3)]">
        <div class="text-white">
            <div id="cbbItems" class="text-sm opacity-85">0 items</div>
            <div id="cbbPrice" class="text-2xl font-black">RS 0</div>
        </div>
        <button onclick="openCart()"
            class="bg-white text-[#0c7a3e] border-none rounded-xl px-7 py-3 text-[15px] font-extrabold cursor-pointer font-[Nunito]">View Cart &amp; Checkout →</button>
    </div>


    <!-- ══════════════════════════════════════
         CHECKOUT MODAL (3-step flow)
    ══════════════════════════════════════ -->
    <div id="checkoutModal" onclick="handleCheckoutBackdropClick(event)">
        <div class="checkout-box">

            <!-- Header -->
            <div class="px-8 py-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white z-10">
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
                <div class="text-lg font-black text-gray-800 mb-5">📍 Delivery Address</div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-wider mb-1.5">Full Name *</label>
                        <input id="addr_name" type="text" placeholder="e.g. Ram Bahadur"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-[#0c7a3e] focus:ring-2 focus:ring-[#0c7a3e]/20 transition-all font-[Nunito]">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-wider mb-1.5">Phone *</label>
                        <input id="addr_phone" type="tel" placeholder="98XXXXXXXX"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-[#0c7a3e] focus:ring-2 focus:ring-[#0c7a3e]/20 transition-all font-[Nunito]">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-black text-gray-500 uppercase tracking-wider mb-1.5">Street Address *</label>
                    <input id="addr_street" type="text" placeholder="House No., Street name, Area"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-[#0c7a3e] focus:ring-2 focus:ring-[#0c7a3e]/20 transition-all font-[Nunito]">
                </div>
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-wider mb-1.5">City *</label>
                        <select id="addr_city" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-[#0c7a3e] font-[Nunito] bg-white">
                            <option>Kathmandu</option><option>Lalitpur</option><option>Bhaktapur</option>
                            <option>Pokhara</option><option>Biratnagar</option><option>Birgunj</option><option>Butwal</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-wider mb-1.5">District</label>
                        <input id="addr_district" type="text" placeholder="Bagmati"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-[#0c7a3e] font-[Nunito]">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-wider mb-1.5">Postal Code</label>
                        <input id="addr_postal" type="text" placeholder="44600"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-[#0c7a3e] font-[Nunito]">
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-xs font-black text-gray-500 uppercase tracking-wider mb-1.5">Delivery Note (optional)</label>
                    <textarea id="addr_note" placeholder="Landmark, gate color, floor number..." rows="2"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-[#0c7a3e] transition-all font-[Nunito] resize-none"></textarea>
                </div>
                <!-- Mini order summary -->
                <div class="bg-gray-50 rounded-xl p-4 mb-5 border border-gray-100">
                    <div class="text-xs font-black text-gray-400 uppercase tracking-wider mb-3">Order Summary</div>
                    <div id="checkoutSummaryItems" class="space-y-2 max-h-36 overflow-y-auto mb-3"></div>
                    <div class="flex justify-between text-sm font-extrabold text-gray-800 border-t border-gray-200 pt-2">
                        <span>Total</span><span id="checkoutTotal">RS 0</span>
                    </div>
                </div>
                <button onclick="goToStep(2)"
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
                <!-- Contextual notes per payment method -->
                <div id="pay_note_cod" class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-sm text-yellow-700 font-semibold mb-6">
                    💡 Keep exact change ready. Our delivery partner will collect payment at your door.
                </div>
                <div id="pay_note_esewa" class="hidden bg-green-50 border border-green-200 rounded-xl p-4 text-sm text-green-700 font-semibold mb-6">
                    📲 You'll be redirected to eSewa to complete payment after placing the order.
                </div>
                <div id="pay_note_khalti" class="hidden bg-purple-50 border border-purple-200 rounded-xl p-4 text-sm text-purple-700 font-semibold mb-6">
                    📲 You'll be redirected to Khalti to complete payment after placing the order.
                </div>
                <div id="pay_note_bank" class="hidden bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm text-blue-700 font-semibold mb-6">
                    🏦 Bank details will be shown after order placement. Transfer within 24 hours to confirm.
                </div>
                <div class="flex gap-3">
                    <button onclick="goToStep(1)" class="flex-1 border border-gray-200 text-gray-500 rounded-2xl py-3.5 text-[14px] font-extrabold cursor-pointer font-[Nunito] bg-transparent transition-colors">← Back</button>
                    <button onclick="goToStep(3)" class="flex-[2] bg-[#0c7a3e] hover:bg-[#0a6633] text-white border-none rounded-2xl py-4 text-[15px] font-extrabold cursor-pointer font-[Nunito] transition-colors">Review Order →</button>
                </div>
            </div>

            <!-- ── Step 3: Review & Confirm ── -->
            <div id="checkStep3" class="hidden px-8 py-6">
                <div class="text-lg font-black text-gray-800 mb-5">✅ Review & Confirm</div>
                <div class="bg-gray-50 rounded-xl p-4 mb-4 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-xs font-black text-gray-400 uppercase tracking-wider">Delivery Address</div>
                        <button onclick="goToStep(1)" class="text-xs text-[#0c7a3e] font-extrabold bg-transparent border-none cursor-pointer">Edit</button>
                    </div>
                    <div id="confirmAddress" class="text-sm font-semibold text-gray-700 leading-relaxed"></div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 mb-4 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-xs font-black text-gray-400 uppercase tracking-wider">Payment Method</div>
                        <button onclick="goToStep(2)" class="text-xs text-[#0c7a3e] font-extrabold bg-transparent border-none cursor-pointer">Edit</button>
                    </div>
                    <div id="confirmPayment" class="text-sm font-semibold text-gray-700"></div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 mb-5 border border-gray-100">
                    <div class="text-xs font-black text-gray-400 uppercase tracking-wider mb-3">Items</div>
                    <div id="confirmItems" class="space-y-2 max-h-44 overflow-y-auto mb-3"></div>
                    <div class="border-t border-gray-200 pt-3 space-y-1.5">
                        <div class="flex justify-between text-sm text-gray-500 font-semibold"><span>Subtotal</span><span id="confirm_sub">RS 0</span></div>
                        <div class="flex justify-between text-sm text-gray-500 font-semibold"><span>Delivery</span><span class="text-green-600 font-bold">FREE</span></div>
                        <div class="flex justify-between text-base font-extrabold text-gray-900 border-t border-gray-200 pt-2 mt-1"><span>Total</span><span id="confirm_total">RS 0</span></div>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button onclick="goToStep(2)" class="flex-1 border border-gray-200 text-gray-500 rounded-2xl py-3.5 text-[14px] font-extrabold cursor-pointer font-[Nunito] bg-transparent">← Back</button>
                    <button onclick="placeOrder()" class="flex-[2] bg-[#0c7a3e] hover:bg-[#0a6633] text-white border-none rounded-2xl py-4 text-[15px] font-extrabold cursor-pointer font-[Nunito] transition-colors flex items-center justify-center gap-2">🎉 Place Order</button>
                </div>
            </div>

            <!-- ── Step 4: Order Success ── -->
            <div id="checkStep4" class="hidden px-8 py-14 text-center">
                <div class="text-6xl mb-4">🎉</div>
                <div class="text-2xl font-black text-gray-900 mb-2">Order Placed!</div>
                <div class="text-sm text-gray-500 font-semibold mb-6">Your order has been received. We'll deliver within 30 minutes.</div>
                <div id="orderNumber" class="inline-block bg-green-50 border border-green-200 text-green-700 font-extrabold text-sm px-5 py-2.5 rounded-xl mb-8"></div>
                <br>
                <button onclick="closeCheckout(); clearCartAfterOrder()"
                    class="bg-[#0c7a3e] text-white border-none rounded-2xl px-10 py-4 text-[15px] font-extrabold cursor-pointer font-[Nunito]">
                    Back to Shopping
                </button>
            </div>
        </div>
    </div>


    <!-- ══════════════════════════════════════
         JAVASCRIPT
    ══════════════════════════════════════ -->
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

        /* ── Smaller placeholder used inside the cart drawer ── */
        const cartPlaceholderSVG = `
<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 opacity-35">
  <path d="M8 36L18 20L26 30L32 22L42 36H8Z" fill="#a5d6a7"/>
  <circle cx="34" cy="14" r="5" fill="#a5d6a7"/>
</svg>`;

        /* ── Tag colours for Fresh / Organic / etc. badges ── */
        const tagMeta = {
            'Fresh':       { bg: '#e8f5e9', color: '#2e7d32' },
            'New':         { bg: '#e3f2fd', color: '#0d47a1' },
            'Organic':     { bg: '#f3e5f5', color: '#6a1b9a' },
            'Best Seller': { bg: '#fff3e0', color: '#e65100' },
            'Popular':     { bg: '#fce4ec', color: '#880e4f' },
            'Healthy':     { bg: '#e0f2f1', color: '#004d40' },
        };

        /* ── Products on the CURRENT paginated page (from Laravel) ── */
        const products = @json($products->items());

        /* ── cart: { product_id: quantity } — source of truth for UI ── */
        let cart = {};

        /*
         * cartProducts: cache of product details fetched from /cart
         * This is the KEY FIX — products on other pages won't be in
         * the `products` array above, so we store their details here
         * so the cart drawer can still render them correctly.
         */
        let cartProducts = {};

        /* ── Modal state ── */
        let modalProduct = null;
        let modalQtyVal  = 1;

        /* ── Checkout state ── */
        let selectedPayMethod  = 'cod';
        let currentCheckoutStep = 1;

        /* ── Auth flag injected by Laravel ── */
        const isAuth = {{ auth()->check() ? 'true' : 'false' }};


        /* ══════════════════════════════════════
           HELPER: look up a product by id
           First checks the current page's products array,
           then falls back to cartProducts cache from /cart response.
           This solves the "cart empty on other pages" bug.
        ══════════════════════════════════════ */
        function getProduct(id) {
            return products.find(p => p.id == id) || cartProducts[id] || null;
        }


        /* ══════════════════════════════════════
           PRODUCT DETAIL MODAL
        ══════════════════════════════════════ */
        function openProductModal(p) {
            modalProduct = p;
            modalQtyVal  = cart[p.id] || 1;

            /* Set main image or show placeholder */
            const img         = document.getElementById('modalImg');
            const placeholder = document.getElementById('modalImgPlaceholder');
            if (p.image) {
                img.src = p.image;
                img.classList.remove('hidden');
                placeholder.classList.add('hidden');
            } else {
                img.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }

            /* Thumbnail strip */
            document.getElementById('thumbStrip').innerHTML = p.image
                ? `<div class="thumb active"><img src="${p.image}" alt=""></div>`
                : '';

            /* Breadcrumb */
            document.getElementById('modalBreadCat').textContent  = p.category || '';
            document.getElementById('modalBreadName').textContent = p.name;

            /* Tag badge */
            const tagEl = document.getElementById('modalTag');
            if (p.tag && tagMeta[p.tag]) {
                tagEl.textContent      = p.tag;
                tagEl.style.background = tagMeta[p.tag].bg;
                tagEl.style.color      = tagMeta[p.tag].color;
                tagEl.classList.remove('hidden');
            } else {
                tagEl.classList.add('hidden');
            }

            /* Category, name, price, unit */
            document.getElementById('modalCategory').textContent     = '📦  ' + (p.category || '');
            document.getElementById('modalName').textContent          = p.name;
            document.getElementById('modalUnit').textContent          = p.unit;
            document.getElementById('modalPrice').textContent         = `RS ${parseFloat(p.price).toFixed(2)}`;
            document.getElementById('modalPricePerUnit').textContent  = `per ${p.unit}`;
            document.getElementById('modalUnitSmall').textContent     = p.unit;

            /* Stock badge */
            const stockEl = document.getElementById('modalStock');
            const qty     = p.stock_quantity ?? null;
            if (qty !== null) {
                const color = qty === 0 ? 'bg-red-100 text-red-600' : qty < 10 ? 'bg-orange-100 text-orange-600' : 'bg-green-100 text-green-700';
                const label = qty === 0 ? '❌ Out of Stock' : qty < 10 ? `⚠️ Only ${qty} left` : `✅ In Stock (${qty} available)`;
                stockEl.innerHTML = `<span class="text-xs font-extrabold px-3 py-1 rounded-full ${color}">${label}</span>`;
            } else {
                stockEl.innerHTML = `<span class="text-xs font-extrabold px-3 py-1 rounded-full bg-green-100 text-green-700">✅ In Stock</span>`;
            }

            /* Description */
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

        /* Close modal when clicking the dark backdrop */
        function handleModalBackdropClick(e) {
            if (e.target === document.getElementById('productModal')) closeProductModal();
        }

        function modalIncreaseQty() {
            const max = modalProduct?.stock_quantity ?? 999;
            if (modalQtyVal < max) { modalQtyVal++; updateModalQtyDisplay(); }
        }
        function modalDecreaseQty() {
            if (modalQtyVal > 1) { modalQtyVal--; updateModalQtyDisplay(); }
        }
        function updateModalQtyDisplay() {
            document.getElementById('modalQty').textContent = modalQtyVal;
            const total = (parseFloat(modalProduct?.price || 0) * modalQtyVal).toFixed(2);
            document.getElementById('modalTotalPrice').textContent = total;
        }

        /* Add the modal's quantity to cart, flash button green */
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


        /* ══════════════════════════════════════
           DARK MODE — persisted in localStorage
        ══════════════════════════════════════ */
        function toggleDarkMode() {
            const html   = document.documentElement;
            const isDark = html.getAttribute('data-theme') === 'dark';
            html.setAttribute('data-theme', isDark ? 'light' : 'dark');
            localStorage.setItem('theme', isDark ? 'light' : 'dark');
            document.querySelectorAll('#dmBtn').forEach(b => {
                b.textContent = isDark ? '🌙 Dark' : '☀️ Light';
            });
        }
        /* Apply saved theme immediately on load */
        (function () {
            const saved = localStorage.getItem('theme');
            if (saved) {
                document.documentElement.setAttribute('data-theme', saved);
                document.querySelectorAll('#dmBtn').forEach(b => {
                    b.textContent = saved === 'dark' ? '☀️ Light' : '🌙 Dark';
                });
            }
        })();


        /* ══════════════════════════════════════
           ACCOUNT DROPDOWN
        ══════════════════════════════════════ */
        function toggleAccountMenu() {
            document.getElementById('accountMenu').classList.toggle('hidden');
        }
        /* Close dropdown when clicking anywhere outside */
        document.addEventListener('click', function (e) {
            const wrapper = document.getElementById('accountWrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                const menu = document.getElementById('accountMenu');
                if (menu) menu.classList.add('hidden');
            }
        });


        /* ══════════════════════════════════════
           SEARCH FILTER
           Filters the current page's products by name.
        ══════════════════════════════════════ */
        function filterProducts() {
            const search   = document.getElementById('searchInput').value.toLowerCase();
            const filtered = products.filter(p => p.name.toLowerCase().includes(search));
            renderProducts(filtered);
        }


        /* ══════════════════════════════════════
           RENDER HELPERS
        ══════════════════════════════════════ */

        /* Build the image block for a product card */
        function cardImageHtml(p) {
            const tagHtml    = p.tag && tagMeta[p.tag]
                ? `<div class="absolute top-2.5 left-2.5 tag-badge z-10" style="background:${tagMeta[p.tag].bg};color:${tagMeta[p.tag].color}">${p.tag}</div>`
                : '';
            const hasImage   = p.image && p.image !== 'YOUR_IMAGE_PATH_HERE';
            const imgContent = hasImage
                ? `<img src="${p.image}" alt="${p.name}" class="w-full h-full object-cover block">`
                : placeholderHTML;
            return `<div class="product-img-wrap bg-[#f0faf4] h-[150px] flex items-center justify-center relative overflow-hidden">${tagHtml}${imgContent}</div>`;
        }

        /* Thumbnail for cart drawer — uses the full image URL returned by /cart */
        function cartThumbHtml(p) {
            return p.image
                ? `<img src="${p.image}" alt="${p.name}" class="w-full h-full object-cover">`
                : cartPlaceholderSVG;
        }


        /* ══════════════════════════════════════
           RENDER PRODUCTS GRID
        ══════════════════════════════════════ */
        function renderProducts(list) {
            const grid  = document.getElementById('productsGrid');
            const empty = document.getElementById('emptyState');
            document.getElementById('productCount').textContent = `(${list.length})`;

            if (list.length === 0) {
                grid.innerHTML = '';
                empty.classList.remove('hidden');
                return;
            }
            empty.classList.add('hidden');

            grid.innerHTML = list.map(p => {
                const qty        = cart[p.id] || 0;
                /* Show ADD button when qty=0, show stepper otherwise */
                const actionHtml = qty === 0
                    ? `<button class="bg-[#0c7a3e] hover:bg-[#0a6633] text-white border-none rounded-lg px-4 py-1.5 text-[13px] font-extrabold cursor-pointer font-[Nunito]"
                            onclick="event.stopPropagation(); addToCart(${p.id})">ADD</button>`
                    : `<div class="flex items-center gap-2 bg-[#0c7a3e] rounded-lg px-2 py-1.5" onclick="event.stopPropagation()">
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

        /* Re-render just the ADD/stepper button for one product */
        function refreshAction(id) {
            const el  = document.getElementById('action-' + id);
            if (!el) return;
            const qty = cart[id] || 0;
            el.innerHTML = qty === 0
                ? `<button class="bg-[#0c7a3e] hover:bg-[#0a6633] text-white border-none rounded-lg px-4 py-1.5 text-[13px] font-extrabold cursor-pointer font-[Nunito]"
                        onclick="event.stopPropagation(); addToCart(${id})">ADD</button>`
                : `<div class="flex items-center gap-2 bg-[#0c7a3e] rounded-lg px-2 py-1.5" onclick="event.stopPropagation()">
                       <button class="bg-transparent border-none text-white text-xl cursor-pointer leading-none font-black font-[Nunito] p-0" onclick="removeFromCart(${id})">−</button>
                       <span class="text-white text-sm font-extrabold min-w-[18px] text-center">${qty}</span>
                       <button class="bg-transparent border-none text-white text-xl cursor-pointer leading-none font-black font-[Nunito] p-0" onclick="addToCart(${id})">+</button>
                   </div>`;
        }


        /* ══════════════════════════════════════
           UPDATE CART BADGE + BOTTOM BAR
        ══════════════════════════════════════ */
        function updateCartUI() {
            const totalItems = Object.values(cart).reduce((a, b) => a + b, 0);
            /* Use getProduct() so items from other pages are counted correctly */
            const totalPrice = Object.entries(cart).reduce((sum, [id, qty]) => {
                const p = getProduct(id);
                return sum + (p ? parseFloat(p.price) * qty : 0);
            }, 0);

            /* Update badge */
            const badge = document.getElementById('cartBadge');
            badge.textContent = totalItems;
            totalItems > 0 ? badge.classList.add('visible') : badge.classList.remove('visible');

            /* Show/hide bottom bar */
            const bar = document.getElementById('cartBottomBar');
            if (totalItems > 0) bar.classList.replace('hidden', 'flex');
            else bar.classList.replace('flex', 'hidden');

            document.getElementById('cbbItems').textContent = `${totalItems} item${totalItems !== 1 ? 's' : ''} in cart`;
            document.getElementById('cbbPrice').textContent = `RS ${totalPrice.toFixed(2)}`;
        }


        /* ══════════════════════════════════════
           CART DRAWER
        ══════════════════════════════════════ */
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
            const body    = document.getElementById('cartBody');
            const footer  = document.getElementById('cartFooter');
            const entries = Object.entries(cart);

            if (entries.length === 0) {
                body.innerHTML = `<div class="text-center py-16 px-6 text-gray-300"><div class="text-6xl">🛒</div><p class="mt-3 font-bold text-base">Your cart is empty</p></div>`;
                footer.innerHTML = '';
                return;
            }

            /* Use getProduct() — falls back to cartProducts for off-page items */
            const subtotal = entries.reduce((sum, [id, qty]) => {
                const p = getProduct(id);
                return sum + (p ? parseFloat(p.price) * qty : 0);
            }, 0);
            const tax   = subtotal * 0.05;
            const total = subtotal + tax;

            body.innerHTML = entries.map(([id, qty]) => {
                const p = getProduct(id);
                if (!p) return ''; // skip items whose product can't be found at all
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
    <div class="font-extrabold text-sm min-w-[55px] text-right">RS ${(parseFloat(p.price) * qty).toFixed(2)}</div>
    <button onclick="cartDelete(${p.product_id ?? p.id})" title="Remove item"
        class="ml-1 text-gray-300 hover:text-red-500 bg-transparent border-none cursor-pointer text-lg transition-colors">🗑</button>
</div>`;
            }).join('');

            footer.innerHTML = `
<div class="flex justify-between mb-1.5"><span class="text-gray-400 text-sm font-semibold">Subtotal</span><strong class="font-bold text-sm">RS ${subtotal.toFixed(2)}</strong></div>
<div class="flex justify-between mb-1.5"><span class="text-gray-400 text-sm font-semibold">Delivery</span><strong class="font-bold text-sm text-[#0c7a3e]">FREE</strong></div>
<hr class="border-t border-gray-100 my-3">
<div class="flex justify-between mb-4"><span class="font-extrabold text-base">Total</span><span class="font-extrabold text-base">RS ${total.toFixed(2)}</span></div>
<button onclick="openCheckout()" class="bg-[#0c7a3e] hover:bg-[#0a6633] text-white border-none rounded-xl py-4 px-6 w-full font-[Nunito] text-base font-extrabold cursor-pointer transition-colors">Proceed to Checkout →</button>`;
        }

        /* Shorthand wrappers used by cart drawer buttons */
        function cartAdd(id)    { addToCart(id);      renderCartDrawer(); }
        function cartRemove(id) { removeFromCart(id); renderCartDrawer(); }

        /* Delete entire line item from cart */
        async function cartDelete(id) {
            delete cart[id];
            delete cartProducts[id]; // also remove from our local cache
            updateCartUI();
            refreshAction(id);
            renderCartDrawer();

            if (!isAuth) { saveLocalCart(cart); return; }

            /* Tell the server to remove the row entirely */
            await fetch('/cart/remove', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ product_id: id, quantity: 0 }) // quantity:0 = delete
            });
        }


        /* ══════════════════════════════════════
           CHECKOUT MODAL
        ══════════════════════════════════════ */
        function openCheckout() {
            closeCart();
            populateCheckoutSummary();
            goToStep(1, false);
            document.getElementById('checkoutModal').classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeCheckout() {
            document.getElementById('checkoutModal').classList.remove('open');
            document.body.style.overflow = '';
        }
        function handleCheckoutBackdropClick(e) {
            if (e.target === document.getElementById('checkoutModal')) closeCheckout();
        }

        /* Build order summary rows using getProduct() */
        function populateCheckoutSummary() {
            const entries  = Object.entries(cart);
            const subtotal = entries.reduce((sum, [id, qty]) => {
                const p = getProduct(id);
                return sum + (p ? parseFloat(p.price) * qty : 0);
           
            }, 0);
            
            const tax   = 0; // Removed tax
            const total = subtotal;

            const itemsHtml = entries.map(([id, qty]) => {
                const p = getProduct(id);
                if (!p) return '';
                return `<div class="flex justify-between text-xs text-gray-600 font-semibold">
                    <span>${p.name} × ${qty}</span>
                    <span>RS ${(parseFloat(p.price) * qty).toFixed(2)}</span>
                </div>`;
            }).join('');

            document.getElementById('checkoutSummaryItems').innerHTML = itemsHtml;
            document.getElementById('checkoutTotal').textContent       = `RS ${total.toFixed(2)}`;
            document.getElementById('confirmItems').innerHTML           = itemsHtml;
            document.getElementById('confirm_sub').textContent         = `RS ${subtotal.toFixed(2)}`;
            document.getElementById('confirm_total').textContent       = `RS ${total.toFixed(2)}`;
        }

        /* Navigate between checkout steps, with validation on step 1 */
        function goToStep(step, validate = true) {
            if (validate && step > currentCheckoutStep && currentCheckoutStep === 1) {
                if (!document.getElementById('addr_name').value.trim() ||
                    !document.getElementById('addr_phone').value.trim() ||
                    !document.getElementById('addr_street').value.trim()) {
                    alert('Please fill in Name, Phone and Street Address.');
                    return;
                }
            }

            currentCheckoutStep = step;
            [1, 2, 3, 4].forEach(s => {
                const el = document.getElementById('checkStep' + s);
                if (el) el.classList.toggle('hidden', s !== step);
            });

            /* Update step dots */
            for (let i = 1; i <= 3; i++) {
                const dot = document.getElementById('step' + i + 'dot');
                dot.classList.remove('active', 'done');
                if (i < step) dot.classList.add('done');
                else if (i === step) dot.classList.add('active');
            }
            for (let i = 1; i <= 2; i++) {
                document.getElementById('line' + i).classList.toggle('done', i < step);
            }

            /* Populate confirm step when we reach it */
            if (step === 3) {
                const name     = document.getElementById('addr_name').value;
                const phone    = document.getElementById('addr_phone').value;
                const street   = document.getElementById('addr_street').value;
                const city     = document.getElementById('addr_city').value;
                const district = document.getElementById('addr_district').value;
                const postal   = document.getElementById('addr_postal').value;
                const note     = document.getElementById('addr_note').value;

                document.getElementById('confirmAddress').innerHTML =
                    `<strong>${name}</strong> · ${phone}<br>${street}, ${city}${district ? ', '+district : ''}${postal ? ' - '+postal : ''}${note ? '<br><em class="text-gray-400">'+note+'</em>' : ''}`;

                const payLabels = { cod:'💵 Cash on Delivery', esewa:'📱 eSewa', khalti:'🟣 Khalti', bank:'🏦 Bank Transfer' };
                document.getElementById('confirmPayment').textContent = payLabels[selectedPayMethod] || '';

                populateCheckoutSummary();
            }
        }

        /* Highlight selected payment card, show its note */
        function selectPayment(el, method) {
            selectedPayMethod = method;
            document.querySelectorAll('.pay-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            ['cod','esewa','khalti','bank'].forEach(m => {
                const note = document.getElementById('pay_note_' + m);
                if (note) note.classList.toggle('hidden', m !== method);
            });
        }

        /* Simulate order placement — replace with real API call when ready */
        function placeOrder() {
            const orderNum = 'ARB-' + Math.random().toString(36).substring(2,8).toUpperCase();
            document.getElementById('orderNumber').textContent = '🧾 Order #' + orderNum;
            goToStep(4, false);
        }

        /* Clear cart after successful order */
        function clearCartAfterOrder() {
            cart = {};
            cartProducts = {};
            saveLocalCart({});
            updateCartUI();
            renderProducts(products);
        }


        /* ══════════════════════════════════════
           AUTH + CART SYNC
        ══════════════════════════════════════ */

        /* Read guest cart from localStorage */
        function getLocalCart()   { return JSON.parse(localStorage.getItem('cart') || '{}'); }
        /* Save guest cart to localStorage */
        function saveLocalCart(c) { localStorage.setItem('cart', JSON.stringify(c)); }

        /*
         * addToCart — updates local cart object then syncs to server.
         * Sends the NEW TOTAL quantity (not +1) so the server can SET
         * the value with updateOrCreate — prevents double-counting on refresh.
         */
        async function addToCart(productId, quantity = 1) {
            cart[productId] = (cart[productId] || 0) + quantity;
            updateCartUI();
            refreshAction(productId);

            if (!isAuth) { saveLocalCart(cart); return; }

            await fetch('/cart/add', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ product_id: productId, quantity: cart[productId] })
            });
        }

        /*
         * removeFromCart — decrements local qty, deletes key if 0.
         * Sends new total to server: 0 = delete row, >0 = update quantity.
         */
        async function removeFromCart(id) {
            if (!cart[id]) return;
            cart[id]--;
            if (cart[id] === 0) delete cart[id];
            updateCartUI();
            refreshAction(id);

            if (!isAuth) { saveLocalCart(cart); return; }

            const newQty = cart[id] || 0;
            await fetch('/cart/remove', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ product_id: id, quantity: newQty })
            });
        }

        /*
         * loadCart — called on page load.
         * For guests: reads localStorage.
         * For auth users: fetches /cart which now returns product details too,
         *   so the drawer works even when products are on a different page.
         */
        async function loadCart() {
            if (!isAuth) {
                cart = getLocalCart();
                /* localStorage keys are strings — convert to int so id matching works */
                const normalized = {};
                Object.entries(cart).forEach(([k, v]) => { normalized[parseInt(k)] = v; });
                cart = normalized;
                updateCartUI();
                renderProducts(products);
                return;
            }

            try {
                const res  = await fetch('/cart');
                const data = await res.json();
                cart         = {};
                cartProducts = {};
                if (Array.isArray(data)) {
                    data.forEach(item => {
                        cart[item.product_id] = item.quantity;
                        /*
                         * Cache product details returned by the server.
                         * This is what allows the cart drawer to show items
                         * from pages other than the current one.
                         */
                        cartProducts[item.product_id] = item;
                    });
                }
            } catch (e) {
                console.error('Cart load failed:', e);
            }

            updateCartUI();
            renderProducts(products);
        }

        /*
         * mergeCartAfterLogin — runs once after a guest logs in.
         * Pushes localStorage cart to the server then clears it.
         */
        async function mergeCartAfterLogin() {
            const localCart = getLocalCart();
            if (Object.keys(localCart).length === 0) return;

            const items = Object.entries(localCart).map(([product_id, quantity]) => ({ product_id, quantity }));

            await fetch('/cart/merge', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ cart: items })
            });

            localStorage.removeItem('cart');
            await loadCart(); // reload from server after merge
        }

        /* Auto-trigger merge if Laravel set the just_logged_in flash */
        @if(session('just_logged_in'))
        mergeCartAfterLogin();
        @endif

        /* Close modals with Escape key */
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') { closeProductModal(); closeCheckout(); }
        });

        /* Boot — load cart state on every page load */
        loadCart();
    </script>
</body>
</html>