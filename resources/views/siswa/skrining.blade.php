<x-app-layout>
    <div class="space-y-8 max-w-3xl mx-auto">
        <!-- Hero Header -->
        <div class="relative overflow-hidden bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-700 rounded-3xl p-6 sm:p-8 text-white shadow-xl border border-teal-500/30">
            <div class="relative z-10 space-y-2">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-semibold uppercase tracking-wider text-teal-100">
                    <svg class="w-4 h-4 text-teal-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Smart School Screening
                </div>
                <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight">Form Skrining Kesehatan</h1>
                <p class="text-teal-100 text-xs sm:text-base leading-relaxed">
                    Silakan isi data kesehatan harianmu di bawah ini. Hasil skrining akan dianalisis secara otomatis.
                </p>
            </div>
            <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-100 shadow-sm space-y-8">
            <form action="{{ route('skrining.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Suhu Tubuh Input -->
                <div class="space-y-2">
                    <label for="suhu_tubuh" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700">
                        Suhu Tubuh (°C) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" step="0.1" min="34" max="45" id="suhu_tubuh" name="suhu_tubuh" placeholder="36.5" value="{{ old('suhu_tubuh', '36.5') }}" required
                            class="w-full rounded-2xl border-slate-200 bg-slate-50 py-3.5 pl-4 pr-16 text-base font-extrabold text-slate-900 focus:border-teal-500 focus:bg-white focus:ring-2 focus:ring-teal-500/20 transition-all">
                        <div class="absolute right-4 top-3 px-3 py-1 bg-teal-50 text-teal-700 font-extrabold text-xs rounded-xl border border-teal-200 pointer-events-none">
                            °C
                        </div>
                    </div>
                    @error('suhu_tubuh')
                        <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gejala Checkboxes -->
                <div class="space-y-3">
                    <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-700">
                        Gejala yang Dirasakan
                    </label>
                    <p class="text-xs text-slate-400">Pilih gejala yang sesuai dengan kondisi fisikmu saat ini:</p>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @php
                            $gejalaOptions = [
                                'Demam' => '🔥 Demam',
                                'Batuk' => '😷 Batuk',
                                'Pusing' => '😵 Pusing',
                                'Mual' => '🤢 Mual',
                                'Nyeri Haid' => '🩸 Nyeri Haid',
                                'Tidak Ada Keluhan' => '✅ Tidak Ada Keluhan',
                            ];
                            $oldGejala = old('gejala', []);
                        @endphp

                        @foreach($gejalaOptions as $val => $label)
                            <label class="relative flex items-center p-3.5 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-slate-100 cursor-pointer transition-all has-[:checked]:bg-teal-50 has-[:checked]:border-teal-500 has-[:checked]:ring-2 has-[:checked]:ring-teal-500/20">
                                <input type="checkbox" name="gejala[]" value="{{ $val }}"
                                    @checked(in_array($val, $oldGejala))
                                    class="w-4 h-4 text-teal-600 rounded border-slate-300 focus:ring-teal-500 focus:ring-offset-0">
                                <span class="ml-2.5 text-xs font-bold text-slate-700 select-none">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('gejala')
                        <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Keluhan Tambahan Textarea -->
                <div class="space-y-2">
                    <label for="keluhan_tambahan" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700">
                        Keluhan Tambahan <span class="text-slate-400 font-normal">(Opsional)</span>
                    </label>
                    <textarea id="keluhan_tambahan" name="keluhan_tambahan" rows="4" placeholder="Tuliskan detail keluhan kesehatan lain jika ada..."
                        class="w-full rounded-2xl border-slate-200 bg-slate-50 py-3.5 px-4 text-xs font-medium text-slate-900 focus:border-teal-500 focus:bg-white focus:ring-2 focus:ring-teal-500/20 transition-all">{{ old('keluhan_tambahan') }}</textarea>
                    @error('keluhan_tambahan')
                        <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full py-4 bg-gradient-to-r from-teal-600 via-emerald-600 to-teal-700 hover:from-teal-700 hover:to-emerald-800 text-white font-extrabold text-sm rounded-2xl shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        <span>Kirim Data Kesehatan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
