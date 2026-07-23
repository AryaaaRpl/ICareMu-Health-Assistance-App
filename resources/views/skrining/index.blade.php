<x-app-layout>
    @php
        // Fallback dummy data if not provided by controller
        $jadwals = $jadwals ?? $jadwal_skrining ?? [
            (object)[
                'id' => 1,
                'jenis_skrining' => 'Pemeriksaan Mata & THT',
                'tanggal_pelaksanaan' => '2026-07-20',
                'lokasi' => 'Ruang UKS Utama',
                'status' => 'PENDING',
                'status_color' => 'bg-amber-50 text-amber-600 border-amber-200',
            ],
            (object)[
                'id' => 2,
                'jenis_skrining' => 'Deteksi Anemia (Putri)',
                'tanggal_pelaksanaan' => '2026-07-15',
                'lokasi' => 'Aula Sekolah',
                'status' => 'BERJALAN',
                'status_color' => 'bg-blue-50 text-blue-600 border-blue-200',
            ],
            (object)[
                'id' => 3,
                'jenis_skrining' => 'Skrining Status Gizi (IMT)',
                'tanggal_pelaksanaan' => '2026-07-05',
                'lokasi' => 'Ruang UKS 2',
                'status' => 'SELESAI',
                'status_color' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
            ],
            (object)[
                'id' => 4,
                'jenis_skrining' => 'Kesehatan Gigi & Mulut',
                'tanggal_pelaksanaan' => '2026-08-10',
                'lokasi' => 'Klinik Gigi Sekolah',
                'status' => 'PENDING',
                'status_color' => 'bg-amber-50 text-amber-600 border-amber-200',
            ],
        ];

        $siswas = $siswas ?? [
            (object)['id' => 101, 'nama' => 'Ahmad Faiz Al-Fatih (X MIPA 1)'],
            (object)['id' => 102, 'nama' => 'Siti Aminah Az-Zahra (XII IPS 2)'],
            (object)['id' => 103, 'nama' => 'Budi Santoso Prabowo (XI MIPA 3)'],
            (object)['id' => 104, 'nama' => 'Nurul Huda Rahmawati (X MIPA 2)'],
            (object)['id' => 105, 'nama' => 'Rizqi Pratama Wijaya (XI MIPA 1)'],
        ];
    @endphp

    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-semibold tracking-wide uppercase">
                        UKS Muhammadiyah Digital
                    </span>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight mt-2">
                    Smart School Screening
                </h1>
                <p class="text-xs md:text-sm text-slate-500 mt-1">
                    Manajemen Jadwal Skrining dan Hasil Pemeriksaan Kesehatan Berkala Siswa.
                </p>
            </div>

            <!-- Header Quick Stats -->
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-3 bg-slate-50 px-4 py-2.5 rounded-2xl border border-slate-100">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">JADWAL BULAN INI</div>
                        <div class="text-sm font-extrabold text-slate-900">{{ count($jadwals) }} Kegiatan</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Flash Message Alert -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-700 text-xs font-semibold flex items-center gap-3 shadow-xs">
                <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Two-Column Grid Layout (Stacked on Mobile) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Column: Jadwal Skrining Form & Schedule List (7 cols on LG) -->
            <div class="lg:col-span-7 space-y-6">
                
                <!-- Card 1: Form Buat Jadwal Skrining Baru -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden p-6">
                    <div class="flex items-center justify-between pb-4 mb-5 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900">Buat Jadwal Skrining Baru</h3>
                                <p class="text-xs text-slate-500">Jadwalkan kegiatan pemeriksaan fisik atau medis berkala.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Native Form targeting route('skrining.jadwal.store') -->
                    <form action="{{ route('skrining.jadwal.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Field: jenis_skrining -->
                        <div>
                            <label for="jenis_skrining" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Jenis Skrining <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="jenis_skrining" id="jenis_skrining" required placeholder="Contoh: Pemeriksaan Mata & THT, Skrining Gigi" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150">
                        </div>

                        <!-- Grid Row: tanggal_pelaksanaan & lokasi -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Field: tanggal_pelaksanaan -->
                            <div>
                                <label for="tanggal_pelaksanaan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Tanggal Pelaksanaan <span class="text-rose-500">*</span>
                                </label>
                                <input type="date" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150">
                            </div>

                            <!-- Field: lokasi -->
                            <div>
                                <label for="lokasi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Lokasi Kegiatan <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="lokasi" id="lokasi" required placeholder="Contoh: Ruang UKS Utama, Aula" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2 flex justify-end">
                            <button type="submit" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-xs font-semibold rounded-xl shadow-lg shadow-blue-500/25 transition duration-150 transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Simpan Jadwal Skrining</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Schedule List / Table Card -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden p-6">
                    <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Daftar Jadwal Skrining</h3>
                            <p class="text-xs text-slate-500">Jadwal pemeriksaan kesehatan mendatang & histori.</p>
                        </div>
                        <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-full text-[11px] font-bold">
                            {{ count($jadwals) }} Jadwal
                        </span>
                    </div>

                    <div class="overflow-x-auto">
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
                                @foreach($jadwals as $j)
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
                                            {{ $j->lokasi }}
                                        </td>
                                        <td class="py-3 px-4 text-right whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-extrabold border {{ $j->status_color ?? 'bg-slate-100 text-slate-600 border-slate-200' }}">
                                                {{ $j->status ?? 'AKTIF' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Right Column: Peserta Skrining & Hasil Form (5 cols on LG) -->
            <div class="lg:col-span-5 space-y-6">
                
                <!-- Card: Form Input Peserta & Hasil Skrining -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden p-6">
                    <div class="flex items-center justify-between pb-4 mb-5 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900">Input Hasil Skrining Siswa</h3>
                                <p class="text-xs text-slate-500">Catat kehadiran dan hasil evaluasi siswa.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Native Form targeting route('skrining.peserta.store') -->
                    <form action="{{ route('skrining.peserta.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Field: jadwal_id (select dropdown from $jadwals) -->
                        <div>
                            <label for="jadwal_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Pilih Jadwal Skrining <span class="text-rose-500">*</span>
                            </label>
                            <select name="jadwal_id" id="jadwal_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition duration-150">
                                <option value="" disabled selected>-- Pilih Jadwal Skrining --</option>
                                @foreach($jadwals as $j)
                                    <option value="{{ $j->id }}">{{ $j->jenis_skrining ?? $j->nama_kegiatan }} ({{ is_string($j->tanggal_pelaksanaan ?? $j->tanggal) ? ($j->tanggal_pelaksanaan ?? $j->tanggal) : ($j->tanggal_pelaksanaan ?? $j->tanggal)->format('d M Y') }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Field: siswa_id (select dropdown from $siswas) -->
                        <div>
                            <label for="siswa_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Pilih Siswa <span class="text-rose-500">*</span>
                            </label>
                            <select name="siswa_id" id="siswa_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition duration-150">
                                <option value="" disabled selected>-- Pilih Siswa --</option>
                                @foreach($siswas as $siswa)
                                    <option value="{{ $siswa->id }}">{{ $siswa->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Field: status_kehadiran (Hadir / Tidak) -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
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
                            <label for="catatan_hasil" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Catatan Hasil Skrining
                            </label>
                            <textarea name="catatan_hasil" id="catatan_hasil" rows="4" placeholder="Masukkan ringkasan hasil pemeriksaan fisik/kesehatan..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition duration-150"></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2 flex justify-end">
                            <button type="submit" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white text-xs font-semibold rounded-xl shadow-lg shadow-emerald-500/25 transition duration-150 transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
</x-app-layout>
