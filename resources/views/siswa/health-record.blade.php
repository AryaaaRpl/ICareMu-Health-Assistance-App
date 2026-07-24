<x-app-layout>
    <div class="space-y-8 max-w-5xl mx-auto">
        <!-- Hero Banner Header -->
        <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-indigo-600 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl border border-blue-500/30">
            <div class="relative z-10 space-y-2">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-semibold uppercase tracking-wider text-blue-100">
                    <svg class="w-4 h-4 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Personal Medical Records
                </div>
                <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight">Smart Health Record Siswa</h1>
                <p class="text-blue-100 text-xs sm:text-base max-w-2xl leading-relaxed">
                    Pantau riwayat lengkap skrining kesehatan harianmu, rekomendasi AI, serta tindakan medis & resep obat dari Petugas UKS sekolah.
                </p>
            </div>
            <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        </div>

        <!-- History Timeline Container -->
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-extrabold text-slate-900">Riwayat Skrining & Penanganan Medis</h2>
                    <p class="text-xs text-slate-400 font-semibold">Diurutkan berdasarkan pemeriksaan terbaru</p>
                </div>
                <a href="{{ route('skrining.siswa') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow transition-all inline-flex items-center gap-2">
                    <span>+ Skrining Baru</span>
                </a>
            </div>

            @forelse($riwayatKesehatan as $record)
                @php
                    $gejalaList = is_array($record->gejala) ? implode(', ', $record->gejala) : ($record->gejala ?? 'Tidak ada gejala spesifik');
                    if (empty($gejalaList)) {
                        $gejalaList = 'Tidak ada gejala spesifik';
                    }
                    
                    $statusMap = [
                        'kembali_ke_kelas' => ['label' => 'Kembali ke Kelas', 'color' => 'bg-emerald-100 text-emerald-800 border-emerald-300'],
                        'istirahat_di_uks' => ['label' => 'Istirahat di UKS', 'color' => 'bg-amber-100 text-amber-800 border-amber-300'],
                        'pulang' => ['label' => 'Diizinkan Pulang', 'color' => 'bg-orange-100 text-orange-800 border-orange-300'],
                        'rujuk_rs' => ['label' => 'Rujuk ke RS / Puskesmas', 'color' => 'bg-rose-100 text-rose-800 border-rose-300'],
                    ];
                    $statusAkhirInfo = $record->status_akhir ? ($statusMap[$record->status_akhir] ?? ['label' => str_replace('_', ' ', $record->status_akhir), 'color' => 'bg-slate-100 text-slate-800 border-slate-300']) : null;
                @endphp

                <!-- Record Card Item -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm hover:shadow-md transition-all space-y-6">
                    <!-- Top Bar: Date, Temperature & Status Badge -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-extrabold text-slate-900">
                                    {{ $record->created_at ? $record->created_at->translatedFormat('l, d F Y - H:i') : '-' }} WIB
                                </h3>
                                <p class="text-xs text-slate-400 font-semibold">Pemeriksaan Kesehatan Mandiri</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 self-start sm:self-auto">
                            <!-- Temperature Badge -->
                            <span class="px-3 py-1.5 rounded-2xl bg-slate-100 text-slate-800 font-extrabold text-xs border border-slate-200">
                                🌡️ {{ number_format((float) $record->suhu_tubuh, 1) }} °C
                            </span>

                            <!-- AI Status Badge -->
                            @if($record->ai_status === 'sehat')
                                <span class="px-3 py-1.5 rounded-2xl font-extrabold text-xs bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    🟢 Sehat
                                </span>
                            @elseif($record->ai_status === 'pulang')
                                <span class="px-3 py-1.5 rounded-2xl font-extrabold text-xs bg-amber-100 text-amber-800 border border-amber-200">
                                    🟠 Pulang
                                </span>
                            @elseif(in_array($record->ai_status, ['observasi_uks', 'darurat']))
                                <span class="px-3 py-1.5 rounded-2xl font-extrabold text-xs bg-rose-100 text-rose-800 border border-rose-200 animate-pulse">
                                    🚨 {{ strtoupper(str_replace('_', ' ', $record->ai_status)) }}
                                </span>
                            @else
                                <span class="px-3 py-1.5 rounded-2xl font-bold text-xs bg-slate-100 text-slate-600 border border-slate-200">
                                    ⏳ Menunggu AI
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Symptoms & Complaints Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-1">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block">Gejala Yang Dilaporkan</span>
                            <p class="text-xs font-bold text-slate-800 leading-relaxed">{{ $gejalaList }}</p>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-1">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block">Keluhan Tambahan</span>
                            <p class="text-xs font-semibold text-slate-700 leading-relaxed">
                                {{ $record->keluhan_tambahan ?: 'Tidak ada keluhan tambahan.' }}
                            </p>
                        </div>
                    </div>

                    <!-- AI Recommendation Box -->
                    @if($record->ai_recommendation)
                        <div class="bg-indigo-50/50 p-4 rounded-2xl border border-indigo-100 space-y-1">
                            <div class="flex items-center gap-1.5">
                                <span class="text-xs">🤖</span>
                                <span class="text-[11px] font-extrabold uppercase tracking-wider text-indigo-700">Analisis & Rekomendasi AI</span>
                            </div>
                            <p class="text-xs font-medium text-indigo-950 leading-relaxed">{{ $record->ai_recommendation }}</p>
                        </div>
                    @endif

                    <!-- Section: Tindakan Medis UKS -->
                    <div class="pt-2">
                        @if($record->tindakan_uks)
                            <div class="bg-gradient-to-r from-teal-50 via-emerald-50 to-cyan-50 p-5 rounded-2xl border border-teal-200/70 space-y-3 shadow-sm">
                                <div class="flex items-center justify-between border-b border-teal-200/50 pb-2.5">
                                    <div class="flex items-center gap-2">
                                        <span class="w-7 h-7 rounded-xl bg-teal-600 text-white flex items-center justify-center text-xs font-bold">🩺</span>
                                        <h4 class="text-xs font-extrabold uppercase tracking-wider text-teal-900">Catatan Penanganan Petugas UKS</h4>
                                    </div>
                                    @if($record->waktu_ditindak)
                                        <span class="text-[10px] font-bold text-teal-700">
                                            Ditindak: {{ $record->waktu_ditindak->format('H:i') }} WIB
                                        </span>
                                    @endif
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                                    <div class="sm:col-span-3 space-y-1">
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-teal-700 block">Tindakan Medis</span>
                                        <p class="font-bold text-teal-950 leading-relaxed">{{ $record->tindakan_uks }}</p>
                                    </div>

                                    @if($record->obat_diberikan)
                                        <div class="sm:col-span-2 space-y-1">
                                            <span class="text-[10px] font-bold uppercase tracking-wider text-teal-700 block">Obat Yang Diberikan</span>
                                            <p class="font-bold text-teal-900 bg-white/70 px-3 py-1.5 rounded-xl border border-teal-200 inline-block">
                                                💊 {{ $record->obat_diberikan }}
                                            </p>
                                        </div>
                                    @endif

                                    @if($statusAkhirInfo)
                                        <div class="space-y-1">
                                            <span class="text-[10px] font-bold uppercase tracking-wider text-teal-700 block">Status Akhir Siswa</span>
                                            <span class="px-3 py-1.5 rounded-xl font-extrabold text-xs border inline-block {{ $statusAkhirInfo['color'] }}">
                                                {{ $statusAkhirInfo['label'] }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 text-center">
                                <p class="text-xs font-semibold text-slate-400 flex items-center justify-center gap-1.5">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Menunggu pemeriksaan & tindakan Petugas UKS...</span>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl p-12 text-center border border-slate-100 space-y-3">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900">Belum Ada Riwayat Kesehatan</h3>
                    <p class="text-xs text-slate-400 max-w-sm mx-auto">
                        Kamu belum pernah melakukan skrining kesehatan. Tekan tombol di bawah untuk memulai skrining pertamamu!
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('skrining.siswa') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs rounded-2xl shadow transition-all inline-block">
                            Mulai Skrining Sekarang
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
