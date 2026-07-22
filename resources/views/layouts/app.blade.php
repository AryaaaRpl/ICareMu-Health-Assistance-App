<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'iCareMu')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Phosphor Icons for Sidebar (similar to the image) -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7fb;
        }
    </style>
</head>
<body class="flex min-h-screen bg-[#F8FAFC]">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col justify-between fixed h-full z-10">
        <div>
            <!-- Logo -->
            <div class="p-6 flex items-center justify-center">
                <img src="{{ asset('auth-iCareMU.png')}}" alt="Logo" class="h-12"/>
            </div>

            <!-- Navigation -->
            <nav class="mt-4 px-4 space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }} transition-colors font-medium text-sm">
                    <i class="ph ph-squares-four text-lg"></i>
                    Dashboard
                </a>
                
                @if(auth()->user()->role === 'admin_super')
                <a href="/admin_super/sekolah" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('admin_super/sekolah*') ? 'bg-blue-600 text-white' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }} transition-colors font-medium text-sm">
                    <i class="ph ph-buildings text-lg"></i>
                    Data Sekolah
                </a>
                @endif
                
                <!-- <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition-colors font-medium text-sm">
                    <i class="ph ph-activity text-lg"></i>
                    Dashboard UKS
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition-colors font-medium text-sm">
                    <i class="ph ph-file-text text-lg"></i>
                    Health Record
                </a> -->
                @if(in_array(auth()->user()->role, ['admin_super', 'admin_sekolah', 'guru_uks']))
                <a href="{{ route('jadwal_skrining.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('jadwal_skrining.*') ? 'bg-blue-600 text-white' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }} transition-colors font-medium text-sm">
                    <i class="ph ph-heartbeat text-lg"></i>
                    School Screening
                </a>
                @endif
                <!-- <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition-colors font-medium text-sm">
                    <i class="ph ph-chat-teardrop-dots text-lg"></i>
                    AI Assistant
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition-colors font-medium text-sm">
                    <i class="ph ph-book-open text-lg"></i>
                    Edukasi ISMUBA
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition-colors font-medium text-sm">
                    <i class="ph ph-drop text-lg"></i>
                    Menstrual Health
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition-colors font-medium text-sm">
                    <i class="ph ph-package text-lg"></i>
                    UKS Inventory
                </a> -->
            </nav>
        </div>

        <!-- User Profile Area (Sidebar Bottom) -->
        <div class="p-4 border-t border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 font-bold text-sm uppercase">
                        {{ substr(auth()->user()->username, 0, 2) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->username }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors">
                        <i class="ph ph-sign-out text-xl"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-64 p-8">
        @yield('content')
    </main>

</body>
</html>
