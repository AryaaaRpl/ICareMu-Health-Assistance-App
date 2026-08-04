<x-app-layout>
    <div class="max-w-2xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-8 sm:p-10 text-center space-y-6">
            <!-- Animated Checkmark Icon -->
            <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto shadow-inner border border-emerald-200">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <!-- Title & Message -->
            <div class="space-y-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold uppercase tracking-wider border border-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                    Transaksi Berhasil
                </span>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Pembayaran Berhasil!</h1>
                <p class="text-sm text-slate-500 max-w-md mx-auto">
                    Terima kasih! Pembayaran Anda telah kami terima dan verifikasi secara otomatis.
                </p>
            </div>

            <!-- Order Details Box -->
            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 space-y-2 text-left text-xs">
                <div class="flex items-center justify-between py-1 border-b border-slate-200/60">
                    <span class="font-semibold text-slate-500">Nomor Order (Order ID):</span>
                    <span class="font-bold text-slate-800 font-mono">{{ $orderId ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center justify-between py-1">
                    <span class="font-semibold text-slate-500">Status Transaksi:</span>
                    <span class="font-bold text-emerald-600 uppercase">{{ $transactionStatus ?? 'settlement' }}</span>
                </div>
                @if(isset($statusCode))
                    <div class="flex items-center justify-between py-1 border-t border-slate-200/60">
                        <span class="font-semibold text-slate-500">Status Code:</span>
                        <span class="font-bold text-slate-700 font-mono">{{ $statusCode }}</span>
                    </div>
                @endif
            </div>

            <!-- Action Button -->
            <div class="pt-4">
                <a href="{{ route('dashboard') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs rounded-2xl shadow-lg shadow-indigo-500/25 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
