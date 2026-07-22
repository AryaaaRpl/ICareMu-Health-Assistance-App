<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - iCareMu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7fb;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-4">

    <!-- Top Logo -->
    <div class="mb-6">
        <img src="{{ asset('auth-iCareMU.png')}}" alt="" class="h-16"/>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-[2rem] shadow-xl w-full max-w-lg p-8 sm:p-10">
        
        <!-- Steps Indicator -->
        <div class="mb-8">
            <div class="flex justify-between items-center text-xs font-bold mb-2">
                <span class="text-blue-600 tracking-wider">STEP 1 OF 3</span>
                <span class="text-gray-500">Data Akun</span>
            </div>
            <div class="flex h-1 bg-gray-100 rounded-full mb-2">
                <div class="w-1/3 bg-blue-600 rounded-full"></div>
            </div>
            <div class="flex justify-between text-[10px] sm:text-xs text-gray-400 font-semibold">
                <span class="text-blue-600">Akun</span>
                <span>Pembayaran</span>
                <span>Verifikasi</span>
            </div>
        </div>

        <!-- Heading -->
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Buat Akun Siswa</h2>
            <p class="text-sm text-gray-500">Lengkapi data diri Anda untuk bergabung dengan layanan kesehatan iCAREMU.</p>
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
        <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Nama Lengkap -->
            <div>
                <label for="nama_lengkap" class="block text-xs font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="pl-10 w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-sm" placeholder="Sesuai kartu pelajar...">
                </div>
            </div>

            <!-- NISN & Tanggal Lahir Row -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- NISN -->
                <div>
                    <label for="nisn" class="block text-xs font-semibold text-gray-700 mb-1">NISN</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <input type="text" name="nisn" id="nisn" value="{{ old('nisn') }}" required class="pl-10 w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-sm" placeholder="Nomor Induk Siswa Nasional...">
                    </div>
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label for="tanggal_lahir" class="block text-xs font-semibold text-gray-700 mb-1">Tanggal Lahir</label>
                    <div class="relative">
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-sm text-gray-500">
                    </div>
                </div>
            </div>

            <!-- Email & Password Row -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required class="pl-10 w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-sm" placeholder="siswa@sekolah.id">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-semibold text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password" id="password" required class="pl-10 w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-sm" placeholder="Minimal 8 karakter...">
                    </div>
                </div>
            </div>

            <!-- Optional Data Section -->
            <div class="pt-4 border-t border-gray-100">
                <p class="text-xs font-semibold text-gray-500 mb-3">Data Opsional (Bisa diisi nanti)</p>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-4">
                    <!-- Nama Ortu -->
                    <div>
                        <label for="nama_ortu" class="block text-xs font-semibold text-gray-700 mb-1">Nama Orang Tua/Wali</label>
                        <input type="text" name="nama_ortu" id="nama_ortu" value="{{ old('nama_ortu') }}" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-sm" placeholder="Nama lengkap orang tua...">
                    </div>

                    <!-- No WA Ortu -->
                    <div>
                        <label for="no_wa_ortu" class="block text-xs font-semibold text-gray-700 mb-1">No WhatsApp Ortu/Wali</label>
                        <input type="text" name="no_wa_ortu" id="no_wa_ortu" value="{{ old('no_wa_ortu') }}" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-sm" placeholder="Contoh: 08123456789">
                    </div>
                </div>

                <!-- Golongan Darah -->
                <div>
                    <label for="golongan_darah" class="block text-xs font-semibold text-gray-700 mb-1">Golongan Darah</label>
                    <select name="golongan_darah" id="golongan_darah" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-sm text-gray-700 bg-white">
                        <option value="">Pilih Golongan Darah...</option>
                        <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                    </select>
                </div>
            </div>

            <!-- Pilih Sekolah -->
            <div>
                <label for="sekolah_id" class="block text-xs font-semibold text-gray-700 mb-1">Pilih Sekolah Anda</label>
                <select name="sekolah_id" id="sekolah_id" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-sm text-gray-500 appearance-none bg-white">
                    <option value="" disabled selected>Cari asal sekolah Muhammadiyah...</option>
                    @foreach($sekolahs as $sekolah)
                        <option value="{{ $sekolah->id }}">{{ $sekolah->nama_sekolah }}</option>
                    @endforeach
                </select>
                <!-- Custom chevron for select -->
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400 mt-5">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 mt-4 rounded-xl shadow-lg shadow-blue-200 transition-all flex justify-center items-center gap-2">
                Lanjut ke Pembayaran 
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </form>

        <!-- Footer link -->
        <div class="text-center mt-6 text-xs text-gray-500">
            Sudah memiliki akun? <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Masuk di sini</a>
        </div>
    </div>

</body>
</html>
