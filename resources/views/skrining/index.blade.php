<x-app-layout>
    @php
        $jadwalSkrining = $jadwalSkrining ?? $jadwals ?? collect();
        $jadwals = $jadwalSkrining;
        $siswas = $siswas ?? collect();
        $totalJadwal = method_exists($jadwalSkrining, 'total') ? $jadwalSkrining->total() : count($jadwalSkrining);
    @endphp

    <div class="space-y-6 md:space-y-8 px-2 sm:px-4 md:px-0 max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 sm:px-3 sm:py-1 bg-blue-50 text-blue-600 rounded-full text-[10px] sm:text-xs font-semibold tracking-wide uppercase">
                        UKS Muhammadiyah Digital
                    </span>
                </div>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight mt-2">
                    Smart School Screening
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Manajemen Jadwal Skrining dan Hasil Pemeriksaan Kesehatan Berkala Siswa.
                </p>
            </div>

            <!-- Header Quick Stats -->
            <div class="flex items-center gap-4 shrink-0">
                <div class="flex items-center gap-3 bg-slate-50 px-3.5 py-2 sm:px-4 sm:py-2.5 rounded-xl sm:rounded-2xl border border-slate-100 w-full sm:w-auto">
                    <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-wider">TOTAL JADWAL</div>
                        <div class="text-xs sm:text-sm font-extrabold text-slate-900">{{ $totalJadwal }} Kegiatan</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Flash Message Alert -->
        @if(session('success'))
            <div class="p-3.5 sm:p-4 bg-emerald-50 border border-emerald-200 rounded-xl sm:rounded-2xl text-emerald-700 text-xs font-semibold flex items-center gap-3 shadow-xs">
                <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Two-Column Grid Layout (Stacked on Mobile) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">
            
            <!-- Left Column: Jadwal Skrining Form & Schedule List (7 cols on LG) -->
            <div class="lg:col-span-7 space-y-6">
                
                <!-- Card 1: Form Buat Jadwal Skrining Baru -->
                <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm overflow-hidden p-4 sm:p-6">
                    <div class="flex items-center justify-between pb-3 sm:pb-4 mb-4 sm:mb-5 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm sm:text-base font-bold text-slate-900">Buat Jadwal Skrining Baru</h3>
                                <p class="text-[11px] sm:text-xs text-slate-500">Jadwalkan kegiatan pemeriksaan fisik atau medis berkala.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Validation Error Catcher -->
                    @if ($errors->any())
                        <div class="mb-4 p-3.5 sm:p-4 bg-rose-50 border border-rose-200 rounded-xl sm:rounded-2xl text-rose-700 text-xs font-semibold">
                            <ul class="list-disc pl-4 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Native Form targeting route('skrining.jadwal.store') with anti-spam prevention -->
                    <form action="{{ route('skrining.jadwal.store') }}" method="POST" class="space-y-4" onsubmit="preventDoubleSubmit(this)">
                        @csrf

                        <!-- Field: jenis_skrining -->
                        <div>
                            <label for="jenis_skrining" class="block text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 sm:mb-2">
                                Jenis Skrining <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="jenis_skrining" id="jenis_skrining" required placeholder="Contoh: Pemeriksaan Mata & THT, Skrining Gigi" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150">
                        </div>

                        <!-- Grid Row: tanggal_pelaksanaan & lokasi -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Field: tanggal_pelaksanaan -->
                            <div>
                                <label for="tanggal_pelaksanaan" class="block text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 sm:mb-2">
                                    Tanggal Pelaksanaan <span class="text-rose-500">*</span>
                                </label>
                                <input type="date" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150">
                            </div>

                            <!-- Field: lokasi -->
                            <div>
                                <label for="lokasi" class="block text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 sm:mb-2">
                                    Lokasi Kegiatan <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="lokasi" id="lokasi" required placeholder="Contoh: Ruang UKS Utama, Aula" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2 flex justify-end">
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 disabled:opacity-50 disabled:cursor-not-allowed text-white text-xs font-semibold rounded-xl shadow-md shadow-blue-500/20 transition duration-150">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Simpan Jadwal Skrining</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Schedule List / Table Card -->
                <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm overflow-hidden p-4 sm:p-6">
                    <div class="flex items-center justify-between pb-3 sm:pb-4 mb-4 border-b border-slate-100">
                        <div>
                            <h3 class="text-sm sm:text-base font-bold text-slate-900">Daftar Jadwal Skrining</h3>
                            <p class="text-[11px] sm:text-xs text-slate-500">Jadwal pemeriksaan kesehatan mendatang & histori.</p>
                        </div>
                        <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-full text-[11px] font-bold shrink-0">
                            {{ $totalJadwal }} Jadwal
                        </span>
                    </div>

                    <!-- Mobile Card View (Visible on small screens) -->
                    <div class="block md:hidden space-y-3">
                        @forelse($jadwalSkrining as $j)
                            <div class="p-3.5 bg-slate-50/70 rounded-xl border border-slate-100 space-y-2">
                                <div class="flex items-start justify-between gap-2">
                                    <h4 class="font-bold text-xs text-slate-900 leading-snug">
                                        {{ $j->jenis_skrining ?? $j->nama_kegiatan }}
                                    </h4>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold border shrink-0 {{ $j->status_color ?? 'bg-emerald-50 text-emerald-600 border-emerald-200' }}">
                                        {{ $j->status ?? 'Aktif' }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between text-[11px] text-slate-500 pt-1 border-t border-slate-200/60">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>
                                            @php
                                                $tgl = $j->tanggal_pelaksanaan ?? $j->tanggal ?? now();
                                            @endphp
                                            {{ is_string($tgl) ? \Carbon\Carbon::parse($tgl)->format('d M Y') : $tgl->format('d M Y') }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        </svg>
                                        <span class="truncate max-w-[140px]">{{ $j->lokasi_kegiatan ?? $j->lokasi }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="py-8 text-center text-xs text-slate-400 font-medium">
                                Belum ada jadwal skrining.
                            </div>
                        @endforelse
                    </div>

                    <!-- Desktop Table View (Hidden on small screens) -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                    <th class="py-3 px-4">Jenis Skrining</th>
                                    <th class="py-3 px-4">Tanggal</th>
                                    <th class="py-3 px-4">Lokasi</th>
                                    <th class="py-3 px-4 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs">
                                @forelse($jadwalSkrining as $j)
                                    <tr class="hover:bg-slate-50/60 transition duration-150">
                                        <td class="py-3 px-4 font-bold text-slate-900">
                                            {{ $j->jenis_skrining ?? $j->nama_kegiatan }}
                                        </td>
                                        <td class="py-3 px-4 text-slate-600 whitespace-nowrap">
                                            @php
                                                $tgl = $j->tanggal_pelaksanaan ?? $j->tanggal ?? now();
                                            @endphp
                                            {{ is_string($tgl) ? \Carbon\Carbon::parse($tgl)->format('d M Y') : $tgl->format('d M Y') }}
                                        </td>
                                        <td class="py-3 px-4 text-slate-600">
                                            {{ $j->lokasi_kegiatan ?? $j->lokasi }}
                                        </td>
                                        <td class="py-3 px-4 text-right whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-extrabold border {{ $j->status_color ?? 'bg-emerald-50 text-emerald-600 border-emerald-200' }}">
                                                {{ $j->status ?? 'Aktif' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-xs text-slate-400 font-medium">
                                            Belum ada jadwal skrining.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    @if(method_exists($jadwalSkrining, 'hasPages') && $jadwalSkrining->hasPages())
                        <div class="mt-4 pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                            <div>
                                Menampilkan {{ $jadwalSkrining->firstItem() ?? 0 }} - {{ $jadwalSkrining->lastItem() ?? 0 }} dari {{ $jadwalSkrining->total() }} data
                            </div>
                            <div class="flex items-center gap-1 overflow-x-auto max-w-full pb-1 sm:pb-0">
                                {{ $jadwalSkrining->links('pagination::tailwind') }}
                            </div>
                        </div>
                    @endif
                </div>

            </div>

            <!-- Right Column: Peserta Skrining & Hasil Form (5 cols on LG) -->
            <div class="lg:col-span-5 space-y-6">
                
                <!-- Card: Form Input Peserta & Hasil Skrining -->
                <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm overflow-hidden p-4 sm:p-6">
                    <div class="flex items-center justify-between pb-3 sm:pb-4 mb-4 sm:mb-5 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm sm:text-base font-bold text-slate-900">Input Hasil Skrining Siswa</h3>
                                <p class="text-[11px] sm:text-xs text-slate-500">Catat kehadiran dan hasil evaluasi siswa.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Native Form targeting route('skrining.peserta.store') with anti-spam prevention -->
                    <form action="{{ route('skrining.peserta.store') }}" method="POST" class="space-y-4" onsubmit="preventDoubleSubmit(this)">
                        @csrf

                        <!-- Field: jadwal_id (select dropdown from $jadwals) -->
                        <div>
                            <label for="jadwal_id" class="block text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 sm:mb-2">
                                Pilih Jadwal Skrining <span class="text-rose-500">*</span>
                            </label>
                            <select name="jadwal_id" id="jadwal_id" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition duration-150">
                                <option value="" disabled selected>-- Pilih Jadwal Skrining --</option>
                                @foreach($jadwals as $j)
                                    <option value="{{ $j->id }}">{{ $j->jenis_skrining ?? $j->nama_kegiatan }} ({{ is_string($j->tanggal_pelaksanaan ?? $j->tanggal) ? ($j->tanggal_pelaksanaan ?? $j->tanggal) : ($j->tanggal_pelaksanaan ?? $j->tanggal)->format('d M Y') }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Field: siswa_id (select dropdown from $siswas) -->
                        <div>
                            <label for="siswa_id" class="block text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 sm:mb-2">
                                Pilih Siswa <span class="text-rose-500">*</span>
                            </label>
                            <select name="siswa_id" id="siswa_id" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition duration-150">
                                <option value="" disabled selected>-- Pilih Siswa --</option>
                                @foreach($siswas as $siswa)
                                    <option value="{{ $siswa->id }}">{{ $siswa->name ?? $siswa->nama_lengkap ?? $siswa->nama ?? 'Siswa #'.$siswa->id }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Field: status_kehadiran (Hadir / Tidak) -->
                        <div>
                            <label class="block text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 sm:mb-2">
                                Status Kehadiran <span class="text-rose-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="flex items-center justify-center gap-2 p-2.5 border border-slate-200 rounded-xl bg-slate-50 cursor-pointer hover:bg-white focus-within:ring-2 focus-within:ring-emerald-500 transition duration-150">
                                    <input type="radio" name="status_kehadiran" value="Hadir" checked class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 border-slate-300">
                                    <span class="text-xs font-bold text-slate-700">Hadir</span>
                                </label>
                                <label class="flex items-center justify-center gap-2 p-2.5 border border-slate-200 rounded-xl bg-slate-50 cursor-pointer hover:bg-white focus-within:ring-2 focus-within:ring-rose-500 transition duration-150">
                                    <input type="radio" name="status_kehadiran" value="Tidak Hadir" class="w-4 h-4 text-rose-600 focus:ring-rose-500 border-slate-300">
                                    <span class="text-xs font-bold text-slate-700">Tidak Hadir</span>
                                </label>
                            </div>
                        </div>

                        <!-- Field: catatan_hasil (textarea) -->
                        <div>
                            <label for="catatan_hasil" class="block text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 sm:mb-2">
                                Catatan Hasil Skrining
                            </label>
                            <textarea name="catatan_hasil" id="catatan_hasil" rows="3" placeholder="Masukkan ringkasan hasil pemeriksaan fisik/kesehatan..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition duration-150"></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2 flex justify-end">
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 disabled:opacity-50 disabled:cursor-not-allowed text-white text-xs font-semibold rounded-xl shadow-md shadow-emerald-500/20 transition duration-150">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Simpan Hasil Skrining</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>

    <script>
        function preventDoubleSubmit(form) {
            const btn = form.querySelector('button[type="submit"]');
            if (btn) {
                btn.disabled = true;
                const span = btn.querySelector('span');
                if (span) {
                    span.innerText = 'Menyimpan...';
                }
            }
        }
    </script>
</x-app-layout>
