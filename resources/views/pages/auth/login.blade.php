<x-app.auth-layout title="Masuk — iCareMu">
    <div class="space-y-6">
        <div class="text-center">
            <h2 class="font-heading font-extrabold text-slate-900 text-2xl">Sistem Kesehatan Digital Terpadu</h2>
            <p class="text-xs text-slate-500 mt-1">Masuk dengan nomor NISN atau NIP Anda</p>
        </div>

        <form action="{{ route('dashboard.uks') }}" method="GET" class="space-y-4">
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">NIS / NIP</label>
                <div class="relative">
                    <input type="text" placeholder="Masukkan NIS atau NIP Anda" required class="w-full pl-10 pr-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-[#186EF9]">
                    <span class="absolute left-3.5 top-3.5 text-slate-400">👤</span>
                </div>
            </div>

            <div class="space-y-1">
                <div class="flex items-center justify-between">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">PASSWORD</label>
                    <a href="#" class="text-xs font-bold text-emerald-600 hover:underline">Lupa password?</a>
                </div>
                <div class="relative">
                    <input type="password" placeholder="Masukkan password Anda" required class="w-full pl-10 pr-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-[#186EF9]">
                    <span class="absolute left-3.5 top-3.5 text-slate-400">🔒</span>
                </div>
            </div>

            <button type="submit" class="w-full py-4 rounded-2xl bg-[#00A86B] hover:bg-emerald-600 text-white font-bold text-base transition-all shadow-lg shadow-emerald-500/20 flex items-center justify-center gap-2">
                <span>Login</span> ➔
            </button>
        </form>

        <div class="text-center text-xs text-slate-500">
            Belum memiliki akun ICAREMU? <a href="{{ route('register.step1') }}" class="font-bold text-[#00A86B] hover:underline">Daftar sekarang</a>
        </div>
    </div>
</x-app.auth-layout>
