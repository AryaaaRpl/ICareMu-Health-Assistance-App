<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display activation page for current authenticated user.
     */
    public function activation()
    {
        $user = Auth::user();

        return view('auth.activation', compact('user'));
    }

    /**
     * Alias method for checkout / activation.
     */
    public function checkout()
    {
        return $this->activation();
    }

    /**
     * Handle payment success page.
     */
    public function finish(Request $request)
    {
        $orderId = $request->query('order_id', 'ICM-' . time());
        $paymentType = $request->query('payment_type');
        
        $user = Auth::user();

        if ($user) {
            $user->update(['payment_status' => 'paid']);
        }

        $paymentDate = now()->translatedFormat('d F Y, H:i') . ' WIB';
        
        $paymentMethod = 'Transfer Bank / Manual';
        if ($paymentType) {
            $paymentMethod = strtoupper(str_replace('_', ' ', $paymentType));
        }

        $amount = 'Rp 10.000';

        return view('payment.success', compact('orderId', 'paymentDate', 'paymentMethod', 'amount', 'user'));
    }

    /**
     * Handle payment failed/cancel callback or view.
     */
    public function failed(Request $request)
    {
        $orderId = $request->query('order_id');
        $statusCode = $request->query('status_code');
        $transactionStatus = $request->query('transaction_status', 'failed');
        $errorMessage = $request->query('error_message');

        return view('payment.failed', compact('orderId', 'statusCode', 'transactionStatus', 'errorMessage'));
    }
}
