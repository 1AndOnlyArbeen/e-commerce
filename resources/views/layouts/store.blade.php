<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ArbeenStore')</title>

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Tailwind CDN --}}
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

    {{-- Store CSS (separated into modules) --}}
    <link rel="stylesheet" href="{{ asset('css/store/base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/store/product.css') }}">
    <link rel="stylesheet" href="{{ asset('css/store/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/store/cart.css') }}">
    <link rel="stylesheet" href="{{ asset('css/store/checkout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/store/orders.css') }}">
    <link rel="stylesheet" href="{{ asset('css/store/khalti.css') }}">
    <link rel="stylesheet" href="{{ asset('css/store/dark-mode.css') }}">

    @stack('styles')
</head>

<body class="bg-gray-100 min-h-screen font-nunito">

    @yield('content')

    {{-- Blade data → JS bridge --}}
    <script>
        window.__STORE_DATA__ = {
            products: @json($products->items()),
            orders: @json($orders),
            isAuth: {{ auth()->check() ? 'true' : 'false' }},
            csrfToken: '{{ csrf_token() }}',
            justLoggedIn: {{ session('just_logged_in') ? 'true' : 'false' }},
        };
    </script>

    {{-- QR Code library for Khalti payment --}}
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>

    {{-- Store JS (separated into modules, order matters) --}}
    <script src="{{ asset('js/store/config.js') }}"></script>
    <script src="{{ asset('js/store/helpers.js') }}"></script>
    <script src="{{ asset('js/store/dark-mode.js') }}"></script>
    <script src="{{ asset('js/store/render-products.js') }}"></script>
    <script src="{{ asset('js/store/product-modal.js') }}"></script>
    <script src="{{ asset('js/store/cart.js') }}"></script>
    <script src="{{ asset('js/store/cart-drawer.js') }}"></script>
    <script src="{{ asset('js/store/khalti.js') }}"></script>
    <script src="{{ asset('js/store/checkout.js') }}"></script>
    <script src="{{ asset('js/store/orders.js') }}"></script>
    <script src="{{ asset('js/store/search.js') }}"></script>
    <script src="{{ asset('js/store/ui.js') }}"></script>
    <script src="{{ asset('js/store/app.js') }}"></script>

    @stack('scripts')
</body>

</html>
