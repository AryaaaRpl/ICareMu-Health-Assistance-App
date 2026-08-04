<x-app-layout>

    <div x-data="{ openModal: false, search: '', statusFilter: '' }" class="space-y-6">
        
        <!-- Header & Action Button -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-semibold tracking-wide uppercase">
                        UKS Muhammadiyah Digital
                    </span>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight mt-2">
                    Smart Health Record
                </h1>
                <p class="text-xs md:text-sm text-slate-500 mt-1">
                    Data skrining fisik siswa, perhitungan indeks massa tubuh (IMT), dan manajemen risiko kesehatan terpadu.
                </p>
            </div>
            
            <div class="flex items-center gap-3">
                <button type="button" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition duration-150 shadow-xs">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Ekspor CSV
                </button>

                <button @click="openModal = true" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-xs font-semibold rounded-2xl shadow-lg shadow-blue-500/25 transition duration-150 transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Catat Pemeriksaan Baru</span>
                </button>
            </div>
        </div>

        <!-- Metric Overview Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">TOTAL SKRINING</span>
                    <h4 class="text-xl font-bold text-slate-900 mt-0.5">{{ $totalSkrining ?? count($records ?? $rekam_medis ?? []) }}</h4>
                    <p class="text-[11px] text-slate-500 font-medium">Siswa terdata</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">STATUS NORMAL</span>
                    <h4 class="text-xl font-bold text-slate-900 mt-0.5">{{ $statusNormal ?? 0 }}</h4>
                    <p class="text-[11px] text-emerald-600 font-medium">Hasil Triage Sehat</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">PERLU PERHATIAN</span>
                    <h4 class="text-xl font-bold text-slate-900 mt-0.5">{{ $perluPerhatian ?? 0 }}</h4>
                    <p class="text-[11px] text-amber-600 font-medium">Suhu > 37.5°C / Observasi</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">TINDAKAN DIRUJUKS</span>
                    <h4 class="text-xl font-bold text-slate-900 mt-0.5">{{ $tindakanDirujuk ?? 0 }}</h4>
                    <p class="text-[11px] text-rose-500 font-medium">Membutuhkan penanganan lanjut</p>
                </div>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="relative w-full md:w-80">
                <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" x-model="search" placeholder="Cari nama siswa, NISN, atau keluhan..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150">
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Filter:</span>
                <select x-model="statusFilter" class="bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status Penanganan</option>
                    <option value="Istirahat di UKS">Istirahat di UKS</option>
                    <option value="Diberi Obat">Diberi Obat</option>
                    <option value="Dirujuk">Dirujuk</option>
                    <option value="Selesai">Selesai</option>
                </select>
            </div>
        </div>

        <!-- Data Table Card -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                            <th class="py-4 px-6">Tanggal</th>
                            <th class="py-4 px-6">Nama Siswa</th>
                            <th class="py-4 px-6">Keluhan Utama</th>
                            <th class="py-4 px-6">Suhu</th>
                            <th class="py-4 px-6">Status AI</th>
                            <th class="py-4 px-6">Status Penanganan</th>
                            <th class="py-4 px-6 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($records ?? $rekam_medis as $row)
                            @php
                                $tgl = $row->created_at ? $row->created_at->format('d M Y, H:i') : (isset($row->tanggal) ? (is_string($row->tanggal) ? \Carbon\Carbon::parse($row->tanggal)->format('d M Y') : $row->tanggal->format('d M Y')) : '-');
                                $namaSiswa = $row->siswa ? ($row->siswa->name ?? $row->siswa->nama_lengkap ?? $row->siswa->nama ?? 'Siswa') : 'Siswa #'.($row->siswa_id ?? '');
                                $nisnSiswa = $row->siswa ? ($row->siswa->nisn ?? '-') : '-';
                                $suhuVal = (float)($row->suhu_tubuh ?? $row->suhu ?? 36.5);
                                $isHighTemp = $suhuVal > 37.5;
                                $gejalaText = is_array($row->gejala) ? implode(', ', $row->gejala) : ($row->gejala ?? $row->keluhan_utama ?? '-');
                                $tindakanText = $row->tindakan_uks ?? $row->penanganan ?? null;
                                $statusAkhirText = $row->status_akhir ? str_replace('_', ' ', $row->status_akhir) : ($row->status ?? 'Selesai');
                            @endphp
                            <tr class="hover:bg-slate-50/60 transition duration-150">
                                <!-- Tanggal -->
                                <td class="py-4 px-6 font-semibold text-slate-600 whitespace-nowrap">
                                    {{ $tgl }}
                                </td>

                                <!-- Nama Siswa -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs uppercase border border-slate-200">
                                            {{ strtoupper(substr($namaSiswa, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900">{{ $namaSiswa }}</div>
                                            <div class="text-[11px] text-slate-400 font-mono">NISN: {{ $nisnSiswa }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Keluhan Utama -->
                                <td class="py-4 px-6 max-w-xs">
                                    <p class="text-slate-700 font-medium truncate" title="{{ $gejalaText }}">
                                        {{ $gejalaText }}
                                    </p>
                                    @if($tindakanText)
                                        <p class="text-[11px] text-slate-400 truncate mt-0.5">
                                            <span class="font-semibold text-slate-500">Tindakan:</span> {{ $tindakanText }}
                                        </p>
                                    @endif
                                </td>

                                <!-- Suhu -->
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border {{ $isHighTemp ? 'bg-rose-50 text-rose-600 border-rose-200 animate-pulse' : 'bg-emerald-50 text-emerald-600 border-emerald-200' }}">
                                        <span class="w-2 h-2 rounded-full {{ $isHighTemp ? 'bg-rose-500' : 'bg-emerald-500' }}"></span>
                                        <span>{{ number_format($suhuVal, 1) }} °C</span>
                                    </div>
                                </td>

                                <!-- Status AI -->
                                <td class="py-4 px-6 whitespace-nowrap">
                                    @if(($row->ai_status ?? null) === 'sehat')
                                        <span class="px-2.5 py-1 rounded-full font-bold text-[10px] uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-300">
                                            Sehat
                                        </span>
                                    @elseif(($row->ai_status ?? null) === 'pulang')
                                        <span class="px-2.5 py-1 rounded-full font-bold text-[10px] uppercase tracking-wider bg-amber-100 text-amber-800 border border-amber-300">
                                            Pulang
                                        </span>
                                    @elseif(in_array(($row->ai_status ?? null), ['observasi_uks', 'darurat']))
                                        <span class="px-2.5 py-1 rounded-full font-bold text-[10px] uppercase tracking-wider bg-rose-100 text-rose-800 border border-rose-300 animate-pulse">
                                            🚨 {{ strtoupper(str_replace('_', ' ', $row->ai_status)) }}
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-500 text-[10px] font-semibold">
                                            -
                                        </span>
                                    @endif
                                </td>

                                <!-- Status Penanganan -->
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold border uppercase bg-slate-100 text-slate-700 border-slate-200">
                                        {{ $statusAkhirText }}
                                    </span>
                                </td>

                                <!-- Action -->
                                <td class="py-4 px-6 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-2">
                                        @if(isset($row->id) && $row instanceof \App\Models\SkriningRecord)
                                            <a href="{{ route('skrining.show', $row->id) }}" title="Lihat Detail & Tindakan" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow transition duration-150 inline-block">
                                                Tindak UKS
                                            </a>
                                        @else
                                            <a href="{{ route('rekam-medis.show', $row->id) }}" title="Lihat Detail" class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-150">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400 font-medium">
                                    Belum ada data rekam medis tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $records->withQueryString()->links() }}
            </div>

            <!-- Table Footer Pagination bar -->
            <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Menampilkan <strong>{{ count($rekam_medis) }}</strong> dari <strong>{{ count($rekam_medis) }}</strong> rekam medis</span>
                <span class="text-[11px] text-slate-400 uppercase tracking-widest font-semibold">Pembaruan UKS Real-time</span>
            </div>
        </div>

        <!-- Input Form Modal (Alpine.js backdrop & slide-up modal) -->
        <div x-show="openModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4"
             style="display: none;">
            
            <div @click.away="openModal = false"
                 x-show="openModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="bg-white rounded-3xl border border-slate-100 shadow-2xl w-full max-w-2xl overflow-hidden">
                
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Catat Rekam Medis / Skrining Baru</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Lengkapi formulir pemeriksaan fisik siswa di bawah ini.</p>
                    </div>
                    <button @click="openModal = false" class="p-2 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition duration-150">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Form targeting route('rekam-medis.store') -->
                <form action="{{ route('rekam-medis.store') }}" method="POST" class="p-6 space-y-5">
                    @csrf

                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-2xl text-xs font-semibold">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Field: siswa_id (select dropdown) -->
                    <div>
                        <label for="siswa_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Pilih Siswa <span class="text-rose-500">*</span>
                        </label>
                        <select name="siswa_id" id="siswa_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150">
                            <option value="" disabled selected>-- Pilih Siswa --</option>
                            @foreach($siswaList as $siswa)
                                <option value="{{ $siswa->id }}">{{ $siswa->name ?? $siswa->nama_lengkap ?? $siswa->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Grid Row: Physical Vitals (tinggi_badan, berat_badan, suhu, tekanan_darah) -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <!-- tinggi_badan -->
                        <div>
                            <label for="tinggi_badan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                TB (cm)
                            </label>
                            <input type="number" step="0.1" name="tinggi_badan" id="tinggi_badan" placeholder="165" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150">
                        </div>

                        <!-- berat_badan -->
                        <div>
                            <label for="berat_badan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                BB (kg)
                            </label>
                            <input type="number" step="0.1" name="berat_badan" id="berat_badan" placeholder="55" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150">
                        </div>

                        <!-- suhu -->
                        <div>
                            <label for="suhu" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Suhu (°C) <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" step="0.1" name="suhu" id="suhu" required placeholder="36.5" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150">
                        </div>

                        <!-- tekanan_darah -->
                        <div>
                            <label for="tekanan_darah" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Tensi (mmHg)
                            </label>
                            <input type="text" name="tekanan_darah" id="tekanan_darah" placeholder="120/80" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150">
                        </div>
                    </div>

                    <!-- Field: keluhan_utama (textarea) -->
                    <div>
                        <label for="keluhan_utama" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Keluhan Utama <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="keluhan_utama" id="keluhan_utama" rows="3" required placeholder="Jelaskan keluhan utama atau hasil skrining fisik siswa..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150"></textarea>
                    </div>

                    <!-- Field: penanganan (textarea) -->
                    <div>
                        <label for="penanganan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Penanganan / Tindakan UKS
                        </label>
                        <textarea name="penanganan" id="penanganan" rows="2" placeholder="Tindakan yang telah diberikan (obat, kompres, istirahat, dll)..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150"></textarea>
                    </div>

                    <!-- Field: status (select dropdown) -->
                    <div>
                        <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Status Penanganan <span class="text-rose-500">*</span>
                        </label>
                        <select name="status" id="status" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150">
                            <option value="Istirahat di UKS">Istirahat di UKS</option>
                            <option value="Diberi Obat">Diberi Obat</option>
                            <option value="Dirujuk">Dirujuk ke Rumah Sakit / Puskesmas</option>
                            <option value="Selesai" selected>Selesai / Sehat</option>
                        </select>
                    </div>

                    <!-- Modal Actions -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" @click="openModal = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition duration-150">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl shadow-lg shadow-blue-500/20 transition duration-150">
                            Simpan Rekam Medis
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</x-app-layout>
