<x-app-layout>
    @php
        $skriningRecords = $skriningRecords ?? collect();
        $searchFilter = request('search', '');
        $kelasFilter = request('kelas', '');
    @endphp

    <div x-data="{ openModal: false }" class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Smart School Screening</h1>
                <p class="text-sm text-slate-500 mt-1">Monitoring hasil skrining kesehatan siswa</p>
            </div>
            <div class="flex items-center gap-3">
                <button @click="openModal = true"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:scale-[0.97] text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/25 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Input Hasil Skrining
                </button>
                <div class="flex items-center gap-3 text-sm text-slate-500">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="font-medium">{{ count($skriningRecords) }} record</span>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-700 text-sm font-medium flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Filter Card -->
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <form method="GET" action="{{ route('skrining.index') }}" class="flex flex-col sm:flex-row items-end gap-4">
                <div class="flex-1 w-full sm:w-auto space-y-1.5">
                    <label for="search" class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Cari Siswa</label>
                    <input type="text" id="search" name="search" value="{{ $searchFilter }}" placeholder="Cari Nama Siswa..."
                        class="w-full rounded-lg border border-slate-300 bg-white py-2.5 px-3.5 text-sm text-slate-900 placeholder-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                </div>
                <div class="w-full sm:w-48 space-y-1.5">
                    <label for="kelas" class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Kelas</label>
                    <select name="kelas" id="kelas"
                        class="w-full rounded-lg border border-slate-300 bg-white py-2.5 px-3.5 text-sm text-slate-900 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                        <option value="">Pilih Kelas</option>
                        <option value="10" @selected($kelasFilter == '10')>Kelas 10</option>
                        <option value="11" @selected($kelasFilter == '11')>Kelas 11</option>
                        <option value="12" @selected($kelasFilter == '12')>Kelas 12</option>
                    </select>
                </div>
                <button type="submit"
                    class="w-full sm:w-auto px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg transition-all flex items-center justify-center gap-2 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Filter
                </button>
                @if($searchFilter || $kelasFilter)
                    <a href="{{ route('skrining.index') }}" class="text-sm font-medium text-slate-400 hover:text-slate-600 transition shrink-0">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50/50">
                            <th class="py-3.5 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider w-12 text-center">No</th>
                            <th class="py-3.5 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Siswa</th>
                            <th class="py-3.5 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kelas</th>
                            <th class="py-3.5 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Jenis Skrining</th>
                            <th class="py-3.5 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                            <th class="py-3.5 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Hasil</th>
                            <th class="py-3.5 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($skriningRecords as $index => $record)
                            @php
                                $siswaName = $record->siswa ? ($record->siswa->nama_lengkap ?? $record->siswa->name ?? 'Siswa #'.$record->siswa_id) : 'Siswa #'.$record->siswa_id;
                                $kelas = $record->siswa->kelas ?? '-';
                                $jenisSkrining = $record->jenis_skrining ?? 'Skrining Harian UKS';
                                $tanggal = $record->created_at ? $record->created_at->format('d M Y, H:i') : '-';
                                $status = $record->status_akhir ?? $record->ai_status ?? 'Menunggu';
                            @endphp
                            <tr class="hover:bg-slate-50 transition-all">
                                <td class="py-4 px-4 text-center text-sm font-medium text-slate-400">{{ $index + 1 }}</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs shrink-0">
                                            {{ strtoupper(substr($siswaName, 0, 1)) }}
                                        </div>
                                        <div>
                                            <span class="text-sm font-semibold text-slate-900 block">{{ $siswaName }}</span>
                                            <span class="text-xs text-slate-400">{{ number_format((float)$record->suhu_tubuh, 1) }}°C</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="text-sm font-medium text-slate-700">{{ $kelas }}</span>
                                </td>
                                <td class="py-4 px-4 text-sm text-slate-700">{{ $jenisSkrining }}</td>
                                <td class="py-4 px-4 text-sm text-slate-500 whitespace-nowrap">{{ $tanggal }}</td>
                                <td class="py-4 px-4 text-center">
                                    @if(in_array($status, ['kembali_ke_kelas', 'sehat']))
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700">Kembali ke Kelas</span>
                                    @elseif(in_array($status, ['istirahat_di_uks', 'observasi_uks']))
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-semibold bg-amber-50 text-amber-700">Istirahat di UKS</span>
                                    @elseif(in_array($status, ['pulang']))
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-semibold bg-orange-50 text-orange-700">Diizinkan Pulang</span>
                                    @elseif(in_array($status, ['rujuk_rs', 'darurat']))
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-semibold bg-rose-50 text-rose-700">Rujuk RS</span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-600">Menunggu</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <a href="{{ route('skrining.show', $record->id) }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-16 text-center">
                                    <div class="max-w-xs mx-auto space-y-2">
                                        <p class="text-3xl text-slate-300">---</p>
                                        <p class="text-sm font-semibold text-slate-700">Belum ada data skrining</p>
                                        <p class="text-xs text-slate-400">Belum ada hasil skrining siswa yang tercatat.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $skriningRecords->withQueryString()->links() }}
        </div>

        <!-- Alpine.js Modal (Input Hasil Skrining) -->
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
                 class="bg-white rounded-2xl border border-slate-100 shadow-2xl w-full max-w-lg overflow-hidden">

                <!-- Modal Header -->
                <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Input Hasil Skrining</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Catat hasil skrining kesehatan siswa.</p>
                    </div>
                    <button @click="openModal = false"
                        class="p-2 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition duration-150">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Form -->
                <form action="{{ route('skrining.peserta.store') }}" method="POST" class="p-6 space-y-5">
                    @csrf

                    <!-- Select Siswa -->
                    <div>
                        <label for="siswa_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Pilih Siswa <span class="text-rose-500">*</span>
                        </label>
                        <select name="siswa_id" id="siswa_id" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition duration-150">
                            <option value="">— Pilih Siswa —</option>
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->id }}">{{ $siswa->name ?? $siswa->nama_lengkap ?? 'Siswa #'.$siswa->id }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Select Jadwal Skrining -->
                    <div>
                        <label for="jadwal_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Jadwal Skrining <span class="text-rose-500">*</span>
                        </label>
                        <select name="jadwal_id" id="jadwal_id" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition duration-150">
                            <option value="">— Pilih Jadwal —</option>
                            @foreach($jadwals as $jadwal)
                                <option value="{{ $jadwal->id }}">
                                    {{ $jadwal->nama_kegiatan ?? $jadwal->jenis_skrining ?? 'Skrining' }}
                                    ({{ $jadwal->tanggal_pelaksanaan ?? $jadwal->tanggal ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Kehadiran (Radio) -->
                    <div>
                        <span class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">
                            Status Kehadiran <span class="text-rose-500">*</span>
                        </span>
                        <div class="flex items-center gap-6">
                            <label class="inline-flex items-center gap-2.5 cursor-pointer group">
                                <input type="radio" name="status_kehadiran" value="Hadir" checked
                                    class="w-4 h-4 border-slate-300 text-indigo-600 focus:ring-indigo-500/20 transition">
                                <span class="text-sm font-medium text-slate-700 group-hover:text-slate-900 transition">Hadir</span>
                            </label>
                            <label class="inline-flex items-center gap-2.5 cursor-pointer group">
                                <input type="radio" name="status_kehadiran" value="Tidak Hadir"
                                    class="w-4 h-4 border-slate-300 text-indigo-600 focus:ring-indigo-500/20 transition">
                                <span class="text-sm font-medium text-slate-700 group-hover:text-slate-900 transition">Tidak Hadir</span>
                            </label>
                        </div>
                    </div>

                    <!-- Catatan Hasil Skrining (Textarea) -->
                    <div>
                        <label for="catatan_hasil" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Catatan Hasil Skrining
                        </label>
                        <textarea name="catatan_hasil" id="catatan_hasil" rows="4"
                            placeholder="Tulis catatan hasil skrining, keluhan, atau tindakan yang diberikan..."
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition duration-150 resize-none"></textarea>
                    </div>

                    <!-- Modal Actions -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" @click="openModal = false"
                            class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition duration-150">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-lg shadow-indigo-500/20 transition duration-150">
                            Simpan Data
                        </button>
                    </div>
                </form>

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
