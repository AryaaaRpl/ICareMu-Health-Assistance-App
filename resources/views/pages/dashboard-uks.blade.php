<x-app.layout active="dashboard-uks" title="School Health Dashboard — iCareMu">
    <!-- Header Title Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-heading text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">School Health Dashboard</h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">Analytics & Monitoring Center UKS Muhammadiyah</p>
        </div>

        <div class="flex items-center gap-3">
            <button class="px-5 py-2.5 rounded-2xl bg-white border border-slate-200 text-slate-700 font-semibold text-sm shadow-sm hover:bg-slate-50 transition-all flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Export Laporan</span>
            </button>
        </div>
    </div>

    <!-- 4 Top Metric Cards with Left Accent Borders -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Metric 1: Jumlah Kunjungan -->
        <div class="bg-white rounded-3xl p-6 border-l-4 border-l-[#186EF9] shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 font-heading">JUMLAH KUNJUNGAN UKS</span>
                <div class="w-8 h-8 rounded-full bg-blue-50 text-[#186EF9] flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-slate-900 font-heading">245</div>
            <div class="text-xs font-semibold text-emerald-600 flex items-center gap-1">
                <span>↗ 12% dari bulan lalu</span>
            </div>
        </div>

        <!-- Metric 2: Siswa Sakit Hari Ini -->
        <div class="bg-white rounded-3xl p-6 border-l-4 border-l-rose-500 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 font-heading">SISWA SAKIT HARI INI</span>
                <div class="w-8 h-8 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.684a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-slate-900 font-heading">12</div>
            <div class="text-xs font-semibold text-rose-600 flex items-center gap-1">
                <span>↗ 4 siswa sedang dirawat</span>
            </div>
        </div>

        <!-- Metric 3: Tingkat Kehadiran Sehat -->
        <div class="bg-white rounded-3xl p-6 border-l-4 border-l-[#00A86B] shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 font-heading">TINGKAT KEHADIRAN SEHAT</span>
                <div class="w-8 h-8 rounded-full bg-emerald-50 text-[#00A86B] flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-slate-900 font-heading">96.8%</div>
            <div class="text-xs font-semibold text-emerald-600 flex items-center gap-1">
                <span>↗ 0.5% dari minggu lalu</span>
            </div>
        </div>

        <!-- Metric 4: Tren Kesehatan Index -->
        <div class="bg-white rounded-3xl p-6 border-l-4 border-l-indigo-500 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 font-heading">TREN KESEHATAN INDEX</span>
                <div class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-500 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-slate-900 font-heading">84/100</div>
            <div class="text-xs font-semibold text-emerald-600 flex items-center gap-1">
                <span>🛡 Kondisi sekolah optimal</span>
            </div>
        </div>
    </div>

    <!-- Charts & Analytics Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Monthly Visit Line Chart -->
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 space-y-6">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-[#186EF9]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <h3 class="font-heading font-bold text-slate-900 text-base">TREN KUNJUNGAN UKS BULANAN</h3>
            </div>
            <!-- Visual SVG Wave Chart -->
            <div class="h-64 w-full relative flex items-end pt-8">
                <svg class="w-full h-full" viewBox="0 0 500 180" fill="none">
                    <defs>
                        <linearGradient id="gradientVisit" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#186EF9" stop-opacity="0.25"/>
                            <stop offset="100%" stop-color="#186EF9" stop-opacity="0.0"/>
                        </linearGradient>
                    </defs>
                    <path d="M0,110 Q40,90 80,100 T160,115 T240,65 T320,85 T400,45 T480,65 L480,180 L0,180 Z" fill="url(#gradientVisit)"/>
                    <path d="M0,110 Q40,90 80,100 T160,115 T240,65 T320,85 T400,45 T480,65" stroke="#186EF9" stroke-width="3" fill="none"/>
                </svg>
                <div class="absolute bottom-0 w-full flex justify-between text-xs font-semibold text-slate-400 px-2 pt-2 border-t border-slate-100">
                    <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span><span>Jul</span>
                </div>
            </div>
        </div>

        <!-- Disease Proportion Donut Chart -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 space-y-6">
            <h3 class="font-heading font-bold text-slate-900 text-base">PROPORSI PENYAKIT</h3>
            <div class="flex justify-center py-4">
                <div class="relative w-44 h-44 rounded-full border-8 border-transparent flex items-center justify-center" style="background: conic-gradient(#186EF9 0% 35%, #00A86B 35% 60%, #F59E0B 60% 80%, #8B5CF6 80% 100%);">
                    <div class="w-32 h-32 bg-white rounded-full flex items-center justify-center shadow-inner">
                        <span class="text-xs font-bold text-slate-400">Kasus UKS</span>
                    </div>
                </div>
            </div>
            <div class="space-y-2 text-xs font-semibold">
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-[#186EF9]"></span> Demam</span>
                    <span class="text-slate-900 font-bold">35%</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-[#00A86B]"></span> Sakit Kepala</span>
                    <span class="text-slate-900 font-bold">25%</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-amber-500"></span> Maag/Asam Lambung</span>
                    <span class="text-slate-900 font-bold">20%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Active UKS Patients Table & Inventory Alert -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Live Students in UKS Table -->
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 space-y-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-emerald-500 text-lg">🩺</span>
                    <h3 class="font-heading font-bold text-slate-900 text-base">SISWA DI UKS SAAT INI</h3>
                </div>
                <span class="px-3 py-1 rounded-full bg-rose-50 text-rose-600 text-xs font-bold">3 Siswa Dirawat</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-slate-400 font-bold uppercase border-b border-slate-100">
                            <th class="py-3">WAKTU</th>
                            <th class="py-3">SISWA</th>
                            <th class="py-3">KELUHAN</th>
                            <th class="py-3">STATUS PENANGANAN</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        <tr>
                            <td class="py-4 text-slate-500 font-mono">08:15</td>
                            <td class="py-4">
                                <div class="font-bold text-slate-900">Budi Santoso</div>
                                <div class="text-[10px] text-slate-400">X MIPA 1</div>
                            </td>
                            <td class="py-4 text-rose-600 font-semibold">Demam Tinggi (38.5°C)</td>
                            <td class="py-4"><span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold">Istirahat di UKS</span></td>
                        </tr>
                        <tr>
                            <td class="py-4 text-slate-500 font-mono">09:30</td>
                            <td class="py-4">
                                <div class="font-bold text-slate-900">Siti Aminah</div>
                                <div class="text-[10px] text-slate-400">XI IPS 2</div>
                            </td>
                            <td class="py-4 text-rose-600 font-semibold">Asam Lambung Naik</td>
                            <td class="py-4"><span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold">Diberi Obat</span></td>
                        </tr>
                        <tr>
                            <td class="py-4 text-slate-500 font-mono">10:45</td>
                            <td class="py-4">
                                <div class="font-bold text-slate-900">Ahmad Riski</div>
                                <div class="text-[10px] text-slate-400">XII MIPA 3</div>
                            </td>
                            <td class="py-4 text-rose-600 font-semibold">Cedera Kaki (Basket)</td>
                            <td class="py-4"><span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold">Menunggu Orang Tua</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Inventory Warning Box -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 space-y-6">
            <div class="flex items-center gap-2">
                <span class="text-amber-500 text-lg">📦</span>
                <h3 class="font-heading font-bold text-slate-900 text-base">PERINGATAN STOK</h3>
            </div>

            <div class="space-y-4">
                <div class="p-3.5 rounded-2xl bg-slate-50 flex items-center justify-between">
                    <div>
                        <div class="font-bold text-slate-900 text-xs">Paracetamol 500mg</div>
                        <div class="text-[10px] text-slate-400">MIN: 50</div>
                    </div>
                    <span class="text-xs font-bold text-slate-900">150 <span class="text-[10px] text-slate-400 font-normal">Tab</span></span>
                </div>
                <div class="p-3.5 rounded-2xl bg-rose-50 flex items-center justify-between">
                    <div>
                        <div class="font-bold text-slate-900 text-xs">Betadine</div>
                        <div class="text-[10px] text-rose-500">MIN: 10</div>
                    </div>
                    <span class="text-xs font-bold text-rose-600">5 <span class="text-[10px] text-rose-400 font-normal">Botol</span></span>
                </div>
                <div class="p-3.5 rounded-2xl bg-slate-50 flex items-center justify-between">
                    <div>
                        <div class="font-bold text-slate-900 text-xs">Kasa Steril</div>
                        <div class="text-[10px] text-slate-400">MIN: 20</div>
                    </div>
                    <span class="text-xs font-bold text-slate-900">45 <span class="text-[10px] text-slate-400 font-normal">Kotak</span></span>
                </div>
            </div>

            <a href="{{ route('uks.inventory') }}" class="block w-full py-3 text-center rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all">
                Buka Modul Inventaris
            </a>
        </div>
    </div>
</x-app.layout>
