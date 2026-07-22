<x-app.auth-layout title="Daftar Step 2 (QRIS) — iCareMu">
    <div class="space-y-6">
        <!-- Progress Bar -->
        <div class="space-y-2">
            <div class="flex justify-between text-[11px] font-bold text-slate-400 font-heading">
                <span class="text-[#186EF9]">STEP 2 OF 3</span>
                <span>Aktivasi Layanan</span>
            </div>
            <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-[#186EF9] w-2/3 rounded-full"></div>
            </div>
            <div class="flex justify-between text-[10px] font-medium text-slate-400 pt-1">
                <span class="text-[#186EF9]">Akun</span>
                <span class="text-[#186EF9] font-bold">Pembayaran</span>
                <span>Verifikasi</span>
            </div>
        </div>

        <div class="text-center">
            <h2 class="font-heading font-extrabold text-slate-900 text-2xl">Aktivasi Layanan ICAREMU</h2>
            <p class="text-xs text-slate-500 mt-1">Scan kode QRIS di bawah ini untuk menyelesaikan pendaftaran (One-Time Registration).</p>
        </div>

        <!-- Total Price Card -->
        <div class="bg-blue-50/70 border border-blue-200/80 rounded-2xl p-4 flex items-center justify-between">
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">TOTAL PEMBAYARAN</div>
                <div class="text-xs font-medium text-slate-600">Aktivasi Kartu Digital & Skrining</div>
            </div>
            <div class="text-xl font-extrabold text-[#186EF9] font-heading">Rp 10.000</div>
        </div>

        <!-- Simulated QRIS Box -->
        <div class="bg-slate-50 border border-slate-200 rounded-3xl p-6 flex flex-col items-center space-y-4">
            <div class="text-[11px] font-bold tracking-widest text-slate-400 uppercase">QRIS NATIONAL STANDARD</div>
            <div class="w-48 h-48 bg-white p-3 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-center">
                <!-- QR Code SVG graphics -->
                <div class="w-full h-full border-4 border-slate-900 p-1 flex flex-col justify-between">
                    <div class="flex justify-between">
                        <div class="w-10 h-10 bg-slate-900"></div>
                        <div class="w-10 h-10 bg-slate-900"></div>
                    </div>
                    <div class="text-[9px] font-extrabold text-center tracking-tighter">ICAREMU OFFICIAL</div>
                    <div class="flex justify-between">
                        <div class="w-10 h-10 bg-slate-900"></div>
                        <div class="w-6 h-6 bg-emerald-500 rounded-full"></div>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3 text-xs font-bold text-slate-400">
                <span>GoPay</span> • <span>OVO</span> • <span>DANA</span> • <span>ShopeePay</span>
            </div>
        </div>

        <form action="{{ route('register.step2.post') }}" method="POST">
            @csrf
            <button type="submit" class="w-full py-4 rounded-2xl bg-[#186EF9] hover:bg-blue-600 text-white font-bold text-base transition-all shadow-lg shadow-blue-500/20 flex items-center justify-center gap-2">
                <span>Saya Sudah Bayar (Aktivasi Akun)</span> ➔
            </button>
        </form>
    </div>
</x-app.auth-layout>
