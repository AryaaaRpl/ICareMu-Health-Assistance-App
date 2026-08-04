<x-app-layout>
    <div class="space-y-8 max-w-7xl mx-auto">
        <!-- Header Banner -->
        <div class="relative overflow-hidden bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl border border-slate-800">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-1">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 text-xs font-bold uppercase tracking-wider">
                        <span>🩺</span> UKS Triage & Medical Response
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Detail Skrining & Tindakan UKS</h1>
                    <p class="text-slate-300 text-xs sm:text-sm">
                        Kelola data skrining kesehatan siswa dan simpan catatan penanganan medis secara real-time.
                    </p>
                </div>
                <div>
                    <a href="{{ route('dashboard.uks') }}"
                        class="px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs shadow-md transition-all inline-flex items-center gap-2 border border-white/10 backdrop-blur-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Dashboard UKS
                    </a>
                </div>
            </div>
        </div>

        <!-- 2 Columns Grid: Left (Student & Triage Info) | Right (Form Tindakan UKS) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Column: Student Info & Triage Details -->
            <div class="lg:col-span-5 space-y-6">
                <!-- Card 1: Student Information -->
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-4">
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-extrabold text-lg">
                            {{ strtoupper(substr($skrining->siswa->name ?? $skrining->siswa->nama_lengkap ?? 'S', 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="text-base font-extrabold text-slate-900">
                                {{ $skrining->siswa->nama_lengkap ?? $skrining->siswa->name ?? 'Siswa #'.$skrining->siswa_id }}
                            </h3>
                            <p class="text-xs font-semibold text-slate-400">
                                Kelas: <span class="text-slate-700 font-bold">{{ $skrining->siswa->kelas ?? '-' }}</span> | NISN: <span class="text-slate-700 font-bold">{{ $skrining->siswa->nisn ?? '-' }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-1">
                        <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-100">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block">Suhu Tubuh</span>
                            <span class="text-lg font-extrabold text-slate-900">
                                {{ number_format((float) $skrining->suhu_tubuh, 1) }} °C
                            </span>
                        </div>
                        <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-100">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block">Waktu Skrining</span>
                            <span class="text-xs font-bold text-slate-800">
                                {{ $skrining->created_at ? $skrining->created_at->format('d M Y, H:i') : '-' }} WIB
                            </span>
                        </div>
                    </div>

                    <!-- Symptoms -->
                    <div class="space-y-1.5 pt-2">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-slate-400">Gejala Yang Dirasakan</span>
                        <div class="flex flex-wrap gap-2">
                            @php
                                $gejalaList = is_array($skrining->gejala) ? $skrining->gejala : json_decode($skrining->gejala ?? '[]', true);
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

                    <!-- Additional Complaints -->
                    <div class="space-y-1 pt-2">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-slate-400">Keluhan Tambahan</span>
                        <p class="text-xs font-medium text-slate-700 bg-slate-50 p-3.5 rounded-2xl border border-slate-100 leading-relaxed">
                            {{ $skrining->keluhan_tambahan ?: 'Tidak ada keluhan tambahan.' }}
                        </p>
                    </div>
                </div>

                <!-- Card 2: AI Triage Status & Recommendation -->
                <div class="bg-gradient-to-br from-slate-900 to-indigo-950 rounded-3xl p-6 text-white shadow-md border border-slate-800 space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                        <div class="flex items-center gap-2">
                            <span class="text-base">🤖</span>
                            <h4 class="text-xs font-extrabold uppercase tracking-wider text-indigo-300">Hasil Triage AI Assistant</h4>
                        </div>
                        <div>
                            @if($skrining->ai_status === 'sehat')
                                <span class="px-3 py-1 rounded-full font-extrabold text-[10px] uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                    Sehat
                                </span>
                            @elseif($skrining->ai_status === 'pulang')
                                <span class="px-3 py-1 rounded-full font-extrabold text-[10px] uppercase tracking-wider bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                    Pulang
                                </span>
                            @elseif(in_array($skrining->ai_status, ['observasi_uks', 'darurat']))
                                <span class="px-3 py-1 rounded-full font-extrabold text-[10px] uppercase tracking-wider bg-rose-500/20 text-rose-300 border border-rose-500/30 animate-pulse">
                                    🚨 {{ strtoupper(str_replace('_', ' ', $skrining->ai_status)) }}
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full font-bold text-[10px] uppercase tracking-wider bg-white/10 text-slate-300 border border-white/10">
                                    Menunggu Analisis AI
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-2">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Rekomendasi Penanganan AI</span>
                        <p class="text-xs leading-relaxed text-slate-200 bg-white/5 p-3.5 rounded-2xl border border-white/10">
                            {{ $skrining->ai_recommendation ?: 'Belum ada rekomendasi AI khusus. Lakukan evaluasi gejala secara langsung oleh petugas UKS.' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Form Tindakan UKS -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-6">
                    <div class="border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Form Tindakan Medis UKS</h3>
                        <p class="text-xs text-slate-400 font-medium">Catat pertolongan pertama dan keputusan status akhir kesehatan siswa</p>
                    </div>

                    @if(session('success'))
                        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-2xl flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('skrining.tindakan.update', $skrining->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Tindakan UKS Textarea -->
                        <div class="space-y-2">
                            <label for="tindakan_uks" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700">
                                Tindakan Medis / Pertolongan Pertama <span class="text-rose-500">*</span>
                            </label>
                            <textarea id="tindakan_uks" name="tindakan_uks" rows="4" required
                                placeholder="Contoh: Kompres air hangat pada dahi, kompres es luka memar, observasi 30 menit di tempat tidur UKS..."
                                class="w-full rounded-2xl border-slate-200 bg-slate-50 py-3.5 px-4 text-xs font-medium text-slate-900 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 transition-all">{{ old('tindakan_uks', $skrining->tindakan_uks) }}</textarea>
                            @error('tindakan_uks')
                                <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Obat Diberikan Dropdown (TomSelect UI with Z-Index Stacking Fix) -->
                        <div class="space-y-2 relative z-50">
                            <label for="inventaris_id" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700">
                                Obat Yang Diberikan <span class="text-slate-400 font-normal">(Pilih satu atau lebih, otomatis mengurangi stok)</span>
                            </label>

                            @if($skrining->obat_diberikan)
                                <div class="mb-2 text-xs font-semibold text-emerald-600 bg-emerald-50 border border-emerald-200 rounded-xl p-2.5 flex items-center gap-2">
                                    <span>💊</span>
                                    <span><strong>Obat Terdaftar Sebelumnya:</strong> {{ $skrining->obat_diberikan }}</span>
                                </div>
                            @endif

                            <select id="inventaris_id" name="inventaris_id[]" multiple placeholder="Cari & pilih obat..." autocomplete="off" class="w-full">
                                @forelse($obat ?? [] as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->nama_barang }} (Stok: {{ $item->stok }} {{ $item->satuan ?? 'pcs' }})
                                    </option>
                                @empty
                                @endforelse
                            </select>

                            @error('inventaris_id')
                                <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status Akhir Dropdown -->
                        <div class="space-y-2 relative z-10">
                            <label for="status_akhir" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700">
                                Status Akhir Siswa <span class="text-rose-500">*</span>
                            </label>
                            <select id="status_akhir" name="status_akhir" required
                                class="w-full rounded-2xl border-slate-200 bg-slate-50 py-3.5 px-4 text-xs font-bold text-slate-900 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 transition-all">
                                <option value="" disabled @selected(!old('status_akhir', $skrining->status_akhir))>-- Pilih Keputusan Status Akhir --</option>
                                <option value="kembali_ke_kelas" @selected(old('status_akhir', $skrining->status_akhir) === 'kembali_ke_kelas')>🟢 Kembali ke Kelas</option>
                                <option value="istirahat_di_uks" @selected(old('status_akhir', $skrining->status_akhir) === 'istirahat_di_uks')>🟡 Istirahat di UKS</option>
                                <option value="pulang" @selected(old('status_akhir', $skrining->status_akhir) === 'pulang')>🟠 Diizinkan Pulang (Dijemput Wali)</option>
                                <option value="rujuk_rs" @selected(old('status_akhir', $skrining->status_akhir) === 'rujuk_rs')>🔴 Rujuk ke RS / Puskesmas</option>
                            </select>
                            @error('status_akhir')
                                <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4 relative z-0">
                            <button type="submit"
                                class="w-full py-4 bg-gradient-to-r from-indigo-600 via-blue-600 to-indigo-700 hover:from-indigo-700 hover:to-blue-800 text-white font-extrabold text-xs sm:text-sm rounded-2xl shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Simpan Tindakan & Perbarui Rekam Medis</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- TomSelect Styles & Script Injection -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <style>
        .ts-wrapper {
            position: relative;
            z-index: 9999 !important;
        }
        .ts-control {
            border-radius: 1rem !important;
            padding: 0.75rem 1rem !important;
            background-color: #f8fafc !important;
            border-color: #e2e8f0 !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
        }
        .ts-control.focus {
            background-color: #ffffff !important;
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15) !important;
        }
        .ts-dropdown {
            border-radius: 1rem !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
            border: 1px solid #e2e8f0 !important;
            font-size: 0.75rem !important;
            overflow: hidden !important;
            z-index: 99999 !important;
            background-color: #ffffff !important;
        }
        .ts-wrapper.multi .ts-control > div {
            border-radius: 0.5rem !important;
            background: #e0e7ff !important;
            color: #3730a3 !important;
            font-weight: 700 !important;
            padding: 2px 8px !important;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectEl = document.getElementById('inventaris_id');
            if (selectEl) {
                new TomSelect('#inventaris_id', {
                    plugins: ['remove_button'],
                    maxOptions: 50,
                    create: false,
                    dropdownParent: 'body',
                    placeholder: '🔍 Cari & pilih obat...',
                    noResultsText: 'Obat tidak ditemukan',
                });
            }
        });
    </script>
</x-app-layout>
