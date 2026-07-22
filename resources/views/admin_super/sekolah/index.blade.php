@extends('layouts.app')

@section('title', 'Data Sekolah - iCareMu')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 leading-tight">Data Sekolah</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola data sekolah yang terdaftar di sistem iCareMu.</p>
        </div>
        
        <a href="{{ route('admin_super.sekolah.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-5 rounded-xl transition-colors flex items-center gap-2 shadow-sm">
            <i class="ph-bold ph-plus"></i>
            Tambah Sekolah
        </a>
    </div>

    <!-- Alert -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
        <i class="ph-fill ph-check-circle text-xl"></i>
        <p class="text-sm font-medium">{{ session('success') }}</p>
    </div>
    @endif

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">NPSN</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Sekolah</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($sekolahs as $index => $sekolah)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $sekolahs->firstItem() + $index }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $sekolah->npsn }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $sekolah->nama_sekolah }}</td>
                        <td class="px-6 py-4 text-sm text-center">
                            <div class="flex justify-center items-center gap-2">
                                <a href="{{ route('admin_super.sekolah.edit', $sekolah->id) }}" class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition-colors" title="Edit">
                                    <i class="ph-bold ph-pencil-simple text-lg"></i>
                                </a>
                                <form action="{{ route('admin_super.sekolah.destroy', $sekolah->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sekolah ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors" title="Hapus">
                                        <i class="ph-bold ph-trash text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500 text-sm">
                            Belum ada data sekolah.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $sekolahs->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
