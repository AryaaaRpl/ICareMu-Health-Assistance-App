<x-app-layout>
    <div class="space-y-8 max-w-7xl mx-auto">
        <!-- Success Alert Notification -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-bold rounded-2xl flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- 1. Hero Banner (Blue Card) -->
        <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-blue-500 to-indigo-600 rounded-3xl p-8 text-white shadow-xl">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-3 max-w-xl">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-semibold uppercase tracking-wider text-blue-100">
                        <svg class="w-4 h-4 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        Student Health Hub
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Pantau Kesehatanmu Hari Ini!</h1>
                    <p class="text-blue-100 text-sm sm:text-base leading-relaxed">
                        Gunakan fasilitas Smart School Screening, AI Assistant, dan layanan UKS Muhammadiyah untuk menjaga kesehatan fisik dan rohanimu secara optimal.
                    </p>
                </div>
                <div>
                    <a href="{{ route('skrining.siswa') }}"
                       class="px-6 py-3.5 bg-white hover:bg-blue-50 text-blue-600 font-extrabold text-sm rounded-2xl shadow-lg hover:shadow-xl transition-all inline-flex items-center gap-2 group">
                        <span>Mulai Skrining</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>
            <!-- Decorative Glow Background -->
            <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        </div>

        <!-- Section Title -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-extrabold text-slate-900">Layanan Kesehatan Siswa</h2>
                <p class="text-xs text-slate-400 font-semibold">Pilih modul atau fitur layanan yang ingin kamu akses</p>
            </div>
        </div>

        <!-- 2. Navigation Grid (Body-8.jpg matching layout) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
            <!-- Item 1: Smart Health Record -->
            <a href="{{ route('health-record.index') }}"
               class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all flex items-center justify-between group">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 group-hover:scale-105 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 group-hover:text-blue-600 transition-colors">Smart Health Record</h3>
                        <p class="text-xs text-slate-400 font-medium">Riwayat medis dan catatan pemeriksaan kesehatan</p>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-slate-50 group-hover:bg-blue-600 text-slate-400 group-hover:text-white flex items-center justify-center transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- Item 2: Smart School Screening -->
            <a href="{{ route('skrining.siswa') }}"
               class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all flex items-center justify-between group">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 group-hover:scale-105 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 group-hover:text-emerald-600 transition-colors">Smart School Screening</h3>
                        <p class="text-xs text-slate-400 font-medium">Pemeriksaan kesehatan berkala dan skrining umum</p>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-slate-50 group-hover:bg-emerald-600 text-slate-400 group-hover:text-white flex items-center justify-center transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- Item 3: AI Health Assistant -->
            <a href="{{ route('ai.index') }}"
               class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md hover:border-purple-200 transition-all flex items-center justify-between group">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-purple-50 border border-purple-100 flex items-center justify-center text-purple-600 group-hover:scale-105 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 group-hover:text-purple-600 transition-colors">AI Health Assistant</h3>
                        <p class="text-xs text-slate-400 font-medium">Konsultasi keluhan dan pertolongan pertama AI</p>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-slate-50 group-hover:bg-purple-600 text-slate-400 group-hover:text-white flex items-center justify-center transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- Item 4: Health Education & ISMUBA -->
            <a href="{{ route('ismuba.index') }}"
               class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md hover:border-teal-200 transition-all flex items-center justify-between group">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-teal-50 border border-teal-100 flex items-center justify-center text-teal-600 group-hover:scale-105 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 group-hover:text-teal-600 transition-colors">Health Education & ISMUBA</h3>
                        <p class="text-xs text-slate-400 font-medium">Artikel kesehatan Islami, Thaharah & Thibbun Nabawi</p>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-slate-50 group-hover:bg-teal-600 text-slate-400 group-hover:text-white flex items-center justify-center transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- Item 5: Menstrual Health Monitoring (Strictly Female Students Only) -->
            @if(auth()->user()->jenis_kelamin === 'P')
                <a href="{{ route('menstrual.index') }}"
                   class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md hover:border-rose-200 transition-all flex items-center justify-between group">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-600 group-hover:scale-105 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900 group-hover:text-rose-600 transition-colors">Menstrual Health Monitoring</h3>
                            <p class="text-xs text-slate-400 font-medium">Pencatatan siklus haid mandiri & prediksi haid</p>
                        </div>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-slate-50 group-hover:bg-rose-600 text-slate-400 group-hover:text-white flex items-center justify-center transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
            @endif

            <!-- Item 6: Riwayat Kunjungan UKS -->
            <a href="{{ route('rekam-medis.index') }}"
               class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md hover:border-amber-200 transition-all flex items-center justify-between group">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 group-hover:scale-105 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 group-hover:text-amber-600 transition-colors">Riwayat Kunjungan UKS</h3>
                        <p class="text-xs text-slate-400 font-medium">Catatan konsultasi dan istirahat di ruang UKS</p>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-slate-50 group-hover:bg-amber-600 text-slate-400 group-hover:text-white flex items-center justify-center transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- Item 7: Profil Saya -->
            <a href="{{ route('profile.edit') }}"
               class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md hover:border-indigo-200 transition-all flex items-center justify-between group">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 group-hover:scale-105 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">Profil Saya</h3>
                        <p class="text-xs text-slate-400 font-medium">Kelola data pribadi, NISN, dan wali siswa</p>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-slate-50 group-hover:bg-indigo-600 text-slate-400 group-hover:text-white flex items-center justify-center transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
        </div>
    </div>
</x-app-layout>
