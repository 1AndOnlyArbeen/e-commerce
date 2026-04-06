<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class KhaltiService
{
    private string $secretKey;
    private string $baseUrl;

    public function __construct()
    {
        $this->secretKey = config('khalti.secret_key');
        $this->baseUrl = config('khalti.base_url');
    }

    /**
     * Check if we're in demo mode (no API key configured).
     */
    public function isDemoMode(): bool
    {
        return empty($this->secretKey) || $this->secretKey === 'test_secret_key_YOUR_KEY_HERE';
    }

    /**
     * Initiate a Khalti e-payment.
     * In demo mode: simulates the response without calling Khalti API.
     */
    public function initiate(
        int $amountInPaisa,
        string $orderId,
        string $orderName,
        string $returnUrl,
        string $websiteUrl
    ): array {
        // Demo mode — simulate Khalti response
        if ($this->isDemoMode()) {
            $fakePidx = 'demo_' . Str::random(24);
            return [
                'success'     => true,
                'pidx'        => $fakePidx,
                'payment_url' => url('/payment/khalti/demo?pidx=' . $fakePidx . '&amount=' . $amountInPaisa . '&order=' . $orderId),
                'demo'        => true,
            ];
        }

        // Real Khalti API call
        try {
            $response = Http::withHeaders([
                'Authorization' => 'key ' . $this->secretKey,
                'Content-Type'  => 'application/json',
            ])->post($this->baseUrl . '/epayment/initiate/', [
                'return_url'          => $returnUrl,
                'website_url'         => $websiteUrl,
                'amount'              => $amountInPaisa,
                'purchase_order_id'   => $orderId,
                'purchase_order_name' => $orderName,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success'     => true,
                    'pidx'        => $data['pidx'] ?? null,
                    'payment_url' => $data['payment_url'] ?? null,
                    'demo'        => false,
                ];
            }

            Log::error('Khalti initiate failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            return ['success' => false, 'message' => 'Payment initiation failed.'];
        } catch (\Exception $e) {
            Log::error('Khalti initiate exception', ['error' => $e->getMessage()]);
            return ['success' => false, 'message' => 'Could not connect to payment service.'];
        }
    }

    /**
     * Lookup/verify a Khalti payment by pidx.
     * In demo mode: checks the cache for simulated payment.
     */
    public function lookup(string $pidx): array
    {
        // Demo mode — check if demo payment was "confirmed"
        if ($this->isDemoMode() || str_starts_with($pidx, 'demo_')) {
            $paid = cache()->get('khalti_demo_paid_' . $pidx, false);
            return [
                'success' => true,
                'status'  => $paid ? 'Completed' : 'Pending',
                'data'    => ['pidx' => $pidx],
            ];
        }

        // Real Khalti API call
        try {
            $response = Http::withHeaders([
                'Authorization' => 'key ' . $this->secretKey,
                'Content-Type'  => 'application/json',
            ])->post($this->baseUrl . '/epayment/lookup/', [
                'pidx' => $pidx,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'status'  => $data['status'] ?? 'Unknown',
                    'data'    => $data,
                ];
            }

            return ['success' => false, 'status' => 'lookup_failed', 'data' => []];
        } catch (\Exception $e) {
            Log::error('Khalti lookup exception', ['error' => $e->getMessage()]);
            return ['success' => false, 'status' => 'error', 'data' => []];
        }
    }

    /**
     * Demo mode: mark a payment as "paid" in cache.
     */
    public function demoConfirmPayment(string $pidx): void
    {
        cache()->put('khalti_demo_paid_' . $pidx, true, now()->addHour());
    }
}
