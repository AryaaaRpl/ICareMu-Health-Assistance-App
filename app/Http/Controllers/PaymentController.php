<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class PaymentController extends Controller
{
    /**
     * Display activation page with Midtrans Redirect URL for current authenticated user.
     */
    public function activation()
    {
        $user = Auth::user();

        // Get keys from config/env
        $serverKey = config('midtrans.server_key', env('MIDTRANS_SERVER_KEY'));
        $clientKey = config('midtrans.client_key', env('MIDTRANS_CLIENT_KEY'));

        // STRICT SANDBOX CONFIGURATION
        \Midtrans\Config::$serverKey = $serverKey;
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
        \Midtrans\Config::$curlOptions = [
            CURLOPT_HTTPHEADER => [],
            CURLOPT_SSL_VERIFYPEER => false,
        ];

        $paymentUrl = null;
        $midtransError = '';

        try {
            $orderId = 'REG-' . $user->id . '-' . time();

            if (Schema::hasColumn('users', 'payment_order_id')) {
                $user->update(['payment_order_id' => $orderId]);
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => 10000,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
            ];

            $paymentUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;
        } catch (\Exception $e) {
            $midtransError = $e->getMessage();
        }

        return view('auth.activation', compact('paymentUrl', 'clientKey', 'midtransError', 'user'));
    }

    /**
     * Alias method for checkout / activation.
     */
    public function checkout()
    {
        return $this->activation();
    }

    /**
     * Handle payment success callback/redirect from Midtrans.
     */
    public function finish(Request $request)
    {
        $orderId = $request->query('order_id');
        $statusCode = $request->query('status_code');
        $transactionStatus = $request->query('transaction_status');

        $user = Auth::user();

        if ($user && in_array($transactionStatus, ['settlement', 'capture', 'success'])) {
            $user->update(['payment_status' => 'paid']);
        }

        return view('payment.success', compact('orderId', 'statusCode', 'transactionStatus'));
    }
}
