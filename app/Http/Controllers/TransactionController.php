<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Upload proof of payment for transaction.
     */
    public function uploadProof(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $transaction = Transaction::findOrFail($id);

        $path = $request->file('payment_proof')->store('proofs', 'public');

        $transaction->update([
            'payment_proof' => $path,
            'payment_status' => 'menunggu_verifikasi',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bukti pembayaran berhasil diupload.',
            'data' => $transaction,
        ], 200);
    }

    /**
     * Approve payment transaction.
     */
    public function approveTransaction($id)
    {
        $transaction = Transaction::findOrFail($id);

        $transaction->update([
            'payment_status' => 'lunas',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil disetujui.',
            'data' => $transaction,
        ], 200);
    }
}
