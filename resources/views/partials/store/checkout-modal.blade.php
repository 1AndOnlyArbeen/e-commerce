{{-- ══ Checkout Modal ══ --}}
<div id="checkoutModal" onclick="handleCheckoutBackdropClick(event)">
    <div class="checkout-box">

        {{-- Header --}}
        <div class="px-8 py-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white z-10">
            <div class="font-black text-xl text-gray-900">🧾 Checkout</div>
            <button onclick="closeCheckout()"
                class="bg-gray-100 hover:bg-gray-200 border-none rounded-full w-9 h-9 text-base cursor-pointer flex items-center justify-center">✕</button>
        </div>

        {{-- Step indicator --}}
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

        {{-- Step 1: Delivery Address --}}
        <div id="checkStep1" class="px-8 py-6">
            <div id="addrPrefillBanner" class="gap-2">
                <span>✅</span>
                <span>We've filled in your last delivery address. Edit if needed.</span>
            </div>

            <div class="text-lg font-black text-gray-800 mb-5">📍 Delivery Address</div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-black text-gray-500 uppercase tracking-wider mb-1.5">First Name *</label>
                    <input name="firstName" id="addr_name" type="text" placeholder="e.g. Arbeen"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-[#0c7a3e] focus:ring-2 focus:ring-[#0c7a3e]/20 transition-all font-[Nunito]">
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-500 uppercase tracking-wider mb-1.5">Last Name *</label>
                    <input name="last_name" id="addr_last_name" type="text" placeholder="e.g. Shrestha"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-[#0c7a3e] focus:ring-2 focus:ring-[#0c7a3e]/20 transition-all font-[Nunito]">
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-500 uppercase tracking-wider mb-1.5">Phone *</label>
                    <input name="phone_number" id="addr_phone" type="tel" placeholder="98XXXXXXXX"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-[#0c7a3e] focus:ring-2 focus:ring-[#0c7a3e]/20 transition-all font-[Nunito]">
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-xs font-black text-gray-500 uppercase tracking-wider mb-1.5">Street Address *</label>
                <input name="street_address" id="addr_street" type="text" placeholder="House No., Street name, Area"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-[#0c7a3e] focus:ring-2 focus:ring-[#0c7a3e]/20 transition-all font-[Nunito]">
            </div>
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-black text-gray-500 uppercase tracking-wider mb-1.5">City *</label>
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
                    <label class="block text-xs font-black text-gray-500 uppercase tracking-wider mb-1.5">District / State</label>
                    <input name="state" id="addr_district" type="text" placeholder="Bagmati"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-[#0c7a3e] font-[Nunito]">
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-500 uppercase tracking-wider mb-1.5">Postal Code</label>
                    <input name="zip_code" id="addr_postal" type="text" placeholder="44600"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-[#0c7a3e] font-[Nunito]">
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-xs font-black text-gray-500 uppercase tracking-wider mb-1.5">Delivery Note (optional)</label>
                <textarea name="description" id="addr_note" placeholder="Landmark, gate color, floor number..." rows="2"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-[#0c7a3e] transition-all font-[Nunito] resize-none"></textarea>
            </div>

            {{-- Mini order summary --}}
            <div class="bg-gray-50 rounded-xl p-4 mb-5 border border-gray-100">
                <div class="text-xs font-black text-gray-400 uppercase tracking-wider mb-3">Order Summary</div>
                <div id="checkoutSummaryItems" class="space-y-2 max-h-36 overflow-y-auto mb-3"></div>
                <div class="flex justify-between text-sm font-extrabold text-gray-800 border-t border-gray-200 pt-2">
                    <span>Total</span><span id="checkoutTotal">RS 0.00</span>
                </div>
            </div>

            <button id="continueToPaymentBtn" onclick="goToStep(2)"
                class="w-full bg-[#0c7a3e] hover:bg-[#0a6633] text-white border-none rounded-2xl py-4 text-[15px] font-extrabold cursor-pointer font-[Nunito] transition-colors">
                Continue to Payment →
            </button>
        </div>

        {{-- Step 2: Payment Method --}}
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
                <button onclick="goToStep(1, false)"
                    class="flex-1 border border-gray-200 text-gray-500 rounded-2xl py-3.5 text-[14px] font-extrabold cursor-pointer font-[Nunito] bg-transparent transition-colors">← Back</button>
                <button id="continueToReviewBtn" onclick="goToStep(3)"
                    class="flex-[2] bg-[#0c7a3e] hover:bg-[#0a6633] text-white border-none rounded-2xl py-4 text-[15px] font-extrabold cursor-pointer font-[Nunito] transition-colors">Review Order →</button>
            </div>
        </div>

        {{-- Step 3: Review & Confirm --}}
        <div id="checkStep3" class="hidden px-8 py-6">
            <div class="text-lg font-black text-gray-800 mb-5">✅ Review &amp; Confirm</div>
            <div class="bg-gray-50 rounded-xl p-4 mb-4 border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-xs font-black text-gray-400 uppercase tracking-wider">Delivery Address</div>
                    <button onclick="goToStep(1, false)" class="text-xs text-[#0c7a3e] font-extrabold bg-transparent border-none cursor-pointer">Edit</button>
                </div>
                <div id="confirmAddress" class="text-sm font-semibold text-gray-700 leading-relaxed"></div>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 mb-4 border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-xs font-black text-gray-400 uppercase tracking-wider">Payment Method</div>
                    <button onclick="goToStep(2, false)" class="text-xs text-[#0c7a3e] font-extrabold bg-transparent border-none cursor-pointer">Edit</button>
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
                    <div class="flex justify-between text-base font-extrabold text-gray-900 border-t border-gray-200 pt-2 mt-1">
                        <span>Total</span><span id="confirm_total">RS 0.00</span>
                    </div>
                </div>
            </div>
            <div class="flex gap-3">
                <button onclick="goToStep(2, false)"
                    class="flex-1 border border-gray-200 text-gray-500 rounded-2xl py-3.5 text-[14px] font-extrabold cursor-pointer font-[Nunito] bg-transparent">← Back</button>
                <button id="placeOrderBtn" onclick="placeOrder()"
                    class="flex-[2] bg-[#0c7a3e] hover:bg-[#0a6633] text-white border-none rounded-2xl py-4 text-[15px] font-extrabold cursor-pointer font-[Nunito] transition-colors flex items-center justify-center gap-2">🎉 Place Order</button>
            </div>
        </div>

        {{-- Step Khalti: Payment QR --}}
        <div id="checkStepKhalti" class="hidden px-8 py-8">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full mb-4" style="background: #5C2D91;">
                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M3 10h18v4H3v-4zm0-5h18v3H3V5zm0 10h18v3H3v-3z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-1">Pay with Khalti</h3>
                <p class="text-sm text-gray-500 font-medium mb-5">Scan the QR code with your Khalti app to complete payment</p>
            </div>

            <div class="flex flex-col items-center mb-6">
                {{-- QR Code container --}}
                <div id="khaltiQrCode" class="p-4 bg-white rounded-xl border border-gray-200 mb-4" style="box-shadow: 0 2px 8px rgba(0,0,0,0.06);"></div>

                {{-- Status indicator --}}
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></div>
                    <span id="khaltiStatus" class="text-sm font-semibold text-yellow-600">Waiting for payment...</span>
                </div>

                {{-- Or pay via link --}}
                <div class="text-center">
                    <p class="text-xs text-gray-400 mb-2">Or open Khalti in browser</p>
                    <a id="khaltiPayLink" href="#" target="_blank" rel="noopener"
                        class="inline-flex items-center gap-1.5 text-[13px] font-bold text-white px-5 py-2.5 rounded-lg transition-colors hover:opacity-90"
                        style="background: #5C2D91;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Pay on Khalti
                    </a>
                </div>
            </div>

            <div class="bg-purple-50 border border-purple-100 rounded-xl p-3.5 mb-5">
                <div class="flex items-start gap-2.5">
                    <svg class="w-4 h-4 text-purple-400 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                    <div class="text-xs text-purple-700 font-medium leading-relaxed">
                        <strong class="font-bold">How it works:</strong> Open your Khalti app, scan the QR code above, and confirm the payment. This page will update automatically once payment is received.
                    </div>
                </div>
            </div>

            <button onclick="cancelKhaltiPayment()"
                class="w-full border border-gray-200 text-gray-500 rounded-xl py-3 text-[13px] font-bold cursor-pointer bg-transparent transition-colors hover:border-gray-300">
                Cancel & Choose Different Payment
            </button>
        </div>

        {{-- Step 4: Order Success --}}
        <div id="checkStep4" class="hidden px-8 py-14 text-center">
            <div class="text-6xl mb-4">🎉</div>
            <div class="text-2xl font-black text-gray-900 mb-2">Order Placed!</div>
            <div class="text-sm text-gray-500 font-semibold mb-6">Your order has been received. We'll deliver within 30 minutes.</div>
            <div id="orderNumber" class="inline-block bg-green-50 border border-green-200 text-green-700 font-extrabold text-sm px-5 py-2.5 rounded-xl mb-8"></div>
            <br>
            <button onclick="closeCheckout()"
                class="bg-[#0c7a3e] text-white border-none rounded-2xl px-10 py-4 text-[15px] font-extrabold cursor-pointer font-[Nunito]">
                Back to Shopping
            </button>
        </div>
    </div>
</div>
