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
                    
                    <img src="{{ asset('images/qris-statis.jpg') }}" alt="QRIS Code Statis" class="w-64 max-h-[360px] object-contain rounded-2xl p-1 bg-white">
                    
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
                <button type="button" onclick="openModal()" id="pay-button" class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all">
                    <svg class="mr-2 h-5 w-5 fill-current" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                    </svg>
                    Konfirmasi Pembayaran
                </button>

                <div class="text-center pt-2">
                    @php
                        $isUploaded = auth()->check() && in_array(auth()->user()->payment_status, ['paid', 'menunggu_verifikasi']);
                    @endphp
                    <a id="dashboard-btn" href="{{ route('dashboard') }}" 
                       class="text-xs font-medium transition-all {{ $isUploaded ? 'text-blue-600 hover:text-blue-700 font-semibold cursor-pointer' : 'text-slate-300 pointer-events-none cursor-not-allowed' }}">
                        Lanjutkan ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pop-up Modal Upload Bukti Transfer -->
    <div id="uploadModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-100">
            <h3 class="text-xl font-extrabold text-slate-900 mb-2">Unggah Bukti Transfer</h3>
            <p class="text-sm text-slate-500 mb-6 leading-relaxed">Silakan unggah foto struk atau screenshot bukti pembayaran.</p>

            <form onsubmit="handleUpload(event)" class="space-y-6">
                <input type="hidden" id="csrfToken" value="{{ csrf_token() }}">
                <input type="hidden" id="transactionId" value="{{ $transaction->id ?? 1 }}">

                <div>
                    <input type="file" id="proofFile" accept="image/png, image/jpeg, image/jpg" required class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer border border-slate-200 rounded-xl p-1 bg-slate-50 focus:outline-none" />
                </div>

                <div class="flex items-center justify-end space-x-3">
                    <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-100 transition-colors">
                        Batal
                    </button>
                    <button type="submit" id="submitBtn" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold transition-colors flex items-center">
                        Kirim Bukti
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('uploadModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('uploadModal').classList.add('hidden');
        }

        async function handleUpload(event) {
            event.preventDefault();

            const fileInput = document.getElementById('proofFile');
            const csrfToken = document.getElementById('csrfToken').value;
            const transactionId = document.getElementById('transactionId').value;
            const submitBtn = document.getElementById('submitBtn');
            const dashboardBtn = document.getElementById('dashboard-btn');

            if (!fileInput.files || !fileInput.files[0]) {
                alert('Silakan pilih file bukti pembayaran terlebih dahulu.');
                return;
            }

            const formData = new FormData();
            formData.append('payment_proof', fileInput.files[0]);

            submitBtn.disabled = true;
            submitBtn.innerText = 'Mengunggah...';

            try {
                const response = await fetch(`/api/transactions/${transactionId}/upload-proof`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                if (response.ok) {
                    // Enable tombol Lanjutkan ke Dashboard
                    if (dashboardBtn) {
                        dashboardBtn.classList.remove('text-slate-300', 'pointer-events-none', 'cursor-not-allowed');
                        dashboardBtn.classList.add('text-blue-600', 'hover:text-blue-700', 'font-semibold', 'cursor-pointer');
                    }
                    closeModal();
                    alert('Bukti pembayaran berhasil diunggah! Tombol Lanjutkan ke Dashboard telah aktif.');
                    window.location.href = '/dashboard';
                } else {
                    const result = await response.json();
                    alert(result.message || 'Gagal mengunggah bukti pembayaran.');
                    submitBtn.disabled = false;
                    submitBtn.innerText = 'Kirim Bukti';
                }
            } catch (error) {
                alert('Terjadi kesalahan koneksi. Silakan coba lagi.');
                submitBtn.disabled = false;
                submitBtn.innerText = 'Kirim Bukti';
            }
        }
    </script>
</x-guest-layout>
