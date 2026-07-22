<x-app.layout active="uks-inventory" title="Smart Inventory UKS — iCareMu">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-heading text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Smart Inventory UKS</h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">Manajemen Obat-obatan, Pertolongan Pertama (P3K), dan Alat Kesehatan Sekolah</p>
        </div>

        <button class="px-6 py-2.5 rounded-2xl bg-[#186EF9] hover:bg-blue-600 text-white font-semibold text-sm shadow-lg shadow-blue-500/20 transition-all flex items-center gap-2">
            <span>+ Tambah Stok / Obat</span>
        </button>
    </div>

    <!-- 3 Summary Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white rounded-3xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#186EF9] flex items-center justify-center font-bold text-xl shrink-0">📦</div>
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 font-heading">TOTAL ITEM</div>
                <div class="text-2xl font-extrabold text-slate-900 font-heading">42</div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center font-bold text-xl shrink-0">⚠️</div>
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 font-heading">STOK MENIPIS</div>
                <div class="text-2xl font-extrabold text-slate-900 font-heading">3</div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center font-bold text-xl shrink-0">⏰</div>
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 font-heading">KRITIS KEDALUWARSA</div>
                <div class="text-2xl font-extrabold text-slate-900 font-heading">1</div>
            </div>
        </div>
    </div>

    <!-- Inventory Table -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 space-y-6">
        <h3 class="font-heading font-bold text-slate-900 text-lg">Daftar Inventaris UKS</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-400 font-bold uppercase border-b border-slate-100">
                        <th class="py-3">NAMA ITEM</th>
                        <th class="py-3">KATEGORI</th>
                        <th class="py-3">STOK TERSEDIA</th>
                        <th class="py-3">MIN. STOK</th>
                        <th class="py-3">KEDALUWARSA</th>
                        <th class="py-3 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    <tr>
                        <td class="py-4 font-bold text-slate-900">Paracetamol 500mg</td>
                        <td class="py-4 text-slate-500">Obat Oral</td>
                        <td class="py-4 font-bold text-slate-900">150 Tab</td>
                        <td class="py-4 text-slate-500">50 Tab</td>
                        <td class="py-4 text-emerald-600 font-semibold">12 Des 2027</td>
                        <td class="py-4 text-right"><button class="p-1.5 hover:bg-slate-100 rounded-lg">✏ Edit</button></td>
                    </tr>
                    <tr>
                        <td class="py-4 font-bold text-slate-900">Betadine 60ml</td>
                        <td class="py-4 text-slate-500">Antiseptik</td>
                        <td class="py-4 font-bold text-rose-600">5 Botol ⚠️</td>
                        <td class="py-4 text-slate-500">10 Botol</td>
                        <td class="py-4 text-rose-600 font-semibold">15 Agt 2026 (1 Bulan lagi)</td>
                        <td class="py-4 text-right"><button class="p-1.5 hover:bg-slate-100 rounded-lg">✏ Edit</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app.layout>
