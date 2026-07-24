<x-app-layout>
    <div class="space-y-8 max-w-7xl mx-auto" x-data="menstrualCalendar(@js($calendarEvents))">
        <!-- Banner Header -->
        <div class="relative overflow-hidden bg-gradient-to-r from-rose-500 via-pink-600 to-purple-600 rounded-3xl p-8 text-white shadow-xl">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2 max-w-xl">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-semibold uppercase tracking-wider text-rose-100">
                        <span>🔒</span> Privasi Kesehatan Terjaga
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Kesehatan Reproduksi Wanita</h1>
                    <p class="text-rose-100 text-sm sm:text-base leading-relaxed">
                        Pencatatan siklus menstruasi mandiri, estimasi haid berikutnya, serta deteksi dini AI untuk gangguan siklus haid.
                    </p>
                </div>
                <div class="hidden sm:block text-5xl">
                    🌸
                </div>
            </div>
            <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        </div>

        <!-- AI Early Warning Red Alert Card (if Indikasi Amenore is true) -->
        @if($indikasiAmenore)
            <div class="bg-gradient-to-r from-rose-600 to-red-700 text-white rounded-3xl p-6 sm:p-8 shadow-xl border-2 border-rose-400/50 flex flex-col sm:flex-row items-start gap-5">
                <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-2xl shrink-0">
                    🚨
                </div>
                <div class="space-y-2 flex-1">
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-white text-rose-700 shadow-sm">
                            Sistem Deteksi AI
                        </span>
                        <span class="text-xs font-bold text-rose-200">
                            Keterlambatan: {{ $daysSinceLastPeriod }} Hari
                        </span>
                    </div>
                    <h3 class="text-lg sm:text-xl font-extrabold tracking-tight">
                        AI EARLY WARNING: Indikasi Amenore (Keterlambatan 3+ Bulan)
                    </h3>
                    <p class="text-xs sm:text-sm text-rose-100 leading-relaxed font-medium">
                        Catatan haid terakhir Anda terdeteksi <strong>{{ $daysSinceLastPeriod }} hari yang lalu</strong>. Terlambat haid lebih dari 90 hari mengindikasikan Amenore Sekunder. Disarankan segera berkonsultasi dengan Dokter atau Petugas UKS sekolah.
                    </p>
                    <div class="pt-2 flex items-center gap-3">
                        <a href="{{ route('ai.index') }}" class="px-4 py-2 bg-white hover:bg-rose-50 text-rose-700 font-bold text-xs rounded-xl shadow-md transition-all inline-flex items-center gap-2">
                            🤖 Konsultasi Dokter AI
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Success Alert -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-bold rounded-2xl flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Top Section Grid: Prediction & Relief Tips -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Prediction Card (2 Cols) -->
            <div class="md:col-span-2 bg-white rounded-3xl p-6 sm:p-8 border border-rose-100 shadow-sm flex flex-col justify-between space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-extrabold uppercase tracking-wider text-rose-500">PREDIKSI HAID BERIKUTNYA</span>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-600 border border-rose-200">
                        Siklus 28 Hari
                    </span>
                </div>

                <div class="space-y-1">
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                        {{ $nextPeriodDate ? $nextPeriodDate->translatedFormat('l, d F Y') : '-' }}
                    </div>
                    <p class="text-xs text-slate-500 font-medium">
                        Diperhitungkan otomatis berdasarkan tanggal awal siklus terakhir Anda.
                    </p>
                </div>

                <div class="pt-2 flex items-center gap-3">
                    @if($indikasiAmenore)
                        <span class="px-4 py-2 bg-rose-600 text-white font-extrabold text-xs rounded-xl shadow-md">
                            ⚠️ Peringatan Keterlambatan Siklus
                        </span>
                    @elseif(($daysRemaining ?? 0) > 0)
                        <span class="px-4 py-2 bg-gradient-to-r from-rose-500 to-pink-500 text-white font-extrabold text-xs rounded-xl shadow-md">
                            ⏳ Estimasi {{ $daysRemaining }} hari lagi
                        </span>
                    @elseif(($daysRemaining ?? 0) === 0)
                        <span class="px-4 py-2 bg-rose-600 text-white font-extrabold text-xs rounded-xl shadow-md">
                            ⚠️ Diprediksi Hari Ini
                        </span>
                    @else
                        <span class="px-4 py-2 bg-amber-500 text-white font-extrabold text-xs rounded-xl shadow-md">
                            📅 Siklus Berjalan
                        </span>
                    @endif
                </div>
            </div>

            <!-- Quick Relief Tips Callout (1 Col) -->
            <div class="bg-gradient-to-br from-rose-50 to-pink-50 rounded-3xl p-6 border border-rose-100 shadow-sm flex flex-col justify-between space-y-4">
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="text-xl">🍵</span>
                        <h3 class="text-sm font-extrabold text-rose-900 uppercase tracking-wider">Perawatan Nyeri Haid</h3>
                    </div>
                    <p class="text-xs text-rose-800 leading-relaxed font-medium">
                        Gunakan kompres hangat di area perut bawah, konsumsi air hangat secukupnya, dan lakukan olahraga ringan.
                    </p>
                </div>

                <div class="space-y-2">
                    <a href="{{ route('ai.index') }}" class="w-full py-2.5 px-3 bg-white hover:bg-rose-100 text-rose-700 font-bold text-xs rounded-xl border border-rose-200 shadow-sm transition-all text-center block">
                        🤖 Konsultasi AI Assistant
                    </a>
                    <a href="{{ route('ismuba.index') }}" class="w-full py-2.5 px-3 bg-white hover:bg-rose-100 text-rose-700 font-bold text-xs rounded-xl border border-rose-200 shadow-sm transition-all text-center block">
                        📖 Edukasi Fiqih & Thibbun Nabawi
                    </a>
                </div>
            </div>
        </div>

        <!-- Interactive Calendar & Form Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Dynamic Interactive Alpine.js Calendar (2 Cols) -->
            <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-6">
                <!-- Calendar Header -->
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-900" x-text="monthYearTitle"></h2>
                        <p class="text-xs text-slate-400 font-medium">Kalender Interaktif Riwayat & Estimasi Haid</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <button @click="previousMonth()" class="p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 transition-all text-slate-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button @click="nextMonth()" class="p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 transition-all text-slate-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Calendar Grid -->
                <div class="space-y-4">
                    <!-- Weekday Labels -->
                    <div class="grid grid-cols-7 gap-2 text-center text-xs font-bold text-slate-400 uppercase tracking-wider">
                        <div>Minggu</div>
                        <div>Senin</div>
                        <div>Selasa</div>
                        <div>Rabu</div>
                        <div>Kamis</div>
                        <div>Jumat</div>
                        <div>Sabtu</div>
                    </div>

                    <!-- Days Grid -->
                    <div class="grid grid-cols-7 gap-2">
                        <template x-for="(blank, index) in blankDays" :key="'blank-'+index">
                            <div class="h-12 rounded-2xl bg-slate-50/50"></div>
                        </template>

                        <template x-for="dateDay in daysInMonth" :key="dateDay.dateStr">
                            <div :class="{
                                    'bg-gradient-to-tr from-rose-500 to-pink-500 text-white font-black shadow-md ring-2 ring-rose-300': isPeriodDay(dateDay.dateStr),
                                    'bg-slate-100 text-slate-900 font-bold': isToday(dateDay.dateStr) && !isPeriodDay(dateDay.dateStr),
                                    'bg-slate-50 text-slate-700 hover:bg-rose-50 font-semibold': !isPeriodDay(dateDay.dateStr) && !isToday(dateDay.dateStr)
                                 }"
                                 class="h-12 rounded-2xl flex flex-col items-center justify-center relative transition-all text-xs cursor-pointer group">
                                <span x-text="dateDay.day"></span>
                                <template x-if="isPeriodDay(dateDay.dateStr)">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white mt-0.5"></span>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Calendar Legend -->
                <div class="flex items-center gap-6 pt-2 text-xs font-semibold text-slate-500 border-t border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="w-3.5 h-3.5 rounded-full bg-gradient-to-tr from-rose-500 to-pink-500 inline-block shadow-sm"></span>
                        <span>Hari Menstruasi</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3.5 h-3.5 rounded-full bg-slate-200 inline-block"></span>
                        <span>Hari Ini</span>
                    </div>
                </div>
            </div>

            <!-- Form Log Siklus Baru (1 Col) -->
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h2 class="text-base font-extrabold text-slate-900">Catat Siklus Haid Baru</h2>
                    <p class="text-xs text-slate-400 font-medium">Masukkan data tanggal dan kondisi nyeri haid Anda</p>
                </div>

                <form action="{{ route('menstrual.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <!-- Tanggal Mulai -->
                    <div class="space-y-1.5">
                        <label for="tanggal_mulai" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Tanggal Mulai <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai" required value="{{ date('Y-m-d') }}"
                            class="w-full rounded-2xl border-slate-200 bg-slate-50 py-3 px-4 text-xs font-semibold text-slate-900 focus:border-rose-500 focus:bg-white focus:ring-2 focus:ring-rose-500/20 transition-all">
                    </div>

                    <!-- Tanggal Selesai -->
                    <div class="space-y-1.5">
                        <label for="tanggal_selesai" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Tanggal Selesai <span class="text-slate-400">(Opsional)</span>
                        </label>
                        <input type="date" id="tanggal_selesai" name="tanggal_selesai"
                            class="w-full rounded-2xl border-slate-200 bg-slate-50 py-3 px-4 text-xs font-semibold text-slate-900 focus:border-rose-500 focus:bg-white focus:ring-2 focus:ring-rose-500/20 transition-all">
                    </div>

                    <!-- Tingkat Nyeri -->
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Tingkat Nyeri Haid <span class="text-rose-500">*</span>
                        </label>
                        <select name="tingkat_nyeri" required
                            class="w-full rounded-2xl border-slate-200 bg-slate-50 py-3 px-4 text-xs font-semibold text-slate-900 focus:border-rose-500 focus:bg-white focus:ring-2 focus:ring-rose-500/20 transition-all">
                            <option value="1">1 - Ringan / Tanpa Nyeri (😊)</option>
                            <option value="2">2 - Sedang (😐)</option>
                            <option value="3" selected>3 - Cukup Mulas (😣)</option>
                            <option value="4">4 - Nyeri Hebat (😫)</option>
                            <option value="5">5 - Sangat Hebat / Perlu Istirahat UKS (😭)</option>
                        </select>
                    </div>

                    <!-- Catatan -->
                    <div class="space-y-1.5">
                        <label for="catatan" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Catatan Gejala <span class="text-slate-400">(Opsional)</span>
                        </label>
                        <textarea id="catatan" name="catatan" rows="3" placeholder="Contoh: Kram perut hari pertama, pusing ringan..."
                            class="w-full rounded-2xl border-slate-200 bg-slate-50 py-3 px-4 text-xs font-medium text-slate-900 focus:border-rose-500 focus:bg-white focus:ring-2 focus:ring-rose-500/20 transition-all"></textarea>
                    </div>

                    <button type="submit"
                        class="w-full py-3.5 bg-gradient-to-r from-rose-500 to-pink-600 hover:from-rose-600 hover:to-pink-700 text-white font-bold text-xs rounded-2xl shadow-md hover:shadow-lg transition-all">
                        Simpan Catatan Siklus
                    </button>
                </form>
            </div>
        </div>

        <!-- History Table Section -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h2 class="text-base font-extrabold text-slate-900">Riwayat Catatan Siklus Haid</h2>
                <span class="text-xs font-semibold text-slate-400">{{ count($records) }} Catatan Tersimpan</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                            <th class="pb-3">Tanggal Mulai</th>
                            <th class="pb-3">Tanggal Selesai</th>
                            <th class="pb-3">Tingkat Nyeri</th>
                            <th class="pb-3">Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-xs">
                        @forelse($records as $rec)
                            @php
                                $nyeriBadge = match((int)$rec->tingkat_nyeri) {
                                    1 => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                    2 => 'bg-blue-50 text-blue-600 border-blue-200',
                                    3 => 'bg-amber-50 text-amber-600 border-amber-200',
                                    4 => 'bg-orange-50 text-orange-600 border-orange-200',
                                    5 => 'bg-rose-50 text-rose-600 border-rose-200',
                                    default => 'bg-slate-50 text-slate-600 border-slate-200',
                                };
                            @endphp
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-3.5 font-bold text-slate-900">
                                    {{ $rec->tanggal_mulai ? $rec->tanggal_mulai->format('d M Y') : '-' }}
                                </td>
                                <td class="py-3.5 text-slate-600 font-medium">
                                    {{ $rec->tanggal_selesai ? $rec->tanggal_selesai->format('d M Y') : 'Berjalan' }}
                                </td>
                                <td class="py-3.5">
                                    <span class="px-2.5 py-1 rounded-full font-bold border text-[10px] uppercase tracking-wider inline-block {{ $nyeriBadge }}">
                                        Level {{ $rec->tingkat_nyeri }}
                                    </span>
                                </td>
                                <td class="py-3.5 text-slate-500 font-medium max-w-xs truncate">
                                    {{ $rec->catatan ?: '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-slate-400 font-medium">
                                    Belum ada riwayat siklus yang dicatat. Silakan masukkan data pertama Anda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Alpine.js Calendar Component Script -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('menstrualCalendar', (events) => ({
                currentMonth: new Date().getMonth(),
                currentYear: new Date().getFullYear(),
                events: events || [],
                monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],

                get monthYearTitle() {
                    return `${this.monthNames[this.currentMonth]} ${this.currentYear}`;
                },

                get blankDays() {
                    const firstDayOfMonth = new Date(this.currentYear, this.currentMonth, 1).getDay();
                    return Array.from({ length: firstDayOfMonth });
                },

                get daysInMonth() {
                    const daysCount = new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
                    const days = [];
                    for (let i = 1; i <= daysCount; i++) {
                        const monthFormatted = String(this.currentMonth + 1).padStart(2, '0');
                        const dayFormatted = String(i).padStart(2, '0');
                        days.push({
                            day: i,
                            dateStr: `${this.currentYear}-${monthFormatted}-${dayFormatted}`
                        });
                    }
                    return days;
                },

                previousMonth() {
                    if (this.currentMonth === 0) {
                        this.currentMonth = 11;
                        this.currentYear--;
                    } else {
                        this.currentMonth--;
                    }
                },

                nextMonth() {
                    if (this.currentMonth === 11) {
                        this.currentMonth = 0;
                        this.currentYear++;
                    } else {
                        this.currentMonth++;
                    }
                },

                isToday(dateStr) {
                    const todayStr = new Date().toISOString().split('T')[0];
                    return dateStr === todayStr;
                },

                isPeriodDay(dateStr) {
                    return this.events.some(ev => {
                        if (!ev.start) return false;
                        const startDate = ev.start;
                        const endDate = ev.end || ev.start;
                        return dateStr >= startDate && dateStr <= endDate;
                    });
                }
            }));
        });
    </script>
</x-app-layout>
