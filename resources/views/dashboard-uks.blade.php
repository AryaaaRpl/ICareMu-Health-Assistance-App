<x-app-layout>
    <!-- Include Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <div class="space-y-8 max-w-7xl mx-auto">
        <!-- Dashboard Banner Header -->
        <div class="relative overflow-hidden bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl border border-slate-800">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 text-xs font-bold uppercase tracking-wider">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                        UKS Analytics Center Live
                    </div>
                    <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight">Dashboard Layanan UKS</h1>
                    <p class="text-slate-300 text-sm max-w-xl">
                        Monitor kesehatan siswa, tren penyakit, jadwal skrining medis, dan inventaris obat secara real-time.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row flex-wrap items-stretch sm:items-center gap-3">
                    <a href="{{ route('dashboard.export') }}" target="_blank" class="justify-center px-4 py-3 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs shadow-md transition-all flex items-center gap-2 border border-white/10 backdrop-blur-md">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export Laporan PDF
                    </a>
                    <a href="{{ route('rekam-medis.index') }}" class="justify-center px-4 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-lg transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Catat Rekam Medis
                    </a>
                    <a href="{{ route('ai.index') }}" class="justify-center px-4 py-3 rounded-2xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold text-xs shadow-lg transition-all flex items-center gap-2">
                        🤖 Asisten AI UKS
                    </a>
                </div>
            </div>
            <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
        </div>

        <!-- 1. Top Section (Stat Cards 4 Columns) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card 1: Total Siswa -->
            <div class="bg-white p-6 rounded-3xl border-l-4 border-indigo-500 shadow-sm border-y border-r border-slate-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-extrabold tracking-wider text-slate-400 uppercase">TOTAL SISWA TERDAFTAR</span>
                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-3xl font-extrabold text-slate-900">{{ number_format($totalSiswa ?? 0) }}</h3>
                    <p class="mt-1.5 text-xs font-semibold text-emerald-600 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7 7 7M12 3v18"/>
                        </svg>
                        <span>Siswa aktif sekolah</span>
                    </p>
                </div>
            </div>

            <!-- Card 2: Total Pemeriksaan Bulan Ini -->
            <div class="bg-white p-6 rounded-3xl border-l-4 border-emerald-500 shadow-sm border-y border-r border-slate-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-extrabold tracking-wider text-slate-400 uppercase">PEMERIKSAAN BULAN INI</span>
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-3xl font-extrabold text-slate-900">{{ number_format($totalPemeriksaan ?? 0) }}</h3>
                    <p class="mt-1.5 text-xs font-semibold text-emerald-600 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7 7 7M12 3v18"/>
                        </svg>
                        <span>Rekam medis tercatat</span>
                    </p>
                </div>
            </div>

            <!-- Card 3: Peringatan Stok Rendah / Rusak -->
            <div class="bg-white p-6 rounded-3xl border-l-4 border-rose-500 shadow-sm border-y border-r border-slate-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-extrabold tracking-wider text-slate-400 uppercase">PERINGATAN STOK / RUSAK</span>
                    <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-3xl font-extrabold text-rose-600">{{ number_format($stokRendah ?? 0) }}</h3>
                    <p class="mt-1.5 text-xs font-semibold text-rose-500 flex items-center gap-1">
                        <span>Perlu restok / perbaikan</span>
                    </p>
                </div>
            </div>

            <!-- Card 4: Jadwal Skrining -->
            <div class="bg-white p-6 rounded-3xl border-l-4 border-amber-500 shadow-sm border-y border-r border-slate-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-extrabold tracking-wider text-slate-400 uppercase">JADWAL SKRINING MEDIS</span>
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-3xl font-extrabold text-slate-900">{{ count($jadwalSkrining ?? []) }}</h3>
                    <p class="mt-1.5 text-xs font-semibold text-amber-600 flex items-center gap-1">
                        <span>Kegiatan mendatang</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- 1.5. Live Triage Monitor (Pemeriksaan Hari Ini) -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                        </span>
                        <h2 class="text-base font-extrabold text-slate-900 tracking-tight">Live Triage Monitor - Pemeriksaan Hari Ini</h2>
                    </div>
                    <p class="text-xs text-slate-400 font-medium mt-0.5">Pantau skrining kesehatan masuk secara real-time dan tingkat urgensi AI</p>
                </div>
                <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-bold self-start sm:self-auto">
                    Total Hari Ini: {{ count($skriningHariIni ?? []) }} Data
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                            <th class="py-3 px-3">Waktu</th>
                            <th class="py-3 px-3">Nama Siswa</th>
                            <th class="py-3 px-3">Suhu</th>
                            <th class="py-3 px-3">Gejala</th>
                            <th class="py-3 px-3">Status AI</th>
                            <th class="py-3 px-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs font-medium">
                        @forelse($skriningHariIni ?? [] as $row)
                            @php
                                $namaSiswa = $row->siswa ? ($row->siswa->nama_lengkap ?? $row->siswa->name ?? 'Siswa') : 'Siswa #'.$row->siswa_id;
                                $kelasSiswa = $row->siswa && isset($row->siswa->kelas) ? ' ('.$row->siswa->kelas.')' : '';
                                
                                $gejalaList = is_array($row->gejala) ? implode(', ', $row->gejala) : ($row->gejala ?? 'Tidak ada');
                                if (empty($gejalaList)) {
                                    $gejalaList = 'Tidak ada';
                                }
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3.5 px-3 font-semibold text-slate-500 whitespace-nowrap">
                                    {{ $row->created_at ? $row->created_at->format('H:i') : '-' }} WIB
                                </td>
                                <td class="py-3.5 px-3 font-bold text-slate-900">
                                    {{ $namaSiswa }}<span class="text-slate-400 font-medium">{{ $kelasSiswa }}</span>
                                </td>
                                <td class="py-3.5 px-3">
                                    <span class="font-extrabold px-2.5 py-1 rounded-xl bg-slate-100 text-slate-800 border border-slate-200">
                                        {{ number_format((float) $row->suhu_tubuh, 1) }} °C
                                    </span>
                                </td>
                                <td class="py-3.5 px-3 max-w-xs text-slate-700 font-semibold truncate" title="{{ $gejalaList }}">
                                    {{ Str::limit($gejalaList, 35) }}
                                </td>
                                <td class="py-3.5 px-3">
                                    @if($row->ai_status === 'sehat')
                                        <span class="px-3 py-1.5 rounded-full font-extrabold text-[11px] uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-300 inline-flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                            Sehat
                                        </span>
                                    @elseif($row->ai_status === 'pulang')
                                        <span class="px-3 py-1.5 rounded-full font-extrabold text-[11px] uppercase tracking-wider bg-amber-100 text-amber-800 border border-amber-300 inline-flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                            Pulang
                                        </span>
                                    @elseif($row->ai_status === 'observasi_uks')
                                        <span class="px-3 py-1.5 rounded-full font-extrabold text-[11px] uppercase tracking-wider bg-red-100 text-red-800 border border-red-300 animate-pulse inline-flex items-center gap-1.5 shadow-sm">
                                            <span class="w-2 h-2 rounded-full bg-red-600 animate-ping"></span>
                                            Observasi UKS
                                        </span>
                                    @elseif($row->ai_status === 'darurat')
                                        <span class="px-3 py-1.5 rounded-full font-extrabold text-[11px] uppercase tracking-wider bg-red-100 text-red-800 border border-red-400 animate-pulse inline-flex items-center gap-1.5 shadow-md">
                                            <span class="w-2.5 h-2.5 rounded-full bg-red-600 animate-ping"></span>
                                            🚨 Darurat
                                        </span>
                                    @else
                                        <span class="px-3 py-1.5 rounded-full font-bold text-[11px] uppercase tracking-wider bg-slate-100 text-slate-600 border border-slate-200">
                                            Menunggu AI
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-3 text-right">
                                    <a href="{{ route('skrining.show', $row->id) }}" class="px-3.5 py-1.5 bg-slate-900 hover:bg-indigo-600 text-white font-bold text-xs rounded-xl shadow transition-all inline-block">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-10 text-center">
                                    <div class="max-w-xs mx-auto space-y-2">
                                        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <p class="text-xs font-semibold text-slate-400">Belum ada data skrining masuk hari ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 2. Middle Section (Charts 2 Columns Grid) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Chart Left: Line Chart Kunjungan 7 Hari -->
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-indigo-600"></span>
                        <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Tren Kunjungan UKS (7 Hari Terakhir)</h2>
                    </div>
                    <span class="text-xs text-slate-400 font-semibold">Live Data</span>
                </div>
                <div class="h-64 relative">
                    <canvas id="lineChartKunjungan"></canvas>
                </div>
            </div>

            <!-- Chart Right: Doughnut Chart Top 5 Keluhan -->
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-purple-600"></span>
                        <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Top 5 Keluhan Siswa Terbanyak</h2>
                    </div>
                    <span class="text-xs text-slate-400 font-semibold">Persentase</span>
                </div>
                <div class="h-64 relative flex items-center justify-center">
                    <canvas id="doughnutChartKeluhan"></canvas>
                </div>
            </div>
        </div>

        <!-- 3. Bottom Section: Upcoming Jadwal Skrining & Recent Rekam Medis Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Table 1: Upcoming Jadwal Skrining -->
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Jadwal Skrining Mendatang</h2>
                    <a href="{{ route('skrining.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700">Lihat Semua →</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                                <th class="pb-2">Kegiatan</th>
                                <th class="pb-2">Jenis</th>
                                <th class="pb-2">Tanggal</th>
                                <th class="pb-2">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-xs">
                            @forelse($jadwalSkrining as $jadwal)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-3 font-bold text-slate-900">
                                        {{ $jadwal->nama_kegiatan ?? 'Skrining Kesehatan' }}
                                    </td>
                                    <td class="py-3 font-medium text-slate-600">
                                        <span class="px-2 py-0.5 rounded-md bg-indigo-50 text-indigo-600 font-bold">
                                            {{ $jadwal->jenis_skrining ?? 'Umum' }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-slate-500 font-medium">
                                        {{ $jadwal->tanggal_pelaksanaan ?? $jadwal->tanggal ?? '-' }}
                                    </td>
                                    <td class="py-3">
                                        <span class="px-2.5 py-1 rounded-full font-bold text-[10px] uppercase tracking-wider bg-emerald-50 text-emerald-600 border border-emerald-200">
                                            {{ $jadwal->status ?? 'Terjadwal' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-slate-400 font-medium">Belum ada jadwal skrining.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Table 2: Recent Rekam Medis -->
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Rekam Medis Terkini</h2>
                    <a href="{{ route('rekam-medis.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700">Lihat Semua →</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                                <th class="pb-2">Siswa</th>
                                <th class="pb-2">Keluhan</th>
                                <th class="pb-2">Suhu</th>
                                <th class="pb-2">Penanganan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-xs">
                            @forelse($kunjungans as $kunjungan)
                                @php
                                    $namaSiswa = $kunjungan->siswa ? ($kunjungan->siswa->name ?? $kunjungan->siswa->nama_lengkap ?? 'Siswa') : 'Siswa #'.$kunjungan->siswa_id;
                                @endphp
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-3 font-bold text-slate-900">{{ $namaSiswa }}</td>
                                    <td class="py-3 text-rose-500 font-semibold">{{ Str::limit($kunjungan->keluhan_utama ?? 'Demam', 25) }}</td>
                                    <td class="py-3 font-medium text-slate-700">{{ $kunjungan->suhu ?? 36.5 }} °C</td>
                                    <td class="py-3 font-medium text-slate-500">{{ $kunjungan->status_penanganan ?? $kunjungan->status ?? 'Istirahat' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-slate-400 font-medium">Belum ada rekam medis recorded.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Initialization Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dataKunjungan = @json($grafikKunjungan);
            const dataKeluhan = @json($grafikKeluhan);

            // 1. Line Chart Kunjungan UKS
            const ctxLine = document.getElementById('lineChartKunjungan').getContext('2d');
            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: dataKunjungan.labels || [],
                    datasets: [{
                        label: 'Jumlah Kunjungan',
                        data: dataKunjungan.data || [],
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointBackgroundColor: '#4f46e5',
                        pointRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    }
                }
            });

            // 2. Doughnut Chart Keluhan Siswa
            const ctxDoughnut = document.getElementById('doughnutChartKeluhan').getContext('2d');
            new Chart(ctxDoughnut, {
                type: 'doughnut',
                data: {
                    labels: dataKeluhan.labels || [],
                    datasets: [{
                        data: dataKeluhan.data || [],
                        backgroundColor: [
                            '#4f46e5',
                            '#9333ea',
                            '#f43f5e',
                            '#f59e0b',
                            '#10b981'
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                font: { size: 11 }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
