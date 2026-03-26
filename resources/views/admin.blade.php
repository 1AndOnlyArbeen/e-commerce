<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Add Product | ArbeenStore</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { nunito: ['Nunito', 'sans-serif'] },
                    colors: {
                        brand: { DEFAULT: '#0c7a3e', dark: '#0a6633', light: '#e8f5ee', mid: '#a8d5bc' }
                    },
                    width: { sidebar: '240px' },
                    height: { topbar: '64px' },
                    minWidth: { sidebar: '240px' }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Nunito', sans-serif; }

        /* Custom select arrow */
        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23999' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 36px !important;
        }

        /* Tag radio toggle */
        .tag-option { display: none; }
        .tag-option:checked + .tag-label {
            background: #0c7a3e !important;
            color: #fff !important;
            border-color: #0c7a3e !important;
        }

        /* Toggle switch */
        .switch { position: relative; width: 44px; height: 24px; flex-shrink: 0; display: inline-block; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; inset: 0; background: #ddd; border-radius: 24px; cursor: pointer; transition: background 0.2s; }
        .slider::before { content: ''; position: absolute; height: 18px; width: 18px; left: 3px; bottom: 3px; background: #fff; border-radius: 50%; transition: transform 0.2s; box-shadow: 0 1px 4px rgba(0,0,0,0.2); }
        .switch input:checked + .slider { background: #0c7a3e; }
        .switch input:checked + .slider::before { transform: translateX(20px); }

        /* Upload hover overlay */
        .upload-zone:hover .upload-preview-overlay { display: flex !important; }

        /* Toast animation */
        .toast { transform: translateY(80px); opacity: 0; transition: all 0.3s ease; }
        .toast.show { transform: translateY(0); opacity: 1; }

        /* Focus ring for inputs */
        .form-input:focus { border-color: #0c7a3e; background: #fff; box-shadow: 0 0 0 3px rgba(12,122,62,0.08); outline: none; }
        .form-input.error { border-color: #e53935 !important; background: #fff5f5 !important; }

        /* Active nav item */
        .nav-item.active { background: #0c7a3e; color: #fff; }
        .nav-item:not(.active):hover { background: #e8f5ee; color: #0c7a3e; }

        /* Page tabs */
        .page-section { display: none; }
        .page-section.active { display: block; }
    </style>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex font-nunito">

<!-- ── SIDEBAR ── -->
<aside class="w-[240px] min-w-[240px] bg-white border-r border-gray-100 h-screen fixed top-0 left-0 flex flex-col z-50">

    <!-- Logo -->
    <a href="#" onclick="navigate('dashboard')" class="px-5 h-16 flex items-center gap-2.5 border-b border-gray-100 no-underline">
        <div class="bg-[#0c7a3e] rounded-xl w-9 h-9 flex items-center justify-center text-xl">🌿</div>
        <div>
            <div class="font-black text-lg text-gray-900 leading-none">Arbeen</div>
            <div class="text-[10px] font-bold text-gray-400">Store</div>
        </div>
        <div class="ml-auto bg-[#e8f5ee] text-[#0c7a3e] text-[9px] font-black rounded px-1.5 py-0.5 tracking-wide">ADMIN</div>
    </a>

    <!-- Nav -->
    <div class="flex-1 overflow-y-auto py-2">
        <div class="px-3 pt-4 pb-2 text-[10px] font-black text-gray-300 tracking-widest uppercase">Main</div>

        <a href="#" onclick="navigate('dashboard')" class="nav-item flex items-center gap-3 px-3.5 py-2.5 mx-2 rounded-xl text-sm font-bold text-gray-500 no-underline transition-all mb-0.5" id="nav-dashboard">
            <span class="text-[17px] w-5 text-center">📊</span> Dashboard
        </a>
        <a href="#" onclick="navigate('products')" class="nav-item flex items-center gap-3 px-3.5 py-2.5 mx-2 rounded-xl text-sm font-bold text-gray-500 no-underline transition-all mb-0.5" id="nav-products">
            <span class="text-[17px] w-5 text-center">📦</span> Products
            <span class="ml-auto bg-red-500 text-white text-[10px] font-black rounded-lg px-1.5 py-0.5">16</span>
        </a>
        <a href="#" onclick="navigate('orders')" class="nav-item flex items-center gap-3 px-3.5 py-2.5 mx-2 rounded-xl text-sm font-bold text-gray-500 no-underline transition-all mb-0.5" id="nav-orders">
            <span class="text-[17px] w-5 text-center">🛒</span> Orders
            <span class="ml-auto bg-red-500 text-white text-[10px] font-black rounded-lg px-1.5 py-0.5">5</span>
        </a>
        <a href="#" onclick="navigate('customers')" class="nav-item flex items-center gap-3 px-3.5 py-2.5 mx-2 rounded-xl text-sm font-bold text-gray-500 no-underline transition-all mb-0.5" id="nav-customers">
            <span class="text-[17px] w-5 text-center">👥</span> Customers
        </a>

        <div class="px-3 pt-4 pb-2 text-[10px] font-black text-gray-300 tracking-widest uppercase">Catalog</div>

        <a href="#" onclick="navigate('add-product')" class="nav-item flex items-center gap-3 px-3.5 py-2.5 mx-2 rounded-xl text-sm font-bold text-gray-500 no-underline transition-all mb-0.5" id="nav-add-product">
            <span class="text-[17px] w-5 text-center">➕</span> Add Product
        </a>
        <a href="#" onclick="navigate('categories')" class="nav-item flex items-center gap-3 px-3.5 py-2.5 mx-2 rounded-xl text-sm font-bold text-gray-500 no-underline transition-all mb-0.5" id="nav-categories">
            <span class="text-[17px] w-5 text-center">🏷️</span> Categories
        </a>
        <a href="#" onclick="navigate('discounts')" class="nav-item flex items-center gap-3 px-3.5 py-2.5 mx-2 rounded-xl text-sm font-bold text-gray-500 no-underline transition-all mb-0.5" id="nav-discounts">
            <span class="text-[17px] w-5 text-center">🎟️</span> Discounts
        </a>

        <div class="px-3 pt-4 pb-2 text-[10px] font-black text-gray-300 tracking-widest uppercase">Settings</div>

        <a href="#" onclick="navigate('settings')" class="nav-item flex items-center gap-3 px-3.5 py-2.5 mx-2 rounded-xl text-sm font-bold text-gray-500 no-underline transition-all mb-0.5" id="nav-settings">
            <span class="text-[17px] w-5 text-center">⚙️</span> Store Settings
        </a>
        <a href="#" onclick="navigate('delivery')" class="nav-item flex items-center gap-3 px-3.5 py-2.5 mx-2 rounded-xl text-sm font-bold text-gray-500 no-underline transition-all mb-0.5" id="nav-delivery">
            <span class="text-[17px] w-5 text-center">🚚</span> Delivery Zones
        </a>
    </div>

    <!-- Footer -->
    <div class="border-t border-gray-100 p-4">
        <div class="flex items-center gap-2.5">
            <div class="w-9 h-9 rounded-full bg-[#0c7a3e] text-white flex items-center justify-center font-black text-sm shrink-0">A</div>
            <div>
                <div class="font-extrabold text-[13px] text-gray-900">Admin</div>
                <div class="text-[11px] text-gray-400 font-semibold">Super Admin</div>
            </div>
            <form action="/logout" method="POST" class="ml-auto m-0">
                <button type="submit" class="bg-red-50 hover:bg-red-100 border-none rounded-lg px-2.5 py-1.5 text-red-600 text-xs font-extrabold cursor-pointer font-nunito transition-colors">↩ Out</button>
            </form>
        </div>
    </div>
</aside>

<!-- ── MAIN ── -->
<div class="ml-[240px] flex-1 flex flex-col min-h-screen">

    <!-- Topbar -->
    <div class="h-16 bg-white border-b border-gray-100 px-8 flex items-center justify-between sticky top-0 z-40">
        <div id="breadcrumbText" class="text-[13px] text-gray-400 font-bold">
            Products &nbsp;/&nbsp; <span class="text-gray-900">Add New Product</span>
        </div>
        <div class="flex items-center gap-3">
            <a href="/" class="bg-gray-100 border-none rounded-xl px-3.5 py-2 text-[13px] font-bold text-gray-500 cursor-pointer font-nunito flex items-center gap-1.5 no-underline hover:bg-gray-200 transition-colors">🛍️ View Store</a>
            <button class="bg-gray-100 border-none rounded-xl px-3.5 py-2 text-[13px] font-bold text-gray-500 cursor-pointer font-nunito">🔔</button>
        </div>
    </div>

    <!-- ════════════════════════════════════
         PAGE: DASHBOARD
    ═══════════════════════════════════════ -->
    <div id="page-dashboard" class="page-section p-8">
        <div class="mb-7">
            <div class="text-2xl font-black text-gray-900">Dashboard</div>
            <div class="text-[13px] text-gray-400 font-semibold mt-1">Welcome back, Admin! Here's your store overview.</div>
        </div>
        <!-- Stats -->
        <div class="grid grid-cols-4 gap-5 mb-8">
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <div class="text-2xl mb-1">📦</div>
                <div class="text-3xl font-black text-gray-900">16</div>
                <div class="text-sm font-bold text-gray-400 mt-1">Total Products</div>
                <div class="text-xs text-green-600 font-bold mt-2">+2 this week</div>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <div class="text-2xl mb-1">🛒</div>
                <div class="text-3xl font-black text-gray-900">5</div>
                <div class="text-sm font-bold text-gray-400 mt-1">Pending Orders</div>
                <div class="text-xs text-orange-500 font-bold mt-2">Needs attention</div>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <div class="text-2xl mb-1">👥</div>
                <div class="text-3xl font-black text-gray-900">142</div>
                <div class="text-sm font-bold text-gray-400 mt-1">Customers</div>
                <div class="text-xs text-green-600 font-bold mt-2">+12 this month</div>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <div class="text-2xl mb-1">💰</div>
                <div class="text-3xl font-black text-gray-900">RS 24K</div>
                <div class="text-sm font-bold text-gray-400 mt-1">Revenue Today</div>
                <div class="text-xs text-green-600 font-bold mt-2">+18% vs yesterday</div>
            </div>
        </div>
        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <div class="font-black text-base text-gray-900 mb-4">Quick Actions</div>
            <div class="flex gap-3 flex-wrap">
                <button onclick="navigate('add-product')" class="bg-[#0c7a3e] text-white border-none rounded-xl px-5 py-2.5 font-extrabold text-sm cursor-pointer font-nunito hover:bg-[#0a6633] transition-colors">➕ Add Product</button>
                <button onclick="navigate('orders')" class="bg-gray-100 text-gray-700 border-none rounded-xl px-5 py-2.5 font-extrabold text-sm cursor-pointer font-nunito hover:bg-gray-200 transition-colors">🛒 View Orders</button>
                <button onclick="navigate('products')" class="bg-gray-100 text-gray-700 border-none rounded-xl px-5 py-2.5 font-extrabold text-sm cursor-pointer font-nunito hover:bg-gray-200 transition-colors">📦 Manage Products</button>
                <button onclick="navigate('customers')" class="bg-gray-100 text-gray-700 border-none rounded-xl px-5 py-2.5 font-extrabold text-sm cursor-pointer font-nunito hover:bg-gray-200 transition-colors">👥 View Customers</button>
            </div>
        </div>
    </div>

    <!-- ════════════════════════════════════
         PAGE: PRODUCTS
    ═══════════════════════════════════════ -->
    <div id="page-products" class="page-section p-8">
        <div class="flex items-center justify-between mb-7">
            <div>
                <div class="text-2xl font-black text-gray-900">Products</div>
                <div class="text-[13px] text-gray-400 font-semibold mt-1">Manage your store's product catalog</div>
            </div>
            <button onclick="navigate('add-product')" class="bg-[#0c7a3e] text-white border-none rounded-xl px-5 py-2.5 font-extrabold text-sm cursor-pointer font-nunito flex items-center gap-2 hover:bg-[#0a6633] transition-colors">➕ Add New Product</button>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div class="font-black text-sm text-gray-900">All Products <span class="text-gray-400 font-semibold">(16)</span></div>
                <input type="text" placeholder="Search products…" class="bg-gray-100 border-none rounded-xl px-4 py-2 text-sm font-semibold text-gray-700 outline-none w-56 font-nunito">
            </div>
            <div id="productsTableBody">
                <!-- Rendered by JS -->
            </div>
        </div>
    </div>

    <!-- ════════════════════════════════════
         PAGE: ORDERS
    ═══════════════════════════════════════ -->
    <div id="page-orders" class="page-section p-8">
        <div class="mb-7">
            <div class="text-2xl font-black text-gray-900">Orders</div>
            <div class="text-[13px] text-gray-400 font-semibold mt-1">Track and manage customer orders</div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 font-black text-sm text-gray-900">Recent Orders <span class="text-gray-400 font-semibold">(5 pending)</span></div>
            <div class="divide-y divide-gray-50">
                <div class="flex items-center gap-4 px-6 py-4">
                    <div class="font-extrabold text-sm text-gray-900 w-20">#ORD-001</div>
                    <div class="flex-1 text-sm font-semibold text-gray-600">Ram Sharma &mdash; Fresh Tomatoes, Bananas</div>
                    <div class="text-sm font-bold text-gray-900">RS 95</div>
                    <span class="bg-orange-100 text-orange-600 text-xs font-extrabold px-2.5 py-1 rounded-lg">Pending</span>
                </div>
                <div class="flex items-center gap-4 px-6 py-4">
                    <div class="font-extrabold text-sm text-gray-900 w-20">#ORD-002</div>
                    <div class="flex-1 text-sm font-semibold text-gray-600">Sita Thapa &mdash; Full Cream Milk × 2</div>
                    <div class="text-sm font-bold text-gray-900">RS 150</div>
                    <span class="bg-blue-100 text-blue-600 text-xs font-extrabold px-2.5 py-1 rounded-lg">Processing</span>
                </div>
                <div class="flex items-center gap-4 px-6 py-4">
                    <div class="font-extrabold text-sm text-gray-900 w-20">#ORD-003</div>
                    <div class="flex-1 text-sm font-semibold text-gray-600">Hari Pradhan &mdash; Mixed Nuts, Dark Chocolate</div>
                    <div class="text-sm font-bold text-gray-900">RS 365</div>
                    <span class="bg-green-100 text-green-700 text-xs font-extrabold px-2.5 py-1 rounded-lg">Delivered</span>
                </div>
                <div class="flex items-center gap-4 px-6 py-4">
                    <div class="font-extrabold text-sm text-gray-900 w-20">#ORD-004</div>
                    <div class="flex-1 text-sm font-semibold text-gray-600">Anita KC &mdash; Almond Milk, Orange Juice</div>
                    <div class="text-sm font-bold text-gray-900">RS 270</div>
                    <span class="bg-orange-100 text-orange-600 text-xs font-extrabold px-2.5 py-1 rounded-lg">Pending</span>
                </div>
                <div class="flex items-center gap-4 px-6 py-4">
                    <div class="font-extrabold text-sm text-gray-900 w-20">#ORD-005</div>
                    <div class="flex-1 text-sm font-semibold text-gray-600">Bijay Lama &mdash; Sourdough Bread × 3</div>
                    <div class="text-sm font-bold text-gray-900">RS 255</div>
                    <span class="bg-blue-100 text-blue-600 text-xs font-extrabold px-2.5 py-1 rounded-lg">Processing</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ════════════════════════════════════
         PAGE: CUSTOMERS
    ═══════════════════════════════════════ -->
    <div id="page-customers" class="page-section p-8">
        <div class="mb-7">
            <div class="text-2xl font-black text-gray-900">Customers</div>
            <div class="text-[13px] text-gray-400 font-semibold mt-1">View and manage your customer base</div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 font-black text-sm text-gray-900">All Customers <span class="text-gray-400 font-semibold">(142)</span></div>
            <div class="divide-y divide-gray-50">
                <div class="flex items-center gap-4 px-6 py-4">
                    <div class="w-9 h-9 rounded-full bg-[#e8f5ee] text-[#0c7a3e] flex items-center justify-center font-black text-sm">RS</div>
                    <div class="flex-1"><div class="font-bold text-sm">Ram Sharma</div><div class="text-xs text-gray-400">ram@example.com</div></div>
                    <div class="text-xs font-bold text-gray-500">8 orders</div>
                    <div class="text-sm font-extrabold text-gray-900">RS 2,340</div>
                </div>
                <div class="flex items-center gap-4 px-6 py-4">
                    <div class="w-9 h-9 rounded-full bg-[#e8f5ee] text-[#0c7a3e] flex items-center justify-center font-black text-sm">ST</div>
                    <div class="flex-1"><div class="font-bold text-sm">Sita Thapa</div><div class="text-xs text-gray-400">sita@example.com</div></div>
                    <div class="text-xs font-bold text-gray-500">5 orders</div>
                    <div class="text-sm font-extrabold text-gray-900">RS 1,200</div>
                </div>
                <div class="flex items-center gap-4 px-6 py-4">
                    <div class="w-9 h-9 rounded-full bg-[#e8f5ee] text-[#0c7a3e] flex items-center justify-center font-black text-sm">HP</div>
                    <div class="flex-1"><div class="font-bold text-sm">Hari Pradhan</div><div class="text-xs text-gray-400">hari@example.com</div></div>
                    <div class="text-xs font-bold text-gray-500">12 orders</div>
                    <div class="text-sm font-extrabold text-gray-900">RS 4,890</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ════════════════════════════════════
         PAGE: CATEGORIES
    ═══════════════════════════════════════ -->
    <div id="page-categories" class="page-section p-8">
        <div class="mb-7">
            <div class="text-2xl font-black text-gray-900">Categories</div>
            <div class="text-[13px] text-gray-400 font-semibold mt-1">Manage product categories</div>
        </div>
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-3">
                <div class="text-3xl">🥦</div>
                <div><div class="font-extrabold text-sm text-gray-900">Vegetables</div><div class="text-xs text-gray-400 font-semibold">4 products</div></div>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-3">
                <div class="text-3xl">🍎</div>
                <div><div class="font-extrabold text-sm text-gray-900">Fruits</div><div class="text-xs text-gray-400 font-semibold">3 products</div></div>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-3">
                <div class="text-3xl">🥛</div>
                <div><div class="font-extrabold text-sm text-gray-900">Dairy</div><div class="text-xs text-gray-400 font-semibold">3 products</div></div>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-3">
                <div class="text-3xl">🍞</div>
                <div><div class="font-extrabold text-sm text-gray-900">Bakery</div><div class="text-xs text-gray-400 font-semibold">3 products</div></div>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-3">
                <div class="text-3xl">🧃</div>
                <div><div class="font-extrabold text-sm text-gray-900">Beverages</div><div class="text-xs text-gray-400 font-semibold">2 products</div></div>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-3">
                <div class="text-3xl">🍫</div>
                <div><div class="font-extrabold text-sm text-gray-900">Snacks</div><div class="text-xs text-gray-400 font-semibold">3 products</div></div>
            </div>
        </div>
    </div>

    <!-- ════════════════════════════════════
         PAGE: DISCOUNTS
    ═══════════════════════════════════════ -->
    <div id="page-discounts" class="page-section p-8">
        <div class="mb-7">
            <div class="text-2xl font-black text-gray-900">Discounts</div>
            <div class="text-[13px] text-gray-400 font-semibold mt-1">Create and manage discount codes</div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center text-gray-300">
            <div class="text-5xl mb-3">🎟️</div>
            <div class="font-bold text-base">No active discount codes</div>
            <button class="mt-4 bg-[#0c7a3e] text-white border-none rounded-xl px-5 py-2.5 font-extrabold text-sm cursor-pointer font-nunito">+ Create Discount</button>
        </div>
    </div>

    <!-- ════════════════════════════════════
         PAGE: SETTINGS
    ═══════════════════════════════════════ -->
    <div id="page-settings" class="page-section p-8">
        <div class="mb-7">
            <div class="text-2xl font-black text-gray-900">Store Settings</div>
            <div class="text-[13px] text-gray-400 font-semibold mt-1">Configure your store preferences</div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-6 max-w-lg">
            <div class="font-black text-sm text-gray-900 mb-4">General</div>
            <div class="mb-4">
                <label class="block text-xs font-extrabold text-gray-500 mb-1.5">Store Name</label>
                <input type="text" value="ArbeenStore" class="form-input w-full bg-gray-50 border-[1.5px] border-gray-200 rounded-xl px-3.5 py-2.5 text-sm font-semibold font-nunito text-gray-900 outline-none">
            </div>
            <div class="mb-4">
                <label class="block text-xs font-extrabold text-gray-500 mb-1.5">Location</label>
                <input type="text" value="Kathmandu, Nepal" class="form-input w-full bg-gray-50 border-[1.5px] border-gray-200 rounded-xl px-3.5 py-2.5 text-sm font-semibold font-nunito text-gray-900 outline-none">
            </div>
            <button class="bg-[#0c7a3e] text-white border-none rounded-xl px-5 py-2.5 font-extrabold text-sm cursor-pointer font-nunito hover:bg-[#0a6633] transition-colors">Save Settings</button>
        </div>
    </div>

    <!-- ════════════════════════════════════
         PAGE: DELIVERY
    ═══════════════════════════════════════ -->
    <div id="page-delivery" class="page-section p-8">
        <div class="mb-7">
            <div class="text-2xl font-black text-gray-900">Delivery Zones</div>
            <div class="text-[13px] text-gray-400 font-semibold mt-1">Configure delivery areas and fees</div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 font-black text-sm text-gray-900">Active Zones</div>
            <div class="divide-y divide-gray-50">
                <div class="flex items-center gap-4 px-6 py-4">
                    <div class="text-2xl">📍</div>
                    <div class="flex-1"><div class="font-bold text-sm">Kathmandu Core</div><div class="text-xs text-gray-400">Thamel, Maharajgunj, Lazimpat</div></div>
                    <div class="text-sm font-extrabold text-[#0c7a3e]">FREE</div>
                </div>
                <div class="flex items-center gap-4 px-6 py-4">
                    <div class="text-2xl">📍</div>
                    <div class="flex-1"><div class="font-bold text-sm">Patan / Lalitpur</div><div class="text-xs text-gray-400">Jawalakhel, Kupondole</div></div>
                    <div class="text-sm font-extrabold text-gray-700">RS 50</div>
                </div>
                <div class="flex items-center gap-4 px-6 py-4">
                    <div class="text-2xl">📍</div>
                    <div class="flex-1"><div class="font-bold text-sm">Bhaktapur</div><div class="text-xs text-gray-400">Durbar Square area</div></div>
                    <div class="text-sm font-extrabold text-gray-700">RS 100</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ════════════════════════════════════
         PAGE: ADD PRODUCT
    ═══════════════════════════════════════ -->
    <div id="page-add-product" class="page-section flex-1 p-8 pb-12">

        <div class="flex items-center justify-between mb-7">
            <div>
                <div class="text-2xl font-black text-gray-900">Add New Product</div>
                <div class="text-[13px] text-gray-400 font-semibold mt-1">Fill in the details below to list a new product in your store</div>
            </div>
            <div class="flex gap-2.5">
                <button onclick="resetForm()" class="bg-white border-[1.5px] border-gray-200 hover:border-[#0c7a3e] hover:text-[#0c7a3e] rounded-xl px-5 py-2.5 text-[13px] font-extrabold text-gray-500 cursor-pointer font-nunito transition-colors">✕ Discard</button>
                <button onclick="submitForm()" class="bg-[#0c7a3e] hover:bg-[#0a6633] border-none rounded-xl px-5 py-2.5 text-[13px] font-extrabold text-white cursor-pointer font-nunito flex items-center gap-2 transition-colors">✓ Publish Product</button>
            </div>
        </div>

        <!-- Form Grid -->
        <div class="grid gap-6" style="grid-template-columns: 1fr 360px; align-items: start;">

            <!-- LEFT -->
            <div class="flex flex-col gap-5">

                <!-- Basic Info -->
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-[#e8f5ee] flex items-center justify-center text-base">📝</div>
                        <div>
                            <div class="font-black text-[15px] text-gray-900">Basic Information</div>
                            <div class="text-xs text-gray-400 font-semibold mt-0.5">Name, description and category</div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="mb-5">
                            <label class="block text-[13px] font-extrabold text-gray-700 mb-1.5">Product Name <span class="text-red-500">*</span></label>
                            <input type="text" id="productName" placeholder="e.g. Fresh Organic Tomatoes" oninput="updatePreview()" maxlength="60"
                                class="form-input w-full bg-gray-50 border-[1.5px] border-gray-200 rounded-xl px-3.5 py-2.5 text-sm font-semibold font-nunito text-gray-900 transition-all">
                            <div class="text-[11px] text-gray-300 font-bold text-right mt-1" id="nameCounter">0 / 60</div>
                            <div class="text-[11px] text-red-500 font-bold mt-1 hidden" id="nameError">Product name is required</div>
                        </div>
                        <div class="mb-5">
                            <label class="block text-[13px] font-extrabold text-gray-700 mb-1.5">Description <span class="text-[11px] font-semibold text-gray-400 ml-1.5">Optional</span></label>
                            <textarea id="productDesc" placeholder="Describe the product — freshness, origin, nutritional info..." maxlength="300" oninput="updateDescCounter()" rows="3"
                                class="form-input w-full bg-gray-50 border-[1.5px] border-gray-200 rounded-xl px-3.5 py-2.5 text-sm font-semibold font-nunito text-gray-900 transition-all resize-y leading-relaxed"></textarea>
                            <div class="text-[11px] text-gray-300 font-bold text-right mt-1" id="descCounter">0 / 300</div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[13px] font-extrabold text-gray-700 mb-1.5">Category <span class="text-red-500">*</span></label>
                                <select id="productCategory" onchange="updatePreview()"
                                    class="form-input w-full bg-gray-50 border-[1.5px] border-gray-200 rounded-xl px-3.5 py-2.5 text-sm font-semibold font-nunito text-gray-900 cursor-pointer transition-all">
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
                                <div class="text-[11px] text-red-500 font-bold mt-1 hidden" id="catError">Please select a category</div>
                            </div>
                            <div>
                                <label class="block text-[13px] font-extrabold text-gray-700 mb-1.5">Unit / Weight <span class="text-red-500">*</span></label>
                                <input type="text" id="productUnit" placeholder="e.g. 500g, 1L, 6 pcs" oninput="updatePreview()"
                                    class="form-input w-full bg-gray-50 border-[1.5px] border-gray-200 rounded-xl px-3.5 py-2.5 text-sm font-semibold font-nunito text-gray-900 transition-all">
                                <div class="text-[11px] text-red-500 font-bold mt-1 hidden" id="unitError">Unit is required</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-[#e8f5ee] flex items-center justify-center text-base">💰</div>
                        <div>
                            <div class="font-black text-[15px] text-gray-900">Pricing</div>
                            <div class="text-xs text-gray-400 font-semibold mt-0.5">Set the selling and compare-at price</div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4 mb-2">
                            <div>
                                <label class="block text-[13px] font-extrabold text-gray-700 mb-1.5">Selling Price <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute left-0 top-0 bottom-0 w-11 flex items-center justify-center text-[13px] font-black text-gray-400 bg-gray-100 rounded-l-xl border-r-[1.5px] border-gray-200 pointer-events-none">RS</div>
                                    <input type="number" id="productPrice" placeholder="0" min="0" oninput="updatePreview()"
                                        class="form-input w-full bg-gray-50 border-[1.5px] border-gray-200 rounded-xl pl-14 pr-3.5 py-2.5 text-sm font-semibold font-nunito text-gray-900 transition-all">
                                </div>
                                <div class="text-[11px] text-red-500 font-bold mt-1 hidden" id="priceError">Price is required</div>
                            </div>
                            <div>
                                <label class="block text-[13px] font-extrabold text-gray-700 mb-1.5">Compare-at Price <span class="text-[11px] font-semibold text-gray-400 ml-1">Optional</span></label>
                                <div class="relative">
                                    <div class="absolute left-0 top-0 bottom-0 w-11 flex items-center justify-center text-[13px] font-black text-gray-400 bg-gray-100 rounded-l-xl border-r-[1.5px] border-gray-200 pointer-events-none">RS</div>
                                    <input type="number" id="comparePrice" placeholder="0" min="0"
                                        class="form-input w-full bg-gray-50 border-[1.5px] border-gray-200 rounded-xl pl-14 pr-3.5 py-2.5 text-sm font-semibold font-nunito text-gray-900 transition-all">
                                </div>
                            </div>
                        </div>
                        <div id="discountBadge" class="hidden mt-1">
                            <span class="bg-[#e8f5e9] text-[#2e7d32] text-xs font-extrabold px-2.5 py-1 rounded-lg">🏷️ <span id="discountPct"></span>% OFF shown to customers</span>
                        </div>
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-[#e8f5ee] flex items-center justify-center text-base">🖼️</div>
                        <div>
                            <div class="font-black text-[15px] text-gray-900">Product Image</div>
                            <div class="text-xs text-gray-400 font-semibold mt-0.5">JPG, PNG or WEBP — recommended 800×800px</div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div id="uploadZone" class="upload-zone border-2 border-dashed border-[#d0e8da] rounded-2xl p-7 text-center cursor-pointer transition-all bg-[#fafffe] hover:border-[#0c7a3e] hover:bg-[#e8f5ee] relative"
                            onclick="document.getElementById('imageInput').click()">
                            <input type="file" id="imageInput" accept="image/*" onchange="handleImageUpload(event)" class="hidden">
                            <div id="uploadDefault">
                                <div class="text-4xl mb-2.5">📸</div>
                                <div class="font-extrabold text-sm text-gray-700 mb-1">Click to upload product image</div>
                                <div class="text-xs text-gray-400 font-semibold">or drag and drop here</div>
                                <div class="mt-3 text-[11px] text-gray-300 font-bold">Max size: 5MB</div>
                            </div>
                            <div id="uploadPreviewWrap" class="hidden relative">
                                <img id="uploadPreviewImg" class="w-full h-[220px] object-cover rounded-xl block" src="" alt="Preview">
                                <div class="upload-preview-overlay absolute inset-0 bg-black/45 rounded-xl hidden items-center justify-center text-white font-extrabold text-[13px] gap-1.5">📷 Change Image</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5 my-3.5">
                            <div class="flex-1 h-px bg-gray-100"></div>
                            <span class="text-xs text-gray-300 font-bold">or paste URL</span>
                            <div class="flex-1 h-px bg-gray-100"></div>
                        </div>
                        <input type="url" id="imageUrl" placeholder="https://example.com/image.jpg" oninput="handleUrlInput()"
                            class="form-input w-full bg-gray-50 border-[1.5px] border-gray-200 rounded-xl px-3.5 py-2.5 text-sm font-semibold font-nunito text-gray-900 transition-all">
                    </div>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="flex flex-col gap-5">

                <!-- Live Preview -->
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-[#e8f5ee] flex items-center justify-center text-base">👁️</div>
                        <div>
                            <div class="font-black text-[15px] text-gray-900">Live Preview</div>
                            <div class="text-xs text-gray-400 font-semibold mt-0.5">How it looks in the store</div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="text-[11px] font-black text-gray-300 tracking-widest uppercase mb-3.5">Customer view</div>
                        <div class="border-[1.5px] border-gray-100 rounded-2xl overflow-hidden max-w-[200px] mx-auto">
                            <div class="h-[130px] bg-[#e8f5ee] flex items-center justify-center relative overflow-hidden">
                                <img id="previewImg" src="" alt="" class="w-full h-full object-cover hidden">
                                <div class="text-[44px]" id="previewPlaceholder">🛒</div>
                                <div id="previewTag" class="hidden absolute top-2 left-2 text-[9px] font-black rounded px-1.5 py-0.5"></div>
                            </div>
                            <div class="p-2.5 pb-3">
                                <div id="previewName" class="font-extrabold text-[13px] text-gray-900 mb-0.5 min-h-[18px]">Product name</div>
                                <div id="previewUnit" class="text-[11px] text-gray-400 font-semibold mb-2">Unit</div>
                                <div class="flex items-center justify-between">
                                    <div id="previewPrice" class="font-black text-[15px] text-gray-900">RS —</div>
                                    <button class="bg-[#0c7a3e] text-white border-none rounded-lg px-3 py-1 text-[11px] font-black font-nunito cursor-default">ADD</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tag -->
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-[#e8f5ee] flex items-center justify-center text-base">🏷️</div>
                        <div>
                            <div class="font-black text-[15px] text-gray-900">Product Tag</div>
                            <div class="text-xs text-gray-400 font-semibold mt-0.5">Badge shown on the card</div>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="flex flex-wrap gap-2">
                            <input type="radio" name="tag" id="tagNone" value="" class="tag-option" checked onchange="updateTag()">
                            <label for="tagNone" class="tag-label px-3.5 py-1.5 rounded-full text-xs font-extrabold cursor-pointer border-[1.5px] border-gray-200 text-gray-500 transition-all">No Tag</label>

                            <input type="radio" name="tag" id="tagFresh" value="Fresh" class="tag-option" onchange="updateTag()">
                            <label for="tagFresh" class="tag-label px-3.5 py-1.5 rounded-full text-xs font-extrabold cursor-pointer border-[1.5px] transition-all" style="border-color:#c8e6c9;color:#2e7d32;">🌿 Fresh</label>

                            <input type="radio" name="tag" id="tagNew" value="New" class="tag-option" onchange="updateTag()">
                            <label for="tagNew" class="tag-label px-3.5 py-1.5 rounded-full text-xs font-extrabold cursor-pointer border-[1.5px] transition-all" style="border-color:#bbdefb;color:#0d47a1;">✨ New</label>

                            <input type="radio" name="tag" id="tagOrganic" value="Organic" class="tag-option" onchange="updateTag()">
                            <label for="tagOrganic" class="tag-label px-3.5 py-1.5 rounded-full text-xs font-extrabold cursor-pointer border-[1.5px] transition-all" style="border-color:#e1bee7;color:#6a1b9a;">🌱 Organic</label>

                            <input type="radio" name="tag" id="tagBest" value="Best Seller" class="tag-option" onchange="updateTag()">
                            <label for="tagBest" class="tag-label px-3.5 py-1.5 rounded-full text-xs font-extrabold cursor-pointer border-[1.5px] transition-all" style="border-color:#ffe0b2;color:#e65100;">🔥 Best Seller</label>

                            <input type="radio" name="tag" id="tagPopular" value="Popular" class="tag-option" onchange="updateTag()">
                            <label for="tagPopular" class="tag-label px-3.5 py-1.5 rounded-full text-xs font-extrabold cursor-pointer border-[1.5px] transition-all" style="border-color:#fce4ec;color:#880e4f;">⭐ Popular</label>

                            <input type="radio" name="tag" id="tagHealthy" value="Healthy" class="tag-option" onchange="updateTag()">
                            <label for="tagHealthy" class="tag-label px-3.5 py-1.5 rounded-full text-xs font-extrabold cursor-pointer border-[1.5px] transition-all" style="border-color:#b2dfdb;color:#004d40;">💚 Healthy</label>
                        </div>
                    </div>
                </div>

                <!-- Inventory -->
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-[#e8f5ee] flex items-center justify-center text-base">📦</div>
                        <div>
                            <div class="font-black text-[15px] text-gray-900">Inventory</div>
                            <div class="text-xs text-gray-400 font-semibold mt-0.5">Stock quantity</div>
                        </div>
                    </div>
                    <div class="p-6">
                        <label class="block text-[13px] font-extrabold text-gray-700 mb-1.5">Stock Quantity <span class="text-red-500">*</span></label>
                        <input type="number" id="stockQty" placeholder="0" min="0" oninput="updateStock()"
                            class="form-input w-full bg-gray-50 border-[1.5px] border-gray-200 rounded-xl px-3.5 py-2.5 text-sm font-semibold font-nunito text-gray-900 transition-all">
                        <div id="stockDisplay" class="hidden bg-[#e8f5ee] rounded-xl px-4 py-3 flex items-center justify-between mt-2.5">
                            <span class="text-xs font-bold text-gray-500">Units available</span>
                            <span id="stockVal" class="text-xl font-black text-[#0c7a3e]">0</span>
                        </div>
                    </div>
                </div>

                <!-- Visibility -->
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-[#e8f5ee] flex items-center justify-center text-base">⚙️</div>
                        <div>
                            <div class="font-black text-[15px] text-gray-900">Visibility &amp; Status</div>
                            <div class="text-xs text-gray-400 font-semibold mt-0.5">Control how this product appears</div>
                        </div>
                    </div>
                    <div class="px-6 py-2">
                        <div class="flex items-center justify-between py-3.5 border-b border-gray-50">
                            <div>
                                <div class="text-sm font-extrabold text-gray-900">Published</div>
                                <div class="text-xs text-gray-400 font-semibold mt-0.5">Visible to customers in store</div>
                            </div>
                            <label class="switch"><input type="checkbox" id="togglePublished" checked><span class="slider"></span></label>
                        </div>
                        <div class="flex items-center justify-between py-3.5 border-b border-gray-50">
                            <div>
                                <div class="text-sm font-extrabold text-gray-900">Featured Product</div>
                                <div class="text-xs text-gray-400 font-semibold mt-0.5">Show in featured section</div>
                            </div>
                            <label class="switch"><input type="checkbox" id="toggleFeatured"><span class="slider"></span></label>
                        </div>
                        <div class="flex items-center justify-between py-3.5">
                            <div>
                                <div class="text-sm font-extrabold text-gray-900">Track Inventory</div>
                                <div class="text-xs text-gray-400 font-semibold mt-0.5">Auto hide when out of stock</div>
                            </div>
                            <label class="switch"><input type="checkbox" id="toggleTrack" checked><span class="slider"></span></label>
                        </div>
                    </div>
                </div>

                <button onclick="submitForm()" class="bg-[#0c7a3e] hover:bg-[#0a6633] border-none rounded-2xl py-3.5 px-6 w-full font-nunito text-[15px] font-extrabold text-white cursor-pointer justify-center flex items-center gap-2 transition-colors">✓ Publish Product</button>
                <button onclick="resetForm()" class="bg-white border-[1.5px] border-gray-200 hover:border-[#0c7a3e] hover:text-[#0c7a3e] rounded-2xl py-3 px-6 w-full text-center font-nunito text-[13px] font-extrabold text-gray-500 cursor-pointer transition-colors">✕ Discard Changes</button>
            </div>
        </div>
    </div>
    <!-- end page-add-product -->

</div>
<!-- end main -->

<!-- Toast -->
<div id="toast" class="toast fixed bottom-8 right-8 bg-gray-900 text-white px-5 py-3.5 rounded-2xl text-sm font-bold flex items-center gap-2.5 shadow-2xl z-[999]">
    <span class="text-lg">✅</span>
    <span id="toastMsg">Product published successfully!</span>
</div>

<script>
    // ── Products data (for the Products page table) ──
    const products = [
        { id:1,  name:"Fresh Tomatoes",        price:35,   unit:"1kg",   category:"Vegetables",   tag:"Fresh" },
        { id:2,  name:"Organic Bananas",        price:60,   unit:"6 pcs", category:"Fruits",       tag:"Organic" },
        { id:3,  name:"Full Cream Milk",        price:75,   unit:"1L",    category:"Dairy",        tag:"Best Seller" },
        { id:5,  name:"JuJu Dhau",              price:90,   unit:"200g",  category:"Dairy",        tag:"New" },
        { id:4,  name:"Multigrain Bread",       price:55,   unit:"400g",  category:"Bakery",       tag:null },
        { id:6,  name:"Orange Juice",           price:110,  unit:"1L",    category:"Beverages",    tag:"Popular" },
        { id:7,  name:"Dark Chocolate",         price:145,  unit:"100g",  category:"Snacks",       tag:null },
        { id:8,  name:"Spinach Leaves",         price:40,   unit:"250g",  category:"Vegetables",   tag:"Fresh" },
        { id:9,  name:"Churpi Himalayan Cheese",price:180,  unit:"200g",  category:"Dairy",        tag:null },
        { id:10, name:"Mixed Nuts",             price:220,  unit:"200g",  category:"Snacks",       tag:"Healthy" },
        { id:11, name:"Green Apples",           price:95,   unit:"4 pcs", category:"Fruits",       tag:null },
        { id:12, name:"Butter Croissant",       price:65,   unit:"2 pcs", category:"Bakery",       tag:"Fresh" },
        { id:13, name:"Watermelon",             price:120,  unit:"1 pc",  category:"Fruits",       tag:"Popular" },
        { id:14, name:"Potato Chips",           price:55,   unit:"150g",  category:"Snacks",       tag:null },
        { id:15, name:"Almond Milk",            price:160,  unit:"1L",    category:"Beverages",    tag:"Healthy" },
        { id:16, name:"Sourdough Bread",        price:85,   unit:"500g",  category:"Bakery",       tag:"New" },
        { id:17, name:"Arbeen Brand Soap",      price:675,  unit:"3 pcs", category:"Personal Care",tag:null },
        { id:18, name:"Baby Oil",               price:2000, unit:"3 pcs", category:"Personal Care",tag:null },
    ];

    function renderProductsTable() {
        const tbody = document.getElementById('productsTableBody');
        if (!tbody) return;
        tbody.innerHTML = products.map(p => `
        <div class="flex items-center gap-4 px-6 py-3.5 border-b border-gray-50 hover:bg-gray-50 transition-colors">
            <div class="w-10 h-10 rounded-xl bg-[#e8f5ee] flex items-center justify-center text-xl shrink-0">
                ${ {Vegetables:'🥦',Fruits:'🍎',Dairy:'🥛',Bakery:'🍞',Beverages:'🧃',Snacks:'🍫',Meat:'🍗','Personal Care':'🧴'}[p.category] || '📦' }
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-bold text-sm text-gray-900 truncate">${p.name}</div>
                <div class="text-xs text-gray-400 font-semibold">${p.category} &nbsp;·&nbsp; ${p.unit}</div>
            </div>
            ${p.tag ? `<span class="text-[10px] font-extrabold bg-[#e8f5ee] text-[#0c7a3e] px-2 py-0.5 rounded-lg">${p.tag}</span>` : ''}
            <div class="font-extrabold text-sm text-gray-900 min-w-[60px] text-right">RS ${p.price}</div>
            <div class="flex gap-1.5">
                <button class="bg-gray-100 border-none rounded-lg px-2.5 py-1.5 text-xs font-bold cursor-pointer font-nunito hover:bg-gray-200 transition-colors">Edit</button>
                <button class="bg-red-50 border-none rounded-lg px-2.5 py-1.5 text-xs font-bold text-red-500 cursor-pointer font-nunito hover:bg-red-100 transition-colors">Delete</button>
            </div>
        </div>`).join('');
    }

    // ── Navigation ──
    const pageTitles = {
        'dashboard':   'Dashboard',
        'products':    'Products',
        'orders':      'Orders',
        'customers':   'Customers',
        'add-product': 'Products / <span class="text-gray-900">Add New Product</span>',
        'categories':  'Catalog / <span class="text-gray-900">Categories</span>',
        'discounts':   'Catalog / <span class="text-gray-900">Discounts</span>',
        'settings':    'Settings / <span class="text-gray-900">Store Settings</span>',
        'delivery':    'Settings / <span class="text-gray-900">Delivery Zones</span>',
    };

    function navigate(page) {
        // Hide all pages
        document.querySelectorAll('.page-section').forEach(p => p.classList.remove('active'));
        // Deactivate all nav items
        document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));

        // Show target page
        const target = document.getElementById('page-' + page);
        if (target) target.classList.add('active');

        // Activate nav item
        const navEl = document.getElementById('nav-' + page);
        if (navEl) navEl.classList.add('active');

        // Update breadcrumb
        document.getElementById('breadcrumbText').innerHTML = pageTitles[page] || page;

        // Special: render products table
        if (page === 'products') renderProductsTable();

        return false;
    }

    // Default page
    navigate('add-product');

    // ── Tag meta ──
    const tagMeta = {
        'Fresh':       { bg:'#e8f5e9', color:'#2e7d32' },
        'New':         { bg:'#e3f2fd', color:'#0d47a1' },
        'Organic':     { bg:'#f3e5f5', color:'#6a1b9a' },
        'Best Seller': { bg:'#fff3e0', color:'#e65100' },
        'Popular':     { bg:'#fce4ec', color:'#880e4f' },
        'Healthy':     { bg:'#e0f2f1', color:'#004d40' },
    };

    // ── Live Preview ──
    function updatePreview() {
        const name  = document.getElementById('productName').value.trim();
        const unit  = document.getElementById('productUnit').value.trim();
        const price = document.getElementById('productPrice').value;
        document.getElementById('previewName').textContent  = name  || 'Product name';
        document.getElementById('previewUnit').textContent  = unit  || 'Unit';
        document.getElementById('previewPrice').textContent = price ? `RS ${price}` : 'RS —';
        const nameLen = document.getElementById('productName').value.length;
        document.getElementById('nameCounter').textContent = `${nameLen} / 60`;
        // discount
        const sell    = parseFloat(document.getElementById('productPrice').value) || 0;
        const compare = parseFloat(document.getElementById('comparePrice').value) || 0;
        const badge   = document.getElementById('discountBadge');
        if (compare > sell && sell > 0) {
            const pct = Math.round(((compare - sell) / compare) * 100);
            document.getElementById('discountPct').textContent = pct;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    }

    function updateDescCounter() {
        const len = document.getElementById('productDesc').value.length;
        document.getElementById('descCounter').textContent = `${len} / 300`;
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
        } else {
            previewTag.classList.add('hidden');
        }
    }

    function updateStock() {
        const qty = parseInt(document.getElementById('stockQty').value) || 0;
        const display = document.getElementById('stockDisplay');
        const val = document.getElementById('stockVal');
        if (document.getElementById('stockQty').value !== '') {
            display.classList.remove('hidden');
            display.classList.add('flex');
            val.textContent = qty;
            display.style.background = qty === 0 ? '#fce4ec' : qty < 10 ? '#fff3e0' : '#e8f5e9';
            val.style.color = qty === 0 ? '#c62828' : qty < 10 ? '#e65100' : '#0c7a3e';
        } else {
            display.classList.add('hidden');
            display.classList.remove('flex');
        }
    }

    // ── Image upload ──
    function handleImageUpload(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(ev) { setPreviewImage(ev.target.result); };
        reader.readAsDataURL(file);
    }

    function handleUrlInput() {
        const url = document.getElementById('imageUrl').value.trim();
        if (url) setPreviewImage(url);
    }

    function setPreviewImage(src) {
        document.getElementById('uploadDefault').classList.add('hidden');
        const wrap = document.getElementById('uploadPreviewWrap');
        wrap.classList.remove('hidden');
        document.getElementById('uploadPreviewImg').src = src;
        // card preview
        const previewImg = document.getElementById('previewImg');
        previewImg.src = src;
        previewImg.classList.remove('hidden');
        document.getElementById('previewPlaceholder').classList.add('hidden');
    }

    document.getElementById('comparePrice').addEventListener('input', updatePreview);
    document.getElementById('productPrice').addEventListener('input', updatePreview);

    // Drag & Drop
    const zone = document.getElementById('uploadZone');
    zone.addEventListener('dragover', e => { e.preventDefault(); zone.style.borderColor = '#0c7a3e'; });
    zone.addEventListener('dragleave', () => { zone.style.borderColor = '#d0e8da'; });
    zone.addEventListener('drop', e => {
        e.preventDefault();
        zone.style.borderColor = '#d0e8da';
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = ev => setPreviewImage(ev.target.result);
            reader.readAsDataURL(file);
        }
    });

    // ── Validation ──
    function validate() {
        let ok = true;
        const fields = [
            { id:'productName', err:'nameError', check: v => v.trim() !== '' },
            { id:'productCategory', err:'catError', check: v => v !== '' },
            { id:'productUnit', err:'unitError', check: v => v.trim() !== '' },
            { id:'productPrice', err:'priceError', check: v => v !== '' && parseFloat(v) >= 0 },
        ];
        fields.forEach(f => {
            const el  = document.getElementById(f.id);
            const err = document.getElementById(f.err);
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
        if (!validate()) { showToast('⚠️ Please fill in all required fields', '#e53935'); return; }
        showToast('✅ Product published successfully!', '#0c7a3e');
    }

    function resetForm() {
        document.querySelectorAll('#page-add-product input[type="text"],#page-add-product input[type="number"],#page-add-product input[type="url"],#page-add-product select,#page-add-product textarea').forEach(el => {
            el.value = '';
            el.classList.remove('error');
        });
        document.querySelectorAll('#page-add-product [id$="Error"]').forEach(el => el.classList.add('hidden'));
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
        document.getElementById('discountBadge').classList.add('hidden');
        document.getElementById('nameCounter').textContent = '0 / 60';
        document.getElementById('descCounter').textContent = '0 / 300';
        updateTag();
        showToast('🗑️ Form cleared', '#555');
    }

    let toastTimer;
    function showToast(msg, bg) {
        const t = document.getElementById('toast');
        document.getElementById('toastMsg').textContent = msg;
        t.style.background = bg || '#1a1a1a';
        t.classList.add('show');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => t.classList.remove('show'), 3000);
    }
</script>
</body>
</html>