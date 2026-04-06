@extends('layouts.store')

@section('title', 'ArbeenStore — Fresh Groceries Delivered')

@section('content')

    @include('partials.store.navbar')

    <div class="flex min-h-[calc(100vh-56px)]">
        @include('partials.store.category-sidebar')

        <main class="flex-1 px-6 pt-5 pb-24 overflow-y-auto">
            @include('partials.store.promo-banner')
            @include('partials.store.product-grid')
        </main>
    </div>

    @include('partials.store.product-modal')
    @include('partials.store.cart-drawer')
    @include('partials.store.checkout-modal')
    @include('partials.store.orders-modal')

@endsection
