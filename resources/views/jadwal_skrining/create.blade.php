@extends('layouts.app')

@section('title', 'Buat Jadwal Skrining - iCareMu')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('jadwal_skrining.index') }}" class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-colors">
            <i class="ph-bold ph-arrow-left text-lg"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight mb-1">Buat Jadwal Skrining</h1>
            <p class="text-sm text-gray-500 font-medium">Tambahkan jadwal pemeriksaan kesehatan baru</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('jadwal_skrining.store') }}" method="POST">
            @csrf

            @if(auth()->user()->role === 'admin_super')
            <div class="mb-6">
                <label for="sekolah_id" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Sekolah</label>
                <select name="sekolah_id" id="sekolah_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-gray-700 bg-gray-50" required>
                    <option value="">-- Pilih Sekolah --</option>
                    @foreach($sekolahs as $sekolah)
                        <option value="{{ $sekolah->id }}" {{ old('sekolah_id') == $sekolah->id ? 'selected' : '' }}>
                            {{ $sekolah->nama_sekolah }} (NPSN: {{ $sekolah->npsn }})
                        </option>
                    @endforeach
                </select>
            </div>
            @endif

            <div class="mb-6">
                <label for="jenis_skrining" class="block text-sm font-semibold text-gray-700 mb-2">Jenis Skrining</label>
                <input type="text" name="jenis_skrining" id="jenis_skrining" value="{{ old('jenis_skrining') }}" placeholder="Contoh: Pemeriksaan Mata & THT" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-gray-700 bg-gray-50" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="tanggal_pelaksanaan" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Pelaksanaan</label>
                    <input type="date" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" value="{{ old('tanggal_pelaksanaan') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-gray-700 bg-gray-50" required>
                </div>
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select name="status" id="status" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-gray-700 bg-gray-50" required>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="berjalan" {{ old('status') == 'berjalan' ? 'selected' : '' }}>Berjalan</option>
                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
            </div>

            <div class="mb-8">
                <label for="lokasi" class="block text-sm font-semibold text-gray-700 mb-2">Lokasi</label>
                <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" placeholder="Contoh: Ruang UKS Utama" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-gray-700 bg-gray-50" required>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('jadwal_skrining.index') }}" class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition-colors flex items-center gap-2">
                    <i class="ph-bold ph-floppy-disk"></i>
                    Simpan Jadwal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
