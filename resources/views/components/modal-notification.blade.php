<div x-data="{
        showModal: false,
        type: 'success', // 'success' or 'error'
        title: '',
        message: '',
        initNotification() {
            @if (session('success'))
                this.type = 'success';
                this.title = 'Berhasil!';
                this.message = @json(session('success'));
                this.showModal = true;
            @elseif (session('error'))
                this.type = 'error';
                this.title = 'Gagal!';
                this.message = @json(session('error'));
                this.showModal = true;
            @elseif ($errors->any())
                this.type = 'error';
                this.title = 'Terjadi Kesalahan!';
                this.message = @json(implode(' ', $errors->all()));
                this.showModal = true;
            @endif
        }
    }"
    x-init="initNotification()">

    <template x-teleport="body">
        <div x-show="showModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200" 
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[100] overflow-y-auto bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 sm:p-6"
             style="display: none;">

            <div @click.away="showModal = false" 
                 x-show="showModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="bg-white rounded-3xl border border-slate-100 shadow-2xl w-full max-w-md p-6 text-center space-y-4 my-auto relative overflow-hidden">
                
                <!-- Close Button -->
                <button @click="showModal = false" class="absolute top-4 right-4 p-1.5 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <!-- Status Icon -->
                <div class="mx-auto w-16 h-16 rounded-2xl flex items-center justify-center shadow-inner"
                     :class="type === 'success' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-rose-50 text-rose-600 border border-rose-100'">
                    <template x-if="type === 'success'">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </template>
                    <template x-if="type === 'error'">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </template>
                </div>

                <!-- Text Content -->
                <div class="space-y-1.5">
                    <h3 class="text-lg font-bold text-slate-900" x-text="title"></h3>
                    <p class="text-xs text-slate-600 leading-relaxed" x-text="message"></p>
                </div>

                <!-- Action Button -->
                <div class="pt-2">
                    <button @click="showModal = false" 
                            class="w-full py-2.5 px-4 font-semibold text-xs rounded-xl shadow-lg transition duration-150 active:scale-[0.98]"
                            :class="type === 'success' ? 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-emerald-500/25' : 'bg-rose-600 hover:bg-rose-700 text-white shadow-rose-500/25'">
                        Mengerti
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>
