<x-app.layout active="school-screening" title="Buat Jadwal Skrining — iCareMu">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="font-heading text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Buat Jadwal Baru</h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">Tambahkan jadwal pemeriksaan skrining kesehatan baru</p>
        </div>
        <a href="{{ route('jadwal_skrining.index') }}" class="px-5 py-2.5 rounded-2xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold text-sm transition-all flex items-center gap-2">
            <span>➔ Kembali</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-200/60">
        @if ($errors->any())
            <div class="mb-6 bg-red-50 text-red-600 p-4 rounded-2xl text-sm border border-red-100">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('jadwal_skrining.store') }}" method="POST" class="space-y-6 max-w-2xl">
            @csrf

            <!-- Jenis Skrining -->
            <div class="space-y-2">
                <label for="jenis_skrining" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Jenis Skrining</label>
                <input type="text" name="jenis_skrining" id="jenis_skrining" value="{{ old('jenis_skrining') }}" required placeholder="Contoh: Pemeriksaan Mata & THT" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-[#186EF9] transition-colors">
            </div>

            <!-- Tanggal Pelaksanaan -->
            <div class="space-y-2">
                <label for="tanggal_pelaksanaan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Tanggal Pelaksanaan</label>
                <input type="date" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" value="{{ old('tanggal_pelaksanaan') }}" required class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-[#186EF9] transition-colors">
            </div>

            <!-- Lokasi -->
            <div class="space-y-2">
                <label for="lokasi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Lokasi</label>
                <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" required placeholder="Contoh: Ruang UKS Utama" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-[#186EF9] transition-colors">
            </div>

            <!-- Status -->
            <div class="space-y-2">
                <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Status</label>
                <select name="status" id="status" required class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-[#186EF9] transition-colors">
                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="berjalan" {{ old('status') == 'berjalan' ? 'selected' : '' }}>Berjalan</option>
                    <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <!-- Sekolah ID (Hanya untuk Admin Super) -->
            @if(auth()->user()->role === 'admin_super')
            <div class="space-y-2">
                <label for="sekolah_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Sekolah</label>
                <select name="sekolah_id" id="sekolah_id" required class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-[#186EF9] transition-colors">
                    <option value="">-- Pilih Sekolah --</option>
                    @foreach($sekolahs as $sekolah)
                        <option value="{{ $sekolah->id }}" {{ old('sekolah_id') == $sekolah->id ? 'selected' : '' }}>{{ $sekolah->nama_sekolah }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            <div class="pt-4">
                <button type="submit" class="px-8 py-3 rounded-2xl bg-[#186EF9] hover:bg-blue-600 text-white font-bold text-sm shadow-lg shadow-blue-500/20 transition-all">
                    Simpan Jadwal
                </button>
            </div>
        </form>
    </div>
</x-app.layout>
