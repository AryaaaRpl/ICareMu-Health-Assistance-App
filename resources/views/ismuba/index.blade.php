<x-app-layout>
    <div class="space-y-8 max-w-7xl mx-auto">
        <!-- Hero Header -->
        <div class="relative overflow-hidden bg-gradient-to-r from-emerald-800 via-teal-900 to-slate-900 rounded-3xl p-8 text-white shadow-xl border border-emerald-800/40">
            <div class="relative z-10 space-y-3 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-semibold uppercase tracking-wider text-emerald-200">
                    <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Modul Edukasi ISMUBA Muhammadiyah
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Kesehatan Islami & Thibbun Nabawi</h1>
                <p class="text-emerald-100 text-sm sm:text-base leading-relaxed">
                    Panduan hidup sehat berbasis Al-Qur'an, As-Sunnah, Thibbun Nabawi, serta fiqih kesehatan untuk membentuk generasi siswa yang sehat jasmani dan rohani.
                </p>
            </div>
            <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        </div>

        <!-- Article Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($articles as $article)
                @php
                    $badgeStyle = match($article->kategori) {
                        'Thibbun Nabawi' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                        'Adab Kebersihan' => 'bg-blue-50 text-blue-700 border-blue-200',
                        'Fiqih Sakit' => 'bg-amber-50 text-amber-700 border-amber-200',
                        default => 'bg-slate-50 text-slate-700 border-slate-200',
                    };
                @endphp

                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col justify-between group">
                    <div>
                        <!-- Cover Image -->
                        <div class="relative h-48 w-full overflow-hidden bg-slate-100">
                            <img src="{{ $article->image_url ?: 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=600&auto=format&fit=crop&q=80' }}"
                                 alt="{{ $article->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold border backdrop-blur-md shadow-sm {{ $badgeStyle }}">
                                    {{ $article->kategori }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-6 space-y-3">
                            <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
                                <span>{{ $article->created_at ? $article->created_at->translatedFormat('d M Y') : date('d M Y') }}</span>
                                <span>•</span>
                                <span>Edukasi UKS</span>
                            </div>

                            <h2 class="text-lg font-bold text-slate-900 group-hover:text-emerald-600 transition-colors line-clamp-2">
                                {{ $article->title }}
                            </h2>

                            <p class="text-xs text-slate-500 leading-relaxed line-clamp-3">
                                {{ Str::limit(strip_tags($article->content), 120) }}
                            </p>
                        </div>
                    </div>

                    <!-- Card Footer Button -->
                    <div class="px-6 pb-6 pt-2">
                        <a href="{{ route('ismuba.show', $article->slug) }}"
                           class="w-full py-3 px-4 bg-slate-50 hover:bg-emerald-600 text-slate-700 hover:text-white font-bold text-xs rounded-2xl border border-slate-200 hover:border-emerald-600 transition-all text-center flex items-center justify-center gap-2">
                            <span>Baca Selengkapnya</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-slate-100 space-y-3">
                    <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto text-2xl">
                        📚
                    </div>
                    <h3 class="text-base font-bold text-slate-800">Belum Ada Artikel ISMUBA</h3>
                    <p class="text-xs text-slate-400">Artikel edukasi kesehatan Islami akan segera diperbarui.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if(method_exists($articles, 'links'))
            <div class="pt-4">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
