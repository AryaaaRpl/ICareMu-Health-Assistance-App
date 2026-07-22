<x-app.layout active="school-screening" title="Smart School Screening — iCareMu">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-heading text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Smart School Screening</h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">Manajemen Jadwal dan Hasil Pemeriksaan Berkala</p>
        </div>

        <a href="{{ route('jadwal_skrining.create') }}" class="px-6 py-2.5 rounded-2xl bg-[#186EF9] hover:bg-blue-600 text-white font-semibold text-sm shadow-lg shadow-blue-500/20 transition-all flex items-center gap-2 inline-block">
            <span>+ Buat Jadwal Skrining</span>
        </a>
    </div>

    <!-- 3 Metrics Top Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white rounded-3xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#186EF9] flex items-center justify-center font-bold text-xl shrink-0">📅</div>
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 font-heading">JADWAL BULAN INI</div>
                <div class="text-2xl font-extrabold text-slate-900 font-heading">4</div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#00A86B] flex items-center justify-center font-bold text-xl shrink-0">👥</div>
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 font-heading">SISWA DIPERIKSA</div>
                <div class="text-2xl font-extrabold text-slate-900 font-heading">128</div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center font-bold text-xl shrink-0">☑</div>
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 font-heading">SKRINING SELESAI</div>
                <div class="text-2xl font-extrabold text-slate-900 font-heading">3</div>
            </div>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60 space-y-6">
        <h3 class="font-heading font-bold text-slate-900 text-lg">Daftar Jadwal Skrining</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-400 font-bold uppercase border-b border-slate-100">
                        <th class="py-3">JENIS SKRINING</th>
                        <th class="py-3">TANGGAL PELAKSANAAN</th>
                        <th class="py-3">LOKASI</th>
                        <th class="py-3">STATUS</th>
                        <th class="py-3 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @forelse($jadwal_skrining as $item)
                    <tr>
                        <td class="py-4 font-bold text-slate-900">{{ $item->jenis_skrining }}</td>
                        <td class="py-4 text-slate-500">🕒 {{ \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->translatedFormat('d F Y') }}</td>
                        <td class="py-4 text-slate-500">📍 {{ $item->lokasi }}</td>
                        <td class="py-4">
                            @if($item->status == 'pending')
                            <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-[10px] font-bold">PENDING</span>
                            @elseif($item->status == 'berjalan')
                            <span class="px-3 py-1 rounded-full bg-blue-100 text-[#186EF9] text-[10px] font-bold">BERJALAN</span>
                            @else
                            <span class="px-3 py-1 rounded-full bg-emerald-100 text-[#00A86B] text-[10px] font-bold">SELESAI</span>
                            @endif
                        </td>
                        <td class="py-4 text-right">
                            <a href="{{ route('jadwal_skrining.edit', $item->id) }}" class="px-4 py-1.5 rounded-xl bg-amber-50 text-amber-600 font-bold text-xs mr-2">Edit</a>
                            <form action="{{ route('jadwal_skrining.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-1.5 rounded-xl bg-red-50 text-red-600 font-bold text-xs hover:bg-red-100">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-500 text-sm">Belum ada jadwal skrining.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app.layout>
