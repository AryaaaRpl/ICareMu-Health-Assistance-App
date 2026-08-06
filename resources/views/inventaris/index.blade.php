<x-app-layout>
    @php
        $currentSearch = request('search', '');
        $currentCategory = request('kategori', '');
    @endphp

    <div x-data="{
        openModal: false,
        modalMode: 'create',
        editId: null,
        search: @js($currentSearch),
        kategori: @js($currentCategory),
        performFilter() {
            const params = new URLSearchParams(window.location.search);
            if (this.search && this.search.trim()) {
                params.set('search', this.search.trim());
            } else {
                params.delete('search');
            }
            if (this.kategori) {
                params.set('kategori', this.kategori);
            } else {
                params.delete('kategori');
            }
            const newUrl = `${window.location.pathname}?${params.toString()}`;
            window.location.href = newUrl;
        },
        form: {
            nama_barang: '',
            kategori: 'Obat',
            jumlah: 1,
            satuan: 'Pcs',
            kondisi: 'Baik',
            keterangan: ''
        },
        resetForm() {
            this.form = {
                nama_barang: '',
                kategori: 'Obat',
                jumlah: 1,
                satuan: 'Pcs',
                kondisi: 'Baik',
                keterangan: ''
            };
            this.editId = null;
            this.modalMode = 'create';
        },
        openCreate() {
            this.resetForm();
            this.openModal = true;
        },
        openEdit(item) {
            this.resetForm();
            this.modalMode = 'edit';
            this.editId = item.id;
            this.form = {
                nama_barang: item.nama_barang,
                kategori: item.kategori,
                jumlah: item.jumlah || item.stok || 0,
                satuan: item.satuan,
                kondisi: item.kondisi,
                keterangan: item.keterangan || ''
            };
            this.openModal = true;
        }
    }">
    <div class="space-y-6">
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
                <button @click="openCreate()" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-xs font-semibold rounded-2xl shadow-lg shadow-blue-500/25 transition duration-150 transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tambah Barang</span>
                </button>
            </div>
        </div>

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
                    <h4 class="text-xl font-bold text-slate-900 mt-0.5">
                        {{ method_exists($inventaris, 'total') ? $inventaris->total() : count($inventaris) }}
                    </h4>
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
                <input type="text" x-model.debounce.500ms="search" @input="performFilter()" placeholder="Cari nama barang atau keterangan..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150">
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Filter Kategori:</span>
                <select x-model="kategori" @change="performFilter()" class="bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Kategori</option>
                    <option value="Obat" @selected($currentCategory == 'Obat')>Obat</option>
                    <option value="Alat Medis" @selected($currentCategory == 'Alat Medis')>Alat Medis</option>
                    <option value="Perlengkapan" @selected($currentCategory == 'Perlengkapan')>Perlengkapan</option>
                    @if(isset($categories) && count($categories) > 0)
                        @foreach($categories as $cat)
                            @if(!in_array($cat, ['Obat', 'Alat Medis', 'Perlengkapan']))
                                <option value="{{ $cat }}" @selected($currentCategory == $cat)>{{ $cat }}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
                @if($currentSearch || $currentCategory)
                    <a href="{{ route('inventaris.index') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-600 transition">
                        Reset
                    </a>
                @endif
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
                        @forelse($inventaris as $item)
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

                                <!-- Action Buttons -->
                                <td class="py-4 px-6 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-2">
                                        <button @click='openEdit(@json($item))' title="Edit" class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-150">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>

                                        <form action="{{ route('inventaris.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition duration-150">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400 font-medium">
                                    Belum ada data barang inventaris UKS.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if(method_exists($inventaris, 'links'))
                    <div class="p-4">
                        {{ $inventaris->withQueryString()->links() }}
                    </div>
                @endif
            </div>

            <!-- Table Footer -->
            <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Menampilkan <strong>{{ method_exists($inventaris, 'count') ? $inventaris->count() : count($inventaris) }}</strong> barang inventaris</span>
                <span class="text-[11px] text-slate-400 uppercase tracking-widest font-semibold">Logistik UKS</span>
            </div>
        </div>
        </div>

        <!-- Alpine.js Modal (Form Create / Edit Barang) -->
        <div x-show="openModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4 sm:p-6"
             style="display: none;">
            
            <div @click.away="openModal = false"
                 x-show="openModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="bg-white rounded-2xl border border-slate-100 shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col my-auto overflow-hidden">
                
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 bg-slate-50/50 shrink-0">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900" x-text="modalMode === 'edit' ? 'Edit Barang Inventaris' : 'Tambah Barang Inventaris UKS'"></h3>
                        <p class="text-xs text-slate-500 mt-0.5" x-text="modalMode === 'edit' ? 'Perbarui data obat atau peralatan medis.' : 'Isi detail obat atau peralatan medis baru.'"></p>
                    </div>
                    <button @click="openModal = false" class="p-2 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition duration-150">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Form targeting store or update -->
                <form :action="modalMode === 'edit' ? '/inventaris/' + editId : '{{ route('inventaris.store') }}'" method="POST" class="p-6 space-y-4 overflow-y-auto">
                    @csrf
                    <template x-if="modalMode === 'edit'">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <!-- Field: nama_barang -->
                    <div>
                        <label for="nama_barang" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Nama Barang <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nama_barang" id="nama_barang" x-model="form.nama_barang" required placeholder="Contoh: Paracetamol 500mg, Betadine" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150">
                    </div>

                    <!-- Field: kategori -->
                    <div>
                        <label for="kategori" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Kategori <span class="text-rose-500">*</span>
                        </label>
                        <select name="kategori" id="kategori" x-model="form.kategori" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150">
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
                            <input type="number" name="jumlah" id="jumlah" x-model="form.jumlah" required min="0" placeholder="10" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150">
                        </div>

                        <!-- Field: satuan -->
                        <div>
                            <label for="satuan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Satuan <span class="text-rose-500">*</span>
                            </label>
                            <select name="satuan" id="satuan" x-model="form.satuan" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150">
                                <option value="Strip">Strip</option>
                                <option value="Botol">Botol</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Box">Box</option>
                                <option value="Tablet">Tablet</option>
                                <option value="Unit">Unit</option>
                            </select>
                        </div>
                    </div>

                    <!-- Field: kondisi -->
                    <div>
                        <label for="kondisi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Kondisi <span class="text-rose-500">*</span>
                        </label>
                        <select name="kondisi" id="kondisi" x-model="form.kondisi" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150">
                            <option value="Baik">Baik</option>
                            <option value="Rusak">Rusak</option>
                            <option value="Kadaluwarsa">Kadaluwarsa</option>
                        </select>
                    </div>

                    <!-- Field: keterangan -->
                    <div>
                        <label for="keterangan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Keterangan
                        </label>
                        <textarea name="keterangan" id="keterangan" x-model="form.keterangan" rows="3" placeholder="Catatan tambahan mengenai kondisi / kedaluwarsa barang..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition duration-150 resize-none"></textarea>
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
