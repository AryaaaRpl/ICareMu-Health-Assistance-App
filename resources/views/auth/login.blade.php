<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - iCareMu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-3xl shadow-xl w-full max-w-md p-8 sm:p-10">
        
        <!-- Logo Area -->
        <div class="flex justify-center mb-8">
            <img src="{{ asset('auth-iCareMU.png')}}" alt="" class="h-16"/>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-4 bg-red-50 text-red-600 p-3 rounded-lg text-sm">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
            @csrf

            <!-- NIS/NIP/Email -->
            <div>
                <label for="credential" class="block text-sm font-semibold text-gray-700 mb-1">Email / NISN</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input type="text" name="credential" id="credential" value="{{ old('credential') }}" required class="pl-10 w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all text-sm" placeholder="Masukkan Email atau NISN Anda">
                </div>
            </div>

            <!-- Password -->
            <div>
                <div class="flex justify-between items-center mb-1">
                    <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                    <a href="#" class="text-xs text-green-600 font-semibold hover:text-green-700">Lupa password?</a>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" name="password" id="password" required class="pl-10 w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all text-sm" placeholder="Masukkan password Anda">
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-[#00A86B] hover:bg-green-600 text-white font-semibold py-3 rounded-xl shadow-lg shadow-green-200 transition-all flex justify-center items-center gap-2">
                Login 
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </form>

        <!-- Footer link -->
        <div class="text-center mt-6 text-sm text-gray-500">
            Belum memiliki akun iCAREMU? <a href="{{ route('register') }}" class="text-green-600 font-semibold hover:underline">Daftar sekarang</a>
        </div>
    </div>

</body>
</html>
