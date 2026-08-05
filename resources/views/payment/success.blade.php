<x-guest-layout>
    <div class="min-h-screen bg-slate-50 flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-lg bg-white rounded-2xl border border-gray-100 shadow-lg p-8 sm:p-10 text-center relative transition-all duration-300">
            <!-- Header Akses (Top Bar Decor) -->
            <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-teal-500 via-emerald-500 to-blue-600 rounded-t-2xl"></div>

            <!-- Icon Checkmark & Ring Animation -->
            <div class="mt-2 mb-6">
                <div class="mx-auto w-20 h-20 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center border border-emerald-100 ring-8 ring-emerald-50/50">
                    <svg class="w-10 h-10 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>

            <!-- Title & Description Spacing -->
            <div class="space-y-3 mb-8">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold uppercase tracking-wider border border-emerald-200/60">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Transaksi Berhasil
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Pembayaran Berhasil!</h1>
                <p class="text-sm text-gray-500 leading-relaxed max-w-md mx-auto">
                    Terima kasih! Akun Anda telah aktif dan layanan pemantauan kesehatan ICAREMU siap digunakan.
                </p>
            </div>

            <!-- Detail Pembayaran Structure (Clean Flexbox Row Pattern) -->
            <div class="bg-slate-50 rounded-xl p-5 border border-gray-200/70 space-y-1 text-left mb-8">
                <div class="flex justify-between items-center py-2.5 border-b border-gray-200 text-sm">
                    <span class="text-gray-500 font-normal">Nomor Referensi</span>
                    <span class="text-gray-900 font-medium font-mono text-right tracking-tight whitespace-nowrap">{{ $orderId ?? 'ICM-REG-' . time() }}</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-gray-200 text-sm">
                    <span class="text-gray-500 font-normal">Tanggal Pembayaran</span>
                    <span class="text-gray-900 font-medium text-right whitespace-nowrap">{{ $paymentDate ?? now()->translatedFormat('d F Y, H:i') . ' WIB' }}</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-gray-200 text-sm">
                    <span class="text-gray-500 font-normal">Metode Pembayaran</span>
                    <span class="text-gray-900 font-medium text-right whitespace-nowrap">{{ $paymentMethod ?? 'QRIS / E-Wallet' }}</span>
                </div>
                <div class="flex justify-between items-center pt-3 text-sm">
                    <span class="text-gray-900 font-semibold">Total Nominal</span>
                    <span class="text-emerald-700 font-bold text-lg font-mono text-right whitespace-nowrap">{{ $amount ?? 'Rp 10.000' }}</span>
                </div>
            </div>

            <!-- Enterprise Action Button -->
            <div>
                <a href="{{ route('dashboard') }}" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-blue-900 hover:bg-blue-950 text-white font-semibold text-sm rounded-lg shadow transition-all focus:outline-none focus:ring-2 focus:ring-blue-900/40">
                    <svg class="w-5 h-5 text-white/90 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
