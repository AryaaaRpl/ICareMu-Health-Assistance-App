<x-app.auth-layout title="Daftar Step 1 — iCareMu">
    <div class="space-y-6">
        <!-- Progress Bar -->
        <div class="space-y-2">
            <div class="flex justify-between text-[11px] font-bold text-slate-400 font-heading">
                <span class="text-[#186EF9]">STEP 1 OF 3</span>
                <span>Data Akun</span>
            </div>
            <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-[#186EF9] w-1/3 rounded-full"></div>
            </div>
            <div class="flex justify-between text-[10px] font-medium text-slate-400 pt-1">
                <span class="text-[#186EF9] font-bold">Akun</span>
                <span>Pembayaran</span>
                <span>Verifikasi</span>
            </div>
        </div>

        <div class="text-center">
            <h2 class="font-heading font-extrabold text-slate-900 text-2xl">Buat Akun Siswa</h2>
            <p class="text-xs text-slate-500 mt-1">Lengkapi data diri Anda untuk bergabung dengan layanan kesehatan ICAREMU.</p>
        </div>

        <form action="{{ route('register.step2') }}" method="GET" class="space-y-4">
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Lengkap</label>
                <div class="relative">
                    <input type="text" placeholder="Sesuai kartu pelajar..." required class="w-full pl-10 pr-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-[#186EF9]">
                    <span class="absolute left-3.5 top-3.5 text-slate-400">👤</span>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">NISN</label>
                <div class="relative">
                    <input type="text" placeholder="Nomor Induk Siswa Nasional..." required class="w-full pl-10 pr-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-[#186EF9]">
                    <span class="absolute left-3.5 top-3.5 text-slate-400">📖</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Email</label>
                    <input type="email" placeholder="siswa@sekolah.id" required class="w-full px-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-[#186EF9]">
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Password</label>
                    <input type="password" placeholder="Minimal 8 karakter..." required class="w-full px-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-[#186EF9]">
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Pilih Sekolah Anda</label>
                <select class="w-full px-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-sm font-medium text-slate-700 focus:outline-none focus:border-[#186EF9]">
                    <option>Cari asal sekolah Muhammadiyah...</option>
                    <option>SMA Muhammadiyah 1 Yogyakarta</option>
                    <option>SMA Muhammadiyah 2 Surabaya</option>
                    <option>SMA Muhammadiyah 3 Jakarta</option>
                </select>
            </div>

            <button type="submit" class="w-full py-4 rounded-2xl bg-[#186EF9] hover:bg-blue-600 text-white font-bold text-base transition-all shadow-lg shadow-blue-500/20 flex items-center justify-center gap-2">
                <span>Lanjut ke Pembayaran</span> ➔
            </button>
        </form>

        <div class="text-center text-xs text-slate-500">
            Sudah memiliki akun? <a href="{{ route('login') }}" class="font-bold text-[#186EF9] hover:underline">Masuk di sini</a>
        </div>
    </div>
</x-app.auth-layout>
