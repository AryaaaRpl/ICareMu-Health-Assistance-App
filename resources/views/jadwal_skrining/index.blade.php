@extends('layouts.app')

@section('title', 'Jadwal Skrining - iCareMu')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight mb-1">Smart School Screening</h1>
            <p class="text-sm text-gray-500 font-medium">Manajemen Jadwal dan Hasil Pemeriksaan Berkala</p>
        </div>
        <div>
            <a href="{{ route('jadwal_skrining.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition-colors flex items-center gap-2 shadow-sm inline-flex">
                <i class="ph-bold ph-plus"></i>
                Buat Jadwal Skrining
            </a>
        </div>
    </div>

    @if (session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 mb-8 flex items-center gap-3 shadow-sm">
        <i class="ph-fill ph-check-circle text-xl text-green-500"></i>
        <p class="text-sm font-medium">{{ session('success') }}</p>
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Card 1 -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between relative overflow-hidden">
            <div class="absolute right-0 top-1/2 -translate-y-1/2 w-24 h-24 bg-blue-50/50 rounded-full blur-2xl -mr-8"></div>
            <div class="flex items-center gap-5 relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <i class="ph ph-calendar-blank text-2xl"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-bold tracking-widest uppercase mb-1">Jadwal Bulan Ini</p>
                    <p class="text-3xl font-bold text-gray-900">4</p>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between relative overflow-hidden">
            <div class="absolute right-0 top-1/2 -translate-y-1/2 w-24 h-24 bg-teal-50/50 rounded-full blur-2xl -mr-8"></div>
            <div class="flex items-center gap-5 relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-teal-50 flex items-center justify-center text-teal-600">
                    <i class="ph ph-users text-2xl"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-bold tracking-widest uppercase mb-1">Siswa Diperiksa</p>
                    <p class="text-3xl font-bold text-gray-900">128</p>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between relative overflow-hidden">
            <div class="absolute right-0 top-1/2 -translate-y-1/2 w-24 h-24 bg-indigo-50/50 rounded-full blur-2xl -mr-8"></div>
            <div class="flex items-center gap-5 relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                    <i class="ph ph-check-circle text-2xl"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-bold tracking-widest uppercase mb-1">Skrining Selesai</p>
                    <p class="text-3xl font-bold text-gray-900">3</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Table Header -->
        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="text-lg font-bold text-gray-900">Daftar Jadwal Skrining</h2>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="ph ph-magnifying-glass text-gray-400"></i>
                    </div>
                    <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors" placeholder="Cari jadwal...">
                </div>
                <button class="p-2 border border-gray-200 text-gray-500 rounded-lg hover:bg-gray-50 transition-colors flex items-center justify-center">
                    <i class="ph ph-funnel text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 bg-white">
                        <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Jenis Skrining</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Pelaksanaan</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Lokasi</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($jadwal_skrining as $item)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-6">
                            <span class="font-semibold text-gray-900 text-sm">{{ $item->jenis_skrining }}</span>
                            @if(auth()->user()->role === 'admin_super')
                                <div class="text-xs text-gray-500 mt-1"><i class="ph-fill ph-buildings"></i> {{ $item->sekolah->nama_sekolah ?? 'N/A' }}</div>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="ph ph-clock text-gray-400"></i>
                                {{ \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->translatedFormat('d F Y') }}
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="ph ph-map-pin text-gray-400"></i>
                                {{ $item->lokasi }}
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            @if($item->status == 'pending')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-yellow-50 text-yellow-600 border border-yellow-100 uppercase tracking-wider">
                                Pending
                            </span>
                            @elseif($item->status == 'berjalan')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-50 text-blue-600 border border-blue-100 uppercase tracking-wider">
                                Berjalan
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-green-50 text-green-600 border border-green-100 uppercase tracking-wider">
                                Selesai
                            </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('jadwal_skrining.edit', $item->id) }}" class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg text-xs font-semibold transition-colors" title="Edit">
                                    <i class="ph-bold ph-pencil-simple text-lg"></i>
                                </a>
                                <form action="{{ route('jadwal_skrining.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-semibold transition-colors" title="Hapus">
                                        <i class="ph-bold ph-trash text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 px-6 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <i class="ph-fill ph-calendar-x text-4xl text-gray-300 mb-3"></i>
                                <p class="text-sm font-medium">Belum ada jadwal skrining yang ditambahkan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
