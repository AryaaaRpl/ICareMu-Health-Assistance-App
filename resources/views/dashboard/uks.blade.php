<x-app-layout>
    @php
        // Dummy data fallbacks if not passed from controller
        $kunjungans = $kunjungans ?? [
            [
                'waktu' => '08:15',
                'siswa' => 'Budi Santoso',
                'kelas' => 'X MIPA 1',
                'keluhan' => 'Demam Tinggi (38.5°C)',
                'status' => 'Istirahat di UKS',
                'status_color' => 'bg-amber-50 text-amber-600 border-amber-200',
            ],
            [
                'waktu' => '09:30',
                'siswa' => 'Siti Aminah',
                'kelas' => 'XII IPS 2',
                'keluhan' => 'Asam Lambung Naik',
                'status' => 'Diberi Obat',
                'status_color' => 'bg-amber-50 text-amber-600 border-amber-200',
            ],
            [
                'waktu' => '10:45',
                'siswa' => 'Ahmad Riski',
                'kelas' => 'XI MIPA 3',
                'keluhan' => 'Cedera Kaki (Basket)',
                'status' => 'Menunggu Orang Tua',
                'status_color' => 'bg-orange-50 text-orange-600 border-orange-200',
            ],
        ];

        $stoks = $stoks ?? [
            [
                'nama' => 'Paracetamol 500mg',
                'min' => 'MIN: 50',
                'jumlah' => 150,
                'satuan' => 'Tab',
                'status' => 'normal',
            ],
            [
                'nama' => 'Betadine',
                'min' => 'MIN: 10',
                'jumlah' => 5,
                'satuan' => 'Botol',
                'status' => 'warning',
            ],
            [
                'nama' => 'Kasa Steril',
                'min' => 'MIN: 20',
                'jumlah' => 45,
                'satuan' => 'Kotak',
                'status' => 'normal',
            ],
        ];
    @endphp

    <div class="space-y-8">
        <!-- Summary Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card 1: Jumlah Kunjungan UKS -->
            <div class="bg-white p-6 rounded-3xl border-l-4 border-blue-500 shadow-sm border-y border-r border-slate-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold tracking-wider text-slate-400 uppercase">JUMLAH KUNJUNGAN UKS</span>
                    <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-3xl font-extrabold text-slate-900">245</h3>
                    <p class="mt-1 text-xs font-semibold text-emerald-600 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7 7 7M12 3v18"></path>
                        </svg>
                        <span>12% dari bulan lalu</span>
                    </p>
                </div>
            </div>

            <!-- Card 2: Siswa Sakit Hari Ini -->
            <div class="bg-white p-6 rounded-3xl border-l-4 border-rose-400 shadow-sm border-y border-r border-slate-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold tracking-wider text-slate-400 uppercase">SISWA SAKIT HARI INI</span>
                    <div class="w-8 h-8 rounded-full bg-rose-50 flex items-center justify-center text-rose-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-3xl font-extrabold text-slate-900">12</h3>
                    <p class="mt-1 text-xs font-semibold text-rose-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7 7 7M12 3v18"></path>
                        </svg>
                        <span>4 siswa sedang dirawat</span>
                    </p>
                </div>
            </div>

            <!-- Card 3: Tingkat Kehadiran Sehat -->
            <div class="bg-white p-6 rounded-3xl border-l-4 border-emerald-500 shadow-sm border-y border-r border-slate-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold tracking-wider text-slate-400 uppercase">TINGKAT KEHADIRAN SEHAT</span>
                    <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-3xl font-extrabold text-slate-900">96.8%</h3>
                    <p class="mt-1 text-xs font-semibold text-emerald-600 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7 7 7M12 3v18"></path>
                        </svg>
                        <span>0.5% dari minggu lalu</span>
                    </p>
                </div>
            </div>

            <!-- Card 4: Tren Kesehatan Index -->
            <div class="bg-white p-6 rounded-3xl border-l-4 border-indigo-500 shadow-sm border-y border-r border-slate-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold tracking-wider text-slate-400 uppercase">TREN KESEHATAN INDEX</span>
                    <div class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-3xl font-extrabold text-slate-900">84<span class="text-xl text-slate-400 font-semibold">/100</span></h3>
                    <p class="mt-1 text-xs font-semibold text-emerald-600 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Kondisi sekolah optimal</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Charts Placeholder Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Line Chart Placeholder -->
            <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between h-72">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    <h4 class="text-xs font-bold tracking-wider text-slate-800 uppercase">TREN KUNJUNGAN UKS BULANAN</h4>
                </div>
                <div class="flex-1 my-4 bg-slate-50 border border-dashed border-slate-200 rounded-2xl flex items-center justify-center text-slate-400 text-sm font-medium">
                    [ Tren Kunjungan Line Chart Placeholder ]
                </div>
            </div>

            <!-- Donut Chart Placeholder -->
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between h-72">
                <h4 class="text-xs font-bold tracking-wider text-slate-800 uppercase">PROPORSI PENYAKIT</h4>
                <div class="flex-1 my-4 bg-slate-50 border border-dashed border-slate-200 rounded-2xl flex items-center justify-center text-slate-400 text-sm font-medium">
                    [ Proporsi Penyakit Pie Chart Placeholder ]
                </div>
            </div>
        </div>

        <!-- Bottom Tables Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Siswa di UKS Saat Ini Table (2 Columns) -->
            <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <h4 class="text-xs font-bold tracking-wider text-slate-800 uppercase">SISWA DI UKS SAAT INI</h4>
                    </div>
                    <span class="px-3 py-1 bg-rose-50 border border-rose-200 rounded-full text-xs font-semibold text-rose-600">
                        3 Siswa Dirawat
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-[11px] font-bold tracking-wider text-slate-400 uppercase">
                                <th class="pb-3">WAKTU</th>
                                <th class="pb-3">SISWA</th>
                                <th class="pb-3">KELUHAN</th>
                                <th class="pb-3">STATUS PENANGANAN</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-sm">
                            @foreach($kunjungans as $kunjungan)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="py-4 font-semibold text-slate-400 text-xs">
                                        {{ $kunjungan['waktu'] }}
                                    </td>
                                    <td class="py-4">
                                        <div class="font-bold text-slate-900">{{ $kunjungan['siswa'] }}</div>
                                        <div class="text-xs text-slate-400 font-medium">{{ $kunjungan['kelas'] }}</div>
                                    </td>
                                    <td class="py-4 font-bold text-rose-500 text-xs">
                                        {{ $kunjungan['keluhan'] }}
                                    </td>
                                    <td class="py-4">
                                        <span class="px-3 py-1.5 inline-block text-xs font-semibold rounded-lg border {{ $kunjungan['status_color'] ?? 'bg-amber-50 text-amber-600 border-amber-200' }}">
                                            {{ $kunjungan['status'] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Peringatan Stok Widget (1 Column) -->
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between space-y-6">
                <div>
                    <div class="flex items-center gap-2 mb-6">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <h4 class="text-xs font-bold tracking-wider text-slate-800 uppercase">PERINGATAN STOK</h4>
                    </div>

                    <div class="space-y-4">
                        @foreach($stoks as $stok)
                            <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50/70 border border-slate-100 hover:bg-slate-50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl {{ ($stok['status'] ?? '') === 'warning' ? 'bg-rose-50 text-rose-500' : 'bg-slate-200/60 text-slate-500' }} flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.59 15.11a2 2 0 01-1.022-.547l-1.07-1.07a2 2 0 010-2.828l8.586-8.586a2 2 0 012.828 0l8.586 8.586a2 2 0 010 2.828l-1.07 1.07z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900 text-sm">{{ $stok['nama'] }}</div>
                                        <div class="text-[11px] font-semibold text-slate-400">{{ $stok['min'] }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-base font-extrabold {{ ($stok['status'] ?? '') === 'warning' ? 'text-rose-500' : 'text-slate-800' }}">
                                        {{ $stok['jumlah'] }}
                                    </span>
                                    <span class="text-xs font-semibold text-slate-400 ms-0.5">{{ $stok['satuan'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button class="w-full py-3 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-bold rounded-2xl border border-slate-200 transition-all text-center">
                    Buka Modul Inventaris
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
