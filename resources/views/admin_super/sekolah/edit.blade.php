@extends('layouts.app')

@section('title', 'Edit Sekolah - iCareMu')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin_super.sekolah.index') }}" class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
            <i class="ph-bold ph-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800 leading-tight">Edit Sekolah</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi detail sekolah.</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('admin_super.sekolah.update', $sekolah->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- NPSN -->
                <div>
                    <label for="npsn" class="block text-sm font-medium text-gray-700 mb-2">NPSN <span class="text-red-500">*</span></label>
                    <input type="text" id="npsn" name="npsn" value="{{ old('npsn', $sekolah->npsn) }}" required
                           class="w-full px-4 py-3 rounded-xl border {{ $errors->has('npsn') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-gray-200 focus:border-blue-500 focus:ring-blue-500/20' }} transition-colors outline-none focus:ring-4"
                           placeholder="Masukkan Nomor Pokok Sekolah Nasional">
                    @error('npsn')
                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                            <i class="ph-fill ph-warning-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Nama Sekolah -->
                <div>
                    <label for="nama_sekolah" class="block text-sm font-medium text-gray-700 mb-2">Nama Sekolah <span class="text-red-500">*</span></label>
                    <input type="text" id="nama_sekolah" name="nama_sekolah" value="{{ old('nama_sekolah', $sekolah->nama_sekolah) }}" required
                           class="w-full px-4 py-3 rounded-xl border {{ $errors->has('nama_sekolah') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-gray-200 focus:border-blue-500 focus:ring-blue-500/20' }} transition-colors outline-none focus:ring-4"
                           placeholder="Contoh: SMA Negeri 1 Jakarta">
                    @error('nama_sekolah')
                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                            <i class="ph-fill ph-warning-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-8 flex justify-end gap-3">
                <a href="{{ route('admin_super.sekolah.index') }}" class="px-6 py-3 rounded-xl text-gray-600 font-medium hover:bg-gray-100 transition-colors">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-8 rounded-xl transition-colors shadow-sm flex items-center gap-2">
                    <i class="ph-bold ph-floppy-disk"></i>
                    Perbarui Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
