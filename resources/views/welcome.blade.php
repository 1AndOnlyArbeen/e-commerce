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
                        green: { brand: '#0c7a3e', dark: '#0a6633', light: '#1aad5e', pale: '#f0faf4', muted: '#a8e6c1' }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Nunito', sans-serif; }

        /* ── Cart badge ── */
        .cart-badge { display: none; }
        .cart-badge.visible { display: flex; }

        /* ── Drawer ── */
        .drawer { transition: right 0.3s ease; }

        /* ── Image zoom on hover ── */
        .product-img-wrap { overflow: hidden; }
        .product-img-wrap img {
            transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            will-change: transform;
        }
        .product-img-wrap:hover img { transform: scale(1.12); }

        /* ── Product card ── */
        .product-card {
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(12,122,62,0.12);
        }

        /* ── Product Detail Modal ── */
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
        .modal-box {
            background: #fff;
            border-radius: 24px;
            width: 780px;
            max-width: 95vw;
            max-height: 90vh;
            overflow: hidden;
            display: flex;
            animation: modalIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 40px 80px rgba(0,0,0,0.25);
        }
        @keyframes modalIn {
            from { transform: scale(0.88) translateY(20px); opacity: 0; }
            to   { transform: scale(1) translateY(0); opacity: 1; }
        }

        /* ── Modal image zoom ── */
        .modal-img-wrap { overflow: hidden; }
        .modal-img-wrap img {
            transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .modal-img-wrap:hover img { transform: scale(1.08); }

        /* ── Quantity stepper ── */
        .qty-btn {
            width: 34px; height: 34px;
            border: 2px solid #0c7a3e;
            border-radius: 10px;
            background: transparent;
            color: #0c7a3e;
            font-size: 20px;
            font-weight: 900;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.15s;
            font-family: 'Nunito', sans-serif;
        }
        .qty-btn:hover { background: #0c7a3e; color: #fff; }

        /* ── Tag badge ── */
        .tag-badge {
            display: inline-block;
            font-size: 10px;
            font-weight: 800;
            border-radius: 6px;
            padding: 2px 8px;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen font-nunito">

    <!-- ── Navbar ── -->
    <nav class="bg-[#0c7a3e] px-10 h-16 flex items-center justify-between sticky top-0 z-[100] shadow-lg">
        <div class="flex items-center gap-4">
            <a href="/" class="flex items-center gap-2.5 no-underline">
                <div class="bg-white rounded-xl w-10 h-10 flex items-center justify-center text-2xl">🌿</div>
                <div>
                    <div class="text-white font-black text-xl leading-none">Arbeen</div>
                    <div class="text-[#a8e6c1] text-[11px] font-semibold">Store</div>
                </div>
            </a>
            <div class="bg-white/15 rounded-full px-3.5 py-1.5 flex items-center gap-1.5 text-white text-[13px] font-bold">
                ⚡ Delivery in 30 mins &nbsp;·&nbsp; Kathmandu, NP
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
                <button id="accountBtn" onclick="toggleAccountMenu()"
                    class="bg-white/15 border-none rounded-xl px-4 py-2 text-white text-[13px] font-bold cursor-pointer font-[Nunito] flex items-center gap-1.5">
                    👤 Account ▾
                </button>
                <div id="accountMenu"
                    class="hidden absolute top-[calc(100%+10px)] right-0 bg-white rounded-xl shadow-2xl min-w-[180px] z-[200] overflow-hidden">
                    <div class="px-4 py-3.5 border-b border-gray-100 font-black text-[13px] text-gray-700 bg-gray-50">👤 My Account</div>
                    <button class="flex items-center gap-2.5 px-4 py-3 text-sm font-bold text-gray-600 cursor-pointer hover:bg-gray-50 w-full text-left border-none bg-transparent font-[Nunito]">🙍 Profile</button>
                    <button class="flex items-center gap-2.5 px-4 py-3 text-sm font-bold text-gray-600 cursor-pointer hover:bg-gray-50 w-full text-left border-none bg-transparent font-[Nunito]">📦 My Orders</button>
                    <hr class="border-t border-gray-100 m-0">
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center gap-2.5 px-4 py-3 text-sm font-bold text-red-600 cursor-pointer hover:bg-red-50 w-full text-left border-none bg-transparent font-[Nunito]">🚪 Logout</button>
                    </form>
                </div>
            </div>

            <button onclick="openCart()"
                class="bg-white text-[#0c7a3e] border-none rounded-xl px-4 py-2 text-[13px] font-extrabold cursor-pointer font-[Nunito] flex items-center gap-2 relative">
                🛒 Cart
                <div id="cartBadge" class="cart-badge bg-red-500 text-white rounded-full w-5 h-5 text-[11px] font-extrabold items-center justify-center">0</div>
            </button>
        </div>
    </nav>

    <!-- ── Page Layout ── -->
    <div class="flex min-h-[calc(100vh-64px)]">

        <!-- Sidebar -->
        <aside class="w-[220px] shrink-0 bg-white px-4 py-6 border-r border-gray-100 sticky top-16 h-[calc(100vh-64px)] overflow-y-auto">
            <div class="text-xs font-black text-gray-400 tracking-widest uppercase mb-3">Categories</div>
            @foreach([['All','🏪','All Products'],['Vegetables','🥦','Vegetables'],['Fruits','🍎','Fruits'],['Dairy','🥛','Dairy'],['Bakery','🍞','Bakery'],['Beverages','🧃','Beverages'],['Snacks','🍫','Snacks'],['Meat','🍗','Meat & Fish'],['Personal Care','🧴','Personal Care']] as [$val,$emoji,$label])
            <button
                class="cat-btn {{ $val==='All' ? 'active bg-[#0c7a3e] text-white' : 'bg-transparent text-gray-600 hover:bg-[#f0faf4] hover:text-[#0c7a3e]' }} flex items-center gap-2.5 w-full border-none rounded-xl px-3 py-2.5 text-sm font-bold cursor-pointer font-[Nunito] transition-all mb-1 text-left"
                onclick="setCategory('{{ $val }}', this)">
                <span class="text-lg w-6 text-center">{{ $emoji }}</span> {{ $label }}
            </button>
            @endforeach
        </aside>

        <!-- Main Content -->
        <main class="flex-1 px-8 pt-7 pb-28 overflow-y-auto">

            <!-- Banner -->
            <div class="bg-gradient-to-br from-[#0c7a3e] to-[#1aad5e] rounded-2xl px-10 py-8 flex items-center justify-between mb-8 relative overflow-hidden">
                <div class="absolute -right-8 -top-8 w-44 h-44 bg-white/[0.07] rounded-full"></div>
                <div class="absolute right-24 -bottom-10 w-28 h-28 bg-white/[0.05] rounded-full"></div>
                <div class="relative z-10">
                    <div class="text-yellow-300 text-xs font-extrabold tracking-widest mb-2">🎉 LIMITED TIME OFFER</div>
                    <div class="text-white text-3xl font-black leading-tight mb-4">Fresh Vegetables<br>Up to 30% Off</div>
                    <button class="bg-white text-[#0c7a3e] border-none rounded-xl px-6 py-2.5 text-sm font-extrabold cursor-pointer font-[Nunito]">Shop Now →</button>
                </div>
            </div>

            <!-- Products Header -->
            <div class="flex items-center justify-between mb-5">
                <div class="font-black text-xl text-gray-900">
                    All Products <span id="productCount" class="font-semibold text-sm text-gray-400 ml-2"></span>
                </div>
                <div class="text-[#0c7a3e] text-[13px] font-bold cursor-pointer">View All →</div>
            </div>

            <!-- Products Grid -->
            <div id="productsGrid" class="grid gap-4" style="grid-template-columns: repeat(auto-fill, minmax(190px, 1fr))"></div>

            <!-- Empty State -->
            <div id="emptyState" class="hidden text-center py-16 text-gray-300">
                <div class="text-6xl">🔍</div>
                <p class="mt-3 font-bold text-base">No products found</p>
            </div>
        </main>
    </div>

    <!-- ── PRODUCT DETAIL MODAL ── -->
    <div id="productModal" class="modal-backdrop" onclick="handleModalBackdropClick(event)">
        <div class="modal-box">
            <!-- Left: Image -->
            <div class="w-[320px] shrink-0 bg-[#f0faf4] modal-img-wrap relative">
                <img id="modalImg" src="" alt="" class="w-full h-full object-cover ">
                <div id="modalImgPlaceholder" class="hidden w-full h-full flex items-center justify-center">
                    <div class="text-8xl opacity-30">🛒</div>
                </div>
                <!-- Tag -->
                <div id="modalTag" class="hidden absolute top-4 left-4 tag-badge"></div>
                <!-- Close btn -->
                <button onclick="closeProductModal()"
                    class="absolute top-4 right-4 bg-white/90 border-none rounded-full w-9 h-9 text-lg cursor-pointer font-[Nunito] flex items-center justify-center shadow-md hover:bg-white transition-colors z-10">✕</button>
            </div>

            <!-- Right: Details -->
            <div class="flex-1 flex flex-col p-8 overflow-y-auto">
                <!-- Category pill -->
                <div id="modalCategory" class="inline-flex items-center gap-1.5 bg-[#e8f5ee] text-[#0c7a3e] text-[11px] font-extrabold px-3 py-1 rounded-full mb-3 self-start"></div>

                <!-- Name -->
                <h2 id="modalName" class="text-2xl font-black text-gray-900 leading-tight mb-1"></h2>

                <!-- Unit -->
                <div id="modalUnit" class="text-sm text-gray-400 font-semibold mb-4"></div>

                <!-- Price row -->
                <div class="flex items-center gap-3 mb-5">
                    <div id="modalPrice" class="text-3xl font-black text-gray-900"></div>
                    <div id="modalPricePerUnit" class="text-sm text-gray-400 font-semibold"></div>
                </div>

                <!-- Stock -->
                <div id="modalStock" class="mb-5"></div>

                <!-- Description -->
                <div id="modalDescWrap" class="mb-6 hidden">
                    <div class="text-xs font-black text-gray-400 tracking-widest uppercase mb-2">Description</div>
                    <p id="modalDesc" class="text-sm text-gray-600 font-semibold leading-relaxed"></p>
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-100 mb-6"></div>

                <!-- Quantity + Add to Cart -->
                <div class="mt-auto">
                    <div class="text-xs font-black text-gray-400 tracking-widest uppercase mb-3">Quantity</div>
                    <div class="flex items-center gap-4 mb-5">
                        <button class="qty-btn" onclick="modalDecreaseQty()">−</button>
                        <span id="modalQty" class="text-xl font-black text-gray-900 min-w-[32px] text-center">1</span>
                        <button class="qty-btn" onclick="modalIncreaseQty()">+</button>
                        <span class="text-sm text-gray-400 font-semibold">× <span id="modalUnitSmall"></span></span>
                    </div>
                    <div class="flex gap-3">
                        <button id="modalAddBtn" onclick="modalAddToCart()"
                            class="flex-1 bg-[#0c7a3e] hover:bg-[#0a6633] text-white border-none rounded-2xl py-3.5 text-[15px] font-extrabold cursor-pointer font-[Nunito] transition-colors flex items-center justify-center gap-2">
                            🛒 Add to Cart — RS <span id="modalTotalPrice"></span>
                        </button>
                    </div>
                    <button onclick="closeProductModal()"
                        class="w-full mt-2.5 bg-transparent border-[1.5px] border-gray-200 hover:border-[#0c7a3e] hover:text-[#0c7a3e] rounded-2xl py-3 text-[13px] font-extrabold text-gray-400 cursor-pointer font-[Nunito] transition-colors">
                        Continue Shopping
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ── Cart Drawer Overlay ── -->
    <div id="drawerOverlay" onclick="closeCart()" class="hidden fixed inset-0 bg-black/45 z-[300]"></div>

    <!-- ── Cart Drawer ── -->
    <div id="cartDrawer" class="drawer fixed top-0 -right-[420px] w-[400px] h-screen bg-white z-[301] flex flex-col shadow-2xl">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <div class="font-black text-xl">🛒 Your Cart</div>
            <button onclick="closeCart()" class="bg-gray-100 border-none rounded-full w-9 h-9 text-lg cursor-pointer font-[Nunito]">✕</button>
        </div>
        <div id="cartBody" class="flex-1 overflow-y-auto py-2"></div>
        <div id="cartFooter" class="px-6 py-5 border-t border-gray-100"></div>
    </div>

    <!-- ── Cart Bottom Bar ── -->
    <div id="cartBottomBar"
        class="hidden fixed bottom-0 left-[220px] right-0 bg-[#0c7a3e] px-10 py-3.5 items-center justify-between z-50 shadow-[0_-4px_20px_rgba(12,122,62,0.3)]">
        <div class="text-white">
            <div id="cbbItems" class="text-sm opacity-85">0 items</div>
            <div id="cbbPrice" class="text-2xl font-black">RS 0</div>
        </div>
        <button onclick="openCart()"
            class="bg-white text-[#0c7a3e] border-none rounded-xl px-7 py-3 text-[15px] font-extrabold cursor-pointer font-[Nunito]">View Cart &amp; Checkout →</button>
    </div>

    <script>
        // ── Placeholder HTML ──
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
            'Fresh':       { bg: '#e8f5e9', color: '#2e7d32' },
            'New':         { bg: '#e3f2fd', color: '#0d47a1' },
            'Organic':     { bg: '#f3e5f5', color: '#6a1b9a' },
            'Best Seller': { bg: '#fff3e0', color: '#e65100' },
            'Popular':     { bg: '#fce4ec', color: '#880e4f' },
            'Healthy':     { bg: '#e0f2f1', color: '#004d40' },
        };

        const catEmoji = {Vegetables:'🥦',Fruits:'🍎',Dairy:'🥛',Bakery:'🍞',Beverages:'🧃',Snacks:'🍫',Meat:'🍗','Personal Care':'🧴'};

        const products = @json($allProducts);
        let cart = {};
        let activeCategory = 'All';

        // ── current modal product + qty ──
        let modalProduct = null;
        let modalQtyVal = 1;

        /* ──────────────────────────────
           PRODUCT DETAIL MODAL
        ────────────────────────────── */
        function openProductModal(p) {
            modalProduct = p;
            modalQtyVal = cart[p.id] || 1;

            // Image
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

            // Tag
            const tagEl = document.getElementById('modalTag');
            if (p.tag && tagMeta[p.tag]) {
                tagEl.textContent = p.tag;
                tagEl.style.background = tagMeta[p.tag].bg;
                tagEl.style.color = tagMeta[p.tag].color;
                tagEl.classList.remove('hidden');
            } else {
                tagEl.classList.add('hidden');
            }

            // Category
            const catEl = document.getElementById('modalCategory');
            catEl.textContent = (catEmoji[p.category] || '📦') + '  ' + (p.category || '');

            // Name, unit, price
            document.getElementById('modalName').textContent = p.name;
            document.getElementById('modalUnit').textContent = p.unit;
            document.getElementById('modalPrice').textContent = `RS ${parseFloat(p.price).toFixed(2)}`;
            document.getElementById('modalPricePerUnit').textContent = `per ${p.unit}`;
            document.getElementById('modalUnitSmall').textContent = p.unit;

            // Stock
            const stockEl = document.getElementById('modalStock');
            const qty = p.stock_quantity ?? null;
            if (qty !== null) {
                const color = qty === 0 ? 'bg-red-100 text-red-600' : qty < 10 ? 'bg-orange-100 text-orange-600' : 'bg-green-100 text-green-700';
                const label = qty === 0 ? '❌ Out of Stock' : qty < 10 ? `⚠️ Only ${qty} left` : `✅ In Stock (${qty} available)`;
                stockEl.innerHTML = `<span class="text-xs font-extrabold px-3 py-1 rounded-full ${color}">${label}</span>`;
            } else {
                stockEl.innerHTML = `<span class="text-xs font-extrabold px-3 py-1 rounded-full bg-green-100 text-green-700">✅ In Stock</span>`;
            }

            // Description
            const descWrap = document.getElementById('modalDescWrap');
            const descEl = document.getElementById('modalDesc');
            if (p.description) {
                descEl.textContent = p.description;
                descWrap.classList.remove('hidden');
            } else {
                descWrap.classList.add('hidden');
            }

            // Qty + total
            updateModalQtyDisplay();

            // Open
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
            cart[modalProduct.id] = (cart[modalProduct.id] || 0) + modalQtyVal;
            updateCartUI();
            refreshAction(modalProduct.id);

            // Flash the button
            const btn = document.getElementById('modalAddBtn');
            btn.textContent = '✅ Added to Cart!';
            btn.style.background = '#0a6633';
            setTimeout(() => {
                btn.innerHTML = `🛒 Add to Cart — RS <span id="modalTotalPrice">${(parseFloat(modalProduct.price) * modalQtyVal).toFixed(2)}</span>`;
            }, 1200);
        }

        /* ──────────────────────────────
           ACCOUNT DROPDOWN
        ────────────────────────────── */
        function toggleAccountMenu() {
            document.getElementById('accountMenu').classList.toggle('hidden');
        }
        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('accountWrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                document.getElementById('accountMenu').classList.add('hidden');
            }
        });

        /* ── Categories ── */
        function setCategory(cat, btn) {
            activeCategory = cat;
            document.querySelectorAll('.cat-btn').forEach(b => {
                b.classList.remove('bg-[#0c7a3e]', 'text-white');
                b.classList.add('bg-transparent', 'text-gray-600');
            });
            btn.classList.add('bg-[#0c7a3e]', 'text-white');
            btn.classList.remove('bg-transparent', 'text-gray-600');
            filterProducts();
        }

        /* ── Filter ── */
        function filterProducts() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const filtered = products.filter(p => {
                const matchCat = activeCategory === 'All' || p.category === activeCategory;
                const matchSearch = p.name.toLowerCase().includes(search);
                return matchCat && matchSearch;
            });
            renderProducts(filtered);
        }

        /* ── Card image HTML ── */
        function cardImageHtml(p) {
            const tagHtml = p.tag && tagMeta[p.tag]
                ? `<div class="absolute top-2.5 left-2.5 tag-badge z-10" style="background:${tagMeta[p.tag].bg};color:${tagMeta[p.tag].color}">${p.tag}</div>`
                : '';
            const hasImage = p.image && p.image !== 'YOUR_IMAGE_PATH_HERE';
            const imgContent = hasImage
                ? `<img src="${p.image}" alt="${p.name}" class="w-full h-full object-cover block">`
                : placeholderHTML;
            return `<div class="product-img-wrap bg-[#f0faf4] h-[150px] flex items-center justify-center relative overflow-hidden">${tagHtml}${imgContent}</div>`;
        }

        /* ── Cart thumb ── */
        function cartThumbHtml(p) {
            const hasImage = p.image && p.image !== 'YOUR_IMAGE_PATH_HERE';
            return hasImage
                ? `<img src="${p.image}" alt="${p.name}" class="w-full h-full object-cover">`
                : cartPlaceholderSVG;
        }

        /* ── Render Products ── */
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
                const actionHtml = qty === 0
                    ? `<button class="bg-[#0c7a3e] hover:bg-[#0a6633] text-white border-none rounded-lg px-4 py-1.5 text-[13px] font-extrabold cursor-pointer font-[Nunito]" onclick="event.stopPropagation(); addToCart(${p.id})">ADD</button>`
                    : `<div class="flex items-center gap-2 bg-[#0c7a3e] rounded-lg px-2 py-1.5" onclick="event.stopPropagation()">
                        <button class="bg-transparent border-none text-white text-xl cursor-pointer leading-none font-black font-[Nunito] p-0" onclick="removeFromCart(${p.id})">−</button>
                        <span class="text-white text-sm font-extrabold min-w-[18px] text-center">${qty}</span>
                        <button class="bg-transparent border-none text-white text-xl cursor-pointer leading-none font-black font-[Nunito] p-0" onclick="addToCart(${p.id})">+</button>
                       </div>`;

                return `
<div class="product-card bg-white rounded-2xl overflow-hidden shadow-sm" onclick="openProductModal(${JSON.stringify(p).replace(/"/g,'&quot;')})">
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

        function addToCart(id) {
            cart[id] = (cart[id] || 0) + 1;
            updateCartUI();
            refreshAction(id);
        }

        function removeFromCart(id) {
            if (!cart[id]) return;
            cart[id]--;
            if (cart[id] === 0) delete cart[id];
            updateCartUI();
            refreshAction(id);
        }

        function refreshAction(id) {
            const el = document.getElementById('action-' + id);
            if (!el) return;
            const qty = cart[id] || 0;
            el.innerHTML = qty === 0
                ? `<button class="bg-[#0c7a3e] hover:bg-[#0a6633] text-white border-none rounded-lg px-4 py-1.5 text-[13px] font-extrabold cursor-pointer font-[Nunito]" onclick="event.stopPropagation(); addToCart(${id})">ADD</button>`
                : `<div class="flex items-center gap-2 bg-[#0c7a3e] rounded-lg px-2 py-1.5" onclick="event.stopPropagation()">
                    <button class="bg-transparent border-none text-white text-xl cursor-pointer leading-none font-black font-[Nunito] p-0" onclick="removeFromCart(${id})">−</button>
                    <span class="text-white text-sm font-extrabold min-w-[18px] text-center">${qty}</span>
                    <button class="bg-transparent border-none text-white text-xl cursor-pointer leading-none font-black font-[Nunito] p-0" onclick="addToCart(${id})">+</button>
                   </div>`;
        }

        function updateCartUI() {
            const totalItems = Object.values(cart).reduce((a, b) => a + b, 0);
            const totalPrice = Object.entries(cart).reduce((sum, [id, qty]) => {
                const p = products.find(p => p.id == id);
                return sum + (p ? p.price * qty : 0);
            }, 0);

            const badge = document.getElementById('cartBadge');
            badge.textContent = totalItems;
            if (totalItems > 0) badge.classList.add('visible');
            else badge.classList.remove('visible');

            const bar = document.getElementById('cartBottomBar');
            if (totalItems > 0) bar.classList.replace('hidden', 'flex');
            else bar.classList.replace('flex', 'hidden');

            document.getElementById('cbbItems').textContent = `${totalItems} item${totalItems !== 1 ? 's' : ''} in cart`;
            document.getElementById('cbbPrice').textContent = `RS ${totalPrice.toFixed(2)}`;
        }

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
                body.innerHTML = `<div class="text-center py-16 px-6 text-gray-300"><div class="text-6xl">🛒</div><p class="mt-3 font-bold text-base">Your cart is empty</p></div>`;
                footer.innerHTML = '';
                return;
            }

            const totalPrice = entries.reduce((sum, [id, qty]) => {
                const p = products.find(p => p.id == id);
                return sum + (p ? p.price * qty : 0);
            }, 0);

            body.innerHTML = entries.map(([id, qty]) => {
                const p = products.find(p => p.id == id);
                if (!p) return '';
                return `
<div class="flex items-center gap-3.5 px-6 py-3.5 border-b border-gray-50">
    <div class="w-[52px] h-[52px] rounded-xl bg-[#f0faf4] shrink-0 overflow-hidden flex items-center justify-center">
        ${cartThumbHtml(p)}
    </div>
    <div class="flex-1">
        <div class="font-bold text-sm">${p.name}</div>
        <div class="text-gray-400 text-xs mt-0.5">${p.unit} &nbsp;·&nbsp; RS ${parseFloat(p.price).toFixed(2)} each</div>
    </div>
    <div class="flex items-center gap-2.5">
        <button class="bg-gray-100 border-none rounded-lg w-7 h-7 text-lg cursor-pointer font-extrabold font-[Nunito]" onclick="cartRemove(${p.id})">−</button>
        <span class="font-extrabold text-[15px] min-w-[18px] text-center">${qty}</span>
        <button class="bg-[#0c7a3e] text-white border-none rounded-lg w-7 h-7 text-lg cursor-pointer font-extrabold font-[Nunito]" onclick="cartAdd(${p.id})">+</button>
    </div>
    <div class="font-extrabold text-[15px] min-w-[55px] text-right">RS ${(p.price * qty).toFixed(2)}</div>
</div>`;
            }).join('');

            const tax = Math.round(totalPrice * 0.05);
            footer.innerHTML = `
<div class="flex justify-between mb-1.5">
    <span class="text-gray-400 text-sm">Subtotal</span>
    <strong class="font-bold text-sm">RS ${totalPrice.toFixed(2)}</strong>
</div>
<div class="flex justify-between mb-1.5">
    <span class="text-gray-400 text-sm">Delivery Fee</span>
    <strong class="font-bold text-sm text-[#0c7a3e]">FREE</strong>
</div>
<div class="flex justify-between mb-1.5">
    <span class="text-gray-400 text-sm">Tax (5%)</span>
    <strong class="font-bold text-sm">RS ${tax}</strong>
</div>
<hr class="border-t border-gray-100 my-2.5">
<div class="flex justify-between mb-4">
    <span class="font-extrabold text-base">Total</span>
    <span class="font-extrabold text-base">RS ${(totalPrice + tax).toFixed(2)}</span>
</div>
<button class="bg-[#0c7a3e] text-white border-none rounded-xl py-4 px-6 w-full font-[Nunito] text-base font-extrabold cursor-pointer">Proceed to Checkout →</button>`;
        }

        function cartAdd(id) { addToCart(id); renderCartDrawer(); }
        function cartRemove(id) { removeFromCart(id); renderCartDrawer(); }

        // Keyboard close
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeProductModal();
        });

        renderProducts(products);
    </script>
</body>
</html>