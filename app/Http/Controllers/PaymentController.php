<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\KhaltiService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Initiate Khalti payment for an order.
     */
    public function initiateKhalti(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
        ]);

        $order = Order::with('items')->findOrFail($request->order_id);

        if ($order->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        if ($order->payment_status === 'paid') {
            return response()->json(['success' => false, 'message' => 'Order already paid.']);
        }

        $totalRS = $order->items->sum('total_amount');
        $totalPaisa = (int) round($totalRS * 100);

        if ($totalPaisa < 1000) {
            return response()->json(['success' => false, 'message' => 'Order total too low for Khalti payment.']);
        }

        $orderNumber = 'ARB-' . strtoupper(substr(md5($order->id), 0, 6));
        $returnUrl = url('/payment/khalti/callback');
        $websiteUrl = url('/');

        $khalti = new KhaltiService();
        $result = $khalti->initiate(
            $totalPaisa,
            (string) $order->id,
            "ArbeenStore Order {$orderNumber}",
            $returnUrl,
            $websiteUrl
        );

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'] ?? 'Payment initiation failed.',
            ]);
        }

        $order->update(['notes' => json_encode(['khalti_pidx' => $result['pidx']])]);

        return response()->json([
            'success'     => true,
            'payment_url' => $result['payment_url'],
            'pidx'        => $result['pidx'],
            'demo'        => $result['demo'] ?? false,
        ]);
    }

    /**
     * Khalti redirects the user here after real payment.
     */
    public function khaltiCallback(Request $request)
    {
        $pidx = $request->query('pidx');
        $status = $request->query('status');

        if (!$pidx) {
            return redirect('/')->with('error', 'Invalid payment callback.');
        }

        $order = Order::where('notes', 'LIKE', "%{$pidx}%")
            ->where('user_id', auth()->id())
            ->first();

        if (!$order) {
            return redirect('/')->with('error', 'Order not found.');
        }

        if ($status === 'Completed') {
            $khalti = new KhaltiService();
            $lookup = $khalti->lookup($pidx);

            if ($lookup['success'] && $lookup['status'] === 'Completed') {
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'processing',
                ]);
            }
        }

        return redirect('/')->with('payment_completed', $order->id);
    }

    /**
     * Verify Khalti payment status via AJAX polling.
     */
    public function verifyKhalti(Request $request)
    {
        $request->validate([
            'pidx'     => 'required|string',
            'order_id' => 'required|integer',
        ]);

        $order = Order::findOrFail($request->order_id);

        if ($order->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        if ($order->payment_status === 'paid') {
            return response()->json([
                'success' => true,
                'paid'    => true,
                'order_number' => 'ARB-' . strtoupper(substr(md5($order->id), 0, 6)),
            ]);
        }

        $khalti = new KhaltiService();
        $lookup = $khalti->lookup($request->pidx);

        if ($lookup['success'] && $lookup['status'] === 'Completed') {
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing',
            ]);

            return response()->json([
                'success' => true,
                'paid'    => true,
                'order_number' => 'ARB-' . strtoupper(substr(md5($order->id), 0, 6)),
            ]);
        }

        return response()->json([
            'success' => true,
            'paid'    => false,
            'status'  => $lookup['status'] ?? 'Pending',
        ]);
    }

    /**
     * Demo payment page — simulates Khalti's payment screen.
     * Only works when no real API key is configured.
     */
    public function demoPage(Request $request)
    {
        $khalti = new KhaltiService();
        if (!$khalti->isDemoMode()) {
            abort(404);
        }

        $pidx = $request->query('pidx', '');
        $amount = (int) $request->query('amount', 0);
        $orderId = $request->query('order', '');
        $amountRS = number_format($amount / 100, 2);

        return view('payment.khalti-demo', compact('pidx', 'amountRS', 'orderId'));
    }

    /**
     * Demo: confirm the simulated payment.
     */
    public function demoConfirm(Request $request)
    {
        $khalti = new KhaltiService();
        if (!$khalti->isDemoMode()) {
            return response()->json(['success' => false], 403);
        }

        $request->validate(['pidx' => 'required|string']);

        $khalti->demoConfirmPayment($request->pidx);

        return response()->json(['success' => true]);
    }
}
