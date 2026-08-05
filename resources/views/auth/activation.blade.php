<x-guest-layout>
    <div class="min-h-screen bg-slate-50 flex flex-col justify-center items-center pt-6 sm:pt-0 pb-12">
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-3xl">
            <!-- Header & Progress Indicator -->
            <div class="mb-8">
                <div class="flex justify-between items-end mb-3">
                    <span class="text-xs font-bold text-blue-600 tracking-wider">STEP 2 OF 2</span>
                    <span class="text-xs font-medium text-gray-500">Aktivasi Akun</span>
                </div>

                <div class="relative w-full h-1.5 bg-gray-100 rounded-full mb-3 overflow-hidden">
                    <div class="absolute top-0 left-0 h-full bg-blue-600 rounded-full transition-all duration-500 ease-in-out w-full"></div>
                </div>

                <div class="flex justify-between text-[11px] font-semibold">
                    <span class="text-blue-600">Registrasi</span>
                    <span class="text-blue-600">Aktivasi Pembayaran</span>
                </div>
            </div>

            <!-- Activation Payment Content -->
            <div class="text-center mb-6">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-50/80 mb-5">
                    <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Aktivasi Akun ICAREMU</h2>
                <p class="text-sm text-gray-500 mt-2.5 leading-relaxed">Nikmati layanan pemantauan kesehatan digital selama 3 tahun penuh.</p>
            </div>

            <div class="text-center mb-6">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">TOTAL PEMBAYARAN</p>
                <p class="text-4xl font-black text-gray-900 mt-1.5 font-mono tracking-tighter">Rp 10.000</p>
            </div>

            <!-- QRIS & Support Card -->
            <div class="flex justify-center mb-6">
                <div class="border-[1.5px] border-gray-200 rounded-3xl p-6 relative bg-white shadow-sm">
                    <div class="absolute top-0 left-0 w-6 h-6 border-t-2 border-l-2 border-blue-500 rounded-tl-2xl mt-3 ml-3"></div>
                    <div class="absolute top-0 right-0 w-6 h-6 border-t-2 border-r-2 border-blue-500 rounded-tr-2xl mt-3 mr-3"></div>
                    <div class="absolute bottom-0 left-0 w-6 h-6 border-b-2 border-l-2 border-blue-500 rounded-bl-2xl mb-3 ml-3"></div>
                    <div class="absolute bottom-0 right-0 w-6 h-6 border-b-2 border-r-2 border-blue-500 rounded-br-2xl mb-3 mr-3"></div>
                    
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=ICAREMU_PAYMENT" alt="QRIS Code" class="w-40 h-40 object-contain rounded-xl p-2 bg-white mix-blend-multiply">
                    
                    <div class="absolute -bottom-3.5 left-1/2 transform -translate-x-1/2 bg-blue-50 border border-blue-100 text-blue-700 px-4 py-1 rounded-full text-[11px] font-bold tracking-widest shadow-sm">
                        QRIS & E-Wallet
                    </div>
                </div>
            </div>

            <div class="text-center mb-6">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">METODE PEMBAYARAN DIDUKUNG</p>
                <div class="flex justify-center space-x-3 text-[11px] font-bold">
                    <span class="text-blue-500">GoPay</span>
                    <span class="text-purple-600">OVO</span>
                    <span class="text-blue-400">DANA</span>
                    <span class="text-orange-500">ShopeePay</span>
                </div>
            </div>

            <!-- Pay Button Container -->
            <div class="space-y-4">
                <a href="{{ route('payment.success') }}" id="pay-button" class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all">
                    <svg class="mr-2 h-5 w-5 fill-current" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                    </svg>
                    Konfirmasi Pembayaran
                </a>

                <div class="text-center pt-2">
                    <a href="{{ route('dashboard') }}" class="text-xs text-slate-400 hover:text-slate-600 font-medium">
                        Lanjutkan ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
