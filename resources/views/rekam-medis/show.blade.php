<x-app-layout>
    <div class="space-y-8 max-w-7xl mx-auto">
        <div class="relative overflow-hidden bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl border border-slate-800">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-1">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 text-xs font-bold uppercase tracking-wider">
                        <span>🩺</span> Rekam Medis & Audit Trail
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Detail Rekam Medis Siswa</h1>
                    <p class="text-slate-300 text-xs sm:text-sm">
                        Tampilan read-only hasil skrining dan tindakan medis untuk kepatuhan audit.
                    </p>
                </div>
                <div>
                    <a href="{{ route('rekam-medis.index') }}"
                        class="px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs shadow-md transition-all inline-flex items-center gap-2 border border-white/10 backdrop-blur-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Rekam Medis
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-4">
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-extrabold text-lg">
                            {{ strtoupper(substr($record->siswa->name ?? $record->siswa->nama_lengkap ?? 'S', 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="text-base font-extrabold text-slate-900">
                                {{ $record->siswa->nama_lengkap ?? $record->siswa->name ?? 'Siswa #'.$record->siswa_id }}
                            </h3>
                            <p class="text-xs font-semibold text-slate-400">
                                Kelas: <span class="text-slate-700 font-bold">{{ $record->siswa->kelas ?? '-' }}</span> | NISN: <span class="text-slate-700 font-bold">{{ $record->siswa->nisn ?? '-' }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-1">
                        <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-100">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block">Suhu Tubuh</span>
                            <span class="text-lg font-extrabold text-slate-900">
                                {{ number_format((float) $record->suhu, 1) }} °C
                            </span>
                        </div>
                        <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-100">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block">Waktu Skrining</span>
                            <span class="text-xs font-bold text-slate-800">
                                {{ $record->created_at ? $record->created_at->format('d M Y, H:i') : '-' }} WIB
                            </span>
                        </div>
                    </div>

                    <div class="space-y-1.5 pt-2">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-slate-400">Gejala Yang Dirasakan</span>
                        <div class="flex flex-wrap gap-2">
                            @php
                                $gejalaList = is_array($record->gejala) ? $record->gejala : json_decode($record->gejala ?? '[]', true);
                            @endphp
                            @forelse($gejalaList ?? [] as $g)
                                <span class="px-3 py-1 rounded-xl bg-slate-100 text-slate-800 font-bold text-xs border border-slate-200">
                                    {{ $g }}
                                </span>
                            @empty
                                <span class="text-xs font-medium text-slate-400 italic">Tidak ada gejala spesifik.</span>
                            @endforelse
                        </div>
                    </div>

                    <div class="space-y-1 pt-2">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-slate-400">Keluhan Tambahan</span>
                        <p class="text-xs font-medium text-slate-700 bg-slate-50 p-3.5 rounded-2xl border border-slate-100 leading-relaxed">
                            {{ $record->keluhan_tambahan ?: 'Tidak ada keluhan tambahan.' }}
                        </p>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-slate-900 to-indigo-950 rounded-3xl p-6 text-white shadow-md border border-slate-800 space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                        <div class="flex items-center gap-2">
                            <span class="text-base">🤖</span>
                            <h4 class="text-xs font-extrabold uppercase tracking-wider text-indigo-300">Hasil Triage AI Assistant</h4>
                        </div>
                        <div>
                            @if($record->ai_status === 'sehat')
                                <span class="px-3 py-1 rounded-full font-extrabold text-[10px] uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Sehat</span>
                            @elseif($record->ai_status === 'pulang')
                                <span class="px-3 py-1 rounded-full font-extrabold text-[10px] uppercase tracking-wider bg-amber-500/20 text-amber-300 border border-amber-500/30">Pulang</span>
                            @elseif(in_array($record->ai_status, ['observasi_uks', 'darurat']))
                                <span class="px-3 py-1 rounded-full font-extrabold text-[10px] uppercase tracking-wider bg-rose-500/20 text-rose-300 border border-rose-500/30 animate-pulse">
                                    🚨 {{ strtoupper(str_replace('_', ' ', $record->ai_status)) }}
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full font-bold text-[10px] uppercase tracking-wider bg-white/10 text-slate-300 border border-white/10">Menunggu Analisis AI</span>
                            @endif
                        </div>
                    </div>
                    <div class="space-y-2">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Rekomendasi Penanganan AI</span>
                        <p class="text-xs leading-relaxed text-slate-200 bg-white/5 p-3.5 rounded-2xl border border-white/10">
                            {{ $record->ai_recommendation ?: 'Belum ada rekomendasi AI khusus. Lakukan evaluasi gejala secara langsung oleh petugas UKS.' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7">
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-6">
                    <div class="border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Catatan Tindakan Medis UKS</h3>
                        <p class="text-xs text-slate-400 font-medium">Riwayat penanganan yang telah dicatat oleh petugas UKS (read-only)</p>
                    </div>

                    @if(session('success'))
                        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-2xl flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($record->penanganan)
                        <div class="space-y-2">
                            <span class="block text-xs font-extrabold uppercase tracking-wider text-slate-700">Tindakan Medis / Pertolongan Pertama</span>
                            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 text-xs font-medium text-slate-900 leading-relaxed">
                                {{ $record->penanganan }}
                            </div>
                        </div>

                        @if($record->obat_diberikan)
                            <div class="space-y-2">
                                <span class="block text-xs font-extrabold uppercase tracking-wider text-slate-700">Obat Yang Diberikan</span>
                                <div class="inline-flex items-center gap-2 bg-emerald-50 border border-emerald-200 rounded-2xl px-4 py-3 text-xs font-bold text-emerald-800">
                                    <span>💊</span>
                                    <span>{{ $record->obat_diberikan }}</span>
                                </div>
                            </div>
                        @endif

                        <div class="space-y-2">
                            <span class="block text-xs font-extrabold uppercase tracking-wider text-slate-700">Status Akhir Siswa</span>
                            <div>
                                @php
                                    $statusMap = [
                                        'kembali_ke_kelas' => ['label' => 'Kembali ke Kelas', 'color' => 'bg-emerald-100 text-emerald-800 border-emerald-300'],
                                        'istirahat_di_uks' => ['label' => 'Istirahat di UKS', 'color' => 'bg-amber-100 text-amber-800 border-amber-300'],
                                        'pulang' => ['label' => 'Diizinkan Pulang', 'color' => 'bg-orange-100 text-orange-800 border-orange-300'],
                                        'rujuk_rs' => ['label' => 'Rujuk ke RS / Puskesmas', 'color' => 'bg-rose-100 text-rose-800 border-rose-300'],
                                    ];
                                    $statusInfo = $statusMap[$record->status_penanganan] ?? ['label' => $record->status_penanganan ?? '-', 'color' => 'bg-slate-100 text-slate-800 border-slate-300'];
                                @endphp
                                <span class="inline-block px-4 py-2 rounded-2xl font-extrabold text-xs border {{ $statusInfo['color'] }}">
                                    {{ $statusInfo['label'] }}
                                </span>
                            </div>
                        </div>

                        <div class="border-t border-slate-100 pt-5 mt-6">
                            <div class="bg-indigo-50 border border-indigo-200 rounded-2xl p-4 space-y-1">
                                <div class="flex items-center gap-2 text-xs">
                                    <span>✅</span>
                                    <span class="font-semibold text-indigo-800">
                                        Tindakan ini diselesaikan oleh: <strong class="font-extrabold text-indigo-950">{{ $record->admin->name ?? 'Sistem' }}</strong>
                                    </span>
                                </div>
                                <div class="text-[11px] font-medium text-indigo-600 pl-6">
                                    pada {{ $record->updated_at ? $record->updated_at->format('d M Y, H:i') : '-' }} WIB
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-16 text-center space-y-3">
                            <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-bold text-slate-700">Belum Ada Tindakan Medis</p>
                            <p class="text-xs text-slate-400 max-w-xs">Petugas UKS belum mencatat tindakan medis untuk skrining ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
