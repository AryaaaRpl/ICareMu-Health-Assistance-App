<x-app.layout active="school-screening" title="Smart School Screening — iCareMu">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-heading text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Smart School Screening</h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">Manajemen Jadwal dan Hasil Pemeriksaan Berkala</p>
        </div>

        <button class="px-6 py-2.5 rounded-2xl bg-[#186EF9] hover:bg-blue-600 text-white font-semibold text-sm shadow-lg shadow-blue-500/20 transition-all flex items-center gap-2">
            <span>+ Buat Jadwal Skrining</span>
        </button>
    </div>

    <!-- 3 Metrics Top Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white rounded-3xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#186EF9] flex items-center justify-center font-bold text-xl shrink-0">📅</div>
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 font-heading">JADWAL BULAN INI</div>
                <div class="text-2xl font-extrabold text-slate-900 font-heading">4</div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#00A86B] flex items-center justify-center font-bold text-xl shrink-0">👥</div>
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 font-heading">SISWA DIPERIKSA</div>
                <div class="text-2xl font-extrabold text-slate-900 font-heading">128</div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center font-bold text-xl shrink-0">☑</div>
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 font-heading">SKRINING SELESAI</div>
                <div class="text-2xl font-extrabold text-slate-900 font-heading">3</div>
            </div>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 space-y-6">
        <h3 class="font-heading font-bold text-slate-900 text-lg">Daftar Jadwal Skrining</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-400 font-bold uppercase border-b border-slate-100">
                        <th class="py-3">JENIS SKRINING</th>
                        <th class="py-3">TANGGAL PELAKSANAAN</th>
                        <th class="py-3">LOKASI</th>
                        <th class="py-3">STATUS</th>
                        <th class="py-3 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    <tr>
                        <td class="py-4 font-bold text-slate-900">Pemeriksaan Mata & THT</td>
                        <td class="py-4 text-slate-500">🕒 20 Juli 2026</td>
                        <td class="py-4 text-slate-500">📍 Ruang UKS Utama</td>
                        <td class="py-4"><span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-[10px] font-bold">PENDING</span></td>
                        <td class="py-4 text-right"><button class="px-4 py-1.5 rounded-xl bg-blue-50 text-[#186EF9] font-bold text-xs">Lihat Peserta ➔</button></td>
                    </tr>
                    <tr>
                        <td class="py-4 font-bold text-slate-900">Deteksi Anemia (Putri)</td>
                        <td class="py-4 text-slate-500">🕒 15 Juli 2026</td>
                        <td class="py-4 text-slate-500">📍 Aula Sekolah</td>
                        <td class="py-4"><span class="px-3 py-1 rounded-full bg-blue-100 text-[#186EF9] text-[10px] font-bold">BERJALAN</span></td>
                        <td class="py-4 text-right"><button class="px-4 py-1.5 rounded-xl bg-blue-50 text-[#186EF9] font-bold text-xs">Input Hasil ➔</button></td>
                    </tr>
                    <tr>
                        <td class="py-4 font-bold text-slate-900">Skrining Status Gizi (IMT)</td>
                        <td class="py-4 text-slate-500">🕒 5 Juli 2026</td>
                        <td class="py-4 text-slate-500">📍 Ruang UKS 2</td>
                        <td class="py-4"><span class="px-3 py-1 rounded-full bg-emerald-100 text-[#00A86B] text-[10px] font-bold">SELESAI</span></td>
                        <td class="py-4 text-right"><button class="px-4 py-1.5 rounded-xl bg-blue-50 text-[#186EF9] font-bold text-xs">Input Hasil ➔</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app.layout>
