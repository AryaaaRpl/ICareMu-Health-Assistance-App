<x-guest-layout>
    <div class="min-h-screen bg-slate-50 flex flex-col justify-center items-center pt-6 sm:pt-0 pb-12">
        
        <!-- Main Card Wrapper -->
        <div 
            class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-3xl" 
            x-data="{ step: 1, paymentStatusChecked: false }"
            x-cloak
        >
            <!-- Header & Progress Indicator -->
            <div class="mb-8">
                <div class="flex justify-between items-end mb-3">
                    <span class="text-xs font-bold text-blue-600 tracking-wider">STEP <span x-text="step"></span> OF 3</span>
                    <span class="text-xs font-medium text-gray-500" x-show="step === 1">Data Akun</span>
                    <span class="text-xs font-medium text-gray-500" x-show="step === 2">Aktivasi Akun</span>
                    <span class="text-xs font-medium text-gray-500" x-show="step === 3">Profil Kesehatan</span>
                </div>
                
                <!-- Progress Bar Container -->
                <div class="relative w-full h-1.5 bg-gray-100 rounded-full mb-3 overflow-hidden">
                    <div class="absolute top-0 left-0 h-full bg-blue-600 rounded-full transition-all duration-500 ease-in-out"
                         :class="{ 'w-1/3': step === 1, 'w-2/3': step === 2, 'w-full': step === 3 }"></div>
                </div>

                <!-- Tabs Labels -->
                <div class="flex justify-between text-[11px] font-semibold">
                    <span :class="{ 'text-blue-600': step >= 1, 'text-gray-400': step < 1 }">Akun</span>
                    <span :class="{ 'text-blue-600': step >= 2, 'text-gray-400': step < 2 }">Pembayaran</span>
                    <span :class="{ 'text-blue-600': step >= 3, 'text-gray-400': step < 3 }">Verifikasi</span>
                </div>
            </div>

            <!-- Registration Form -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- ==============================
                     STEP 1: DATA AKUN
                     ============================== -->
                <div x-show="step === 1" x-transition.opacity.duration.300ms>
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Buat Akun Siswa</h2>
                        <p class="text-sm text-gray-500 mt-2.5 leading-relaxed">Lengkapi data diri Anda untuk bergabung dengan layanan kesehatan ICAREMU.</p>
                    </div>

                    <div class="space-y-4">
                        <!-- Nama Lengkap -->
                        <div>
                            <label for="nama_lengkap" class="block text-xs font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input type="text" name="nama_lengkap" id="nama_lengkap" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-11 text-sm border-gray-200 rounded-xl py-3 bg-gray-50/50" placeholder="Sesuai kartu pelajar..." required>
                            </div>
                        </div>

                        <!-- NISN -->
                        <div>
                            <label for="nisn" class="block text-xs font-semibold text-gray-700 mb-1.5">NISN</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                    </svg>
                                </div>
                                <input type="text" name="nisn" id="nisn" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-11 text-sm border-gray-200 rounded-xl py-3 bg-gray-50/50" placeholder="Nomor Induk Siswa Nasional..." required>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-xs font-semibold text-gray-700 mb-1.5">Email</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <input type="email" name="email" id="email" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-11 text-sm border-gray-200 rounded-xl py-3 bg-gray-50/50" placeholder="siswa@sekolah.id" required>
                                </div>
                            </div>
                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-xs font-semibold text-gray-700 mb-1.5">Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <input type="password" name="password" id="password" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-11 text-sm border-gray-200 rounded-xl py-3 bg-gray-50/50" placeholder="Minimal 8 karakter..." required>
                                </div>
                            </div>
                        </div>

                        <!-- Pilih Sekolah -->
                        <div>
                            <label for="sekolah_id" class="block text-xs font-semibold text-gray-700 mb-1.5">Pilih Sekolah Anda</label>
                            <select name="sekolah_id" id="sekolah_id" class="block w-full pl-3 pr-10 py-3 text-sm border-gray-200 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-xl bg-gray-50/50 text-gray-600 appearance-none" required>
                                <option value="" disabled selected>Cari asal sekolah Muhammadiyah...</option>
                                @if(isset($sekolahs))
                                    @foreach($sekolahs as $sekolah)
                                        <option value="{{ $sekolah->id }}">{{ $sekolah->nama }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="mt-8">
                        <button x-on:click.prevent="step = 2" class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Lanjut ke Pembayaran
                            <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>

                    <div class="mt-6 text-center">
                        <p class="text-xs text-gray-500">Sudah memiliki akun? <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-700 transition">Masuk di sini</a></p>
                    </div>
                </div>

                <!-- ==============================
                     STEP 2: PEMBAYARAN
                     ============================== -->
                <div x-show="step === 2" style="display: none;" x-transition.opacity.duration.300ms>
                    <div class="text-center mb-6">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-50/80 mb-5">
                            <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Aktivasi Akun ICAREMU</h2>
                        <p class="text-sm text-gray-500 mt-2.5 leading-relaxed">Nikmati layanan pemantauan kesehatan digital selama 3 tahun penuh.</p>
                    </div>

                    <div class="text-center mb-8">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">TOTAL PEMBAYARAN</p>
                        <p class="text-4xl font-black text-gray-900 mt-1.5 font-mono tracking-tighter">Rp 10.000</p>
                    </div>

                    <!-- QRIS Mockup -->
                    <div class="flex justify-center mb-8">
                        <div class="border-[1.5px] border-gray-200 rounded-3xl p-6 relative bg-white shadow-sm">
                            <!-- Scanner corners overlay -->
                            <div class="absolute top-0 left-0 w-6 h-6 border-t-2 border-l-2 border-blue-500 rounded-tl-2xl mt-3 ml-3"></div>
                            <div class="absolute top-0 right-0 w-6 h-6 border-t-2 border-r-2 border-blue-500 rounded-tr-2xl mt-3 mr-3"></div>
                            <div class="absolute bottom-0 left-0 w-6 h-6 border-b-2 border-l-2 border-blue-500 rounded-bl-2xl mb-3 ml-3"></div>
                            <div class="absolute bottom-0 right-0 w-6 h-6 border-b-2 border-r-2 border-blue-500 rounded-br-2xl mb-3 mr-3"></div>
                            
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=ICAREMU_PAYMENT" alt="QRIS Code" class="w-44 h-44 object-contain rounded-xl p-2 bg-white mix-blend-multiply">
                            
                            <div class="absolute -bottom-3.5 left-1/2 transform -translate-x-1/2 bg-blue-50 border border-blue-100 text-blue-700 px-4 py-1 rounded-full text-[11px] font-bold tracking-widest shadow-sm">
                                QRIS
                            </div>
                        </div>
                    </div>

                    <div class="text-center mb-8">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">METODE PEMBAYARAN DIDUKUNG</p>
                        <div class="flex justify-center space-x-4 text-[11px] font-bold">
                            <span class="text-blue-500">GoPay</span>
                            <span class="text-purple-600">OVO</span>
                            <span class="text-blue-400">DANA</span>
                            <span class="text-orange-500">ShopeePay</span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <!-- Simulated Payment Check -->
                        <button 
                            x-show="!paymentStatusChecked" 
                            x-on:click.prevent="paymentStatusChecked = true" 
                            class="w-full flex justify-center items-center py-3.5 px-4 border border-gray-200 rounded-xl shadow-sm text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-300 focus:outline-none transition-all"
                        >
                            <svg class="mr-2 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Cek Status Pembayaran
                        </button>
                        
                        <!-- Proceeds to Step 3 -->
                        <button 
                            x-show="paymentStatusChecked" 
                            style="display: none;" 
                            x-on:click.prevent="step = 3" 
                            class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all"
                        >
                            Pembayaran Berhasil - Lanjut
                            <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>

                        <button x-on:click.prevent="step = 1" class="w-full flex justify-center items-center py-2 px-4 text-[11px] font-semibold text-gray-400 hover:text-gray-600 bg-transparent transition-colors">
                            Kembali ke Step 1
                        </button>
                    </div>
                </div>

                <!-- ==============================
                     STEP 3: PROFIL KESEHATAN
                     ============================== -->
                <div x-show="step === 3" style="display: none;" x-transition.opacity.duration.300ms>
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Profil Kesehatan</h2>
                        <p class="text-sm text-gray-500 mt-2.5 leading-relaxed">Lengkapi data metrik kesehatan & kontak wali Anda.</p>
                    </div>

                    <div class="space-y-4">
                        <!-- Nama Wali -->
                        <div>
                            <label for="nama_wali" class="block text-xs font-semibold text-gray-700 mb-1.5">Nama Wali (Orang Tua)</label>
                            <input type="text" name="nama_wali" id="nama_wali" class="focus:ring-blue-500 focus:border-blue-500 block w-full px-4 text-sm border-gray-200 rounded-xl py-3 bg-gray-50/50" placeholder="Nama lengkap wali..." required>
                        </div>

                        <!-- No WA -->
                        <div>
                            <label for="no_wa_wali" class="block text-xs font-semibold text-gray-700 mb-1.5">No. WhatsApp Wali</label>
                            <input type="tel" name="no_wa_wali" id="no_wa_wali" class="focus:ring-blue-500 focus:border-blue-500 block w-full px-4 text-sm border-gray-200 rounded-xl py-3 bg-gray-50/50" placeholder="08xx xxxx xxxx" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Tinggi Badan -->
                            <div>
                                <label for="tinggi_badan" class="block text-xs font-semibold text-gray-700 mb-1.5">Tinggi Badan (cm)</label>
                                <input type="number" name="tinggi_badan" id="tinggi_badan" class="focus:ring-blue-500 focus:border-blue-500 block w-full px-4 text-sm border-gray-200 rounded-xl py-3 bg-gray-50/50" placeholder="Cth: 165" required>
                            </div>
                            <!-- Berat Badan -->
                            <div>
                                <label for="berat_badan" class="block text-xs font-semibold text-gray-700 mb-1.5">Berat Badan (kg)</label>
                                <input type="number" name="berat_badan" id="berat_badan" class="focus:ring-blue-500 focus:border-blue-500 block w-full px-4 text-sm border-gray-200 rounded-xl py-3 bg-gray-50/50" placeholder="Cth: 55" required>
                            </div>
                        </div>

                        <!-- Golongan Darah -->
                        <div>
                            <label for="golongan_darah" class="block text-xs font-semibold text-gray-700 mb-1.5">Golongan Darah</label>
                            <select name="golongan_darah" id="golongan_darah" class="block w-full px-4 py-3 text-sm border-gray-200 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-xl bg-gray-50/50 text-gray-600 appearance-none" required>
                                <option value="" disabled selected>Pilih Golongan Darah</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                                <option value="Tidak Tahu">Tidak Tahu</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-8 space-y-3">
                        <button type="submit" class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Selesai & Buka Dashboard
                        </button>

                        <button x-on:click.prevent="step = 2" class="w-full flex justify-center items-center py-2 px-4 text-[11px] font-semibold text-gray-400 hover:text-gray-600 bg-transparent transition-colors">
                            Kembali ke Step 2
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
