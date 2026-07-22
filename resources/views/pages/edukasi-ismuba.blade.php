<x-app.layout active="edukasi-ismuba" title="Edukasi Kesehatan & ISMUBA — iCareMu">
    <div class="space-y-4">
        <h1 class="font-heading text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Edukasi Kesehatan & ISMUBA</h1>
        <p class="text-sm text-slate-500 font-medium">Temukan panduan kesehatan, Fikih Wanita Muhammadiyah, kesehatan mental, dan konsultasi dengan Asatidz.</p>

        <!-- Search Bar -->
        <div class="relative max-w-xl">
            <input type="text" placeholder="Cari artikel, fikih wanita, atau topik kesehatan..." class="w-full pl-12 pr-4 py-3.5 rounded-2xl bg-white border border-slate-200 shadow-sm text-sm focus:outline-none focus:border-[#186EF9]">
            <svg class="w-5 h-5 text-slate-400 absolute left-4 top-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
    </div>

    <!-- Category Hub Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <div class="bg-white rounded-3xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 hover:shadow-md transition-all space-y-3 cursor-pointer">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#00A86B] flex items-center justify-center font-bold text-2xl">📖</div>
            <h3 class="font-heading font-bold text-slate-900 text-base">Fikih Wanita</h3>
            <p class="text-xs text-slate-500 leading-relaxed">Panduan thaharah, haid, dan ibadah bagi siswi Muhammadiyah.</p>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-3xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 hover:shadow-md transition-all space-y-3 cursor-pointer">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#186EF9] flex items-center justify-center font-bold text-2xl">🧠</div>
            <h3 class="font-heading font-bold text-slate-900 text-base">Kesehatan Mental</h3>
            <p class="text-xs text-slate-500 leading-relaxed">Manajemen stres belajar, kecemasan, dan kesehatan emosional.</p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-3xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 hover:shadow-md transition-all space-y-3 cursor-pointer">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center font-bold text-2xl">🕌</div>
            <h3 class="font-heading font-bold text-slate-900 text-base">Halo Asatidz</h3>
            <p class="text-xs text-slate-500 leading-relaxed">Konsultasi langsung seputar hukum agama dan bimbingan rohani.</p>
        </div>

        <!-- Card 4 -->
        <div class="bg-white rounded-3xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 hover:shadow-md transition-all space-y-3 cursor-pointer">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center font-bold text-2xl">🥗</div>
            <h3 class="font-heading font-bold text-slate-900 text-base">Edukasi Gizi & Fisik</h3>
            <p class="text-xs text-slate-500 leading-relaxed">Tips makanan sehat kantin, pola tidur, dan pencegahan anemia.</p>
        </div>
    </div>
</x-app.layout>
