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
                        nunito: ['Nunito', 'sans-serif'],
                    },
                    colors: {
                        green: {
                            brand: '#0c7a3e',
                            dark: '#0a6633',
                            light: '#1aad5e',
                            pale: '#f0faf4',
                            muted: '#a8e6c1',
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

        .drawer {
            transition: right 0.3s ease;
        }

        .cart-badge {
            display: none;
        }

        .cart-badge.visible {
            display: flex;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen font-nunito">

    <!-- Navbar -->
    <nav class="bg-[#0c7a3e] px-10 h-16 flex items-center justify-between sticky top-0 z-[100] shadow-lg">
        <!-- Left -->
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
                ⚡ Delivery in 30 mins &nbsp;·&nbsp; Kathmandu, NP
            </div>
        </div>

        <!-- Center Search -->
        <div class="flex-1 max-w-[500px] mx-10">
            <div class="bg-white rounded-xl flex items-center px-4 py-2.5 gap-2.5 shadow-md">
                <span class="text-lg">🔍</span>
                <input type="text" id="searchInput" placeholder="Search for groceries, vegetables, snacks..."
                    oninput="filterProducts()"
                    class="border-none outline-none text-sm font-[Nunito] text-gray-700 bg-transparent w-full placeholder-gray-400">
            </div>
        </div>

        <!-- Right -->
        <div class="flex items-center gap-3">
            <!-- Account Dropdown -->
            <div class="relative" id="accountWrapper">
                <button id="accountBtn" onclick="toggleAccountMenu()"
                    class="bg-white/15 border-none rounded-xl px-4 py-2 text-white text-[13px] font-bold cursor-pointer font-[Nunito] flex items-center gap-1.5">
                    👤 Account ▾
                </button>
                <div id="accountMenu"
                    class="hidden absolute top-[calc(100%+10px)] right-0 bg-white rounded-xl shadow-2xl min-w-[180px] z-[200] overflow-hidden">
                    <div class="px-4 py-3.5 border-b border-gray-100 font-black text-[13px] text-gray-700 bg-gray-50">👤
                        My Account</div>
                    <button
                        class="flex items-center gap-2.5 px-4 py-3 text-sm font-bold text-gray-600 cursor-pointer hover:bg-gray-50 w-full text-left border-none bg-transparent font-[Nunito]">🙍
                        Profile</button>
                    <button
                        class="flex items-center gap-2.5 px-4 py-3 text-sm font-bold text-gray-600 cursor-pointer hover:bg-gray-50 w-full text-left border-none bg-transparent font-[Nunito]">📦
                        My Orders</button>
                    <hr class="border-t border-gray-100 m-0">
                    <form action="/logout" method="POST">
                        <input type="hidden" name="_token" value="">
                        <button type="submit"
                            class="flex items-center gap-2.5 px-4 py-3 text-sm font-bold text-red-600 cursor-pointer hover:bg-red-50 w-full text-left border-none bg-transparent font-[Nunito]">🚪
                            Logout</button>
                    </form>
                </div>
            </div>

            <!-- Cart Button -->
            <button onclick="openCart()"
                class="bg-white text-[#0c7a3e] border-none rounded-xl px-4 py-2 text-[13px] font-extrabold cursor-pointer font-[Nunito] flex items-center gap-2 relative">
                🛒 Cart
                <div id="cartBadge"
                    class="cart-badge bg-red-500 text-white rounded-full w-5 h-5 text-[11px] font-extrabold items-center justify-center">
                    0</div>
            </button>
        </div>
    </nav>

    <!-- Page Layout -->
    <div class="flex min-h-[calc(100vh-64px)]">

        <!-- Sidebar -->
        <aside
            class="w-[220px] shrink-0 bg-white px-4 py-6 border-r border-gray-100 sticky top-16 h-[calc(100vh-64px)] overflow-y-auto">
            <div class="text-xs font-black text-gray-400 tracking-widest uppercase mb-3">Categories</div>

            <button
                class="cat-btn active flex items-center gap-2.5 w-full border-none rounded-xl px-3 py-2.5 text-sm font-bold cursor-pointer font-[Nunito] transition-all mb-1 text-left bg-[#0c7a3e] text-white"
                onclick="setCategory('All', this)">
                <span class="text-lg w-6 text-center">🏪</span> All Products
            </button>
            <button
                class="cat-btn flex items-center gap-2.5 w-full border-none rounded-xl px-3 py-2.5 text-sm font-bold text-gray-600 cursor-pointer font-[Nunito] hover:bg-[#f0faf4] hover:text-[#0c7a3e] transition-all mb-1 bg-transparent text-left"
                onclick="setCategory('Vegetables', this)">
                <span class="text-lg w-6 text-center">🥦</span> Vegetables
            </button>
            <button
                class="cat-btn flex items-center gap-2.5 w-full border-none rounded-xl px-3 py-2.5 text-sm font-bold text-gray-600 cursor-pointer font-[Nunito] hover:bg-[#f0faf4] hover:text-[#0c7a3e] transition-all mb-1 bg-transparent text-left"
                onclick="setCategory('Fruits', this)">
                <span class="text-lg w-6 text-center">🍎</span> Fruits
            </button>
            <button
                class="cat-btn flex items-center gap-2.5 w-full border-none rounded-xl px-3 py-2.5 text-sm font-bold text-gray-600 cursor-pointer font-[Nunito] hover:bg-[#f0faf4] hover:text-[#0c7a3e] transition-all mb-1 bg-transparent text-left"
                onclick="setCategory('Dairy', this)">
                <span class="text-lg w-6 text-center">🥛</span> Dairy
            </button>
            <button
                class="cat-btn flex items-center gap-2.5 w-full border-none rounded-xl px-3 py-2.5 text-sm font-bold text-gray-600 cursor-pointer font-[Nunito] hover:bg-[#f0faf4] hover:text-[#0c7a3e] transition-all mb-1 bg-transparent text-left"
                onclick="setCategory('Bakery', this)">
                <span class="text-lg w-6 text-center">🍞</span> Bakery
            </button>
            <button
                class="cat-btn flex items-center gap-2.5 w-full border-none rounded-xl px-3 py-2.5 text-sm font-bold text-gray-600 cursor-pointer font-[Nunito] hover:bg-[#f0faf4] hover:text-[#0c7a3e] transition-all mb-1 bg-transparent text-left"
                onclick="setCategory('Beverages', this)">
                <span class="text-lg w-6 text-center">🧃</span> Beverages
            </button>
            <button
                class="cat-btn flex items-center gap-2.5 w-full border-none rounded-xl px-3 py-2.5 text-sm font-bold text-gray-600 cursor-pointer font-[Nunito] hover:bg-[#f0faf4] hover:text-[#0c7a3e] transition-all mb-1 bg-transparent text-left"
                onclick="setCategory('Snacks', this)">
                <span class="text-lg w-6 text-center">🍫</span> Snacks
            </button>
            <button
                class="cat-btn flex items-center gap-2.5 w-full border-none rounded-xl px-3 py-2.5 text-sm font-bold text-gray-600 cursor-pointer font-[Nunito] hover:bg-[#f0faf4] hover:text-[#0c7a3e] transition-all mb-1 bg-transparent text-left"
                onclick="setCategory('Meat', this)">
                <span class="text-lg w-6 text-center">🍗</span> Meat &amp; Fish
            </button>
            <button
                class="cat-btn flex items-center gap-2.5 w-full border-none rounded-xl px-3 py-2.5 text-sm font-bold text-gray-600 cursor-pointer font-[Nunito] hover:bg-[#f0faf4] hover:text-[#0c7a3e] transition-all mb-1 bg-transparent text-left"
                onclick="setCategory('Personal Care', this)">
                <span class="text-lg w-6 text-center">🧴</span> Personal Care
            </button>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 px-8 pt-7 pb-28 overflow-y-auto">

            <!-- Banner -->
            <div
                class="bg-gradient-to-br from-[#0c7a3e] to-[#1aad5e] rounded-2xl px-10 py-8 flex items-center justify-between mb-8 relative overflow-hidden">
                <div class="absolute -right-8 -top-8 w-44 h-44 bg-white/[0.07] rounded-full"></div>
                <div class="absolute right-24 -bottom-10 w-28 h-28 bg-white/[0.05] rounded-full"></div>
                <div class="relative z-10">
                    <div class="text-yellow-300 text-xs font-extrabold tracking-widest mb-2">🎉 LIMITED TIME OFFER</div>
                    <div class="text-white text-3xl font-black leading-tight mb-4">Fresh Vegetables<br>Up to 30% Off
                    </div>
                    <button
                        class="bg-white text-[#0c7a3e] border-none rounded-xl px-6 py-2.5 text-sm font-extrabold cursor-pointer font-[Nunito]">Shop
                        Now →</button>
                </div>
            </div>

            <!-- Products Header -->
            <div class="flex items-center justify-between mb-5">
                <div class="font-black text-xl text-gray-900">
                    All Products <span id="productCount" class="font-semibold text-sm text-gray-400 ml-2">(16)</span>
                </div>
                <div class="text-[#0c7a3e] text-[13px] font-bold cursor-pointer">View All →</div>
            </div>

            <!-- Products Grid -->
            <div id="productsGrid" class="grid gap-4"
                style="grid-template-columns: repeat(auto-fill, minmax(190px, 1fr))"></div>

            <!-- Empty State -->
            <div id="emptyState" class="hidden text-center py-16 text-gray-300">
                <div class="text-6xl">🔍</div>
                <p class="mt-3 font-bold text-base">No products found</p>
            </div>

        </main>
    </div>

    <!-- Cart Drawer Overlay -->
    <div id="drawerOverlay" onclick="closeCart()" class="hidden fixed inset-0 bg-black/45 z-[300]"></div>

    <!-- Cart Drawer -->
    <div id="cartDrawer"
        class="drawer fixed top-0 -right-[420px] w-[400px] h-screen bg-white z-[301] flex flex-col shadow-2xl">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <div class="font-black text-xl">🛒 Your Cart</div>
            <button onclick="closeCart()"
                class="bg-gray-100 border-none rounded-full w-9 h-9 text-lg cursor-pointer font-[Nunito]">✕</button>
        </div>
        <div id="cartBody" class="flex-1 overflow-y-auto py-2"></div>
        <div id="cartFooter" class="px-6 py-5 border-t border-gray-100"></div>
    </div>

    <!-- Cart Bottom Bar -->
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

    <script>
        const placeholderHTML = `
<div class="w-full h-full flex flex-col items-center justify-center gap-1.5">
  <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11 opacity-35">
    <rect width="48" height="48" rx="6" fill="#e8f5e9"/>
    <path d="M8 36L18 20L26 30L32 22L42 36H8Z" fill="#a5d6a7"/>
    <circle cx="34" cy="14" r="5" fill="#a5d6a7"/>
  </svg>
  <span class="text-[11px] font-bold text-gray-300">Add image</span>
</div>`;

        const cartPlaceholderSVG = `
<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 opacity-35">
  <path d="M8 36L18 20L26 30L32 22L42 36H8Z" fill="#a5d6a7"/>
  <circle cx="34" cy="14" r="5" fill="#a5d6a7"/>
</svg>`;

        const products = [{
                id: 1,
                name: "Fresh Tomatoes",
                price: 35,
                unit: "1kg",
                category: "Vegetables",
                image: "/storage/image/tomato.jpg",
                tag: "Fresh",
                tagBg: "#e8f5e9",
                tagColor: "#2e7d32"
            },
            {
                id: 2,
                name: "Organic Bananas",
                price: 60,
                unit: "6 pcs",
                category: "Fruits",
                image: "/storage/image/banana.avif",
                tag: "Organic",
                tagBg: "#f3e5f5",
                tagColor: "#6a1b9a"
            },
            {
                id: 3,
                name: "Full Cream Milk",
                price: 75,
                unit: "1L",
                category: "Dairy",
                image: "/storage/image/fullcreammilk.webp",
                tag: "Best Seller",
                tagBg: "#fff3e0",
                tagColor: "#e65100"
            },
            {
                id: 5,
                name: "JuJu Dhau",
                price: 90,
                unit: "200g",
                category: "Dairy",
                image: "/storage/image/JuJuDhauPNG.webp",
                tag: "New",
                tagBg: "#e3f2fd",
                tagColor: "#0d47a1"
            },
            {
                id: 4,
                name: "Multigrain Bread",
                price: 55,
                unit: "400g",
                category: "Bakery",
                image: "/storage/image/Multigrain bread.jpg",
                tag: null
            },
            {
                id: 6,
                name: "Orange Juice",
                price: 110,
                unit: "1L",
                category: "Beverages",
                image: "/storage/image/orange juice .jpg",
                tag: "Popular",
                tagBg: "#fce4ec",
                tagColor: "#880e4f"
            },
            {
                id: 7,
                name: "Dark Chocolate",
                price: 145,
                unit: "100g",
                category: "Snacks",
                image: "/storage/image/darkchoclate.jpg",
                tag: null
            },
            {
                id: 8,
                name: "Spinach Leaves",
                price: 40,
                unit: "250g",
                category: "Vegetables",
                image: "/storage/image/spanish leaf.jpg",
                tag: "Fresh",
                tagBg: "#e8f5e9",
                tagColor: "#2e7d32"
            },
            {
                id: 9,
                name: "Churpi – Himalayan Cheese",
                price: 180,
                unit: "200g",
                category: "Dairy",
                image: "/storage/image/churpi.jpg",
                tag: null
            },
            {
                id: 10,
                name: "Mixed Nuts",
                price: 220,
                unit: "200g",
                category: "Snacks",
                image: "/storage/image/mixed nuts .avif",
                tag: "Healthy",
                tagBg: "#e0f2f1",
                tagColor: "#004d40"
            },
            {
                id: 11,
                name: "Green Apples",
                price: 95,
                unit: "4 pcs",
                category: "Fruits",
                image: "/storage/image/green apple .jpg",
                tag: null
            },
            {
                id: 12,
                name: "Butter Croissant",
                price: 65,
                unit: "2 pcs",
                category: "Bakery",
                image: "/storage/image/butter-croissant-1.jpg",
                tag: "Fresh",
                tagBg: "#e8f5e9",
                tagColor: "#2e7d32"
            },
            {
                id: 13,
                name: "Watermelon",
                price: 120,
                unit: "1 pc",
                category: "Fruits",
                image: "/storage/image/watermelon.jpg",
                tag: "Popular",
                tagBg: "#fce4ec",
                tagColor: "#880e4f"
            },
            {
                id: 14,
                name: "Potato Chips",
                price: 55,
                unit: "150g",
                category: "Snacks",
                image: "/storage/image/potato chips .avif",
                tag: null
            },
            {
                id: 15,
                name: "Almond Milk",
                price: 160,
                unit: "1L",
                category: "Beverages",
                image: "/storage/image/almond milk .webp",
                tag: "Healthy",
                tagBg: "#e0f2f1",
                tagColor: "#004d40"
            },
            {
                id: 16,
                name: "Sourdough Bread",
                price: 85,
                unit: "500g",
                category: "Bakery",
                image: "/storage/image/Sourdough.webp",
                tag: "New",
                tagBg: "#e3f2fd",
                tagColor: "#0d47a1"
            },
            {
                id: 17,
                name: "Arbeen Brand Soap",
                price: 675,
                unit: "3 pcs",
                category: "Personal Care",
                image: "/storage/image/soap.jpg",
                tag: "Personal Care",
                tagBg: "#e3f2fd",
                tagColor: "#0d47a1"
            },
            {
                id: 18,
                name: "Baby Oil",
                price: 2000,
                unit: "3 pcs",
                category: "Personal Care",
                image: "/storage/image/baby oil .jpg",
                tag: "Personal Care",
                tagBg: "#e3f2fd",
                tagColor: "#0d47a1"
            },
        ];

        let cart = {};
        let activeCategory = 'All';

        /* ── Account Dropdown ── */
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
                b.classList.remove('active', 'bg-[#0c7a3e]', 'text-white');
                b.classList.add('bg-transparent', 'text-gray-600');
            });
            btn.classList.add('active', 'bg-[#0c7a3e]', 'text-white');
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

        /* ── Card image ── */
        function cardImageHtml(p) {
            const tagHtml = p.tag ?
                `<div class="absolute top-2.5 left-2.5 text-[10px] font-extrabold rounded-md px-2 py-0.5 z-10" style="background:${p.tagBg};color:${p.tagColor}">${p.tag}</div>` :
                '';
            const hasImage = p.image && p.image !== 'YOUR_IMAGE_PATH_HERE';
            const imgContent = hasImage ?
                `<img src="${p.image}" alt="${p.name}" class="w-full h-full object-cover block">` :
                placeholderHTML;
            return `<div class="bg-[#f0faf4] h-[150px] flex items-center justify-center relative overflow-hidden">${tagHtml}${imgContent}</div>`;
        }

        /* ── Cart thumb ── */
        function cartThumbHtml(p) {
            const hasImage = p.image && p.image !== 'YOUR_IMAGE_PATH_HERE';
            return hasImage ?
                `<img src="${p.image}" alt="${p.name}" class="w-full h-full object-cover">` :
                cartPlaceholderSVG;
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
                const actionHtml = qty === 0 ?
                    `<button class="bg-[#0c7a3e] hover:bg-[#0a6633] text-white border-none rounded-lg px-4 py-1.5 text-[13px] font-extrabold cursor-pointer font-[Nunito]" onclick="addToCart(${p.id})">ADD</button>` :
                    `<div class="flex items-center gap-2.5 bg-[#0c7a3e] rounded-lg px-2.5 py-1.5">
                        <button class="bg-transparent border-none text-white text-xl cursor-pointer leading-none font-black font-[Nunito] p-0" onclick="removeFromCart(${p.id})">−</button>
                        <span class="text-white text-sm font-extrabold min-w-[18px] text-center">${qty}</span>
                        <button class="bg-transparent border-none text-white text-xl cursor-pointer leading-none font-black font-[Nunito] p-0" onclick="addToCart(${p.id})">+</button>
                       </div>`;

                return `
<div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
    ${cardImageHtml(p)}
    <div class="px-3.5 pt-3 pb-3.5">
        <div class="font-bold text-sm text-gray-900 leading-tight mb-0.5">${p.name}</div>
        <div class="text-gray-400 text-xs mb-2.5">${p.unit}</div>
        <div class="flex items-center justify-between">
            <div class="font-black text-[17px] text-gray-900">RS ${p.price}</div>
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
            el.innerHTML = qty === 0 ?
                `<button class="bg-[#0c7a3e] hover:bg-[#0a6633] text-white border-none rounded-lg px-4 py-1.5 text-[13px] font-extrabold cursor-pointer font-[Nunito]" onclick="addToCart(${id})">ADD</button>` :
                `<div class="flex items-center gap-2.5 bg-[#0c7a3e] rounded-lg px-2.5 py-1.5">
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
            document.getElementById('cbbPrice').textContent = `RS ${totalPrice}`;
        }

        function openCart() {
            const drawer = document.getElementById('cartDrawer');
            drawer.style.right = '0';
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
        <div class="text-gray-400 text-xs mt-0.5">${p.unit} &nbsp;·&nbsp; RS ${p.price} each</div>
    </div>
    <div class="flex items-center gap-2.5">
        <button class="bg-gray-100 border-none rounded-lg w-7 h-7 text-lg cursor-pointer font-extrabold font-[Nunito]" onclick="cartRemove(${p.id})">−</button>
        <span class="font-extrabold text-[15px] min-w-[18px] text-center">${qty}</span>
        <button class="bg-[#0c7a3e] text-white border-none rounded-lg w-7 h-7 text-lg cursor-pointer font-extrabold font-[Nunito]" onclick="cartAdd(${p.id})">+</button>
    </div>
    <div class="font-extrabold text-[15px] min-w-[55px] text-right">RS ${p.price * qty}</div>
</div>`;
            }).join('');

            const tax = Math.round(totalPrice * 0.05);
            footer.innerHTML =
                `
<div class="flex justify-between mb-1.5">
    <span class="text-gray-400 text-sm">Subtotal</span>
    <strong class="font-bold text-sm">RS ${totalPrice}</strong>
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
    <span class="font-extrabold text-base">RS ${totalPrice + tax}</span>
</div>
<button class="bg-[#0c7a3e] text-white border-none rounded-xl py-4 px-6 w-full font-[Nunito] text-base font-extrabold cursor-pointer">Proceed to Checkout →</button>`;
        }

        function cartAdd(id) {
            addToCart(id);
            renderCartDrawer();
        }

        function cartRemove(id) {
            removeFromCart(id);
            renderCartDrawer();
        }

        renderProducts(products);
    </script>
</body>

</html>
