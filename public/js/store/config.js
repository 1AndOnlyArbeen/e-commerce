/* ══ Store Config & Constants ══
   Reads initial data from window.__STORE_DATA__ (set by Blade) */

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

const statusMeta = {
    delivered:  { label: 'Delivered',  cls: 'status-delivered',  icon: '✅' },
    transit:    { label: 'In Transit', cls: 'status-transit',    icon: '🚚' },
    processing: { label: 'Processing', cls: 'status-processing', icon: '⏳' },
    pending:    { label: 'Pending',    cls: 'status-pending',    icon: '🕐' },
    cancelled:  { label: 'Cancelled',  cls: 'status-cancelled',  icon: '❌' },
};

const payMeta = {
    cod:    { label: 'Cash on Delivery', icon: '💵' },
    esewa:  { label: 'eSewa',            icon: '📱' },
    khalti: { label: 'Khalti',           icon: '🟣' },
    bank:   { label: 'Bank Transfer',    icon: '🏦' },
};

const timelineSteps = {
    pending:    [true,  false, false, false],
    processing: [true,  true,  false, false],
    transit:    [true,  true,  true,  false],
    delivered:  [true,  true,  true,  true ],
    cancelled:  [false, false, false, false],
};

const timelineLabels = [
    { label: 'Order Placed',     sub: 'We received your order' },
    { label: 'Confirmed',        sub: 'Order verified & packed' },
    { label: 'Out for Delivery', sub: 'Rider is on the way' },
    { label: 'Delivered',        sub: 'Order delivered successfully' },
];

/* Data injected from Blade */
const products   = window.__STORE_DATA__.products;
const ordersData = window.__STORE_DATA__.orders;
const isAuth     = window.__STORE_DATA__.isAuth;
const csrfToken  = window.__STORE_DATA__.csrfToken;

/* Mutable state */
let cart = {};
let cartProducts = {};
let modalProduct = null;
let modalQtyVal = 1;
let selectedPayMethod = 'cod';
let currentCheckoutStep = 1;
let currentOrderId = null;
