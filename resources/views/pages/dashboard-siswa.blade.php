<x-app.layout active="dashboard-siswa" title="Dashboard Siswa — iCareMu">
    <!-- Header Welcome Card -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#186EF9] flex items-center justify-center font-bold text-xl">
                🛡
            </div>
            <div>
                <h1 class="font-heading text-2xl font-extrabold text-slate-900 tracking-tight">ICAREMU</h1>
                <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">STUDENT HEALTH HUB</p>
            </div>
        </div>

        <div class="px-5 py-2.5 rounded-2xl bg-white border border-slate-200 text-slate-700 font-semibold text-xs shadow-sm flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-blue-100 text-[#186EF9] flex items-center justify-center font-bold text-xs">DA</div>
            <div>
                <div class="text-[10px] text-slate-400 font-bold uppercase">SELAMAT DATANG,</div>
                <div class="font-bold text-slate-900">Daniswara Ahmad</div>
            </div>
        </div>
    </div>

    <!-- Blue Banner Hero Card -->
    <div class="bg-gradient-to-r from-[#186EF9] to-[#0052D4] rounded-3xl p-8 text-white space-y-4 shadow-lg shadow-blue-500/20">
        <h2 class="font-heading font-extrabold text-2xl sm:text-3xl">Pantau Kesehatanmu Hari Ini!</h2>
        <p class="text-sm text-blue-100 max-w-xl leading-relaxed">
            Jangan lupa untuk rutin mengisi Smart School Screening dan pantau terus kondisi kesehatanmu untuk aktivitas belajar yang optimal.
        </p>
        <a href="{{ route('school.screening') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-white text-[#186EF9] font-bold text-sm shadow-md hover:bg-blue-50 transition-all">
            <span>Mulai Skrining</span> ➔
        </a>
    </div>

    <!-- Grid Hub Options matching Body-8.png -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Hub 1: Smart Health Record -->
        <a href="{{ route('health.record') }}" class="bg-white rounded-3xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 hover:shadow-md transition-all flex items-center justify-between group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#186EF9] flex items-center justify-center font-bold text-xl">📄</div>
                <div>
                    <h3 class="font-heading font-bold text-slate-900 text-base group-hover:text-[#186EF9] transition-colors">Smart Health Record</h3>
                    <p class="text-xs text-slate-500">Lihat profil kesehatan dan riwayat medis lengkap</p>
                </div>
            </div>
            <span class="text-slate-400 group-hover:text-[#186EF9]">➔</span>
        </a>

        <!-- Hub 2: Smart School Screening -->
        <a href="{{ route('school.screening') }}" class="bg-white rounded-3xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 hover:shadow-md transition-all flex items-center justify-between group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#00A86B] flex items-center justify-center font-bold text-xl">📈</div>
                <div>
                    <h3 class="font-heading font-bold text-slate-900 text-base group-hover:text-[#186EF9] transition-colors">Smart School Screening</h3>
                    <p class="text-xs text-slate-500">Isi form penilaian kesehatan rutin secara berkala</p>
                </div>
            </div>
            <span class="text-slate-400 group-hover:text-[#186EF9]">➔</span>
        </a>

        <!-- Hub 3: AI Health Assistant -->
        <a href="{{ route('ai.assistant') }}" class="bg-white rounded-3xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 hover:shadow-md transition-all flex items-center justify-between group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#186EF9] flex items-center justify-center font-bold text-xl">💬</div>
                <div>
                    <h3 class="font-heading font-bold text-slate-900 text-base group-hover:text-[#186EF9] transition-colors">AI Health Assistant</h3>
                    <p class="text-xs text-slate-500">Konsultasi keluhan kesehatan ringan dengan AI</p>
                </div>
            </div>
            <span class="text-slate-400 group-hover:text-[#186EF9]">➔</span>
        </a>

        <!-- Hub 4: Health Education & ISMUBA -->
        <a href="{{ route('edukasi.ismuba') }}" class="bg-white rounded-3xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 hover:shadow-md transition-all flex items-center justify-between group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center font-bold text-xl">📖</div>
                <div>
                    <h3 class="font-heading font-bold text-slate-900 text-base group-hover:text-[#186EF9] transition-colors">Health Education & ISMUBA</h3>
                    <p class="text-xs text-slate-500">Artikel kesehatan, mental, dan Fikih Wanita</p>
                </div>
            </div>
            <span class="text-slate-400 group-hover:text-[#186EF9]">➔</span>
        </a>

        <!-- Hub 5: Menstrual Health Monitoring -->
        <a href="{{ route('menstrual.health') }}" class="bg-white rounded-3xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 hover:shadow-md transition-all flex items-center justify-between group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center font-bold text-xl">♥</div>
                <div>
                    <h3 class="font-heading font-bold text-slate-900 text-base group-hover:text-[#186EF9] transition-colors">Menstrual Health Monitoring</h3>
                    <p class="text-xs text-slate-500">Pantau siklus menstruasi bulanan</p>
                </div>
            </div>
            <span class="text-slate-400 group-hover:text-[#186EF9]">➔</span>
        </a>

        <!-- Hub 6: Riwayat Kunjungan UKS -->
        <a href="#" class="bg-white rounded-3xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 hover:shadow-md transition-all flex items-center justify-between group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center font-bold text-xl">🕒</div>
                <div>
                    <h3 class="font-heading font-bold text-slate-900 text-base group-hover:text-[#186EF9] transition-colors">Riwayat Kunjungan UKS</h3>
                    <p class="text-xs text-slate-500">Log kunjungan dan tindakan medis</p>
                </div>
            </div>
            <span class="text-slate-400 group-hover:text-[#186EF9]">➔</span>
        </a>
    </div>
</x-app.layout>
