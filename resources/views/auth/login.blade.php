<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'iCareMu') }} - Masuk</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-['Plus_Jakarta_Sans',sans-serif] text-slate-800 antialiased selection:bg-blue-500 selection:text-white">
    <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-gradient-to-br from-slate-50 via-blue-50/30 to-teal-50/20 relative overflow-hidden">
        
        <!-- Decorative Background Elements -->
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-blue-400/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-teal-400/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10">
            <!-- Brand Logo & Header -->
            <div class="flex justify-center items-center">
                <img src="{{ asset('Logo.png') }}" alt="Logo" class="h-20 sm:h-24 w-auto max-w-full object-contain mx-auto drop-shadow-sm" />
            </div>

            <!-- Session Status Alert -->
            @if (session('status'))
                <div class="mt-6 p-4 rounded-xl bg-teal-50 border border-teal-200/80 text-sm text-teal-700 flex items-center gap-2 shadow-sm">
                    <svg class="w-5 h-5 text-teal-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Main Card Form -->
            <div class="mt-6 bg-white/90 backdrop-blur-xl py-8 px-6 shadow-xl shadow-slate-200/50 sm:rounded-3xl sm:px-10 border border-slate-100">
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- NISN / NIP / Identifier Input -->
                    <div>
                        <label for="identifier" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            NISN / NIP / Identifier
                        </label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <input id="identifier" 
                                   type="text" 
                                   name="identifier" 
                                   value="{{ old('identifier') }}" 
                                   required 
                                   autofocus 
                                   placeholder="Masukkan NISN atau NIP anda" 
                                   class="block w-full pl-10 pr-4 py-3 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white text-sm transition-all duration-200 @error('identifier') border-red-300 bg-red-50/30 focus:ring-red-500 @enderror">
                        </div>
                        @error('identifier')
                            <p class="mt-2 text-xs font-medium text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-sm font-semibold text-slate-700">
                                Kata Sandi
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 hover:underline transition-colors">
                                    Lupa kata sandi?
                                </a>
                            @endif
                        </div>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input id="password" 
                                   type="password" 
                                   name="password" 
                                   required 
                                   autocomplete="current-password" 
                                   placeholder="••••••••" 
                                   class="block w-full pl-10 pr-4 py-3 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white text-sm transition-all duration-200 @error('password') border-red-300 bg-red-50/30 focus:ring-red-500 @enderror">
                        </div>
                        @error('password')
                            <p class="mt-2 text-xs font-medium text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Remember Me Option -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                            <input id="remember_me" 
                                   type="checkbox" 
                                   name="remember" 
                                   class="w-4 h-4 text-blue-600 bg-slate-100 border-slate-300 rounded focus:ring-blue-500 focus:ring-2 transition cursor-pointer">
                            <span class="ms-2.5 text-sm text-slate-600 group-hover:text-slate-900 transition-colors">
                                Ingat saya
                            </span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <p>Belum Punya Akun? <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800">Daftar di sini</a></p>
                    </div>
                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                                class="w-full flex justify-center items-center py-3 px-4 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg shadow-blue-500/30 hover:shadow-blue-500/40 transform active:scale-[0.99] transition-all duration-200">
                            <span>Masuk ke Dashboard</span>
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer Info -->
            <p class="mt-8 text-center text-xs text-slate-400">
                &copy; {{ date('Y') }} iCareMu. Seluruh Hak Cipta Dilindungi.
            </p>
        </div>
    </div>
</body>
</html>
