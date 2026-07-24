<x-app-layout>
    <div class="space-y-8 max-w-3xl mx-auto" x-data="{
        suhu: 36.5,
        gejala: [],
        toggleGejala(val) {
            if (val === 'Tidak Ada') {
                this.gejala = ['Tidak Ada'];
                return;
            }
            this.gejala = this.gejala.filter(g => g !== 'Tidak Ada');
            if (this.gejala.includes(val)) {
                this.gejala = this.gejala.filter(g => g !== val);
            } else {
                this.gejala.push(val);
            }
        }
    }">
        <!-- Hero Header -->
        <div class="relative overflow-hidden bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-700 rounded-3xl p-8 text-white shadow-xl border border-teal-500/30">
            <div class="relative z-10 space-y-2">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-semibold uppercase tracking-wider text-teal-100">
                    <span>🩺</span> Screening Kesehatan Berkala
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Smart School Screening Harian</h1>
                <p class="text-teal-100 text-sm sm:text-base leading-relaxed">
                    Isi kondisi kesehatan harianmu untuk pemantauan fisik berkala oleh Petugas UKS sekolah.
                </p>
            </div>
            <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-100 shadow-sm space-y-8">
            <form action="{{ route('skrining.siswa.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Suhu Tubuh Input -->
                <div class="space-y-2">
                    <label for="suhu_tubuh" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700">
                        Suhu Tubuh <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" step="0.1" min="34" max="43" id="suhu_tubuh" name="suhu_tubuh" x-model="suhu" required
                            class="w-full rounded-2xl border-slate-200 bg-slate-50 py-3.5 pl-4 pr-16 text-base font-extrabold text-slate-900 focus:border-teal-500 focus:bg-white focus:ring-2 focus:ring-teal-500/20 transition-all">
                        <div class="absolute right-4 top-3 px-3 py-1 bg-teal-50 text-teal-700 font-extrabold text-xs rounded-xl border border-teal-200 pointer-events-none">
                            °C
                        </div>
                    </div>
                    <p class="text-[11px] text-slate-400 font-medium">Suhu normal tubuh berkisar antara 36.1°C - 37.2°C</p>
                </div>

                <!-- Gejala / Keluhan Chips Choice -->
                <div class="space-y-3">
                    <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-700">
                        Pilihan Gejala / Keluhan Hari Ini <span class="text-slate-400">(Pilih yang sesuai)</span>
                    </label>

                    <div class="flex flex-wrap gap-2.5">
                        @php
                            $gejalaList = ['Tidak Ada', 'Pusing', 'Mual', 'Batuk', 'Pilek', 'Sakit Perut', 'Demam', 'Lemas'];
                        @endphp

                        @foreach($gejalaList as $item)
                            <label @click="toggleGejala('{{ $item }}')"
                                :class="gejala.includes('{{ $item }}')
                                    ? 'bg-teal-600 text-white border-teal-600 shadow-md ring-2 ring-teal-300'
                                    : 'bg-slate-50 text-slate-700 border-slate-200 hover:bg-slate-100'"
                                class="px-4 py-2.5 rounded-2xl border text-xs font-bold cursor-pointer transition-all inline-flex items-center gap-2 select-none">
                                <input type="checkbox" name="gejala[]" value="{{ $item }}" x-model="gejala" class="hidden">
                                <span>{{ $item }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Tekanan Darah (Opsional) -->
                <div class="space-y-2">
                    <label for="tekanan_darah" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700">
                        Tekanan Darah <span class="text-slate-400">(Opsional, Contoh: 120/80)</span>
                    </label>
                    <input type="text" id="tekanan_darah" name="tekanan_darah" placeholder="120/80"
                        class="w-full rounded-2xl border-slate-200 bg-slate-50 py-3.5 px-4 text-xs font-semibold text-slate-900 focus:border-teal-500 focus:bg-white focus:ring-2 focus:ring-teal-500/20 transition-all">
                </div>

                <!-- Catatan Keluhan Detail -->
                <div class="space-y-2">
                    <label for="keluhan" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700">
                        Catatan Keluhan Tambahan <span class="text-slate-400">(Opsional)</span>
                    </label>
                    <textarea id="keluhan" name="catatan_keluhan" rows="3" placeholder="Jelaskan detail keluhan jika ada..."
                        class="w-full rounded-2xl border-slate-200 bg-slate-50 py-3.5 px-4 text-xs font-medium text-slate-900 focus:border-teal-500 focus:bg-white focus:ring-2 focus:ring-teal-500/20 transition-all"></textarea>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full py-4 bg-gradient-to-r from-teal-600 via-emerald-600 to-teal-700 hover:from-teal-700 hover:to-emerald-800 text-white font-extrabold text-sm rounded-2xl shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Kirim Data Skrining</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
