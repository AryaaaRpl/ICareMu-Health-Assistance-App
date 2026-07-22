<x-app.auth-layout title="Daftar Step 3 — iCareMu">
    <div class="space-y-6">
        <!-- Progress Bar -->
        <div class="space-y-2">
            <div class="flex justify-between text-[11px] font-bold text-slate-400 font-heading">
                <span class="text-[#186EF9]">STEP 3 OF 3</span>
                <span>Profil Kesehatan</span>
            </div>
            <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-[#186EF9] w-full rounded-full"></div>
            </div>
            <div class="flex justify-between text-[10px] font-medium text-slate-400 pt-1">
                <span class="text-[#186EF9]">Akun</span>
                <span class="text-[#186EF9]">Pembayaran</span>
                <span class="text-[#186EF9] font-bold">Verifikasi</span>
            </div>
        </div>

        <div class="text-center">
            <h2 class="font-heading font-extrabold text-slate-900 text-2xl">Profil Kesehatan & Wali</h2>
            <p class="text-xs text-slate-500 mt-1">Lengkapi data kesehatan dasar dan informasi wali untuk keadaan darurat.</p>
        </div>

        @if ($errors->any())
            <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl text-xs text-rose-600 font-semibold space-y-1">
                @foreach ($errors->all() as $error)
                    <div>• {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register.step3.post') }}" method="POST" class="space-y-6">
            @csrf
            <!-- Section 1: Data Wali -->
            <div class="space-y-3">
                <div class="flex items-center gap-2 text-xs font-bold text-slate-700">
                    <span class="text-[#186EF9]">🛡</span> Data Orang Tua / Wali
                </div>
                <div class="space-y-3">
                    <input type="text" name="nama_ortu" value="{{ old('nama_ortu', $siswa->nama_ortu ?? '') }}" placeholder="Nama lengkap wali..." required class="w-full px-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-[#186EF9]">
                    <input type="text" name="no_wa_ortu" value="{{ old('no_wa_ortu', $siswa->no_wa_ortu ?? '') }}" placeholder="No. WhatsApp Orang Tua (0812...)" required class="w-full px-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-[#186EF9]">
                </div>
            </div>

            <!-- Section 2: Data Medis Dasar -->
            <div class="space-y-3">
                <div class="flex items-center gap-2 text-xs font-bold text-slate-700">
                    <span class="text-rose-500">♥</span> Data Medis Dasar
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="relative">
                        <input type="number" step="0.1" name="tinggi_badan" value="{{ old('tinggi_badan') }}" placeholder="Tinggi (cm)" required class="w-full px-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-[#186EF9]">
                    </div>
                    <div class="relative">
                        <input type="number" step="0.1" name="berat_badan" value="{{ old('berat_badan') }}" placeholder="Berat (kg)" required class="w-full px-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-[#186EF9]">
                    </div>
                </div>
                <select name="golongan_darah" class="w-full px-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-sm font-medium text-slate-700 focus:outline-none focus:border-[#186EF9]">
                    <option value="">Golongan Darah (Pilih)...</option>
                    <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>Golongan Darah A</option>
                    <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>Golongan Darah B</option>
                    <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>Golongan Darah AB</option>
                    <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>Golongan Darah O</option>
                </select>
            </div>

            <button type="submit" class="w-full py-4 rounded-2xl bg-[#00A86B] hover:bg-emerald-600 text-white font-bold text-base transition-all shadow-lg shadow-emerald-500/20 flex items-center justify-center gap-2">
                <span>Selesai & Buka Dashboard</span> ➔
            </button>
        </form>
    </div>
</x-app.auth-layout>
