<x-app-layout>
    @php
        // Fallback dummy inventory data if not passed from controller
        $inventaris = $inventaris ?? [
            (object)[
                'id' => 1,
                'nama_barang' => 'Paracetamol 500mg',
                'kategori' => 'Obat',
                'jumlah' => 150,
                'stok' => 150,
                'satuan' => 'Tablet',
                'kondisi' => 'Baik',
                'keterangan' => 'Stok aman untuk pertolongan demam & pusing.',
            ],
            (object)[
                'id' => 2,
                'nama_barang' => 'Betadine Antiseptik 60ml',
                'kategori' => 'Obat',
                'jumlah' => 5,
                'stok' => 5,
                'satuan' => 'Botol',
                'kondisi' => 'Baik',
                'keterangan' => 'Stok menipis, perlu pengadaan ulang minggu ini.',
            ],
            (object)[
                'id' => 3,
                'nama_barang' => 'Termometer Digital Infrared',
                'kategori' => 'Alat Medis',
                'jumlah' => 3,
                'stok' => 3,
                'satuan' => 'Pcs',
                'kondisi' => 'Baik',
                'keterangan' => 'Kondisi baterai penuh, kalibrasi normal.',
            ],
            (object)[
                'id' => 4,
                'nama_barang' => 'Kasa Steril 16x16 cm',
                'kategori' => 'Perlengkapan',
                'jumlah' => 45,
                'stok' => 45,
                'satuan' => 'Box',
                'kondisi' => 'Baik',
                'keterangan' => 'P3K dasar luka ringan.',
            ],
            (object)[
                'id' => 5,
                'nama_barang' => 'Tensimeter Anaroid Manual',
                'kategori' => 'Alat Medis',
                'jumlah' => 1,
                'stok' => 1,
                'satuan' => 'Pcs',
                'kondisi' => 'Rusak',
                'keterangan' => 'Manset bocor, menunggu servis / penggantian unit baru.',
            ],
        ];
    @endphp

    <div x-data="{ openModal: false, search: '', categoryFilter: '' }" class="space-y-6">
        
        <!-- Header & Action Button -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-semibold tracking-wide uppercase">
                        Manajerial Logistik
                    </span>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight mt-2">
                    Manajemen Inventaris UKS
                </h1>
                <p class="text-xs md:text-sm text-slate-500 mt-1">
                    Sistem manajemen ketersediaan obat-obatan, alat medis, dan perlengkapan P3K sekolah.
                </p>
            </div>
            
            <div class="flex items-center gap-3">
                <button @click="openModal = true" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-xs font-semibold rounded-2xl shadow-lg shadow-blue-500/25 transition duration-150 transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tambah Barang</span>
                </button>
            </div>
        </div>

        <!-- Success Flash Message -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-700 text-xs font-semibold flex items-center gap-3 shadow-xs">
                <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Quick Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">TOTAL ITEM</span>
                    <h4 class="text-xl font-bold text-slate-900 mt-0.5">{{ count($inventaris) }}</h4>
                    <p class="text-[11px] text-slate-500 font-medium">Jenis Logistik Terdata</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">KONDISI BAIK</span>
                    <h4 class="text-xl font-bold text-slate-900 mt-0.5">
                        {{ collect($inventaris)->where('kondisi', 'Baik')->count() }}
                    </h4>
                    <p class="text-[11px] text-emerald-600 font-medium">Siap Digunakan</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">KONDISI RUSAK / HABIS</span>
                    <h4 class="text-xl font-bold text-slate-900 mt-0.5">
                        {{ collect($inventaris)->where('kondisi', '!=', 'Baik')->count() }}
                    </h4>
                    <p class="text-[11px] text-rose-500 font-medium">Perlu Perbaikan / Restok</p>
                </div>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="relative w-full md:w-80">
                <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" x-model="search" placeholder="Cari nama barang atau keterangan..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150">
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Filter Kategori:</span>
                <select x-model="categoryFilter" class="bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Kategori</option>
                    <option value="Obat">Obat</option>
                    <option value="Alat Medis">Alat Medis</option>
                    <option value="Perlengkapan">Perlengkapan</option>
                </select>
            </div>
        </div>

        <!-- Inventory Data Table Card -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                            <th class="py-4 px-6">Nama Barang</th>
                            <th class="py-4 px-6">Kategori</th>
                            <th class="py-4 px-6">Jumlah & Satuan</th>
                            <th class="py-4 px-6">Kondisi</th>
                            <th class="py-4 px-6">Keterangan</th>
                            <th class="py-4 px-6 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @foreach($inventaris as $item)
                            <tr class="hover:bg-slate-50/60 transition duration-150">
                                <!-- Nama Barang -->
                                <td class="py-4 px-6 font-bold text-slate-900 whitespace-nowrap">
                                    {{ $item->nama_barang }}
                                </td>

                                <!-- Kategori -->
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $item->kategori }}
                                    </span>
                                </td>

                                <!-- Jumlah & Satuan -->
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <span class="font-extrabold text-slate-900 text-sm">{{ $item->jumlah ?? $item->stok ?? 0 }}</span>
                                    <span class="text-xs text-slate-400 font-semibold uppercase ml-1">{{ $item->satuan }}</span>
                                </td>

                                <!-- Kondisi (Green for 'Baik', Red for 'Rusak') -->
                                <td class="py-4 px-6 whitespace-nowrap">
                                    @php
                                        $isBaik = strtolower($item->kondisi) === 'baik';
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border {{ $isBaik ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : 'bg-rose-50 text-rose-600 border-rose-200' }}">
                                        <span class="w-2 h-2 rounded-full {{ $isBaik ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                        <span>{{ $item->kondisi }}</span>
                                    </span>
                                </td>

                                <!-- Keterangan -->
                                <td class="py-4 px-6 max-w-xs">
                                    <p class="text-slate-600 font-medium truncate" title="{{ $item->keterangan }}">
                                        {{ $item->keterangan ?? '-' }}
                                    </p>
                                </td>

                                <!-- Action (Edit/Delete placeholder buttons) -->
                                <td class="py-4 px-6 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-2">
                                        <button title="Edit" class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-150">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button title="Hapus" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition duration-150">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Menampilkan <strong>{{ count($inventaris) }}</strong> barang inventaris</span>
                <span class="text-[11px] text-slate-400 uppercase tracking-widest font-semibold">Logistik UKS</span>
            </div>
        </div>

        <!-- Alpine.js Modal (Form Tambah Barang) -->
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
                 class="bg-white rounded-3xl border border-slate-100 shadow-2xl w-full max-w-lg overflow-hidden">
                
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Tambah Barang Inventaris UKS</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Isi detail obat atau peralatan medis baru.</p>
                    </div>
                    <button @click="openModal = false" class="p-2 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition duration-150">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Native Form targeting route('inventaris.store') -->
                <form action="{{ route('inventaris.store') }}" method="POST" class="p-6 space-y-4">
                    @csrf

                    <!-- Field: nama_barang -->
                    <div>
                        <label for="nama_barang" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Nama Barang <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nama_barang" id="nama_barang" required placeholder="Contoh: Paracetamol 500mg, Betadine" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150">
                    </div>

                    <!-- Field: kategori -->
                    <div>
                        <label for="kategori" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Kategori <span class="text-rose-500">*</span>
                        </label>
                        <select name="kategori" id="kategori" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150">
                            <option value="Obat">Obat</option>
                            <option value="Alat Medis">Alat Medis</option>
                            <option value="Perlengkapan">Perlengkapan</option>
                        </select>
                    </div>

                    <!-- Grid Row: jumlah & satuan -->
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Field: jumlah -->
                        <div>
                            <label for="jumlah" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Jumlah <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" name="jumlah" id="jumlah" required min="0" placeholder="10" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150">
                        </div>

                        <!-- Field: satuan -->
                        <div>
                            <label for="satuan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Satuan <span class="text-rose-500">*</span>
                            </label>
                            <select name="satuan" id="satuan" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150">
                                <option value="Strip">Strip</option>
                                <option value="Botol">Botol</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Box">Box</option>
                                <option value="Tablet">Tablet</option>
                            </select>
                        </div>
                    </div>

                    <!-- Field: kondisi -->
                    <div>
                        <label for="kondisi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Kondisi <span class="text-rose-500">*</span>
                        </label>
                        <select name="kondisi" id="kondisi" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150">
                            <option value="Baik" selected>Baik</option>
                            <option value="Rusak">Rusak</option>
                        </select>
                    </div>

                    <!-- Field: keterangan -->
                    <div>
                        <label for="keterangan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Keterangan
                        </label>
                        <textarea name="keterangan" id="keterangan" rows="3" placeholder="Catatan tambahan mengenai kondisi / kedaluwarsa barang..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150"></textarea>
                    </div>

                    <!-- Modal Actions -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" @click="openModal = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition duration-150">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl shadow-lg shadow-blue-500/20 transition duration-150">
                            Simpan Barang
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</x-app-layout>
