<x-app-layout>
    <div class="max-w-5xl mx-auto space-y-8 py-8 px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-indigo-900 via-slate-900 to-indigo-900 rounded-3xl p-8 text-white shadow-xl border border-slate-800 relative overflow-hidden">
            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-indigo-200 border border-white/10 text-xs font-bold uppercase tracking-wider mb-4">
                    <span>🕒</span> Histori Kesehatan
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Riwayat Kunjungan UKS</h1>
                <p class="text-slate-300 mt-2 text-sm max-w-2xl">
                    Pantau terus catatan kesehatan, keluhan, dan tindakan medis yang pernah kamu terima selama berada di lingkungan sekolah.
                </p>
            </div>
            <!-- Dekorasi Background -->
            <div class="absolute -right-10 -top-10 w-64 h-64 bg-indigo-500/20 blur-3xl rounded-full"></div>
        </div>

        <!-- Timeline Section -->
        <div class="relative pt-4">
            <!-- Garis Vertikal Timeline -->
            <div class="absolute left-4 sm:left-1/2 top-4 bottom-0 w-1 bg-indigo-100 rounded-full transform sm:-translate-x-1/2"></div>

            <div class="space-y-12">
                @forelse($riwayatKunjungan as $index => $rekam)
                    <!-- Item Timeline -->
                    <div class="relative flex flex-col sm:flex-row items-start {{ $index % 2 == 0 ? 'sm:flex-row-reverse' : '' }} group">
                        
                        <!-- Dot Timeline Tengah -->
                        <div class="absolute left-4 sm:left-1/2 w-8 h-8 rounded-full bg-indigo-500 border-4 border-white shadow-md transform -translate-x-1/2 mt-1 z-10 group-hover:bg-indigo-600 transition-colors flex items-center justify-center">
                            <span class="w-2.5 h-2.5 bg-white rounded-full"></span>
                        </div>

                        <!-- Konten Card -->
                        <div class="w-full sm:w-[calc(50%-2rem)] pl-12 sm:pl-0 {{ $index % 2 == 0 ? 'sm:pr-12' : 'sm:pl-12' }}">
                            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-lg transition-all duration-300">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <span class="text-xs font-extrabold text-indigo-500 uppercase tracking-wider">
                                            {{ \Carbon\Carbon::parse($rekam->created_at)->translatedFormat('d F Y') }}
                                        </span>
                                        <h3 class="text-lg font-extrabold text-slate-900 mt-1 leading-tight">
                                            {{ $rekam->keluhan_utama ?? 'Pemeriksaan Rutin' }}
                                        </h3>
                                    </div>
                                    <span class="px-3 py-1 rounded-xl text-[10px] font-bold uppercase tracking-wider {{ $rekam->status == 'selesai' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ $rekam->status ?? 'Tercatat' }}
                                    </span>
                                </div>

                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 mb-4">
                                    <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1">Tindakan / Penanganan</span>
                                    <p class="text-sm font-medium text-slate-700 leading-relaxed">
                                        {{ $rekam->penanganan ?? 'Tidak ada tindakan khusus yang dicatat.' }}
                                    </p>
                                </div>

                                <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-100">
                                    <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                                        <span>👨‍⚕️</span> Ditangani oleh: 
                                        <span class="font-bold text-slate-800">{{ $rekam->admin->name ?? 'Petugas UKS' }}</span>
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-bold">
                                        {{ \Carbon\Carbon::parse($rekam->created_at)->format('H:i') }} WIB
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- State Kosong -->
                    <div class="flex flex-col items-center justify-center py-20 text-center relative z-10 bg-white rounded-3xl border border-slate-100 shadow-sm">
                        <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mb-4 border border-emerald-100">
                            <span class="text-3xl">🌿</span>
                        </div>
                        <h3 class="text-lg font-extrabold text-slate-900">Belum Ada Riwayat Sakit</h3>
                        <p class="text-sm text-slate-500 mt-2 max-w-sm font-medium">Alhamdulillah! Rekam medis kamu masih bersih. Tetap jaga kesehatan dan pola makan ya.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>