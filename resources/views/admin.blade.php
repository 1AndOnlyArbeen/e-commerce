<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — ArbeenStore</title>
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
                        brand: {
                            DEFAULT: '#0c7a3e',
                            dark: '#0a6633',
                            light: '#e8f5ee',
                            mid: '#a8d5bc'
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

        /* ── THEME VARIABLES ── */
        [data-theme="light"] {
            --bg: #f3f4f6;
            --sidebar: #ffffff;
            --card: #ffffff;
            --border: #e5e7eb;
            --text: #111827;
            --text2: #6b7280;
            --input-bg: #f9fafb;
            --hover: #f3f4f6;
            --input-text: #111827;
            --topbar: #ffffff;
        }

        [data-theme="dark"] {
            --bg: #0f1117;
            --sidebar: #161b22;
            --card: #1c2333;
            --border: #30363d;
            --text: #e6edf3;
            --text2: #8b949e;
            --input-bg: #21262d;
            --hover: #1f2937;
            --input-text: #e6edf3;
            --topbar: #161b22;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: var(--bg);
            color: var(--text);
            transition: background .3s, color .3s;
        }

        .text-primary {
            color: var(--text) !important;
        }

        .text-secondary {
            color: var(--text2) !important;
        }

        .border-theme {
            border-color: var(--border) !important;
        }

        .hover-row:hover {
            background: var(--hover);
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
        }

        .form-input {
            background: var(--input-bg);
            border: 1px solid var(--border);
            color: var(--input-text);
            font-family: 'Nunito', sans-serif;
            font-weight: 600;
            font-size: 14px;
            border-radius: 12px;
            padding: 10px 14px;
            width: 100%;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .form-input:focus {
            border-color: #0c7a3e;
            box-shadow: 0 0 0 3px rgba(12, 122, 62, .1);
        }

        .form-input.error {
            border-color: #e53935 !important;
            background: #fff5f5 !important;
        }

        [data-theme="dark"] .form-input.error {
            background: #2d1515 !important;
        }

        select.form-input {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23999' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 36px !important;
            cursor: pointer;
        }

        aside {
            background: var(--sidebar);
            border-right: 1px solid var(--border);
        }

        .topbar {
            background: var(--topbar);
            border-bottom: 1px solid var(--border);
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            margin: 2px 8px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            color: var(--text2);
            text-decoration: none;
            transition: all .15s;
            cursor: pointer;
        }

        .nav-item.active {
            background: #0c7a3e;
            color: #fff !important;
        }

        .nav-item:not(.active):hover {
            background: var(--hover);
            color: #0c7a3e;
        }

        .page-section {
            display: none;
        }

        .page-section.active {
            display: block;
        }

        .switch {
            position: relative;
            width: 44px;
            height: 24px;
            display: inline-block;
            flex-shrink: 0;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            inset: 0;
            background: #ddd;
            border-radius: 24px;
            cursor: pointer;
            transition: background .2s;
        }

        .slider::before {
            content: '';
            position: absolute;
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background: #fff;
            border-radius: 50%;
            transition: transform .2s;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .2);
        }

        .switch input:checked+.slider {
            background: #0c7a3e;
        }

        .switch input:checked+.slider::before {
            transform: translateX(20px);
        }

        .tag-option {
            display: none;
        }

        .tag-option:checked+.tag-label {
            background: #0c7a3e !important;
            color: #fff !important;
            border-color: #0c7a3e !important;
        }

        .tag-label {
            padding: 6px 14px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            border: 1px solid var(--border);
            color: var(--text2);
            transition: all .15s;
        }

        .upload-zone {
            cursor: pointer;
            transition: all .2s;
        }

        .upload-zone:hover {
            border-color: #0c7a3e !important;
        }

        .upload-preview-overlay {
            display: none;
        }

        .upload-zone:hover .upload-preview-overlay {
            display: flex;
        }

        .modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .55);
            z-index: 200;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(3px);
        }

        .modal-backdrop.open {
            display: flex;
        }

        .modal-box {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 20px;
            max-height: 90vh;
            overflow-y: auto;
            animation: slideUp .25s ease;
        }

        @keyframes slideUp {
            from {
                transform: translateY(24px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .toast {
            transform: translateY(80px);
            opacity: 0;
            transition: all .3s ease;
            pointer-events: none;
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        .banner-dropzone {
            border: 2px dashed var(--border);
            border-radius: 14px;
            padding: 28px;
            text-align: center;
            cursor: pointer;
            transition: all .2s;
            background: var(--input-bg);
        }

        .banner-dropzone:hover {
            border-color: #0c7a3e;
            background: #e8f5ee22;
        }

        .cat-actions {
            opacity: 0;
            transition: opacity .15s;
        }

        .cat-card:hover .cat-actions {
            opacity: 1;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 99px;
        }

        .profile-dropdown {
            display: none;
            position: absolute;
            bottom: 72px;
            left: 12px;
            right: 12px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 8px;
            z-index: 100;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .15);
        }

        .profile-dropdown.open {
            display: block;
            animation: slideUp .2s ease;
        }

        .divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 0;
        }

        .card-header {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-header-icon {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            background: #e8f5ee;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .btn-primary {
            background: #0c7a3e;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 10px 20px;
            font-family: 'Nunito', sans-serif;
            font-weight: 800;
            font-size: 14px;
            cursor: pointer;
            transition: background .2s;
        }

        .btn-primary:hover {
            background: #0a6633;
        }

        .btn-ghost {
            background: var(--card);
            color: var(--text);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 10px 20px;
            font-family: 'Nunito', sans-serif;
            font-weight: 800;
            font-size: 14px;
            cursor: pointer;
            transition: all .2s;
        }

        .btn-ghost:hover {
            border-color: #0c7a3e;
        }

        .btn-danger {
            background: #fef2f2;
            color: #dc2626;
            border: none;
            border-radius: 10px;
            padding: 6px 12px;
            font-family: 'Nunito', sans-serif;
            font-weight: 800;
            font-size: 12px;
            cursor: pointer;
            transition: background .2s;
        }

        .btn-danger:hover {
            background: #fee2e2;
        }

        .btn-edit {
            background: #e8f5ee;
            color: #0c7a3e;
            border: none;
            border-radius: 10px;
            padding: 6px 12px;
            font-family: 'Nunito', sans-serif;
            font-weight: 800;
            font-size: 12px;
            cursor: pointer;
            transition: background .2s;
        }

        .btn-edit:hover {
            background: #d0ead8;
        }

        .input-prefix {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 800;
            color: var(--text2);
            background: var(--hover);
            border-radius: 12px 0 0 12px;
            border-right: 1px solid var(--border);
            pointer-events: none;
        }
    </style>
</head>

<body class="min-h-screen flex">

    <!-- ══ SIDEBAR ══ -->
    <aside class="w-[240px] min-w-[240px] h-screen fixed top-0 left-0 flex flex-col z-50">
        <a href="#" onclick="navigate('dashboard'); return false;"
            class="px-5 h-16 flex items-center gap-2.5 no-underline" style="border-bottom:1px solid var(--border);">
            <div class="bg-[#0c7a3e] rounded-xl w-9 h-9 flex items-center justify-center text-xl">🌿</div>
            <div>
                <div class="font-black text-lg leading-none text-primary">Arbeen</div>
                <div class="text-[10px] font-bold text-secondary">Store</div>
            </div>
            <div class="ml-auto text-[9px] font-black rounded px-1.5 py-0.5 tracking-wide"
                style="background:#e8f5ee;color:#0c7a3e;">ADMIN</div>
        </a>

        <div class="flex-1 overflow-y-auto py-2">
            <div class="px-4 pt-4 pb-1.5 text-[10px] font-black text-secondary tracking-widest uppercase">Main</div>
            <a href="#" onclick="navigate('dashboard'); return false;" class="nav-item" id="nav-dashboard"><span
                    class="text-[17px] w-5 text-center">📊</span> Dashboard</a>
            <a href="#" onclick="navigate('products'); return false;" class="nav-item" id="nav-products">
                <span class="text-[17px] w-5 text-center">📦</span> Products
                <span class="ml-auto bg-red-500 text-white text-[10px] font-black rounded-lg px-1.5 py-0.5"
                    id="nav-product-count">{{ $allProduct->count() }}</span>
            </a>

            <a href="#" onclick="navigate('orders'); return false;" class="nav-item" id="nav-orders"><span
                    class="text-[17px] w-5 text-center">🛒</span> Orders <span
                    class="ml-auto bg-red-500 text-white text-[10px] font-black rounded-lg px-1.5 py-0.5">5</span></a>
            <a href="#" onclick="navigate('customers'); return false;" class="nav-item" id="nav-customers"><span
                    class="text-[17px] w-5 text-center">👥</span> Customers</a>

            <div class="px-4 pt-4 pb-1.5 text-[10px] font-black text-secondary tracking-widest uppercase">Catalog</div>
            <a href="#" onclick="navigate('add-product'); return false;" class="nav-item"
                id="nav-add-product"><span class="text-[17px] w-5 text-center">➕</span> Add Product</a>
            <a href="#" onclick="navigate('categories'); return false;" class="nav-item" id="nav-categories"><span
                    class="text-[17px] w-5 text-center">🏷️</span> Categories</a>
            <a href="#" onclick="navigate('banner'); return false;" class="nav-item" id="nav-banner"><span
                    class="text-[17px] w-5 text-center">🖼️</span> Banner & Featured</a>
            <a href="#" onclick="navigate('discounts'); return false;" class="nav-item" id="nav-discounts"><span
                    class="text-[17px] w-5 text-center">🎟️</span> Discounts</a>

            <div class="px-4 pt-4 pb-1.5 text-[10px] font-black text-secondary tracking-widest uppercase">Settings</div>
            <a href="#" onclick="navigate('settings'); return false;" class="nav-item" id="nav-settings"><span
                    class="text-[17px] w-5 text-center">⚙️</span> Store Settings</a>
            <a href="#" onclick="navigate('delivery'); return false;" class="nav-item" id="nav-delivery"><span
                    class="text-[17px] w-5 text-center">🚚</span> Delivery Zones</a>
        </div>

        <!-- Admin Profile -->
        <div style="border-top:1px solid var(--border);padding:14px;position:relative;">
            <div class="profile-dropdown" id="profileDropdown">
                <div class="px-3 py-2 mb-1">
                    <div class="font-black text-sm text-primary">Admin User</div>
                    <div class="text-xs text-secondary font-semibold">admin@arbeenstore.com</div>
                </div>
                <hr class="divider mb-1">
                <button onclick="navigate('settings'); closeProfileDropdown();"
                    class="w-full text-left px-3 py-2 rounded-lg text-sm font-bold text-primary hover-row transition-colors flex items-center gap-2">⚙️
                    Settings</button>
                <hr class="divider my-1">
                <form action="/logout" method="POST" class="m-0">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-3 py-2 rounded-lg text-sm font-bold text-red-500 hover:bg-red-50 transition-colors flex items-center gap-2">↩
                        Logout</button>
                </form>
            </div>
            <button onclick="toggleProfileDropdown()"
                class="flex items-center gap-2.5 w-full cursor-pointer bg-transparent border-none p-0 font-nunito">
                <div
                    class="w-9 h-9 rounded-full bg-[#0c7a3e] text-white flex items-center justify-center font-black text-sm shrink-0">
                    A</div>
                <div class="text-left flex-1">
                    <div class="font-extrabold text-[13px] text-primary">Admin</div>
                    <div class="text-[11px] text-secondary font-semibold">Super Admin</div>
                </div>
                <span class="text-xs text-secondary">⌄</span>
            </button>
        </div>
    </aside>

    <!-- ══ MAIN ══ -->
    <div class="ml-[240px] flex-1 flex flex-col min-h-screen">

        <!-- Topbar -->
        <div class="topbar h-16 px-8 flex items-center justify-between sticky top-0 z-40">
            <div id="breadcrumbText" class="text-[13px] text-secondary font-bold">Dashboard</div>
            <div class="flex items-center gap-3">
                <button onclick="toggleDarkMode()" id="dmBtn"
                    class="rounded-xl px-3.5 py-2 text-[13px] font-bold cursor-pointer font-nunito flex items-center gap-1.5 transition-colors border-theme border"
                    style="background:var(--input-bg);color:var(--text2);">🌙 Dark</button>
                <a href="/"
                    class="rounded-xl px-3.5 py-2 text-[13px] font-bold cursor-pointer font-nunito flex items-center gap-1.5 no-underline transition-colors border-theme border"
                    style="background:var(--input-bg);color:var(--text2);">🛍️ View Store</a>
                <button
                    class="rounded-xl px-3.5 py-2 text-[13px] font-bold cursor-pointer font-nunito border-theme border"
                    style="background:var(--input-bg);color:var(--text2);">🔔</button>
            </div>
        </div>

        <!-- ══════════ DASHBOARD ══════════ -->
        <div id="page-dashboard" class="page-section p-8">
            <div class="mb-7">
                <div class="text-2xl font-black text-primary">Dashboard</div>
                <div class="text-[13px] text-secondary font-semibold mt-1">Welcome back, Admin! Here's your store
                    overview.</div>
            </div>
            <div class="grid grid-cols-4 gap-5 mb-8">
                <div class="card p-5">
                    <div class="text-2xl mb-1">📦</div>
                    <div class="text-3xl font-black text-primary">{{ $allProduct->count() }}</div>
                    <div class="text-sm font-bold text-secondary mt-1">Total Products</div>
                    <div class="text-xs text-green-600 font-bold mt-2">+2 this week</div>
                </div>
                <div class="card p-5">
                    <div class="text-2xl mb-1">🛒</div>
                    <div class="text-3xl font-black text-primary">5</div>
                    <div class="text-sm font-bold text-secondary mt-1">Pending Orders</div>
                    <div class="text-xs text-orange-500 font-bold mt-2">Needs attention</div>
                </div>
                <div class="card p-5">
                    <div class="text-2xl mb-1">👥</div>
                    <div class="text-3xl font-black text-primary">142</div>
                    <div class="text-sm font-bold text-secondary mt-1">Customers</div>
                    <div class="text-xs text-green-600 font-bold mt-2">+12 this month</div>
                </div>
                <div class="card p-5">
                    <div class="text-2xl mb-1">💰</div>
                    <div class="text-3xl font-black text-primary">RS 24K</div>
                    <div class="text-sm font-bold text-secondary mt-1">Revenue Today</div>
                    <div class="text-xs text-green-600 font-bold mt-2">+18% vs yesterday</div>
                </div>
            </div>
            <div class="card p-6">
                <div class="font-black text-base text-primary mb-4">Quick Actions</div>
                <div class="flex gap-3 flex-wrap">
                    <button onclick="navigate('add-product')" class="btn-primary">➕ Add Product</button>
                    <button onclick="navigate('orders')" class="btn-ghost">🛒 View Orders</button>
                    <button onclick="navigate('products')" class="btn-ghost">📦 Manage Products</button>
                    <button onclick="navigate('banner')" class="btn-ghost">🖼️ Edit Banner</button>
                    <button onclick="navigate('customers')" class="btn-ghost">👥 View Customers</button>
                </div>
            </div>
        </div>

        <!-- ══════════ PRODUCTS ══════════ -->
        <div id="page-products" class="page-section p-8">
            <div class="flex items-center justify-between mb-7">
                <div>
                    <div class="text-2xl font-black text-primary">Products</div>
                    <div class="text-[13px] text-secondary font-semibold mt-1">Manage your store's product catalog
                    </div>
                </div>
                <button onclick="navigate('add-product')" class="btn-primary flex items-center gap-2">➕ Add New
                    Product</button>
            </div>
            <div class="card overflow-hidden">
                <div class="px-6 py-4 flex items-center justify-between"
                    style="border-bottom:1px solid var(--border);">
                    <div class="font-black text-sm text-primary">All Products <span
                            class="text-secondary font-semibold"
                            id="productCountLabel">{{ $allProduct->count() }}</span></div>
                    <input type="text" id="productSearch" placeholder="Search products…" oninput="filterTable()"
                        class="form-input w-56" style="padding:8px 14px;">
                </div>
                <div id="productsTableBody"></div>
                {{-- pagination  --}}
                <div id="paginationContainer" class="flex justify-center mt-4 py-4" style="border-top:1px solid var(--border);">
    {{ $products->links() }}
</div>

            </div>


        </div>

        <!-- ══════════ ORDERS ══════════ -->
        <div id="page-orders" class="page-section p-8">
            <div class="mb-7">
                <div class="text-2xl font-black text-primary">Orders</div>
                <div class="text-[13px] text-secondary font-semibold mt-1">Track and manage customer orders</div>
            </div>
            <div class="card overflow-hidden">
                <div class="px-6 py-4 font-black text-sm text-primary" style="border-bottom:1px solid var(--border);">
                    Recent Orders <span class="text-secondary font-semibold">(5 pending)</span></div>
                <div id="ordersBody"></div>
            </div>
        </div>

        <!-- ══════════ CUSTOMERS ══════════ -->
        <div id="page-customers" class="page-section p-8">
            <div class="mb-7">
                <div class="text-2xl font-black text-primary">Customers</div>
                <div class="text-[13px] text-secondary font-semibold mt-1">View and manage your customer base</div>
            </div>
            <div class="card overflow-hidden">
                <div class="px-6 py-4 font-black text-sm text-primary" style="border-bottom:1px solid var(--border);">
                    All Customers <span class="text-secondary font-semibold">(3)</span></div>
                <div id="customersBody"></div>
            </div>
        </div>

        <!-- ══════════ CATEGORIES ══════════ -->
        <div id="page-categories" class="page-section p-8">
            <div class="flex items-center justify-between mb-7">
                <div>
                    <div class="text-2xl font-black text-primary">Categories</div>
                    <div class="text-[13px] text-secondary font-semibold mt-1">Manage your product categories</div>
                </div>
                <button onclick="openCatModal()" class="btn-primary flex items-center gap-2">➕ Add Category</button>
            </div>
            <div class="grid grid-cols-3 gap-4" id="categoriesGrid"></div>
        </div>

        <!-- ══════════ BANNER & FEATURED ══════════ -->
        <div id="page-banner" class="page-section p-8">
            <div class="mb-7">
                <div class="text-2xl font-black text-primary">Banner & Featured Products</div>
                <div class="text-[13px] text-secondary font-semibold mt-1">Manage homepage banners and featured product
                    highlights</div>
            </div>
            <div class="card overflow-hidden mb-6">
                <div class="card-header">
                    <div class="card-header-icon">🖼️</div>
                    <div>
                        <div class="font-black text-[15px] text-primary">Homepage Banners</div>
                        <div class="text-xs text-secondary font-semibold mt-0.5">Upload up to 5 rotating banners for
                            the homepage slider</div>
                    </div>
                    <button onclick="document.getElementById('bannerFileInput').click()"
                        class="btn-primary ml-auto text-sm">+ Upload Banner</button>
                    <input type="file" id="bannerFileInput" accept="image/*" class="hidden"
                        onchange="addBanner(event)">
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-3 gap-4" id="bannersGrid">
                        <div class="relative rounded-xl overflow-hidden group"
                            style="background:linear-gradient(135deg,#0c7a3e,#a8d5bc);height:140px;">
                            <div
                                class="absolute inset-0 flex flex-col items-center justify-center text-white p-4 text-center">
                                <div class="font-black text-lg">🌿 Fresh Today</div>
                                <div class="text-sm font-semibold opacity-80">Farm to table</div>
                            </div>
                            <div
                                class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button onclick="this.closest('.relative').remove()"
                                    class="bg-white/90 border-none rounded-lg w-7 h-7 text-sm cursor-pointer">🗑️</button>
                            </div>
                            <div
                                class="absolute bottom-2 left-2 bg-green-600 text-white text-[10px] font-black px-1.5 py-0.5 rounded">
                                Active</div>
                        </div>
                        <div class="relative rounded-xl overflow-hidden group"
                            style="background:linear-gradient(135deg,#e65100,#ffcc02);height:140px;">
                            <div
                                class="absolute inset-0 flex flex-col items-center justify-center text-white p-4 text-center">
                                <div class="font-black text-lg">🔥 Weekend Deal</div>
                                <div class="text-sm font-semibold opacity-80">Up to 30% OFF</div>
                            </div>
                            <div
                                class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button onclick="this.closest('.relative').remove()"
                                    class="bg-white/90 border-none rounded-lg w-7 h-7 text-sm cursor-pointer">🗑️</button>
                            </div>
                            <div
                                class="absolute bottom-2 left-2 bg-green-600 text-white text-[10px] font-black px-1.5 py-0.5 rounded">
                                Active</div>
                        </div>
                        <div class="banner-dropzone flex flex-col items-center justify-center gap-2 text-secondary"
                            onclick="document.getElementById('bannerFileInput').click()" style="height:140px;">
                            <div class="text-3xl">📸</div>
                            <div class="font-bold text-sm">Add Banner</div>
                            <div class="text-xs">JPG, PNG up to 10MB</div>
                        </div>
                    </div>
                    <div class="mt-5 p-4 rounded-xl flex items-center gap-6 flex-wrap"
                        style="background:var(--input-bg);border:1px solid var(--border);">
                        <div>
                            <label class="block text-xs font-extrabold text-secondary mb-1">Slide Interval</label>
                            <select class="form-input" style="width:150px;">
                                <option>3 seconds</option>
                                <option selected>5 seconds</option>
                                <option>8 seconds</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-extrabold text-secondary mb-1">Transition Effect</label>
                            <select class="form-input" style="width:150px;">
                                <option selected>Fade</option>
                                <option>Slide</option>
                                <option>Zoom</option>
                            </select>
                        </div>
                        <div class="flex items-center gap-3 pt-4">
                            <label class="switch"><input type="checkbox" checked><span class="slider"></span></label>
                            <span class="text-sm font-bold text-primary">Auto-play enabled</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card overflow-hidden">
                <div class="card-header">
                    <div class="card-header-icon">⭐</div>
                    <div>
                        <div class="font-black text-[15px] text-primary">Featured Products</div>
                        <div class="text-xs text-secondary font-semibold mt-0.5">Highlight up to 8 products on the
                            homepage</div>
                    </div>
                    <div class="ml-auto text-xs font-bold text-secondary" id="featuredCount">0 / 8 selected</div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-4 gap-3" id="featuredGrid"></div>
                    <div class="mt-4 p-3 rounded-xl text-xs font-bold text-secondary flex items-center gap-2"
                        style="background:var(--input-bg);border:1px solid var(--border);">
                        💡 Tip: Featured products appear highlighted on the homepage. Choose your best-sellers and new
                        arrivals.
                    </div>
                </div>
            </div>
        </div>

        <!-- ══════════ DISCOUNTS ══════════ -->
        <div id="page-discounts" class="page-section p-8">
            <div class="flex items-center justify-between mb-7">
                <div>
                    <div class="text-2xl font-black text-primary">Discounts</div>
                    <div class="text-[13px] text-secondary font-semibold mt-1">Create and manage discount codes</div>
                </div>
                <button onclick="openDiscountModal()" class="btn-primary">+ Create Discount</button>
            </div>
            <div class="card overflow-hidden">
                <div id="discountsBody"></div>
            </div>
        </div>

        <!-- ══════════ SETTINGS ══════════ -->
        <div id="page-settings" class="page-section p-8">
            <div class="mb-7">
                <div class="text-2xl font-black text-primary">Store Settings</div>
                <div class="text-[13px] text-secondary font-semibold mt-1">Configure your store preferences</div>
            </div>
            <div class="grid gap-6" style="grid-template-columns:1fr 1fr;align-items:start;">
                <!-- General -->
                <div class="card overflow-hidden">
                    <div class="card-header">
                        <div class="card-header-icon">🏪</div>
                        <div>
                            <div class="font-black text-[15px] text-primary">General Info</div>
                        </div>
                    </div>
                    <div class="p-6 flex flex-col gap-4">
                        <div><label class="block text-xs font-extrabold text-secondary mb-1.5">Store Name</label><input
                                type="text" value="ArbeenStore" class="form-input"></div>
                        <div><label class="block text-xs font-extrabold text-secondary mb-1.5">Store
                                Tagline</label><input type="text" value="Fresh groceries, delivered fast"
                                class="form-input"></div>
                        <div><label class="block text-xs font-extrabold text-secondary mb-1.5">Store
                                Email</label><input type="email" value="hello@arbeenstore.com" class="form-input">
                        </div>
                        <div><label class="block text-xs font-extrabold text-secondary mb-1.5">Phone
                                Number</label><input type="tel" value="+977-9801234567" class="form-input"></div>
                        <div><label class="block text-xs font-extrabold text-secondary mb-1.5">Location /
                                Address</label><input type="text" value="Thamel, Kathmandu, Nepal"
                                class="form-input"></div>
                        <button class="btn-primary" onclick="showToast('✅ General info saved!')">Save Changes</button>
                    </div>
                </div>
                <!-- Appearance -->
                <div class="card overflow-hidden">
                    <div class="card-header">
                        <div class="card-header-icon">🎨</div>
                        <div>
                            <div class="font-black text-[15px] text-primary">Appearance</div>
                        </div>
                    </div>
                    <div class="p-6 flex flex-col gap-4">
                        <div><label class="block text-xs font-extrabold text-secondary mb-1.5">Brand Color</label>
                            <div class="flex items-center gap-3"><input type="color" value="#0c7a3e"
                                    class="w-10 h-10 rounded-xl border-theme border cursor-pointer"
                                    style="padding:2px;"><input type="text" value="#0c7a3e"
                                    class="form-input flex-1"></div>
                        </div>
                        <div><label class="block text-xs font-extrabold text-secondary mb-1.5">Store Logo</label>
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-12 h-12 rounded-xl bg-[#0c7a3e] flex items-center justify-center text-2xl shrink-0">
                                    🌿</div><button onclick="showToast('📸 Logo upload coming soon')"
                                    class="btn-ghost text-sm">Upload Logo</button>
                            </div>
                        </div>
                        <div><label class="block text-xs font-extrabold text-secondary mb-2">Default Theme</label>
                            <div class="flex gap-3">
                                <label class="flex items-center gap-2 cursor-pointer"><input type="radio"
                                        name="theme_pref" value="light" checked class="accent-[#0c7a3e]"><span
                                        class="text-sm font-bold text-primary">☀️ Light</span></label>
                                <label class="flex items-center gap-2 cursor-pointer"><input type="radio"
                                        name="theme_pref" value="dark" class="accent-[#0c7a3e]"><span
                                        class="text-sm font-bold text-primary">🌙 Dark</span></label>
                            </div>
                        </div>
                        <button class="btn-primary" onclick="showToast('✅ Appearance saved!')">Save Changes</button>
                    </div>
                </div>
                <!-- Payment -->
                <div class="card overflow-hidden">
                    <div class="card-header">
                        <div class="card-header-icon">💳</div>
                        <div>
                            <div class="font-black text-[15px] text-primary">Payment & Currency</div>
                        </div>
                    </div>
                    <div class="p-6 flex flex-col gap-4">
                        <div><label class="block text-xs font-extrabold text-secondary mb-1.5">Currency</label>
                            <select class="form-input">
                                <option selected>NPR — Nepalese Rupee (RS)</option>
                                <option>USD — US Dollar ($)</option>
                                <option>INR — Indian Rupee (₹)</option>
                            </select>
                        </div>
                        <div class="text-xs font-extrabold text-secondary">Accepted Payments</div>
                        <div class="flex flex-col gap-2">
                            <label class="flex items-center justify-between"><span
                                    class="text-sm font-bold text-primary">💵 Cash on Delivery</span><label
                                    class="switch"><input type="checkbox" checked><span
                                        class="slider"></span></label></label>
                            <label class="flex items-center justify-between"><span
                                    class="text-sm font-bold text-primary">📱 eSewa</span><label class="switch"><input
                                        type="checkbox" checked><span class="slider"></span></label></label>
                            <label class="flex items-center justify-between"><span
                                    class="text-sm font-bold text-primary">📱 Khalti</span><label
                                    class="switch"><input type="checkbox" checked><span
                                        class="slider"></span></label></label>
                            <label class="flex items-center justify-between"><span
                                    class="text-sm font-bold text-primary">🏦 Bank Transfer</span><label
                                    class="switch"><input type="checkbox"><span
                                        class="slider"></span></label></label>
                        </div>
                        <button class="btn-primary" onclick="showToast('✅ Payment settings saved!')">Save
                            Changes</button>
                    </div>
                </div>
                <!-- Notifications -->
                <div class="card overflow-hidden">
                    <div class="card-header">
                        <div class="card-header-icon">🔔</div>
                        <div>
                            <div class="font-black text-[15px] text-primary">Notifications</div>
                        </div>
                    </div>
                    <div class="p-6 flex flex-col gap-3">
                        <label class="flex items-center justify-between"><span
                                class="text-sm font-bold text-primary">New order email alerts</span><label
                                class="switch"><input type="checkbox" checked><span
                                    class="slider"></span></label></label>
                        <label class="flex items-center justify-between"><span
                                class="text-sm font-bold text-primary">Low stock alerts</span><label
                                class="switch"><input type="checkbox" checked><span
                                    class="slider"></span></label></label>
                        <label class="flex items-center justify-between"><span
                                class="text-sm font-bold text-primary">Weekly sales report</span><label
                                class="switch"><input type="checkbox" checked><span
                                    class="slider"></span></label></label>
                        <div><label class="block text-xs font-extrabold text-secondary mb-1.5">Notification
                                Email</label><input type="email" value="admin@arbeenstore.com" class="form-input">
                        </div>
                        <button class="btn-primary" onclick="showToast('✅ Notification settings saved!')">Save
                            Changes</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ══════════ DELIVERY ══════════ -->
        <div id="page-delivery" class="page-section p-8">
            <div class="flex items-center justify-between mb-7">
                <div>
                    <div class="text-2xl font-black text-primary">Delivery Zones</div>
                    <div class="text-[13px] text-secondary font-semibold mt-1">Configure delivery areas, fees, and time
                        slots</div>
                </div>
                <button onclick="openDeliveryModal()" class="btn-primary">➕ Add Zone</button>
            </div>
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="card p-4 text-center">
                    <div class="text-2xl font-black text-[#0c7a3e]">3</div>
                    <div class="text-xs font-bold text-secondary mt-1">Active Zones</div>
                </div>
                <div class="card p-4 text-center">
                    <div class="text-2xl font-black text-primary">RS 50</div>
                    <div class="text-xs font-bold text-secondary mt-1">Avg Delivery Fee</div>
                </div>
                <div class="card p-4 text-center">
                    <div class="text-2xl font-black text-primary">RS 500</div>
                    <div class="text-xs font-bold text-secondary mt-1">Free Delivery Above</div>
                </div>
            </div>
            <div class="card overflow-hidden mb-6">
                <div class="px-6 py-4 font-black text-sm text-primary" style="border-bottom:1px solid var(--border);">
                    Active Delivery Zones</div>
                <div id="deliveryZonesBody"></div>
            </div>
            <div class="card overflow-hidden">
                <div class="card-header">
                    <div class="card-header-icon">⚙️</div>
                    <div>
                        <div class="font-black text-[15px] text-primary">Delivery Settings</div>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-2 gap-4">
                    <div><label class="block text-xs font-extrabold text-secondary mb-1.5">Minimum Order Amount</label>
                        <div class="relative">
                            <div class="input-prefix">RS</div><input type="number" value="100"
                                class="form-input" style="padding-left:52px;">
                        </div>
                    </div>
                    <div><label class="block text-xs font-extrabold text-secondary mb-1.5">Free Delivery Above</label>
                        <div class="relative">
                            <div class="input-prefix">RS</div><input type="number" value="500"
                                class="form-input" style="padding-left:52px;">
                        </div>
                    </div>
                    <div><label class="block text-xs font-extrabold text-secondary mb-1.5">Estimated Delivery
                            Time</label>
                        <select class="form-input">
                            <option>30–45 minutes</option>
                            <option selected>45–60 minutes</option>
                            <option>1–2 hours</option>
                        </select>
                    </div>
                    <div><label class="block text-xs font-extrabold text-secondary mb-1.5">Max Orders Per
                            Slot</label><input type="number" value="20" class="form-input"></div>
                    <div class="col-span-2"><button class="btn-primary"
                            onclick="showToast('✅ Delivery settings saved!')">Save Settings</button></div>
                </div>
            </div>
        </div>

        <!-- ══════════ ADD PRODUCT ══════════ -->
        <form id="productForm" action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="page-add-product" class="page-section flex-1 p-8 pb-12">
                <div class="flex items-center justify-between mb-7">
                    <div>
                        <div class="text-2xl font-black text-primary">Add New Product</div>
                        <div class="text-[13px] text-secondary font-semibold mt-1">Fill in the details below to list a
                            new product</div>
                    </div>
                    <div class="flex gap-2.5">
                        <button type="button" onclick="resetForm()" class="btn-ghost">✕ Discard</button>
                        <button type="button" onclick="submitForm()" class="btn-primary flex items-center gap-2">✓
                            Publish Product</button>
                    </div>
                </div>
                <div class="grid gap-6" style="grid-template-columns:1fr 360px;align-items:start;">
                    <div class="flex flex-col gap-5">
                        <!-- Basic Info -->
                        <div class="card overflow-hidden">
                            <div class="card-header">
                                <div class="card-header-icon">📝</div>
                                <div>
                                    <div class="font-black text-[15px] text-primary">Basic Information</div>
                                    <div class="text-xs text-secondary font-semibold mt-0.5">Name, description and
                                        category</div>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="mb-5">
                                    <label class="block text-[13px] font-extrabold text-primary mb-1.5">Product Name
                                        <span class="text-red-500">*</span></label>
                                    <input name="name" type="text" id="productName"
                                        placeholder="e.g. Fresh Organic Tomatoes" oninput="updatePreview()"
                                        maxlength="60" class="form-input">
                                    <div class="text-[11px] text-secondary font-bold text-right mt-1"
                                        id="nameCounter">0 / 60</div>
                                    <div class="text-[11px] text-red-500 font-bold mt-1 hidden" id="nameError">Product
                                        name is required</div>
                                </div>
                                <div class="mb-5">
                                    <label class="block text-[13px] font-extrabold text-primary mb-1.5">Description
                                        <span
                                            class="text-[11px] font-semibold text-secondary ml-1.5">Optional</span></label>
                                    <textarea name="description" id="productDesc" placeholder="Describe the product…" maxlength="300"
                                        oninput="updateDescCounter()" rows="3" class="form-input" style="resize:vertical;"></textarea>
                                    <div class="text-[11px] text-secondary font-bold text-right mt-1"
                                        id="descCounter">0 / 300</div>
                                </div>
                                <form action="action="{{ route('category') }}>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[13px] font-extrabold text-primary mb-1.5">Category
                                            <span class="text-red-500">*</span></label>
                                        <select name="category" id="productCategory" onchange="updatePreview()"
                                            class="form-input">
                                            <option value="">Select category…</option>
                                            <option value="Vegetables">🥦 Vegetables</option>
                                            <option value="Fruits">🍎 Fruits</option>
                                            <option value="Dairy">🥛 Dairy</option>
                                            <option value="Bakery">🍞 Bakery</option>
                                            <option value="Beverages">🧃 Beverages</option>
                                            <option value="Snacks">🍫 Snacks</option>
                                            <option value="Meat">🍗 Meat &amp; Fish</option>
                                            <option value="Personal Care">🧴 Personal Care</option>
                                        </select>
                                        <div class="text-[11px] text-red-500 font-bold mt-1 hidden" id="catError">
                                            Please select a category</div>
                                    </div>
                                    <div>
                                        <label class="block text-[13px] font-extrabold text-primary mb-1.5">Unit /
                                            Weight <span class="text-red-500">*</span></label>
                                        <input type="text" name="unit" id="productUnit"
                                            placeholder="e.g. 500g, 1L, 6 pcs" oninput="updatePreview()"
                                            class="form-input">
                                        <div class="text-[11px] text-red-500 font-bold mt-1 hidden" id="unitError">
                                            Unit is required</div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>

                        <!-- Pricing -->
                        <div class="card overflow-hidden">
                            <div class="card-header">
                                <div class="card-header-icon">💰</div>
                                <div>
                                    <div class="font-black text-[15px] text-primary">Pricing</div>
                                    <div class="text-xs text-secondary font-semibold mt-0.5">Set the selling and
                                        compare-at price</div>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-2 gap-4 mb-2">
                                    <div>
                                        <label class="block text-[13px] font-extrabold text-primary mb-1.5">Selling
                                            Price <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <div class="input-prefix">RS</div>
                                            <input type="number" name="price" id="productPrice" placeholder="0"
                                                min="0" oninput="updatePreview()" class="form-input"
                                                style="padding-left:52px;">
                                        </div>
                                        <div class="text-[11px] text-red-500 font-bold mt-1 hidden" id="priceError">
                                            Price is required</div>
                                    </div>
                                    <div>
                                        <label class="block text-[13px] font-extrabold text-primary mb-1.5">Compare-at
                                            Price <span
                                                class="text-[11px] font-semibold text-secondary ml-1">Optional</span></label>
                                        <div class="relative">
                                            <div class="input-prefix">RS</div>
                                            <input type="number" id="comparePrice" placeholder="0" min="0"
                                                oninput="updatePreview()" class="form-input"
                                                style="padding-left:52px;">
                                        </div>
                                    </div>
                                </div>
                                <div id="discountBadge" class="hidden mt-1"><span
                                        style="background:#e8f5e9;color:#2e7d32;"
                                        class="text-xs font-extrabold px-2.5 py-1 rounded-lg">🏷️ <span
                                            id="discountPct"></span>% OFF shown to customers</span></div>
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div class="card overflow-hidden">
                            <div class="card-header">
                                <div class="card-header-icon">🖼️</div>
                                <div>
                                    <div class="font-black text-[15px] text-primary">Product Image</div>
                                    <div class="text-xs text-secondary font-semibold mt-0.5">JPG, PNG or WEBP —
                                        recommended 800×800px</div>
                                </div>
                            </div>
                            <div class="p-6">
                                <div id="uploadZone"
                                    class="upload-zone border-2 border-dashed rounded-2xl p-7 text-center relative"
                                    style="border-color:var(--border);background:var(--input-bg);"
                                    onclick="document.getElementById('imageInput').click()">
                                    <input type="file" name="image" id="imageInput" accept="image/*"
                                        onchange="handleImageUpload(event)" class="hidden">
                                    <div id="uploadDefault">
                                        <div class="text-4xl mb-2.5">📸</div>
                                        <div class="font-extrabold text-sm text-primary mb-1">Click to upload product
                                            image</div>
                                        <div class="text-xs text-secondary font-semibold">or drag and drop here</div>
                                        <div class="mt-3 text-[11px] text-secondary font-bold">Max size: 10MB</div>
                                    </div>
                                    <div id="uploadPreviewWrap" class="hidden relative">
                                        <img id="uploadPreviewImg"
                                            class="w-full h-[220px] object-cover rounded-xl block" src=""
                                            alt="Preview">
                                        <div
                                            class="upload-preview-overlay absolute inset-0 bg-black/45 rounded-xl items-center justify-center text-white font-extrabold text-[13px] gap-1.5">
                                            📷 Change Image</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN -->
                    <div class="flex flex-col gap-5">
                        <!-- Live Preview -->
                        <div class="card overflow-hidden">
                            <div class="card-header">
                                <div class="card-header-icon">👁️</div>
                                <div>
                                    <div class="font-black text-[15px] text-primary">Live Preview</div>
                                    <div class="text-xs text-secondary font-semibold mt-0.5">How it looks in the store
                                    </div>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="border-theme border rounded-2xl overflow-hidden max-w-[200px] mx-auto">
                                    <div class="h-[130px] flex items-center justify-center relative overflow-hidden"
                                        style="background:#e8f5ee;">
                                        <img id="previewImg" src="" alt=""
                                            class="w-full h-full object-cover hidden">
                                        <div class="text-[44px]" id="previewPlaceholder">🛒</div>
                                        <div id="previewTag"
                                            class="hidden absolute top-2 left-2 text-[9px] font-black rounded px-1.5 py-0.5">
                                        </div>
                                    </div>
                                    <div class="p-2.5 pb-3">
                                        <div id="previewName"
                                            class="font-extrabold text-[13px] text-primary mb-0.5 min-h-[18px]">Product
                                            name</div>
                                        <div id="previewUnit" class="text-[11px] text-secondary font-semibold mb-2">
                                            Unit</div>
                                        <div class="flex items-center justify-between">
                                            <div id="previewPrice" class="font-black text-[15px] text-primary">RS —
                                            </div>
                                            <button
                                                class="bg-[#0c7a3e] text-white border-none rounded-lg px-3 py-1 text-[11px] font-black font-nunito cursor-default">ADD</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tag -->
                        <div class="card overflow-hidden">
                            <div class="card-header">
                                <div class="card-header-icon">🏷️</div>
                                <div>
                                    <div class="font-black text-[15px] text-primary">Product Tag</div>
                                </div>
                            </div>
                            <div class="p-5">
                                <div class="flex flex-wrap gap-2">
                                    <input type="radio" name="tag" id="tagNone" value=""
                                        class="tag-option" checked onchange="updateTag()">
                                    <label for="tagNone" class="tag-label">No Tag</label>
                                    <input type="radio" name="tag" id="tagFresh" value="Fresh"
                                        class="tag-option" onchange="updateTag()">
                                    <label for="tagFresh" class="tag-label"
                                        style="border-color:#c8e6c9;color:#2e7d32;">🌿 Fresh</label>
                                    <input type="radio" name="tag" id="tagNew" value="New"
                                        class="tag-option" onchange="updateTag()">
                                    <label for="tagNew" class="tag-label"
                                        style="border-color:#bbdefb;color:#0d47a1;">✨ New</label>
                                    <input type="radio" name="tag" id="tagOrganic" value="Organic"
                                        class="tag-option" onchange="updateTag()">
                                    <label for="tagOrganic" class="tag-label"
                                        style="border-color:#e1bee7;color:#6a1b9a;">🌱 Organic</label>
                                    <input type="radio" name="tag" id="tagBest" value="Best Seller"
                                        class="tag-option" onchange="updateTag()">
                                    <label for="tagBest" class="tag-label"
                                        style="border-color:#ffe0b2;color:#e65100;">🔥 Best Seller</label>
                                    <input type="radio" name="tag" id="tagPopular" value="Popular"
                                        class="tag-option" onchange="updateTag()">
                                    <label for="tagPopular" class="tag-label"
                                        style="border-color:#fce4ec;color:#880e4f;">⭐ Popular</label>
                                    <input type="radio" name="tag" id="tagHealthy" value="Healthy"
                                        class="tag-option" onchange="updateTag()">
                                    <label for="tagHealthy" class="tag-label"
                                        style="border-color:#b2dfdb;color:#004d40;">💚 Healthy</label>
                                </div>
                            </div>
                        </div>

                        <!-- Inventory -->
                        <div class="card overflow-hidden">
                            <div class="card-header">
                                <div class="card-header-icon">📦</div>
                                <div>
                                    <div class="font-black text-[15px] text-primary">Inventory</div>
                                    <div class="text-xs text-secondary font-semibold mt-0.5">Stock quantity</div>
                                </div>
                            </div>
                            <div class="p-6">
                                <label class="block text-[13px] font-extrabold text-primary mb-1.5">Stock Quantity
                                    <span class="text-red-500">*</span></label>
                                <input name="stock_quantity" type="number" id="stockQty" placeholder="0"
                                    min="0" oninput="updateStock()" class="form-input">
                                <div id="stockDisplay"
                                    class="hidden items-center justify-between mt-2.5 px-4 py-3 rounded-xl"
                                    style="background:#e8f5ee;">
                                    <span class="text-xs font-bold text-secondary">Units available</span>
                                    <span id="stockVal" class="text-xl font-black text-[#0c7a3e]">0</span>
                                </div>
                            </div>
                        </div>

                        <button type="button" onclick="submitForm()"
                            class="btn-primary w-full py-3.5 text-[15px] flex items-center justify-center gap-2">✓
                            Publish Product</button>
                        <button type="button" onclick="resetForm()" class="btn-ghost w-full py-3 text-[13px]">✕
                            Discard Changes</button>
                    </div>
                </div>
            </div>
        </form>

    </div><!-- end main -->

    <!-- ══ EDIT PRODUCT MODAL ══ -->
    <div id="editModal" class="modal-backdrop">
        <div class="modal-box p-0 w-[580px]">
            <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid var(--border);">
                <div class="font-black text-lg text-primary">✏️ Edit Product</div>
                <button onclick="closeEditModal()"
                    class="rounded-full w-8 h-8 text-lg cursor-pointer font-nunito text-primary border-none"
                    style="background:var(--input-bg);">✕</button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="p-6 flex flex-col gap-4">
                    <div>
                        <label class="block text-xs font-extrabold text-secondary mb-1.5">Product Name <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" id="edit_name" maxlength="60" class="form-input">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-extrabold text-secondary mb-1.5">Price (RS) <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="price" id="edit_price" min="0" class="form-input">
                        </div>
                        <div>
                            <label class="block text-xs font-extrabold text-secondary mb-1.5">Stock Quantity</label>
                            <input type="number" name="stock_quantity" id="edit_stock" min="0"
                                class="form-input">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-extrabold text-secondary mb-1.5">Category <span
                                    class="text-red-500">*</span></label>
                            <select name="category" id="edit_category" class="form-input">
                                <option value="Vegetables">🥦 Vegetables</option>
                                <option value="Fruits">🍎 Fruits</option>
                                <option value="Dairy">🥛 Dairy</option>
                                <option value="Bakery">🍞 Bakery</option>
                                <option value="Beverages">🧃 Beverages</option>
                                <option value="Snacks">🍫 Snacks</option>
                                <option value="Meat">🍗 Meat &amp; Fish</option>
                                <option value="Personal Care">🧴 Personal Care</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-extrabold text-secondary mb-1.5">Unit / Weight <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="unit" id="edit_unit" class="form-input">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-secondary mb-1.5">Tag</label>
                        <select name="tag" id="edit_tag" class="form-input">
                            <option value="">No Tag</option>
                            <option value="Fresh">🌿 Fresh</option>
                            <option value="New">✨ New</option>
                            <option value="Organic">🌱 Organic</option>
                            <option value="Best Seller">🔥 Best Seller</option>
                            <option value="Popular">⭐ Popular</option>
                            <option value="Healthy">💚 Healthy</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-secondary mb-1.5">Description</label>
                        <textarea name="description" id="edit_description" rows="3" class="form-input" style="resize:vertical;"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-secondary mb-1.5">Product Image <span
                                class="text-[11px] font-semibold text-secondary ml-1">Optional — leave blank to keep
                                current</span></label>
                        <div id="editCurrentImg" class="mb-2 hidden">
                            <img id="editImgPreview" src="" alt="Current"
                                class="h-20 w-20 object-cover rounded-xl border-theme border">
                        </div>
                        <input type="file" name="image" accept="image/*" class="form-input"
                            style="padding:8px;">
                    </div>
                </div>
                <div class="px-6 pb-6 flex gap-3">
                    <button type="button" onclick="closeEditModal()" class="btn-ghost flex-1">Cancel</button>
                    <button type="submit" class="btn-primary flex-1">✓ Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ══ DELETE MODAL ══ -->
    <div id="deleteModal" class="modal-backdrop">
        <div class="modal-box p-6 w-[400px] text-center">
            <div class="text-5xl mb-3">🗑️</div>
            <div class="font-black text-lg text-primary mb-1">Delete Product?</div>
            <div class="text-sm text-secondary mb-6">Are you sure you want to delete <strong id="deleteProductName"
                    class="text-primary"></strong>? This cannot be undone.</div>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()" class="btn-ghost flex-1">Cancel</button>
                <form id="deleteForm" method="POST" class="flex-1 m-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full bg-red-500 hover:bg-red-600 text-white border-none rounded-xl py-2.5 font-extrabold text-sm cursor-pointer font-nunito transition-colors">Yes,
                        Delete</button>
                </form>
            </div>
        </div>
    </div>

    <!-- ══ ORDER DETAIL MODAL ══ -->
    <div id="orderModal" class="modal-backdrop">
        <div class="modal-box p-0 w-[500px]">
            <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid var(--border);">
                <div class="font-black text-lg text-primary">🛒 Order Details</div>
                <button onclick="document.getElementById('orderModal').classList.remove('open')"
                    class="rounded-full w-8 h-8 text-lg cursor-pointer font-nunito text-primary border-none"
                    style="background:var(--input-bg);">✕</button>
            </div>
            <div class="p-6 flex flex-col gap-3" id="orderDetailBody"></div>
        </div>
    </div>

    <!-- ══ CUSTOMER DETAIL MODAL ══ -->
    <div id="customerModal" class="modal-backdrop">
        <div class="modal-box p-0 w-[480px]">
            <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid var(--border);">
                <div class="font-black text-lg text-primary">👤 Customer Details</div>
                <button onclick="document.getElementById('customerModal').classList.remove('open')"
                    class="rounded-full w-8 h-8 text-lg cursor-pointer font-nunito text-primary border-none"
                    style="background:var(--input-bg);">✕</button>
            </div>
            <div class="p-6" id="customerDetailBody"></div>
        </div>
    </div>

    <!-- ══ CATEGORY MODAL ══ -->
    <div id="catModal" class="modal-backdrop">
        <div class="modal-box p-0 w-[440px]">
            <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid var(--border);">
                <div class="font-black text-lg text-primary" id="catModalTitle">➕ Add Category</div>
                <button onclick="closeCatModal()"
                    class="rounded-full w-8 h-8 text-lg cursor-pointer font-nunito text-primary border-none"
                    style="background:var(--input-bg);">✕</button>
            </div>
            <div class="p-6 flex flex-col gap-4">
                <div><label class="block text-xs font-extrabold text-secondary mb-1.5">Category Name <span
                            class="text-red-500">*</span></label><input type="text" id="catName"
                        placeholder="e.g. Frozen Foods" class="form-input"></div>
                <div><label class="block text-xs font-extrabold text-secondary mb-1.5">Emoji Icon</label><input
                        type="text" id="catEmoji" placeholder="e.g. 🧊" class="form-input"
                        style="font-size:20px;"></div>
                <div><label class="block text-xs font-extrabold text-secondary mb-1.5">Description <span
                            class="text-[11px] font-semibold text-secondary">Optional</span></label>
                    <textarea id="catDesc" rows="2" placeholder="Short description…" class="form-input" style="resize:none;"></textarea>
                </div>
                <div class="flex items-center gap-3"><label class="switch"><input type="checkbox" id="catVisible"
                            checked><span class="slider"></span></label><span
                        class="text-sm font-bold text-primary">Visible in store</span></div>
            </div>
            <div class="px-6 pb-6 flex gap-3">
                <button onclick="closeCatModal()" class="btn-ghost flex-1">Cancel</button>
                <button onclick="saveCat()" class="btn-primary flex-1">✓ Save Category</button>
            </div>
        </div>
    </div>

    <!-- ══ DELIVERY ZONE MODAL ══ -->
    <div id="deliveryModal" class="modal-backdrop">
        <div class="modal-box p-0 w-[480px]">
            <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid var(--border);">
                <div class="font-black text-lg text-primary">📍 Add Delivery Zone</div>
                <button onclick="closeDeliveryModal()"
                    class="rounded-full w-8 h-8 text-lg cursor-pointer font-nunito text-primary border-none"
                    style="background:var(--input-bg);">✕</button>
            </div>
            <div class="p-6 flex flex-col gap-4">
                <div><label class="block text-xs font-extrabold text-secondary mb-1.5">Zone Name <span
                            class="text-red-500">*</span></label><input type="text" id="dz_name"
                        placeholder="e.g. Kirtipur" class="form-input"></div>
                <div><label class="block text-xs font-extrabold text-secondary mb-1.5">Coverage Areas</label>
                    <textarea id="dz_areas" rows="2" placeholder="e.g. Kirtipur, Chobhar, Balambu" class="form-input"
                        style="resize:none;"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-xs font-extrabold text-secondary mb-1.5">Delivery Fee
                            (RS)</label><input type="number" id="dz_fee" placeholder="0 for free" min="0"
                            class="form-input"></div>
                    <div><label class="block text-xs font-extrabold text-secondary mb-1.5">Est. Delivery Time</label>
                        <select id="dz_time" class="form-input">
                            <option>30–45 min</option>
                            <option selected>45–60 min</option>
                            <option>1–2 hours</option>
                            <option>Same day</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center gap-3"><label class="switch"><input type="checkbox" id="dz_active"
                            checked><span class="slider"></span></label><span
                        class="text-sm font-bold text-primary">Zone is active</span></div>
            </div>
            <div class="px-6 pb-6 flex gap-3">
                <button onclick="closeDeliveryModal()" class="btn-ghost flex-1">Cancel</button>
                <button onclick="saveDeliveryZone()" class="btn-primary flex-1">✓ Save Zone</button>
            </div>
        </div>
    </div>

    <!-- ══ DISCOUNT MODAL ══ -->
    <div id="discountModal" class="modal-backdrop">
        <div class="modal-box p-0 w-[440px]">
            <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid var(--border);">
                <div class="font-black text-lg text-primary">🎟️ Create Discount</div>
                <button onclick="closeDiscountModal()"
                    class="rounded-full w-8 h-8 text-lg cursor-pointer font-nunito text-primary border-none"
                    style="background:var(--input-bg);">✕</button>
            </div>
            <div class="p-6 flex flex-col gap-4">
                <div><label class="block text-xs font-extrabold text-secondary mb-1.5">Discount Code <span
                            class="text-red-500">*</span></label><input type="text" id="dc_code"
                        placeholder="e.g. SAVE20" class="form-input" style="text-transform:uppercase;"></div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-xs font-extrabold text-secondary mb-1.5">Type</label>
                        <select id="dc_type" class="form-input">
                            <option value="percent">Percentage (%)</option>
                            <option value="flat">Flat Amount (RS)</option>
                        </select>
                    </div>
                    <div><label class="block text-xs font-extrabold text-secondary mb-1.5">Value</label><input
                            type="number" id="dc_value" placeholder="20" min="0" class="form-input"></div>
                </div>
                <div><label class="block text-xs font-extrabold text-secondary mb-1.5">Minimum Order (RS)</label><input
                        type="number" id="dc_min" placeholder="0" min="0" class="form-input"></div>
                <div><label class="block text-xs font-extrabold text-secondary mb-1.5">Expiry Date</label><input
                        type="date" id="dc_expiry" class="form-input"></div>
            </div>
            <div class="px-6 pb-6 flex gap-3">
                <button onclick="closeDiscountModal()" class="btn-ghost flex-1">Cancel</button>
                <button onclick="saveDiscount()" class="btn-primary flex-1">✓ Create Code</button>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div id="toast"
        class="toast fixed bottom-8 right-8 px-5 py-3.5 rounded-2xl text-sm font-bold flex items-center gap-2.5 shadow-2xl z-[999]"
        style="background:#1a1a2e;color:#fff;">
        <span id="toastMsg">Done!</span>
    </div>


    <script>
        // ══ REAL PRODUCTS FROM LARAVEL (dynamic) ══
       
        // product ajax 
        let products = @json($products->items());
let currentPage = 1;

function fetchProducts(page = 1) {
    fetch(`/admin?page=${page}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        products = data.products;
        renderProducts(products);
        document.getElementById('paginationContainer').innerHTML = data.pagination;
        bindPaginationLinks();
    });
}

function bindPaginationLinks() {
    document.querySelectorAll('#paginationContainer a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = new URL(this.href);
            const page = url.searchParams.get('page') || 1;
            fetchProducts(page);
        });
    });
}


        // ══ STATIC DATA ══
        const orders = [{
                id: 'ORD-001',
                customer: 'Ram Sharma',
                email: 'ram@example.com',
                phone: '9841234567',
                address: 'Thamel, Kathmandu',
                items: 'Fresh Tomatoes × 2, Bananas × 1',
                total: 95,
                status: 'Pending',
                date: '2026-03-29',
                payment: 'Cash on Delivery'
            },
            {
                id: 'ORD-002',
                customer: 'Sita Thapa',
                email: 'sita@example.com',
                phone: '9851234567',
                address: 'Lazimpat, Kathmandu',
                items: 'Full Cream Milk × 2',
                total: 150,
                status: 'Processing',
                date: '2026-03-29',
                payment: 'eSewa'
            },
            {
                id: 'ORD-003',
                customer: 'Hari Pradhan',
                email: 'hari@example.com',
                phone: '9861234567',
                address: 'Kupondole, Lalitpur',
                items: 'Mixed Nuts × 1, Dark Chocolate × 2',
                total: 365,
                status: 'Delivered',
                date: '2026-03-28',
                payment: 'Khalti'
            },
            {
                id: 'ORD-004',
                customer: 'Anita KC',
                email: 'anita@example.com',
                phone: '9871234567',
                address: 'Jawalakhel, Lalitpur',
                items: 'Almond Milk × 1, Orange Juice × 1',
                total: 270,
                status: 'Pending',
                date: '2026-03-28',
                payment: 'Cash on Delivery'
            },
            {
                id: 'ORD-005',
                customer: 'Bijay Lama',
                email: 'bijay@example.com',
                phone: '9881234567',
                address: 'Durbar Square, Bhaktapur',
                items: 'Sourdough Bread × 3',
                total: 255,
                status: 'Processing',
                date: '2026-03-27',
                payment: 'eSewa'
            },
        ];

        const customers = [{
                id: 'USR-001',
                name: 'Ram Sharma',
                email: 'ram@example.com',
                phone: '9841234567',
                address: 'House No. 12, Thamel Marg, Kathmandu 44600',
                gender: 'Male',
                dob: '1990-05-14',
                joined: '2025-11-03',
                orders: 8,
                total: 2340,
                status: 'Active'
            },
            {
                id: 'USR-002',
                name: 'Sita Thapa',
                email: 'sita@example.com',
                phone: '9851234567',
                address: 'Flat 3B, Lazimpat Height, Kathmandu 44600',
                gender: 'Female',
                dob: '1994-08-22',
                joined: '2025-12-18',
                orders: 5,
                total: 1200,
                status: 'Active'
            },
            {
                id: 'USR-003',
                name: 'Hari Pradhan',
                email: 'hari@example.com',
                phone: '9861234567',
                address: 'Ward No. 7, Kupondole, Lalitpur 44700',
                gender: 'Male',
                dob: '1988-02-10',
                joined: '2026-01-05',
                orders: 12,
                total: 4890,
                status: 'Active'
            },
        ];

        let categories = [{
                id: 1,
                emoji: '🥦',
                name: 'Vegetables',
                count: 0,
                visible: true
            },
            {
                id: 2,
                emoji: '🍎',
                name: 'Fruits',
                count: 0,
                visible: true
            },
            {
                id: 3,
                emoji: '🥛',
                name: 'Dairy',
                count: 0,
                visible: true
            },
            {
                id: 4,
                emoji: '🍞',
                name: 'Bakery',
                count: 0,
                visible: true
            },
            {
                id: 5,
                emoji: '🧃',
                name: 'Beverages',
                count: 0,
                visible: true
            },
            {
                id: 6,
                emoji: '🍫',
                name: 'Snacks',
                count: 0,
                visible: true
            },
        ];

        // Count products per category from real data
        products.forEach(p => {
            const c = categories.find(x => x.name === p.category);
            if (c) c.count++;
        });

        let deliveryZones = [{
                id: 1,
                name: 'Kathmandu Core',
                areas: 'Thamel, Maharajgunj, Lazimpat, Baneshwor, New Road',
                fee: 0,
                time: '30–45 min',
                active: true,
                riders: 4
            },
            {
                id: 2,
                name: 'Patan / Lalitpur',
                areas: 'Jawalakhel, Kupondole, Pulchowk, Lagankhel',
                fee: 50,
                time: '45–60 min',
                active: true,
                riders: 2
            },
            {
                id: 3,
                name: 'Bhaktapur',
                areas: 'Durbar Square, Suryabinayak, Thimi, Madhyapur',
                fee: 100,
                time: '1–2 hours',
                active: true,
                riders: 1
            },
        ];

        let discounts = [];
        let editingCatId = null;
        let featuredIds = new Set();

        const catEmoji = {
            Vegetables: '🥦',
            Fruits: '🍎',
            Dairy: '🥛',
            Bakery: '🍞',
            Beverages: '🧃',
            Snacks: '🍫',
            Meat: '🍗',
            'Personal Care': '🧴'
        };
        const statusColor = {
            Pending: 'background:#fff7ed;color:#ea580c;',
            Processing: 'background:#eff6ff;color:#2563eb;',
            Delivered: 'background:#f0fdf4;color:#16a34a;',
            Cancelled: 'background:#fef2f2;color:#dc2626;'
        };
        const tagMeta = {
            Fresh: {
                bg: '#e8f5e9',
                color: '#2e7d32'
            },
            New: {
                bg: '#e3f2fd',
                color: '#0d47a1'
            },
            Organic: {
                bg: '#f3e5f5',
                color: '#6a1b9a'
            },
            'Best Seller': {
                bg: '#fff3e0',
                color: '#e65100'
            },
            Popular: {
                bg: '#fce4ec',
                color: '#880e4f'
            },
            Healthy: {
                bg: '#e0f2f1',
                color: '#004d40'
            }
        };

        // ══ NAVIGATION ══
        const pageTitles = {
            dashboard: 'Dashboard',
            products: 'Products',
            orders: 'Orders',
            customers: 'Customers',
            'add-product': 'Products &nbsp;/&nbsp; <span class="text-primary">Add New Product</span>',
            categories: 'Catalog &nbsp;/&nbsp; <span class="text-primary">Categories</span>',
            banner: 'Catalog &nbsp;/&nbsp; <span class="text-primary">Banner & Featured</span>',
            discounts: 'Catalog &nbsp;/&nbsp; <span class="text-primary">Discounts</span>',
            settings: 'Settings &nbsp;/&nbsp; <span class="text-primary">Store Settings</span>',
            delivery: 'Settings &nbsp;/&nbsp; <span class="text-primary">Delivery Zones</span>',
        };

        function navigate(page) {
            document.querySelectorAll('.page-section').forEach(p => p.classList.remove('active'));
            document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
            const target = document.getElementById('page-' + page);
            if (target) target.classList.add('active');
            const nav = document.getElementById('nav-' + page);
            if (nav) nav.classList.add('active');
            document.getElementById('breadcrumbText').innerHTML = pageTitles[page] || page;
            if (page === 'products') renderProducts(products);
            if (page === 'orders') renderOrders();
            if (page === 'customers') renderCustomers();
            if (page === 'categories') renderCategories();
            if (page === 'delivery') renderDeliveryZones();
            if (page === 'banner') renderFeatured();
            if (page === 'discounts') renderDiscounts();
            closeProfileDropdown();
            return false;
        }
        navigate('dashboard');

        // ══ DARK MODE ══
        function toggleDarkMode() {
            const html = document.documentElement;
            const isDark = html.getAttribute('data-theme') === 'dark';
            html.setAttribute('data-theme', isDark ? 'light' : 'dark');
            document.getElementById('dmBtn').textContent = isDark ? '🌙 Dark' : '☀️ Light';
            localStorage.setItem('theme', isDark ? 'light' : 'dark');
        }
        const saved = localStorage.getItem('theme');
        if (saved) {
            document.documentElement.setAttribute('data-theme', saved);
            document.getElementById('dmBtn').textContent = saved === 'dark' ? '☀️ Light' : '🌙 Dark';
        }

        // ══ PROFILE DROPDOWN ══
        function toggleProfileDropdown() {
            document.getElementById('profileDropdown').classList.toggle('open');
        }

        function closeProfileDropdown() {
            document.getElementById('profileDropdown').classList.remove('open');
        }
        document.addEventListener('click', e => {
            if (!e.target.closest('.profile-dropdown') && !e.target.closest('aside > div:last-child > button'))
                closeProfileDropdown();
        });

        // ══ PRODUCTS TABLE ══
        function renderProducts(list) {
            const tbody = document.getElementById('productsTableBody');
            if (!tbody) return;
            if (!list || list.length === 0) {
                tbody.innerHTML = `<div class="px-6 py-12 text-center text-secondary font-bold">No products found</div>`;
                return;
            }
            tbody.innerHTML = list.map(p => `
    <div class="flex items-center gap-4 px-6 py-3.5 hover-row transition-colors" style="border-bottom:1px solid var(--border);">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl shrink-0 overflow-hidden" style="background:#e8f5ee;">
            ${p.image ? `<img src="/storage/${p.image}" class="w-full h-full object-cover" onerror="this.style.display='none'">` : (catEmoji[p.category] || '📦')}
        </div>
        <div class="flex-1 min-w-0">
            <div class="font-bold text-sm text-primary truncate">${p.name}</div>
            <div class="text-xs text-secondary font-semibold">${p.category} &nbsp;·&nbsp; ${p.unit}</div>
        </div>
        ${p.tag ? `<span class="text-[10px] font-extrabold px-2 py-0.5 rounded-lg" style="background:#e8f5ee;color:#0c7a3e;">${p.tag}</span>` : ''}
        <div class="font-extrabold text-sm text-primary min-w-[70px] text-right">RS ${parseFloat(p.price).toFixed(0)}</div>
        <div class="text-xs text-secondary min-w-[50px] text-center">${p.stock_quantity ?? 0} pcs</div>
        <div class="flex gap-1.5">
            <button onclick='openEditModal(${JSON.stringify(p).replace(/'/g,"\\'")})'  class="btn-edit">✏️ Edit</button>
            <button onclick="openDeleteModal(${p.id}, '${p.name.replace(/'/g, "\\'")}')" class="btn-danger">🗑️</button>
        </div>
    </div>`).join('');
        }

        function filterTable() {
            const q = document.getElementById('productSearch').value.toLowerCase();
            renderProducts(products.filter(p => p.name.toLowerCase().includes(q) || p.category.toLowerCase().includes(q)));
        }

        // ══ ORDERS ══
        function renderOrders() {
            document.getElementById('ordersBody').innerHTML = orders.map(o => `
    <div class="flex items-center gap-4 px-6 py-4 hover-row transition-colors" style="border-bottom:1px solid var(--border);">
        <div class="font-extrabold text-sm text-primary w-24">#${o.id}</div>
        <div class="flex-1"><div class="font-bold text-sm text-primary">${o.customer}</div><div class="text-xs text-secondary mt-0.5">${o.items}</div></div>
        <div class="text-xs text-secondary hidden md:block">${o.date}</div>
        <div class="text-sm font-bold text-primary min-w-[60px] text-right">RS ${o.total}</div>
        <span class="text-xs font-extrabold px-2.5 py-1 rounded-lg" style="${statusColor[o.status]}">${o.status}</span>
        <button onclick='openOrderDetail(${JSON.stringify(o).replace(/'/g,"\\'")})' style="background:var(--input-bg);" class="border-none rounded-lg px-2.5 py-1.5 text-xs font-bold cursor-pointer font-nunito text-primary hover-row">View</button>
    </div>`).join('');
        }

        // ══ CUSTOMERS ══
        function renderCustomers() {
            document.getElementById('customersBody').innerHTML = customers.map(c => {
                const initials = c.name.split(' ').map(w => w[0]).join('').slice(0, 2);
                return `<div class="flex items-center gap-4 px-6 py-4 hover-row transition-colors" style="border-bottom:1px solid var(--border);">
            <div class="w-10 h-10 rounded-full flex items-center justify-center font-black text-sm shrink-0" style="background:#e8f5ee;color:#0c7a3e;">${initials}</div>
            <div class="flex-1">
                <div class="font-bold text-sm text-primary">${c.name}</div>
                <div class="text-xs text-secondary">${c.email} · ${c.phone}</div>
                <div class="text-xs text-secondary mt-0.5">📍 ${c.address}</div>
            </div>
            <div class="text-center hidden md:block"><div class="text-xs font-bold text-secondary">${c.orders} orders</div><div class="text-xs text-secondary">Joined ${c.joined}</div></div>
            <div class="text-sm font-extrabold text-primary min-w-[70px] text-right">RS ${c.total.toLocaleString()}</div>
            <span class="text-[10px] font-extrabold px-2 py-0.5 rounded-lg" style="background:#f0fdf4;color:#16a34a;">${c.status}</span>
            <button onclick='openCustomerDetail(${JSON.stringify(c).replace(/'/g,"\\'")})' style="background:var(--input-bg);" class="border-none rounded-lg px-2.5 py-1.5 text-xs font-bold cursor-pointer font-nunito text-primary">View</button>
        </div>`;
            }).join('');
        }

        // ══ CATEGORIES ══
        function renderCategories() {
            document.getElementById('categoriesGrid').innerHTML = categories.map(c => `
    <div class="card p-5 cat-card flex items-center gap-3 relative group">
        <div class="text-3xl">${c.emoji}</div>
        <div class="flex-1">
            <div class="font-extrabold text-sm text-primary">${c.name}</div>
            <div class="text-xs text-secondary font-semibold">${c.count} products</div>
            ${!c.visible ? '<div class="text-[10px] text-orange-500 font-bold">Hidden</div>' : ''}
        </div>
        <div class="cat-actions flex gap-1.5 absolute right-4 top-4">
            <button onclick="editCat(${c.id})" class="btn-edit text-[11px] px-2 py-1">✏️</button>
            <button onclick="deleteCat(${c.id})" class="btn-danger text-[11px] px-2 py-1">🗑️</button>
        </div>
    </div>`).join('') + `
    <button onclick="openCatModal()" class="card p-5 flex flex-col items-center justify-center gap-2 text-secondary cursor-pointer hover-row transition-all" style="border:2px dashed var(--border);border-radius:16px;min-height:80px;">
        <div class="text-2xl">➕</div><div class="text-sm font-bold">Add Category</div>
    </button>`;
        }

        function openCatModal() {
            editingCatId = null;
            document.getElementById('catName').value = '';
            document.getElementById('catEmoji').value = '';
            document.getElementById('catDesc').value = '';
            document.getElementById('catVisible').checked = true;
            document.getElementById('catModalTitle').textContent = '➕ Add Category';
            document.getElementById('catModal').classList.add('open');
        }

        function editCat(id) {
            const c = categories.find(x => x.id === id);
            if (!c) return;
            editingCatId = id;
            document.getElementById('catName').value = c.name;
            document.getElementById('catEmoji').value = c.emoji;
            document.getElementById('catDesc').value = c.desc || '';
            document.getElementById('catVisible').checked = c.visible;
            document.getElementById('catModalTitle').textContent = '✏️ Edit Category';
            document.getElementById('catModal').classList.add('open');
        }

        function deleteCat(id) {
            if (!confirm('Delete this category?')) return;
            categories = categories.filter(c => c.id !== id);
            renderCategories();
            showToast('🗑️ Category deleted');
        }

        function saveCat() {
            const name = document.getElementById('catName').value.trim();
            const emoji = document.getElementById('catEmoji').value.trim() || '📦';
            if (!name) {
                showToast('⚠️ Category name required');
                return;
            }
            if (editingCatId) {
                const c = categories.find(x => x.id === editingCatId);
                if (c) {
                    c.name = name;
                    c.emoji = emoji;
                    c.visible = document.getElementById('catVisible').checked;
                }
                showToast('✅ Category updated!');
            } else {
                categories.push({
                    id: Date.now(),
                    emoji,
                    name,
                    count: 0,
                    visible: document.getElementById('catVisible').checked
                });
                showToast('✅ Category added!');
            }
            closeCatModal();
            renderCategories();
        }

        function closeCatModal() {
            document.getElementById('catModal').classList.remove('open');
        }

        // ══ DELIVERY ══
        function renderDeliveryZones() {
            document.getElementById('deliveryZonesBody').innerHTML = deliveryZones.map(z => `
    <div class="flex items-center gap-4 px-6 py-4 hover-row transition-colors" style="border-bottom:1px solid var(--border);">
        <div class="text-2xl">📍</div>
        <div class="flex-1">
            <div class="flex items-center gap-2">
                <div class="font-bold text-sm text-primary">${z.name}</div>
                ${z.active ? '<span class="text-[10px] font-black px-1.5 py-0.5 rounded" style="background:#f0fdf4;color:#16a34a;">Active</span>' : '<span class="text-[10px] font-black px-1.5 py-0.5 rounded" style="background:#f9fafb;color:#9ca3af;">Inactive</span>'}
            </div>
            <div class="text-xs text-secondary mt-0.5">${z.areas}</div>
            <div class="text-xs text-secondary mt-0.5">⏱ ${z.time} &nbsp;·&nbsp; 🛵 ${z.riders} rider${z.riders !== 1 ? 's' : ''}</div>
        </div>
        <div class="text-sm font-extrabold min-w-[60px] text-right" style="color:${z.fee === 0 ? '#0c7a3e' : 'var(--text)'};">${z.fee === 0 ? 'FREE' : 'RS ' + z.fee}</div>
        <div class="flex gap-1.5">
            <button onclick="toggleZone(${z.id})" class="btn-edit text-[11px] px-2 py-1">${z.active ? 'Disable' : 'Enable'}</button>
            <button onclick="deleteZone(${z.id})" class="btn-danger text-[11px] px-2 py-1">🗑️</button>
        </div>
    </div>`).join('');
        }

        function toggleZone(id) {
            const z = deliveryZones.find(x => x.id === id);
            if (z) {
                z.active = !z.active;
                renderDeliveryZones();
                showToast(z.active ? '✅ Zone enabled' : '🔴 Zone disabled');
            }
        }

        function deleteZone(id) {
            if (!confirm('Delete this delivery zone?')) return;
            deliveryZones = deliveryZones.filter(z => z.id !== id);
            renderDeliveryZones();
            showToast('🗑️ Zone deleted');
        }

        function openDeliveryModal() {
            document.getElementById('deliveryModal').classList.add('open');
        }

        function closeDeliveryModal() {
            document.getElementById('deliveryModal').classList.remove('open');
        }

        function saveDeliveryZone() {
            const name = document.getElementById('dz_name').value.trim();
            if (!name) {
                showToast('⚠️ Zone name required');
                return;
            }
            deliveryZones.push({
                id: Date.now(),
                name,
                areas: document.getElementById('dz_areas').value,
                fee: parseInt(document.getElementById('dz_fee').value) || 0,
                time: document.getElementById('dz_time').value,
                active: document.getElementById('dz_active').checked,
                riders: 0
            });
            closeDeliveryModal();
            renderDeliveryZones();
            showToast('✅ Delivery zone added!');
        }

        // ══ DISCOUNTS ══
        function openDiscountModal() {
            document.getElementById('discountModal').classList.add('open');
        }

        function closeDiscountModal() {
            document.getElementById('discountModal').classList.remove('open');
        }

        function saveDiscount() {
            const code = document.getElementById('dc_code').value.trim().toUpperCase();
            if (!code) {
                showToast('⚠️ Code required');
                return;
            }
            discounts.push({
                code,
                type: document.getElementById('dc_type').value,
                value: document.getElementById('dc_value').value,
                min: document.getElementById('dc_min').value,
                expiry: document.getElementById('dc_expiry').value
            });
            renderDiscounts();
            closeDiscountModal();
            showToast('✅ Discount code created!');
        }

        function renderDiscounts() {
            const body = document.getElementById('discountsBody');
            if (discounts.length === 0) {
                body.innerHTML =
                    `<div class="p-12 text-center text-secondary"><div class="text-5xl mb-3">🎟️</div><div class="font-bold text-base">No active discount codes</div><button onclick="openDiscountModal()" class="btn-primary mt-4">+ Create Discount</button></div>`;
                return;
            }
            body.innerHTML =
                `<div class="px-6 py-4 font-black text-xs text-secondary uppercase tracking-widest" style="border-bottom:1px solid var(--border);">Active Codes</div>` +
                discounts.map((d, i) => `
        <div class="flex items-center gap-4 px-6 py-4 hover-row" style="border-bottom:1px solid var(--border);">
            <div class="font-black text-sm text-primary px-3 py-1.5 rounded-lg" style="background:#e8f5ee;">${d.code}</div>
            <div class="flex-1">
                <div class="text-sm font-bold text-primary">${d.type === 'percent' ? d.value+'% off' : 'RS '+d.value+' off'}</div>
                ${d.min ? `<div class="text-xs text-secondary">Min order: RS ${d.min}</div>` : ''}
                ${d.expiry ? `<div class="text-xs text-secondary">Expires: ${d.expiry}</div>` : ''}
            </div>
            <button onclick="discounts.splice(${i},1);renderDiscounts();showToast('🗑️ Code deleted')" class="btn-danger">Remove</button>
        </div>`).join('');
        }

        // ══ FEATURED ══
        function renderFeatured() {
            const count = featuredIds.size;
            document.getElementById('featuredCount').textContent = `${count} / 8 selected`;
            document.getElementById('featuredGrid').innerHTML = products.map(p => {
                const isFeatured = featuredIds.has(p.id);
                return `<div onclick="toggleFeatured(${p.id})" class="cursor-pointer rounded-xl p-3 transition-all" style="background:${isFeatured ? '#e8f5ee' : 'var(--input-bg)'};border:2px solid ${isFeatured ? '#0c7a3e' : 'var(--border)'};">
            <div class="text-2xl text-center mb-1">${catEmoji[p.category] || '📦'}</div>
            <div class="text-xs font-bold text-center" style="color:${isFeatured ? '#0c7a3e' : 'var(--text)'};">${p.name}</div>
            <div class="text-[10px] text-center mt-0.5 text-secondary">RS ${p.price}</div>
            ${isFeatured ? '<div class="text-center mt-1"><span class="text-[9px] font-black" style="color:#0c7a3e;">⭐ Featured</span></div>' : ''}
        </div>`;
            }).join('');
        }

        function toggleFeatured(id) {
            if (featuredIds.has(id)) featuredIds.delete(id);
            else if (featuredIds.size < 8) featuredIds.add(id);
            else {
                showToast('⚠️ Max 8 featured products');
                return;
            }
            renderFeatured();
            showToast(featuredIds.has(id) ? '⭐ Added to featured' : '✅ Removed from featured');
        }

        // ══ BANNER UPLOAD ══
        function addBanner(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                const grid = document.getElementById('bannersGrid');
                const addBtn = grid.querySelector('.banner-dropzone');
                const div = document.createElement('div');
                div.className = 'relative rounded-xl overflow-hidden group';
                div.style.height = '140px';
                div.innerHTML =
                    `<img src="${e.target.result}" class="w-full h-full object-cover">
        <div class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
            <button onclick="this.closest('.relative').remove()" class="bg-white/90 border-none rounded-lg w-7 h-7 text-sm cursor-pointer">🗑️</button>
        </div>
        <div class="absolute bottom-2 left-2 bg-green-600 text-white text-[10px] font-black px-1.5 py-0.5 rounded">Active</div>`;
                grid.insertBefore(div, addBtn);
                showToast('✅ Banner uploaded!');
            };
            reader.readAsDataURL(file);
            event.target.value = '';
        }

        // ══ EDIT PRODUCT MODAL ══
        function openEditModal(p) {
            if (typeof p === 'string') p = JSON.parse(p);
            document.getElementById('edit_name').value = p.name;
            document.getElementById('edit_price').value = p.price;
            document.getElementById('edit_stock').value = p.stock_quantity ?? 0;
            document.getElementById('edit_category').value = p.category;
            document.getElementById('edit_unit').value = p.unit;
            document.getElementById('edit_tag').value = p.tag ?? '';
            document.getElementById('edit_description').value = p.description ?? '';
            document.getElementById('editForm').action = `/admin/products/${p.id}`;
            if (p.image) {
                document.getElementById('editCurrentImg').classList.remove('hidden');
                document.getElementById('editImgPreview').src = `/storage/${p.image}`;
            } else {
                document.getElementById('editCurrentImg').classList.add('hidden');
            }
            document.getElementById('editModal').classList.add('open');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.remove('open');
        }

        // ══ DELETE MODAL ══
        function openDeleteModal(id, name) {
            document.getElementById('deleteProductName').textContent = name;
            document.getElementById('deleteForm').action = `/admin/products/${id}`;
            document.getElementById('deleteModal').classList.add('open');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('open');
        }

        // ══ ORDER DETAIL MODAL ══
        function infoRow(label, value) {
            return `<div class="flex items-start gap-2"><span class="text-xs font-extrabold text-secondary w-32 shrink-0 pt-0.5">${label}</span><span class="text-sm font-semibold text-primary flex-1">${value}</span></div>`;
        }

        function openOrderDetail(o) {
            if (typeof o === 'string') o = JSON.parse(o);
            document.getElementById('orderDetailBody').innerHTML = `
    <div class="flex items-center justify-between">
        <div class="font-black text-xl text-primary">#${o.id}</div>
        <span class="text-xs font-extrabold px-2.5 py-1 rounded-lg" style="${statusColor[o.status]}">${o.status}</span>
    </div>
    <div class="p-4 rounded-xl flex flex-col gap-2" style="background:var(--input-bg);border:1px solid var(--border);">
        ${infoRow('👤 Customer', o.customer)}${infoRow('📧 Email', o.email)}${infoRow('📞 Phone', o.phone)}${infoRow('📍 Address', o.address)}${infoRow('📅 Date', o.date)}${infoRow('💳 Payment', o.payment)}
    </div>
    <div class="p-4 rounded-xl" style="background:var(--input-bg);border:1px solid var(--border);">
        <div class="text-xs font-extrabold text-secondary mb-2 uppercase tracking-widest">Items</div>
        <div class="text-sm font-semibold text-primary">${o.items}</div>
    </div>
    <div class="flex items-center justify-between p-4 rounded-xl" style="background:var(--input-bg);border:1px solid var(--border);">
        <div class="font-extrabold text-sm text-primary">Total Amount</div>
        <div class="font-black text-xl" style="color:#0c7a3e;">RS ${o.total}</div>
    </div>`;
            document.getElementById('orderModal').classList.add('open');
        }

        // ══ CUSTOMER DETAIL MODAL ══
        function openCustomerDetail(c) {
            if (typeof c === 'string') c = JSON.parse(c);
            const initials = c.name.split(' ').map(w => w[0]).join('').slice(0, 2);
            document.getElementById('customerDetailBody').innerHTML = `
    <div class="flex items-center gap-4 mb-5">
        <div class="w-14 h-14 rounded-full flex items-center justify-center font-black text-xl shrink-0" style="background:#e8f5ee;color:#0c7a3e;">${initials}</div>
        <div><div class="font-black text-xl text-primary">${c.name}</div><div class="text-xs font-bold text-secondary mt-0.5">${c.id}</div><span class="text-[10px] font-extrabold px-2 py-0.5 rounded-lg" style="background:#f0fdf4;color:#16a34a;">${c.status}</span></div>
    </div>
    <div class="p-4 rounded-xl flex flex-col gap-2 mb-4" style="background:var(--input-bg);border:1px solid var(--border);">
        ${infoRow('📧 Email', c.email)}${infoRow('📞 Phone', c.phone)}${infoRow('📍 Address', c.address)}${infoRow('⚧ Gender', c.gender)}${infoRow('🎂 DOB', c.dob)}${infoRow('📅 Joined', c.joined)}
    </div>
    <div class="grid grid-cols-2 gap-3">
        <div class="p-4 rounded-xl text-center" style="background:var(--input-bg);border:1px solid var(--border);">
            <div class="text-2xl font-black" style="color:#0c7a3e;">${c.orders}</div><div class="text-xs font-bold text-secondary mt-0.5">Total Orders</div>
        </div>
        <div class="p-4 rounded-xl text-center" style="background:var(--input-bg);border:1px solid var(--border);">
            <div class="text-2xl font-black" style="color:#0c7a3e;">RS ${c.total.toLocaleString()}</div><div class="text-xs font-bold text-secondary mt-0.5">Total Spent</div>
        </div>
    </div>`;
            document.getElementById('customerModal').classList.add('open');
        }

        // ══ ADD PRODUCT FORM ══
        function updatePreview() {
            document.getElementById('previewName').textContent = document.getElementById('productName').value.trim() ||
                'Product name';
            document.getElementById('previewUnit').textContent = document.getElementById('productUnit').value.trim() ||
                'Unit';
            const price = document.getElementById('productPrice').value;
            document.getElementById('previewPrice').textContent = price ? `RS ${price}` : 'RS —';
            document.getElementById('nameCounter').textContent =
                `${document.getElementById('productName').value.length} / 60`;
            const sell = parseFloat(price) || 0;
            const compare = parseFloat(document.getElementById('comparePrice').value) || 0;
            const badge = document.getElementById('discountBadge');
            if (compare > sell && sell > 0) {
                document.getElementById('discountPct').textContent = Math.round(((compare - sell) / compare) * 100);
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }

        function updateDescCounter() {
            document.getElementById('descCounter').textContent =
                `${document.getElementById('productDesc').value.length} / 300`;
        }

        function updateTag() {
            const selected = document.querySelector('input[name="tag"]:checked');
            const tag = selected ? selected.value : '';
            const previewTag = document.getElementById('previewTag');
            if (tag && tagMeta[tag]) {
                previewTag.classList.remove('hidden');
                previewTag.textContent = tag;
                previewTag.style.background = tagMeta[tag].bg;
                previewTag.style.color = tagMeta[tag].color;
            } else previewTag.classList.add('hidden');
        }

        function updateStock() {
            const qty = parseInt(document.getElementById('stockQty').value) || 0;
            const display = document.getElementById('stockDisplay');
            if (document.getElementById('stockQty').value !== '') {
                display.classList.remove('hidden');
                display.style.display = 'flex';
                document.getElementById('stockVal').textContent = qty;
                display.style.background = qty === 0 ? '#fce4ec' : qty < 10 ? '#fff3e0' : '#e8f5ee';
                document.getElementById('stockVal').style.color = qty === 0 ? '#c62828' : qty < 10 ? '#e65100' : '#0c7a3e';
            } else {
                display.classList.add('hidden');
                display.style.display = '';
            }
        }

        function handleImageUpload(e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = ev => {
                document.getElementById('uploadDefault').classList.add('hidden');
                document.getElementById('uploadPreviewWrap').classList.remove('hidden');
                document.getElementById('uploadPreviewImg').src = ev.target.result;
                document.getElementById('previewImg').src = ev.target.result;
                document.getElementById('previewImg').classList.remove('hidden');
                document.getElementById('previewPlaceholder').classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }

        function validate() {
            let ok = true;
            [{
                id: 'productName',
                err: 'nameError',
                check: v => v.trim() !== ''
            }, {
                id: 'productCategory',
                err: 'catError',
                check: v => v !== ''
            }, {
                id: 'productUnit',
                err: 'unitError',
                check: v => v.trim() !== ''
            }, {
                id: 'productPrice',
                err: 'priceError',
                check: v => v !== '' && parseFloat(v) >= 0
            }].forEach(f => {
                const el = document.getElementById(f.id),
                    err = document.getElementById(f.err);
                if (!f.check(el.value)) {
                    el.classList.add('error');
                    err.classList.remove('hidden');
                    ok = false;
                } else {
                    el.classList.remove('error');
                    err.classList.add('hidden');
                }
            });
            return ok;
        }

        function submitForm() {
            if (!validate()) {
                showToast('⚠️ Please fill in all required fields');
                return;
            }
            document.getElementById('productForm').submit();
        }

        function resetForm() {
            ['productName', 'productDesc', 'productUnit', 'productPrice', 'comparePrice', 'stockQty'].forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.value = '';
                    el.classList.remove('error');
                }
            });
            document.getElementById('productCategory').value = '';
            ['nameError', 'catError', 'unitError', 'priceError'].forEach(id => document.getElementById(id).classList.add(
                'hidden'));
            document.getElementById('tagNone').checked = true;
            document.getElementById('uploadDefault').classList.remove('hidden');
            document.getElementById('uploadPreviewWrap').classList.add('hidden');
            document.getElementById('previewImg').classList.add('hidden');
            document.getElementById('previewPlaceholder').classList.remove('hidden');
            document.getElementById('previewTag').classList.add('hidden');
            document.getElementById('previewName').textContent = 'Product name';
            document.getElementById('previewUnit').textContent = 'Unit';
            document.getElementById('previewPrice').textContent = 'RS —';
            document.getElementById('stockDisplay').classList.add('hidden');
            document.getElementById('nameCounter').textContent = '0 / 60';
            document.getElementById('descCounter').textContent = '0 / 300';
            document.getElementById('discountBadge').classList.add('hidden');
            updateTag();
            showToast('🗑️ Form cleared');
        }

        // ══ CLOSE MODALS ON BACKDROP CLICK ══
        ['editModal', 'deleteModal', 'orderModal', 'customerModal', 'catModal', 'deliveryModal', 'discountModal'].forEach(
            id => {
                document.getElementById(id).addEventListener('click', function(e) {
                    if (e.target === this) this.classList.remove('open');
                });
            });

        // ══ TOAST ══
        let toastTimer;

        function showToast(msg) {
            const t = document.getElementById('toast');
            document.getElementById('toastMsg').textContent = msg;
            t.classList.add('show');
            clearTimeout(toastTimer);
            toastTimer = setTimeout(() => t.classList.remove('show'), 3000);
        }

        // ══ LARAVEL SESSION FLASH ══
        @if (session('success'))
            showToast('✅ {{ session('success') }}');
        @endif
        @if (session('error'))
            showToast('⚠️ {{ session('error') }}');
        @endif



        //drag and frop image



        const uploadZone = document.getElementById('uploadZone');
        const imageInput = document.getElementById('imageInput');
        const previewImg = document.getElementById('uploadPreviewImg');
        const previewWrap = document.getElementById('uploadPreviewWrap');
        const uploadDefault = document.getElementById('uploadDefault');

        // click overlay already works via onclick

        // drag over
        uploadZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadZone.style.borderColor = "#4f46e5"; // highlight
        });

        // drag leave
        uploadZone.addEventListener('dragleave', () => {
            uploadZone.style.borderColor = "var(--border)";
        });

        // drop file
        uploadZone.addEventListener('drop', (e) => {
            e.preventDefault();

            uploadZone.style.borderColor = "var(--border)";

            const file = e.dataTransfer.files[0];

            if (file) {
                imageInput.files = e.dataTransfer.files;
                showPreview(file);
            }
        });

        // file input change (click upload)
        imageInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                showPreview(file);
            }
        });

        // preview function
        function showPreview(file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImg.src = e.target.result;

                uploadDefault.classList.add('hidden');
                previewWrap.classList.remove('hidden');
            };

            reader.readAsDataURL(file);
        }
    </script>
</body>

</html>
