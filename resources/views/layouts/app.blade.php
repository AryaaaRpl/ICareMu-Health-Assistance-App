<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' - ' . config('app.name', 'ICareMu') : config('app.name', 'ICareMu') . ' - School Health Assistance' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="{ sidebarOpen: false }"
    class="h-full font-['Plus_Jakarta_Sans',sans-serif] bg-slate-50 text-slate-800 antialiased selection:bg-blue-500 selection:text-white">
    <div class="min-h-screen flex flex-col md:flex-row relative">
        <!-- Backdrop Overlay for Mobile -->
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
            class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-40 md:hidden" style="display: none;"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
            class="w-64 bg-white border-r border-slate-100 flex flex-col justify-between shrink-0 shadow-xl md:shadow-sm fixed inset-y-0 left-0 z-50 transition-transform duration-300 ease-in-out">
            <div class="flex flex-col h-full justify-between">
                <div>
                    <!-- Brand Logo Header -->
                    <div class="p-5 md:p-6 flex justify-between items-center border-b md:border-b-0 border-slate-100">
                        <img src="{{ asset('Logo.png') }}" alt="Logo"
                            class="h-12 md:h-16 w-auto max-w-full object-contain mx-auto transition-transform hover:scale-105" />
                        <!-- Close button mobile -->
                        <button @click="sidebarOpen = false"
                            class="md:hidden p-2 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Navigation Menu -->
                    <nav class="p-3 md:p-4 space-y-1.5 overflow-y-auto max-h-[calc(100vh-140px)]">
                        @auth
                            @php
                                $user = auth()->user();
                                $isAdmin = in_array($user->role, [
                                    'super_admin',
                                    'petugas_uks',
                                    'admin_super',
                                ]);
                                $isUks = $user->role === 'admin_uks';
                                $isSiswa = $user->role === 'siswa';
                                $isGuruIsmuba = $user->role === 'guru_ismuba';
                                $isFemaleStudent =
                                    ($user->role === 'siswa' && $user->jenis_kelamin === 'P') ||
                                    ($user->role === 'super_admin' && $user->jenis_kelamin === 'P') ||
                                    ($user->role === 'admin_uks' && $user->jenis_kelamin === 'P');
                            @endphp

                            <!-- Dashboard -->
                            @if ($isSiswa || $isAdmin || $isGuruIsmuba)
                                <a href="{{ route('dashboard') }}" @click="sidebarOpen = false"
                                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold {{ request()->routeIs('dashboard') ? 'text-white bg-blue-600 rounded-xl shadow-lg shadow-blue-500/30' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-xl' }} transition-all">
                                    <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400' }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                        </path>
                                    </svg>
                                    <span>Dashboard</span>
                                </a>
                            @endif

                            @if ($isUks)
                            <a href="{{ route('dashboard.uks') }}" @click="sidebarOpen = false"
                                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold {{ request()->routeIs('dashboard.uks') ? 'text-white bg-blue-600 rounded-xl shadow-lg shadow-blue-500/30' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-xl' }} transition-all">
                                    <svg class="w-5 h-5 {{ request()->routeIs('dashboard.uks') ? 'text-white' : 'text-slate-400' }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    <span>Dashboard UKS</span>
                                </a>
                            @endif

                            <!-- Dashboard (Admin Only) -->
                            @if ($isAdmin)
                                <!-- School Screening (Admin Only) -->
                                <a href="{{ route('skrining.index') }}" @click="sidebarOpen = false"
                                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold {{ request()->routeIs('skrining.*') ? 'text-white bg-blue-600 rounded-xl shadow-lg shadow-blue-500/30' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-xl' }} transition-all">
                                    <svg class="w-5 h-5 {{ request()->routeIs('skrining.*') ? 'text-white' : 'text-slate-400' }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                    <span>Smart School Screening</span>
                                </a>

                                <!-- Smart Health Record (Admin Only) -->
                                <a href="{{ route('rekam-medis.index') }}" @click="sidebarOpen = false"
                                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold {{ request()->routeIs('rekam-medis.*') ? 'text-white bg-blue-600 rounded-xl shadow-lg shadow-blue-500/30' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-xl' }} transition-all">
                                    <svg class="w-5 h-5 {{ request()->routeIs('rekam-medis.*') ? 'text-white' : 'text-slate-400' }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <span>Smart Health Record</span>
                                </a>
                            @endif

                            <!-- AI Assistant -->
                            <a href="{{ route('ai.index') }}" @click="sidebarOpen = false"
                                class="flex items-center gap-3 px-4 py-3 text-sm font-semibold {{ request()->routeIs('ai.*') ? 'text-white bg-blue-600 rounded-xl shadow-lg shadow-blue-500/30' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-xl' }} transition-all">
                                <svg class="w-5 h-5 {{ request()->routeIs('ai.*') ? 'text-white' : 'text-slate-400' }}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                    </path>
                                </svg>
                                <span>AI Health Assistant</span>
                            </a>

                            <!-- Edukasi ISMUBA -->
                            <a href="{{ route('ismuba.index') }}" @click="sidebarOpen = false"
                                class="flex items-center gap-3 px-4 py-3 text-sm font-semibold {{ request()->routeIs('ismuba.*') ? 'text-white bg-blue-600 rounded-xl shadow-lg shadow-blue-500/30' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-xl' }} transition-all">
                                <svg class="w-5 h-5 {{ request()->routeIs('ismuba.*') ? 'text-white' : 'text-slate-400' }}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                                <span>Health Education & ISMUBA</span>
                            </a>

                            <!-- Menstrual Health (Strictly Siswa & Perempuan Only) -->
                            @if ($isFemaleStudent)
                                <a href="{{ route('menstrual.index') }}" @click="sidebarOpen = false"
                                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold {{ request()->routeIs('menstrual.*') ? 'text-white bg-blue-600 rounded-xl shadow-lg shadow-blue-500/30' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-xl' }} transition-all">
                                    <svg class="w-5 h-5 {{ request()->routeIs('menstrual.*') ? 'text-white' : 'text-slate-400' }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                    <span>Menstrual Health Monitoring</span>
                                </a>
                            @endif

                            <!-- UKS Inventory (Admin Only) -->
                            @if ($isAdmin)
                                <a href="{{ route('inventaris.index') }}" @click="sidebarOpen = false"
                                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold {{ request()->routeIs('inventaris.*') ? 'text-white bg-blue-600 rounded-xl shadow-lg shadow-blue-500/30' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-xl' }} transition-all">
                                    <svg class="w-5 h-5 {{ request()->routeIs('inventaris.*') ? 'text-white' : 'text-slate-400' }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <span>Smart UKS Inventaris</span>
                                </a>
                            @endif
                        @endauth
                    </nav>
                </div>

                <!-- User Profile Bottom Widget -->
                <div class="p-4 border-t border-slate-100 bg-white">
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-slate-50 transition-colors">
                        <div
                            class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm shrink-0">
                            {{ auth()->user() ? substr(auth()->user()->name, 0, 2) : 'dr' }}
                        </div>
                        <div class="overflow-hidden min-w-0">
                            <h4 class="text-sm font-bold text-slate-900 truncate">
                                {{ auth()->user() ? auth()->user()->name : 'Pengguna' }}
                            </h4>
                            <p class="text-xs text-slate-400 truncate uppercase font-semibold">
                                {{ auth()->user() ? auth()->user()->role : 'Siswa' }}
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Wrapper -->
        <div class="flex-1 md:pl-64 flex flex-col min-h-screen w-full min-w-0">
            <!-- Top Navigation -->
            <header
                class="h-16 md:h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 px-4 md:px-8 flex items-center justify-between sticky top-0 z-20">
                <div class="flex items-center gap-3">
                    <!-- Mobile Sidebar Hamburger Button -->
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="md:hidden p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none transition-colors"
                        aria-label="Toggle Menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-base md:text-xl font-bold text-slate-900 leading-tight">School Health Dashboard
                        </h1>
                        <p class="text-[11px] md:text-xs text-slate-400 hidden sm:block">Analytics & Monitoring Center
                            UKS Muhammadiyah</p>
                    </div>
                </div>

                <div class="flex items-center gap-2 md:gap-4 shrink-0">
                    <!-- Profile Link -->
                    <a href="{{ route('profile.edit') }}"
                        class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 transition-all"
                        title="Edit Profile">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </a>

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-1.5 md:gap-2 px-2.5 md:px-3 py-2 md:py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-semibold text-xs rounded-xl transition-all"
                            title="Log Out">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            <span class="hidden sm:inline">Keluar</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 p-4 md:p-8 bg-slate-50/5">
                {{ $slot }}
                <x-modal-notification />
            </main>
        </div>
    </div>
</body>

</html>
