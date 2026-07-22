@props(['active' => 'dashboard-uks'])

<aside class="w-64 bg-white border-r border-slate-200/80 flex flex-col justify-between h-screen sticky top-0 shrink-0 select-none">
    <div class="p-6 space-y-8">
        <!-- Logo -->
        <a href="{{ route('dashboard.uks') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-emerald-500 flex items-center justify-center text-white font-bold text-xl shadow-md">
                +
            </div>
            <div class="flex flex-col">
                <span class="font-heading font-extrabold text-xl tracking-tight text-[#006654]">
                    iCare<span class="text-[#00A86B]">Mu</span>
                </span>
                <span class="text-[9px] font-semibold text-slate-400 uppercase tracking-wider">Sehat • Peduli • Berkemajuan</span>
            </div>
        </a>

        <!-- Sidebar Navigation List -->
        <nav class="space-y-1.5 text-sm font-medium text-slate-600">
            <!-- Dashboard Siswa -->
            <a href="{{ route('dashboard.siswa') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ $active === 'dashboard-siswa' ? 'bg-[#186EF9] text-white font-semibold shadow-md shadow-blue-500/20' : 'hover:bg-slate-50 text-slate-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                <span>Dashboard Siswa</span>
            </a>

            <!-- Dashboard UKS -->
            <a href="{{ route('dashboard.uks') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ $active === 'dashboard-uks' ? 'bg-[#186EF9] text-white font-semibold shadow-md shadow-blue-500/20' : 'hover:bg-slate-50 text-slate-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>Dashboard UKS</span>
            </a>

            <!-- Health Record -->
            <a href="{{ route('health.record') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ $active === 'health-record' ? 'bg-[#186EF9] text-white font-semibold shadow-md shadow-blue-500/20' : 'hover:bg-slate-50 text-slate-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Health Record</span>
            </a>

            <!-- School Screening -->
            <a href="{{ route('jadwal_skrining.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ $active === 'school-screening' ? 'bg-[#186EF9] text-white font-semibold shadow-md shadow-blue-500/20' : 'hover:bg-slate-50 text-slate-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <span>School Screening</span>
            </a>

            <!-- AI Assistant -->
            <a href="{{ route('ai.assistant') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ $active === 'ai-assistant' ? 'bg-[#186EF9] text-white font-semibold shadow-md shadow-blue-500/20' : 'hover:bg-slate-50 text-slate-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                <span>AI Assistant</span>
            </a>

            <!-- Edukasi ISMUBA -->
            <a href="{{ route('edukasi.ismuba') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ $active === 'edukasi-ismuba' ? 'bg-[#186EF9] text-white font-semibold shadow-md shadow-blue-500/20' : 'hover:bg-slate-50 text-slate-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                <span>Edukasi ISMUBA</span>
            </a>

            <!-- Menstrual Health -->
            <a href="{{ route('menstrual.health') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ $active === 'menstrual-health' ? 'bg-[#186EF9] text-white font-semibold shadow-md shadow-blue-500/20' : 'hover:bg-slate-50 text-slate-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.684a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                <span>Menstrual Health</span>
            </a>

            <!-- UKS Inventory -->
            <a href="{{ route('uks.inventory') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ $active === 'uks-inventory' ? 'bg-[#186EF9] text-white font-semibold shadow-md shadow-blue-500/20' : 'hover:bg-slate-50 text-slate-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <span>UKS Inventory</span>
            </a>
        </nav>
    </div>

    <!-- Sidebar Footer Profile -->
    <div class="p-4 border-t border-slate-200/80">
        <div class="flex items-center gap-3 p-2">
            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold text-xs border border-slate-200">
                dr
            </div>
            <div class="flex flex-col min-w-0">
                <span class="text-sm font-bold text-slate-900 truncate">Dr. Aisyah</span>
                <span class="text-xs text-slate-500 truncate">Kepala UKS</span>
            </div>
        </div>
    </div>
</aside>
