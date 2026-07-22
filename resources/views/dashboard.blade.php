@extends('layouts.app')

@section('title', 'Dashboard - iCareMu')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Header Area -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-3">
            <div class="bg-blue-600 text-white p-2 rounded-xl">
                <i class="ph-fill ph-shield-check text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-800 leading-tight">ICAREMU</h1>
                <p class="text-xs text-gray-500 font-medium tracking-wider">STUDENT HEALTH HUB</p>
            </div>
        </div>

        <div class="flex items-center gap-4 bg-white border border-gray-100 px-4 py-2 rounded-full shadow-sm">
            <div class="text-right">
                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-widest">Selamat Datang,</p>
                <p class="text-sm font-bold text-gray-700 capitalize">{{ auth()->user()->username }}</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 font-bold flex items-center justify-center uppercase text-sm">
                {{ substr(auth()->user()->username, 0, 2) }}
            </div>
        </div>
    </div>

    <!-- Admin Super Content -->
    @if(auth()->user()->role === 'admin_super')
        <div class="bg-gradient-to-r from-blue-600 to-blue-500 rounded-3xl p-8 text-white mb-8 shadow-lg shadow-blue-200">
            <h2 class="text-2xl font-bold mb-2">Ringkasan Sistem</h2>
            <p class="text-blue-100 mb-6 text-sm max-w-lg">
                Pantau jumlah data secara keseluruhan yang ada pada sistem iCareMu.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                    <i class="ph ph-users text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Pengguna</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $total_users ?? 0 }}</p>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                    <i class="ph ph-buildings text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Sekolah</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $total_sekolahs ?? 0 }}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                    <i class="ph ph-student text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Siswa</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $total_siswas ?? 0 }}</p>
                </div>
            </div>
        </div>
    @else
        <!-- Siswa/Other Role Content (From Mockup) -->
        <!-- Banner -->
        <div class="bg-gradient-to-r from-[#1E5EFF] to-[#0A45D8] rounded-[28px] p-10 text-white mb-8 shadow-xl shadow-blue-200/50 relative overflow-hidden">
            <!-- Decorative circle -->
            <div class="absolute -right-10 -top-10 w-64 h-64 bg-white opacity-5 rounded-full blur-2xl"></div>
            
            <div class="relative z-10">
                <h2 class="text-3xl font-bold mb-3 tracking-tight">Pantau Kesehatanmu Hari Ini!</h2>
                <p class="text-blue-100 mb-8 text-[15px] max-w-xl leading-relaxed">
                    Jangan lupa untuk rutin mengisi Smart School Screening dan pantau terus kondisi kesehatanmu untuk aktivitas belajar yang optimal.
                </p>
                <a href="#" class="inline-flex items-center gap-2 bg-white text-blue-600 font-bold px-6 py-3 rounded-full hover:bg-gray-50 transition-colors shadow-sm">
                    Mulai Skrining
                    <i class="ph-bold ph-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Menu Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Card 1 -->
            <a href="#" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 hover:shadow-md transition-all">
                <div class="w-14 h-14 rounded-full bg-[#F4F7FB] flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
                    <i class="ph-fill ph-file-text text-2xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 mb-1">Smart Health Record</h3>
                    <p class="text-sm text-gray-500 line-clamp-1">Lihat profil kesehatan dan riwayat medis lengkap</p>
                </div>
                <i class="ph-bold ph-caret-right text-gray-300"></i>
            </a>

            <!-- Card 2 -->
            <a href="#" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 hover:shadow-md transition-all">
                <div class="w-14 h-14 rounded-full bg-[#F4F7FB] flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
                    <i class="ph-fill ph-heartbeat text-2xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 mb-1">Smart School Screening</h3>
                    <p class="text-sm text-gray-500 line-clamp-1">Isi form penilaian kesehatan rutin secara berkala</p>
                </div>
                <i class="ph-bold ph-caret-right text-gray-300"></i>
            </a>

            <!-- Card 3 -->
            <a href="#" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 hover:shadow-md transition-all">
                <div class="w-14 h-14 rounded-full bg-[#F4F7FB] flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
                    <i class="ph-fill ph-chat-teardrop-dots text-2xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 mb-1">AI Health Assistant</h3>
                    <p class="text-sm text-gray-500 line-clamp-1">Konsultasi keluhan kesehatan ringan dengan AI</p>
                </div>
                <i class="ph-bold ph-caret-right text-gray-300"></i>
            </a>

            <!-- Card 4 -->
            <a href="#" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 hover:shadow-md transition-all">
                <div class="w-14 h-14 rounded-full bg-[#F4F7FB] flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
                    <i class="ph-fill ph-book-open text-2xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 mb-1">Health Education & ISMUBA</h3>
                    <p class="text-sm text-gray-500 line-clamp-1">Artikel kesehatan, mental, dan Fikih Wanita</p>
                </div>
                <i class="ph-bold ph-caret-right text-gray-300"></i>
            </a>

            <!-- Card 5 -->
            <a href="#" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 hover:shadow-md transition-all">
                <div class="w-14 h-14 rounded-full bg-[#F4F7FB] flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
                    <i class="ph-fill ph-heart-break text-2xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 mb-1">Menstrual Health Monitoring</h3>
                    <p class="text-sm text-gray-500 line-clamp-1">Pantau siklus menstruasi bulanan</p>
                </div>
                <i class="ph-bold ph-caret-right text-gray-300"></i>
            </a>

            <!-- Card 6 -->
            <a href="#" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 hover:shadow-md transition-all">
                <div class="w-14 h-14 rounded-full bg-[#F4F7FB] flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
                    <i class="ph-fill ph-clock-counter-clockwise text-2xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 mb-1">Riwayat Kunjungan UKS</h3>
                    <p class="text-sm text-gray-500 line-clamp-1">Log kunjungan dan tindakan medis</p>
                </div>
                <i class="ph-bold ph-caret-right text-gray-300"></i>
            </a>

            <!-- Card 7 -->
            <a href="#" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 hover:shadow-md transition-all">
                <div class="w-14 h-14 rounded-full bg-[#F4F7FB] flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
                    <i class="ph-fill ph-user text-2xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 mb-1">Profil Saya</h3>
                    <p class="text-sm text-gray-500 line-clamp-1">Pengaturan akun dan preferensi aplikasi</p>
                </div>
                <i class="ph-bold ph-caret-right text-gray-300"></i>
            </a>
        </div>
    @endif
</div>
@endsection
