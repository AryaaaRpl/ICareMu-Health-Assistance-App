<x-app-layout>
    <div class="space-y-8 max-w-4xl mx-auto">
        <!-- Back Navigation Button -->
        <div>
            <a href="{{ route('ismuba.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-slate-100 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 shadow-sm transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Edukasi ISMUBA
            </a>
        </div>

        <!-- Main Article Container -->
        <article class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden space-y-8 p-6 sm:p-10">
            <!-- Article Header Info -->
            <div class="space-y-4 border-b border-slate-100 pb-6">
                @php
                    $badgeStyle = match($article->kategori) {
                        'Thibbun Nabawi' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                        'Adab Kebersihan' => 'bg-blue-50 text-blue-700 border-blue-200',
                        'Fiqih Sakit' => 'bg-amber-50 text-amber-700 border-amber-200',
                        default => 'bg-slate-50 text-slate-700 border-slate-200',
                    };
                @endphp
                <div>
                    <span class="px-3.5 py-1.5 rounded-full text-xs font-bold border inline-block {{ $badgeStyle }}">
                        {{ $article->kategori }}
                    </span>
                </div>

                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight">
                    {{ $article->title }}
                </h1>

                <div class="flex items-center gap-3 text-xs font-semibold text-slate-400">
                    <span>Dipublikasikan: {{ $article->created_at ? $article->created_at->translatedFormat('d F Y') : date('d F Y') }}</span>
                    <span>•</span>
                    <span>Modul Kesehatan ISMUBA</span>
                </div>
            </div>

            <!-- Hero Image -->
            @if($article->image_url)
                <div class="rounded-2xl overflow-hidden max-h-96 w-full bg-slate-100 border border-slate-100">
                    <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            <!-- Article Body Content -->
            <div class="prose prose-slate max-w-none text-slate-800 text-sm sm:text-base leading-relaxed space-y-4 font-normal">
                {!! nl2br(e($article->content)) !!}
            </div>

            <!-- Islamic Health Quote Box -->
            <div class="p-6 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-2xl border border-emerald-100 flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-xl shrink-0 font-bold">
                    ☪️
                </div>
                <div class="space-y-1 text-emerald-950 text-xs sm:text-sm">
                    <h4 class="font-extrabold uppercase tracking-wider text-[11px] text-emerald-700">Motto Kesehatan ISMUBA Muhammadiyah</h4>
                    <p class="italic">"Jagalah sehatmu sebelum sakitmu, dan hidupmu sebelum matimu." (HR. Al-Hakim)</p>
                </div>
            </div>
        </article>

        <!-- Related Articles Section -->
        @if(isset($relatedArticles) && count($relatedArticles) > 0)
            <div class="space-y-4">
                <h3 class="text-lg font-extrabold text-slate-900">Artikel Terkait Lainnya</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach($relatedArticles as $rel)
                        <a href="{{ route('ismuba.show', $rel->slug) }}" class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm hover:border-emerald-500 hover:shadow-md transition-all space-y-2 block">
                            <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider block">{{ $rel->kategori }}</span>
                            <h4 class="text-xs font-bold text-slate-900 line-clamp-2">{{ $rel->title }}</h4>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
