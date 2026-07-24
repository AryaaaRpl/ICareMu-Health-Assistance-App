<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'iCareMu') }} - School Health Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full font-['Plus_Jakarta_Sans',sans-serif] bg-slate-50 text-slate-800 antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-slate-100 flex flex-col justify-between shrink-0 shadow-sm fixed inset-y-0 left-0 z-30">
            <div>
                <!-- Brand Logo Header -->
                <div class="p-6 flex justify-center items-center">
                    <img src="{{ asset('Logo.png') }}" alt="Logo" class="h-16 w-auto max-w-full object-contain mx-auto transition-transform hover:scale-105" />
                </div>

                <!-- Navigation Menu -->
                <nav class="p-4 space-y-1.5">
                    @auth
                    @php
                    $user = auth()->user();
                    $isAdmin = in_array($user->role, ['admin_uks', 'super_admin', 'petugas_uks', 'admin_super']);
                    $isSiswa = $user->role === 'siswa';
                    $isFemaleStudent = $user->role === 'siswa' && $user->jenis_kelamin === 'P';
                    @endphp

                    <!-- Dashboard Siswa -->
                    @if($isSiswa || $isAdmin)
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold {{ request()->routeIs('dashboard') ? 'text-white bg-blue-600 rounded-xl shadow-lg shadow-blue-500/30' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-xl' }} transition-all">
                        <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        <span>Dashboard Siswa</span>
                    </a>
                    @endif

                    <!-- Dashboard UKS (Admin Only) -->
                    @if($isAdmin)
                    <a href="{{ route('dashboard.uks') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold {{ request()->routeIs('dashboard.uks') ? 'text-white bg-blue-600 rounded-xl shadow-lg shadow-blue-500/30' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-xl' }} transition-all">
                        <svg class="w-5 h-5 {{ request()->routeIs('dashboard.uks') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <span>Dashboard UKS</span>
                    </a>

                    <!-- Health Record (Admin Only) -->
                    <a href="{{ route('rekam-medis.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold {{ request()->routeIs('rekam-medis.*') ? 'text-white bg-blue-600 rounded-xl shadow-lg shadow-blue-500/30' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-xl' }} transition-all">
                        <svg class="w-5 h-5 {{ request()->routeIs('rekam-medis.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Health Record</span>
                    </a>

                    <!-- School Screening (Admin Only) -->
                    <a href="{{ route('skrining.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold {{ request()->routeIs('skrining.*') ? 'text-white bg-blue-600 rounded-xl shadow-lg shadow-blue-500/30' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-xl' }} transition-all">
                        <svg class="w-5 h-5 {{ request()->routeIs('skrining.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span>School Screening</span>
                    </a>
                    @endif

                    <!-- AI Assistant -->
                    <a href="{{ route('ai.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold {{ request()->routeIs('ai.*') ? 'text-white bg-blue-600 rounded-xl shadow-lg shadow-blue-500/30' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-xl' }} transition-all">
                        <svg class="w-5 h-5 {{ request()->routeIs('ai.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                        <span>AI Assistant</span>
                    </a>

                    <!-- Edukasi ISMUBA -->
                    <a href="{{ route('ismuba.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold {{ request()->routeIs('ismuba.*') ? 'text-white bg-blue-600 rounded-xl shadow-lg shadow-blue-500/30' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-xl' }} transition-all">
                        <svg class="w-5 h-5 {{ request()->routeIs('ismuba.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span>Edukasi ISMUBA</span>
                    </a>

                    <!-- Menstrual Health (Strictly Siswa & Perempuan Only) -->
                    @if($isFemaleStudent)
                    <a href="{{ route('menstrual.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold {{ request()->routeIs('menstrual.*') ? 'text-white bg-blue-600 rounded-xl shadow-lg shadow-blue-500/30' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-xl' }} transition-all">
                        <svg class="w-5 h-5 {{ request()->routeIs('menstrual.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <span>Menstrual Health</span>
                    </a>
                    @endif

                    <!-- UKS Inventory (Admin Only) -->
                    @if($isAdmin)
                    <a href="{{ route('inventaris.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold {{ request()->routeIs('inventaris.*') ? 'text-white bg-blue-600 rounded-xl shadow-lg shadow-blue-500/30' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-xl' }} transition-all">
                        <svg class="w-5 h-5 {{ request()->routeIs('inventaris.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <span>Inventaris UKS</span>
                    </a>
                    @endif
                    @endauth
                </nav>
            </div>

            <!-- User Profile Bottom Widget -->
            <div class="p-4 border-t border-slate-100">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-slate-50 transition-colors">
                    <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center font-bold text-slate-600 text-sm">
                        {{ auth()->user() ? substr(auth()->user()->name, 0, 2) : 'dr' }}
                    </div>
                    <div class="overflow-hidden">
                        <h4 class="text-sm font-bold text-slate-900 truncate">
                            {{ auth()->user() ? auth()->user()->name : 'Pengguna' }}
                        </h4>
                        <p class="text-xs text-slate-400 truncate uppercase font-semibold">
                            {{ auth()->user() ? auth()->user()->role : 'Siswa' }}
                        </p>
                    </div>
                </a>
            </div>
        </aside>

        <!-- Main Wrapper -->
        <div class="flex-1 pl-64 flex flex-col min-h-screen">
            <!-- Top Navigation -->
            <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 px-8 flex items-center justify-between sticky top-0 z-20">
                <div>
                    <h1 class="text-xl font-bold text-slate-900">School Health Dashboard</h1>
                    <p class="text-xs text-slate-400">Analytics & Monitoring Center UKS Muhammadiyah</p>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Search input -->
                    <div class="relative">
                        <input type="text" placeholder="Cari data..." class="w-64 pl-4 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <svg class="w-4 h-4 text-slate-400 absolute right-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>

                    <!-- Profile Link -->
                    <a href="{{ route('profile.edit') }}" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 transition-all" title="Edit Profile">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </a>

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 px-3 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-semibold text-xs rounded-xl transition-all" title="Log Out">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 p-8 bg-slate-50/50">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>