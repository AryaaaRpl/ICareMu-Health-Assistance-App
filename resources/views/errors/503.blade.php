<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistem Dalam Pemeliharaan - {{ config('app.name', 'ICareMu') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-4 sm:p-6 selection:bg-amber-500 selection:text-slate-900">

    <!-- Background Decorative Glow Effects -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-500/5 rounded-full blur-3xl"></div>
    </div>

    <!-- Main Container -->
    <div class="relative z-10 max-w-xl w-full mx-auto">
        <div class="bg-slate-800/80 backdrop-blur-xl border border-slate-700/60 rounded-3xl p-8 sm:p-12 shadow-2xl text-center space-y-8">
            
            <!-- Logo Brand -->
            <div class="flex justify-center">
                <img src="{{ asset('Logo.png') }}" alt="ICareMu Logo" class="h-16 sm:h-20 w-auto object-contain drop-shadow-md" />
            </div>

            <!-- Maintenance Icon with Animated Gear & Pulse -->
            <div class="relative w-24 h-24 mx-auto flex items-center justify-center">
                <div class="absolute inset-0 bg-amber-500/20 rounded-3xl blur-lg animate-pulse"></div>
                <div class="relative w-20 h-20 bg-gradient-to-tr from-amber-500 to-amber-400 text-slate-950 rounded-2xl flex items-center justify-center shadow-lg shadow-amber-500/20 border border-amber-300/40">
                    <svg class="w-10 h-10 animate-spin" style="animation-duration: 12s;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>

            <!-- Content Area -->
            <div class="space-y-3">
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-500/10 text-amber-400 text-xs font-bold uppercase tracking-wider border border-amber-500/20">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                    Pemeliharaan Sistem
                </span>
                
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                    Sistem Sedang Dalam Pemeliharaan
                </h1>
                
                <p class="text-sm text-slate-400 max-w-md mx-auto leading-relaxed">
                    Kami sedang melakukan peningkatan performa dan pembaruan rutin pada platform **ICareMu Health Assistance**. Mohon tunggu beberapa saat.
                </p>
            </div>

            <!-- Notice Box -->
            <div class="bg-slate-900/60 rounded-2xl p-4 border border-slate-700/50 text-left text-xs space-y-2 text-slate-300">
                <div class="flex items-center gap-2 text-amber-400 font-bold">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Informasi Pemeliharaan</span>
                </div>
                <p class="text-slate-400 text-[11px] leading-relaxed">
                    Layanan akan kembali normal sesaat lagi. Apabila terdapat hal mendesak mengenai kesehatan siswa, mohon hubungi petugas UKS sekolah secara langsung.
                </p>
            </div>

            <!-- Action Button / Refresh -->
            <div class="pt-2">
                <button onclick="window.location.reload()" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-amber-500 hover:bg-amber-400 active:bg-amber-600 text-slate-950 font-extrabold text-xs rounded-2xl shadow-lg shadow-amber-500/20 transition-all cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>Muat Ulang Halaman</span>
                </button>
            </div>

        </div>

        <!-- Footer Footer Credit -->
        <div class="text-center mt-6 text-xs text-slate-500 font-medium">
            &copy; {{ date('Y') }} ICareMu Health Assistance - UKS Muhammadiyah Digital.
        </div>
    </div>

</body>
</html>
