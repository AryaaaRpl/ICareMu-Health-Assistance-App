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
            <!-- Success / Error Alert -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-bold rounded-2xl flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 text-sm font-bold rounded-2xl flex items-center gap-3">
                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Admin Student Selector Bar -->
        @if($isAdmin)
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="space-y-1">
                    <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-rose-100 text-rose-700">
                        Mode Pengelola UKS / Admin
                    </span>
                    <h2 class="text-base font-extrabold text-slate-900">Pilih Siswi yang hendak Diinput / Dipantau</h2>
                </div>
                <form method="GET" action="{{ route('menstrual.index') }}" class="w-full sm:w-auto flex items-center gap-3">
                    <select name="siswa_id" onchange="this.form.submit()" class="w-full sm:w-64 rounded-2xl border-slate-200 bg-slate-50 py-2.5 px-4 text-xs font-bold text-slate-900 focus:border-rose-500 focus:bg-white focus:ring-2 focus:ring-rose-500/20 transition-all">
                        @forelse($femaleStudents as $fs)
                            <option value="{{ $fs->id }}" {{ (string)$selectedSiswaId === (string)$fs->id ? 'selected' : '' }}>
                                {{ $fs->name }} {{ $fs->nisn ? '('.$fs->nisn.')' : '' }}
                            </option>
                        @empty
                            <option value="">Tidak ada data siswi</option>
                        @endforelse
                    </select>
                </form>
            </div>
        @endif

        <!-- Top Section Grid: Prediction & Relief Tips -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Prediction Card (2 Cols) -->
            <div class="md:col-span-2 bg-white rounded-3xl p-6 sm:p-8 border border-rose-100 shadow-sm flex flex-col justify-between space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-extrabold uppercase tracking-wider text-rose-500">
                        PREDIKSI HAID BERIKUTNYA {{ $selectedStudent ? '('.$selectedStudent->name.')' : '' }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-600 border border-rose-200">
                        Siklus 28 Hari
                    </span>
                </div>

                <div class="space-y-1">
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                        {{ $nextPeriodDate ? $nextPeriodDate->translatedFormat('l, d F Y') : '-' }}
                    </div>
                    <p class="text-xs text-slate-500 font-medium">
                        Diperhitungkan otomatis berdasarkan tanggal awal siklus terakhir siswi.
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
        <div class="grid grid-cols-1 {{ $isAdmin ? 'lg:grid-cols-3' : '' }} gap-8">
            <!-- Dynamic Interactive Alpine.js Calendar (2 Cols jika admin, 3 cols jika siswa read-only) -->
            <div class="{{ $isAdmin ? 'lg:col-span-2' : 'lg:col-span-3' }} bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-6">
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
                                {{-- <template x-if="isPeriodDay(dateDay.dateStr)">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white mt-0.5"></span>
                                </template> --}}
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

            <!-- Form Log Siklus Baru (HANYA UNTUK ROLE ADMIN SUPER / ADMIN UKS) -->
            @if($isAdmin)
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-5">
                    <div class="border-b border-slate-100 pb-3">
                        <h2 class="text-base font-extrabold text-slate-900">Catat Mulai Haid Siswi</h2>
                        <p class="text-xs text-slate-400 font-medium">
                            Target Siswi: <strong class="text-rose-600">{{ $selectedStudent?->name ?? 'Belum dipilih' }}</strong>
                        </p>
                    </div>

                    @if($selectedStudent)
                        <form action="{{ route('menstrual.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="siswa_id" value="{{ $selectedStudent->id }}">

                            <!-- Tanggal Mulai -->
                            <div class="space-y-1.5">
                                <label for="tanggal_mulai" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                    Tanggal Mulai Haid <span class="text-rose-500">*</span>
                                </label>
                                <input type="date" id="tanggal_mulai" name="tanggal_mulai" required value="{{ date('Y-m-d') }}"
                                    class="w-full rounded-2xl border-slate-200 bg-slate-50 py-3 px-4 text-xs font-semibold text-slate-900 focus:border-rose-500 focus:bg-white focus:ring-2 focus:ring-rose-500/20 transition-all">
                                <p class="text-[11px] text-slate-400">Menandai bahwa siswi sedang mulai haid pada tanggal ini.</p>
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
                                    <option value="5">5 - Sangat Hebat / Istirahat UKS (😭)</option>
                                </select>
                            </div>

                            <!-- Catatan -->
                            <div class="space-y-1.5">
                                <label for="catatan" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                    Catatan UKS / Gejala <span class="text-slate-400">(Opsional)</span>
                                </label>
                                <textarea id="catatan" name="catatan" rows="3" placeholder="Keluhan saat mulai haid..."
                                    class="w-full rounded-2xl border-slate-200 bg-slate-50 py-3 px-4 text-xs font-medium text-slate-900 focus:border-rose-500 focus:bg-white focus:ring-2 focus:ring-rose-500/20 transition-all"></textarea>
                            </div>

                            <button type="submit"
                                class="w-full py-3.5 bg-gradient-to-r from-rose-500 to-pink-600 hover:from-rose-600 hover:to-pink-700 text-white font-bold text-xs rounded-2xl shadow-md hover:shadow-lg transition-all">
                                🌸 Simpan Tanggal Mulai Haid
                            </button>
                        </form>
                    @else
                        <p class="text-xs text-slate-400 text-center py-4">Silakan pilih siswi terlebih dahulu.</p>
                    @endif
                </div>
            @endif
        </div>

        <!-- History Table Section -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900">Riwayat Catatan Siklus Haid</h2>
                    <p class="text-xs text-slate-400 font-medium">Menampilkan data resmi yang dicatat oleh Admin UKS / Admin Super</p>
                </div>
                <span class="text-xs font-semibold text-slate-400">{{ count($records) }} Catatan Tersimpan</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                            <th class="pb-3">Tanggal Mulai</th>
                            <th class="pb-3">Tanggal Selesai</th>
                            <th class="pb-3">Status Haid</th>
                            <th class="pb-3">Tingkat Nyeri</th>
                            <th class="pb-3">Catatan</th>
                            @if($isAdmin)
                                <th class="pb-3 text-right">Aksi Admin</th>
                            @endif
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
                                    {{ $rec->tanggal_selesai ? $rec->tanggal_selesai->format('d M Y') : 'Belum Selesai' }}
                                </td>
                                <td class="py-3.5">
                                    @if($rec->tanggal_selesai)
                                        <span class="px-2.5 py-1 rounded-full font-bold border border-emerald-200 bg-emerald-50 text-emerald-700 text-[10px]">
                                            ✓ Selesai Haid
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full font-bold border border-rose-200 bg-rose-50 text-rose-700 text-[10px] animate-pulse">
                                            🔴 Sedang Haid
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5">
                                    <span class="px-2.5 py-1 rounded-full font-bold border text-[10px] uppercase tracking-wider inline-block {{ $nyeriBadge }}">
                                        Level {{ $rec->tingkat_nyeri }}
                                    </span>
                                </td>
                                <td class="py-3.5 text-slate-500 font-medium max-w-xs truncate">
                                    {{ $rec->catatan ?: '-' }}
                                </td>
                                @if($isAdmin)
                                    <td class="py-3.5 text-right">
                                        @if(!$rec->tanggal_selesai)
                                            <form action="{{ route('menstrual.finish', $rec->id) }}" method="POST" class="inline-flex items-center gap-2">
                                                @csrf
                                                @method('PUT')
                                                <input type="date" name="tanggal_selesai" required value="{{ date('Y-m-d') }}"
                                                    class="rounded-xl border-slate-200 bg-slate-50 py-1 px-2 text-[11px] font-semibold text-slate-900 focus:border-rose-500">
                                                <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[11px] rounded-xl shadow-sm transition-all">
                                                    Isi Tanggal Selesai
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-[11px] text-slate-400 italic">Tercatat Lengkap</span>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $isAdmin ? '6' : '5' }}" class="py-6 text-center text-slate-400 font-medium">
                                    Belum ada riwayat siklus yang dicatat untuk siswi ini.
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
