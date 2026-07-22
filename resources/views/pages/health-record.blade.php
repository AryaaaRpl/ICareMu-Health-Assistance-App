<x-app.layout active="health-record" title="Smart Health Record — iCareMu">
    <!-- Header Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 text-[#186EF9] text-xs font-semibold mb-2">
                ⚡ UKS MUHAMMADIYAH DIGITAL
            </div>
            <h1 class="font-heading text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Smart Health Record</h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">Data skrining fisik siswa, perhitungan indeks massa tubuh (IMT), dan manajemen risiko kesehatan terpadu.</p>
        </div>

        <div class="flex items-center gap-3">
            <button class="px-5 py-2.5 rounded-2xl bg-white border border-slate-200 text-slate-700 font-semibold text-sm shadow-sm hover:bg-slate-50 transition-all flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Ekspor CSV</span>
            </button>
            <button class="px-6 py-2.5 rounded-2xl bg-[#186EF9] hover:bg-blue-600 text-white font-semibold text-sm shadow-lg shadow-blue-500/20 transition-all flex items-center gap-2">
                <span>+ Tambah Rekam Medis / Skrining</span>
            </button>
        </div>
    </div>

    <!-- Top 4 Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Metric 1 -->
        <div class="bg-white rounded-3xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#186EF9] flex items-center justify-center font-bold text-xl shrink-0">
                👤
            </div>
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 font-heading">TOTAL SKRINING</div>
                <div class="text-2xl font-extrabold text-slate-900 font-heading">8</div>
                <div class="text-[10px] text-slate-400">Siswa diperiksa</div>
            </div>
        </div>

        <!-- Metric 2 -->
        <div class="bg-white rounded-3xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#00A86B] flex items-center justify-center font-bold text-xl shrink-0">
                ✓
            </div>
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 font-heading">STATUS NORMAL</div>
                <div class="text-2xl font-extrabold text-slate-900 font-heading">3 <span class="text-xs text-emerald-600 font-bold">38% dari total</span></div>
            </div>
        </div>

        <!-- Metric 3 -->
        <div class="bg-white rounded-3xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center font-bold text-xl shrink-0">
                ⚠️
            </div>
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 font-heading">RISIKO RINGAN</div>
                <div class="text-2xl font-extrabold text-slate-900 font-heading">3 <span class="text-xs text-amber-600 font-bold">38% dari total</span></div>
            </div>
        </div>

        <!-- Metric 4 -->
        <div class="bg-white rounded-3xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center font-bold text-xl shrink-0">
                📈
            </div>
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 font-heading">RISIKO TINGGI</div>
                <div class="text-2xl font-extrabold text-slate-900 font-heading">2 <span class="text-xs text-rose-600 font-bold">25% membutuhkan kontrol</span></div>
            </div>
        </div>
    </div>

    <!-- Main Table Container -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 space-y-6">
        <!-- Search & Filter Bar -->
        <div class="flex flex-col sm:flex-row gap-4 justify-between">
            <div class="relative flex-1 max-w-md">
                <input type="text" placeholder="Cari berdasarkan nama atau NISN..." class="w-full pl-10 pr-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-[#186EF9]">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-medium text-slate-400">Filter:</span>
                <select class="px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-700">
                    <option>Semua Kelas</option>
                    <option>X MIPA 1</option>
                    <option>XI IPS 2</option>
                </select>
            </div>
        </div>

        <!-- Health Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-400 font-bold uppercase border-b border-slate-100">
                        <th class="py-3">NAMA SISWA</th>
                        <th class="py-3">NISN</th>
                        <th class="py-3">GOL. DARAH</th>
                        <th class="py-3">TINGGI BADAN</th>
                        <th class="py-3">BERAT BADAN</th>
                        <th class="py-3">IMT</th>
                        <th class="py-3">STATUS RISIKO</th>
                        <th class="py-3 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    <!-- Row 1 -->
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-4 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs">👤</div>
                            <div>
                                <div class="font-bold text-slate-900">Ahmad Faiz Al-Fatih</div>
                                <div class="text-[10px] text-slate-400">X MIPA 1</div>
                            </div>
                        </td>
                        <td class="py-4 font-mono text-slate-500">0081234567</td>
                        <td class="py-4"><span class="px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-600 font-bold text-[10px]">🩸 O</span></td>
                        <td class="py-4">168 <span class="text-[10px] text-slate-400">cm</span></td>
                        <td class="py-4">62 <span class="text-[10px] text-slate-400">kg</span></td>
                        <td class="py-4 font-bold text-slate-900">22</td>
                        <td class="py-4"><span class="px-3 py-1 rounded-full bg-emerald-50 text-[#00A86B] text-[10px] font-bold">● NORMAL</span></td>
                        <td class="py-4 text-right space-x-2">
                            <button class="p-1.5 hover:bg-slate-200 rounded-lg text-slate-400 hover:text-slate-600">➔</button>
                            <button class="p-1.5 hover:bg-rose-100 rounded-lg text-rose-400 hover:text-rose-600">🗑</button>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-4 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs">👤</div>
                            <div>
                                <div class="font-bold text-slate-900">Siti Aminah Az-Zahra</div>
                                <div class="text-[10px] text-slate-400">XI IPS 2</div>
                            </div>
                        </td>
                        <td class="py-4 font-mono text-slate-500">0072345678</td>
                        <td class="py-4"><span class="px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-600 font-bold text-[10px]">🩸 A</span></td>
                        <td class="py-4">155 <span class="text-[10px] text-slate-400">cm</span></td>
                        <td class="py-4">41 <span class="text-[10px] text-slate-400">kg</span></td>
                        <td class="py-4 font-bold text-slate-900">17.1</td>
                        <td class="py-4"><span class="px-3 py-1 rounded-full bg-amber-50 text-amber-600 text-[10px] font-bold">● RISIKO RINGAN</span></td>
                        <td class="py-4 text-right space-x-2">
                            <button class="p-1.5 hover:bg-slate-200 rounded-lg text-slate-400 hover:text-slate-600">➔</button>
                            <button class="p-1.5 hover:bg-rose-100 rounded-lg text-rose-400 hover:text-rose-600">🗑</button>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-4 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs">👤</div>
                            <div>
                                <div class="font-bold text-slate-900">Budi Santoso Prabowo</div>
                                <div class="text-[10px] text-slate-400">XII MIPA 3</div>
                            </div>
                        </td>
                        <td class="py-4 font-mono text-slate-500">0063456789</td>
                        <td class="py-4"><span class="px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-600 font-bold text-[10px]">🩸 B</span></td>
                        <td class="py-4">172 <span class="text-[10px] text-slate-400">cm</span></td>
                        <td class="py-4">96 <span class="text-[10px] text-slate-400">kg</span></td>
                        <td class="py-4 font-bold text-slate-900">32.4</td>
                        <td class="py-4"><span class="px-3 py-1 rounded-full bg-rose-50 text-rose-600 text-[10px] font-bold">● RISIKO TINGGI</span></td>
                        <td class="py-4 text-right space-x-2">
                            <button class="p-1.5 hover:bg-slate-200 rounded-lg text-slate-400 hover:text-slate-600">➔</button>
                            <button class="p-1.5 hover:bg-rose-100 rounded-lg text-rose-400 hover:text-rose-600">🗑</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app.layout>
