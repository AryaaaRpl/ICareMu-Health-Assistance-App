<x-app.layout active="menstrual-health" title="Menstrual Health Monitoring — iCareMu">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rose-50 text-rose-600 text-xs font-semibold mb-2">
                ♥ KESEHATAN REPRODUKSI
            </div>
            <h1 class="font-heading text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Menstrual Health</h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">Pantau siklus menstruasi, catat gejala, dan dapatkan peringatan dini kesehatan secara privat.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Calendar Grid Card (Col 2) -->
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 space-y-6">
            <div class="flex items-center justify-between">
                <h3 class="font-heading font-bold text-slate-900 text-lg">Juli 2026</h3>
                <div class="flex gap-2">
                    <button class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600">‹</button>
                    <button class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600">›</button>
                </div>
            </div>

            <div class="grid grid-cols-7 gap-2 text-center text-xs font-bold text-slate-400 py-2 border-b border-slate-100">
                <span>SEN</span><span>SEL</span><span>RAB</span><span>KAM</span><span>JUM</span><span>SAB</span><span>MIN</span>
            </div>

            <div class="grid grid-cols-7 gap-2 text-center text-sm font-semibold text-slate-700">
                <span class="p-3 text-slate-300">29</span><span class="p-3 text-slate-300">30</span>
                <span class="p-3">1</span><span class="p-3">2</span><span class="p-3">3</span><span class="p-3">4</span><span class="p-3">5</span>
                <span class="p-3">6</span><span class="p-3">7</span><span class="p-3">8</span><span class="p-3">9</span><span class="p-3">10</span><span class="p-3">11</span><span class="p-3">12</span>
                <span class="p-3">13</span><span class="p-3">14</span>
                <span class="p-3 rounded-full bg-rose-500 text-white font-bold shadow-md">15</span>
                <span class="p-3">16</span><span class="p-3">17</span><span class="p-3">18</span><span class="p-3">19</span>
                <span class="p-3">20</span><span class="p-3">21</span><span class="p-3">22</span><span class="p-3">23</span><span class="p-3">24</span><span class="p-3">25</span><span class="p-3">26</span>
                <span class="p-3">27</span><span class="p-3">28</span><span class="p-3">29</span><span class="p-3">30</span><span class="p-3">31</span>
            </div>
        </div>

        <!-- AI Early Warning Box & Symptom Logger -->
        <div class="space-y-6">
            <!-- AI Early Warning Card -->
            <div class="bg-rose-50/80 rounded-3xl p-6 border border-rose-200/80 space-y-3">
                <div class="flex items-center gap-2 text-rose-600 font-bold text-xs">
                    <span>✨ AI EARLY WARNING</span>
                </div>
                <h4 class="font-heading font-bold text-rose-900 text-sm">Indikasi Amenore (Keterlambatan 3+ Bulan)</h4>
                <p class="text-xs text-rose-700 leading-relaxed">
                    Sistem mendeteksi tidak ada siklus menstruasi yang dicatat selama 3 bulan terakhir (Terakhir: 14 Apr 2026). Ini mungkin indikasi Amenore Sekunder. Disarankan untuk segera berkonsultasi dengan petugas UKS atau dokter.
                </p>
                <button class="w-full py-3 rounded-2xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs transition-all shadow-md">
                    Hubungi Dokter UKS
                </button>
            </div>

            <!-- Catat Gejala Card -->
            <div class="bg-white rounded-3xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 space-y-4">
                <h4 class="font-heading font-bold text-slate-900 text-sm">Catat Gejala (15 Juli 2026)</h4>
                
                <div class="p-3 rounded-2xl bg-slate-50 flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-700">Sedang Menstruasi?</span>
                    <input type="checkbox" class="w-5 h-5 accent-rose-500 rounded">
                </div>

                <div class="space-y-2">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">GEJALA YANG DIRASAKAN</span>
                    <div class="flex flex-wrap gap-2 text-xs">
                        <span class="px-3 py-1.5 rounded-full bg-slate-100 hover:bg-rose-100 text-slate-600 hover:text-rose-600 cursor-pointer">Nyeri Perut (Kram)</span>
                        <span class="px-3 py-1.5 rounded-full bg-slate-100 hover:bg-rose-100 text-slate-600 hover:text-rose-600 cursor-pointer">Pusing / Sakit Kepala</span>
                        <span class="px-3 py-1.5 rounded-full bg-slate-100 hover:bg-rose-100 text-slate-600 hover:text-rose-600 cursor-pointer">Mual</span>
                        <span class="px-3 py-1.5 rounded-full bg-slate-100 hover:bg-rose-100 text-slate-600 hover:text-rose-600 cursor-pointer">Kelelahan</span>
                    </div>
                </div>

                <button class="w-full py-3 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-all">
                    ✓ Simpan Catatan Hari Ini
                </button>
            </div>
        </div>
    </div>
</x-app.layout>
