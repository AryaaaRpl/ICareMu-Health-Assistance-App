<x-app-layout>
    <div x-data="{
        openModal: false,
        modalMode: 'create',
        editId: null,
        form: { judul: '', kategori: 'Fiqih', konten: '', status: 'published' },
        resetForm() {
            this.form = { judul: '', kategori: 'Fiqih', konten: '', status: 'published' };
            this.editId = null;
            this.modalMode = 'create';
        },
        openCreate() {
            this.resetForm();
            this.openModal = true;
        },
        openEdit(btn) {
            this.resetForm();
            this.modalMode = 'edit';
            this.editId = btn.dataset.id;
            this.form = {
                judul: btn.dataset.judul,
                kategori: btn.dataset.kategori || 'Fiqih',
                konten: btn.dataset.konten,
                status: btn.dataset.status,
            };
            this.openModal = true;
        }
    }" class="space-y-10 max-w-7xl mx-auto pb-12">
        <!-- Hero Header -->
        <div class="relative overflow-hidden bg-gradient-to-r from-emerald-800 via-teal-900 to-slate-900 rounded-3xl p-8 text-white shadow-xl border border-emerald-800/40">
            <div class="relative z-10 space-y-3 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-semibold uppercase tracking-wider text-emerald-200">
                    <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Modul Edukasi ISMUBA Muhammadiyah
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Edukasi ISMUBA & Halo Asatidz</h1>
                <p class="text-emerald-100 text-sm sm:text-base leading-relaxed">
                    Panduan hidup sehat berbasis Al-Qur'an, As-Sunnah, Thibbun Nabawi, serta konsultasi langsung bersama Asatidz ISMUBA.
                </p>
            </div>
            <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        </div>

        @if (session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-sm font-semibold flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
            </div>
        @endif

        @if(in_array(auth()->user()->role, ['super_admin', 'admin_super', 'admin_uks', 'petugas_uks', 'guru_ismuba']))
            <div class="flex justify-end mb-6">
                <button @click="openCreate()" class="px-5 py-2.5 bg-emerald-600 text-white text-xs font-bold rounded-xl hover:bg-emerald-700 transition shadow-md flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Tambah Edukasi ISMUBA</span>
                </button>
            </div>
        @endif

        <!-- Halo Asatidz Section -->
        <section class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">Halo Asatidz</h2>
                    <p class="text-xs sm:text-sm text-slate-500">Konsultasi seputar fikih kesehatan, keislaman, dan kesehatan mental dengan Guru ISMUBA</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($asatidz as $guru)
                    <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-800 font-bold flex items-center justify-center text-xl shadow-inner border border-emerald-200">
                                {{ strtoupper(substr($guru->nama ?? $guru->name ?? 'U', 0, 2)) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-base">{{ $guru->nama ?? $guru->name }}</h3>
                                <p class="text-xs text-emerald-600 font-medium">Guru ISMUBA / Konsultan</p>
                            </div>
                        </div>

                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $guru->no_wa ?? $guru->no_wa_wali ?? '') }}?text={{ urlencode('Assalamualaikum Ustadz/Ustadzah ' . ($guru->nama ?? $guru->name) . ', saya ' . (auth()->user()->nama ?? auth()->user()->name) . ' izin berkonsultasi mengenai...') }}"
                           target="_blank"
                           class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-2xl shadow-md transition-all text-center flex items-center justify-center gap-2 group">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                            </svg>
                            <span>Konsultasi via WhatsApp</span>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-3xl p-8 text-center border border-slate-100 space-y-2">
                        <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto text-xl">
                            👳‍♂️
                        </div>
                        <h4 class="text-sm font-bold text-slate-800">Belum Ada Asatidz Tersedia</h4>
                        <p class="text-xs text-slate-400">Jadwal konsultasi Asatidz akan segera diperbarui.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Articles Section -->
        <section class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">Artikel ISMUBA</h2>
                    <p class="text-xs sm:text-sm text-slate-500">Kumpulan edukasi kesehatan islami dan fiqih kebersihan</p>
                </div>
            </div>

            <!-- Article Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($artikels as $article)
                    @php
                        $badgeStyle = match($article->kategori) {
                            'Fiqih', 'fikih_wanita' => 'bg-pink-50 text-pink-700 border-pink-200',
                            'Aqidah' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'Akhlaq', 'kesehatan_mental' => 'bg-purple-50 text-purple-700 border-purple-200',
                            'Tarikh', 'artikel_islami' => 'bg-blue-50 text-blue-700 border-blue-200',
                            default => 'bg-slate-50 text-slate-700 border-slate-200',
                        };

                        $kategoriLabel = match($article->kategori) {
                            'edukasi_kesehatan' => 'Edukasi Kesehatan',
                            'fikih_wanita' => 'Fikih Wanita',
                            'kesehatan_mental' => 'Kesehatan Mental',
                            'artikel_islami' => 'Artikel Islami',
                            default => $article->kategori,
                        };

                        $isAdmin = in_array(auth()->user()->role, ['super_admin', 'admin_super', 'admin_uks', 'petugas_uks', 'guru_ismuba']);
                    @endphp

                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col justify-between group">
                        <div>
                            <!-- Cover Image -->
                            <div class="relative h-48 w-full overflow-hidden bg-slate-100">
                                <img src="{{ $article->thumbnail ?: ($article->cover ?: 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=600&auto=format&fit=crop&q=80') }}"
                                     alt="{{ $article->judul }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute top-4 left-4 flex items-center gap-2">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold border backdrop-blur-md shadow-sm {{ $badgeStyle }}">
                                        {{ $kategoriLabel }}
                                    </span>
                                    @if($article->status === 'draft')
                                        <span class="px-3 py-1 rounded-full text-xs font-bold border backdrop-blur-md shadow-sm bg-amber-50 text-amber-700 border-amber-200">
                                            Draft
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-6 space-y-3">
                                <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
                                    <span>{{ $article->created_at ? $article->created_at->translatedFormat('d M Y') : date('d M Y') }}</span>
                                    <span>•</span>
                                    <span>Edukasi ISMUBA</span>
                                </div>

                                <h3 class="text-lg font-bold text-slate-900 group-hover:text-emerald-600 transition-colors line-clamp-2">
                                    {{ $article->judul }}
                                </h3>

                                <p class="text-xs text-slate-500 leading-relaxed line-clamp-3">
                                    {{ Str::limit(strip_tags($article->konten), 120) }}
                                </p>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="px-6 pb-6 pt-2 space-y-2">
                            @if($isAdmin)
                                <div class="flex items-center justify-end gap-2">
                                    <button
                                        data-id="{{ $article->id }}"
                                        data-judul="{{ $article->judul }}"
                                        data-kategori="{{ $article->kategori }}"
                                        data-konten="{{ $article->konten }}"
                                        data-status="{{ $article->status }}"
                                        @click="openEdit($event.currentTarget)"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-xl transition"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </button>
                                    <form action="{{ route('ismuba.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                        @csrf @method('DELETE')
                                        <button class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-rose-600 hover:text-rose-700 hover:bg-rose-50 rounded-xl transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            @endif

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
        </section>

        <!-- Alpine.js Modal (Create / Edit) -->
        <div x-show="openModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4"
             style="display: none;">

            <div @click.away="openModal = false"
                 x-show="openModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="bg-white rounded-3xl border border-slate-100 shadow-2xl w-full max-w-2xl overflow-hidden">

                <!-- Modal Header -->
                <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900" x-text="modalMode === 'edit' ? 'Edit Artikel/Edukasi' : 'Tambah Edukasi ISMUBA'"></h3>
                        <p class="text-xs text-slate-500 mt-0.5" x-text="modalMode === 'edit' ? 'Perbarui konten artikel ISMUBA.' : 'Buat artikel edukasi ISMUBA baru.'"></p>
                    </div>
                    <button @click="openModal = false" class="p-2 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition duration-150">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Form -->
                <form x-bind:action="modalMode === 'edit' ? '/ismuba/' + editId : '{{ route('ismuba.store') }}'" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                    @csrf
                    <input type="hidden" name="_method" x-bind:value="modalMode === 'edit' ? 'PUT' : 'POST'">

                    <!-- Field: Judul -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Judul Artikel <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="judul" x-model="form.judul" required placeholder="Masukkan judul artikel" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition duration-150">
                    </div>

                    <!-- Field: Kategori -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Kategori <span class="text-rose-500">*</span>
                        </label>
                        <select name="kategori" x-model="form.kategori" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition duration-150">
                            <option value="Fiqih">Fiqih</option>
                            <option value="Aqidah">Aqidah</option>
                            <option value="Akhlaq">Akhlaq</option>
                            <option value="Tarikh">Tarikh</option>
                        </select>
                    </div>

                    <!-- Field: Konten -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Konten <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="konten" x-model="form.konten" rows="6" required placeholder="Tulis konten artikel di sini..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition duration-150"></textarea>
                    </div>

                    <!-- Field: Cover / Gambar -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Cover / Gambar
                        </label>
                        <input type="file" name="cover" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition duration-150">
                    </div>

                    <!-- Field: Status -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Status
                        </label>
                        <select name="status" x-model="form.status" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition duration-150">
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>

                    <!-- Modal Actions -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" @click="openModal = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition duration-150">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-lg shadow-emerald-500/20 transition duration-150">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
