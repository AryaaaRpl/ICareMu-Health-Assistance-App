<x-app-layout>
    <!-- Marked.js for Markdown Parsing -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    <div x-data="aiChat()" class="flex flex-col h-[calc(100vh-7rem)] max-w-5xl mx-auto bg-white rounded-3xl border border-slate-200/80 shadow-xl overflow-hidden">
        <!-- Chat Header -->
        <div class="px-6 py-4 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white flex items-center justify-between shadow-md">
            <div class="flex items-center gap-3.5">
                <div class="relative">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center text-xl shadow-lg border border-white/20">
                        🤖
                    </div>
                    <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-emerald-400 border-2 border-slate-900 rounded-full"></span>
                </div>
                <div>
                    <h1 class="text-base font-extrabold tracking-tight flex items-center gap-2">
                        ICARE AI Health Assistant
                        <span class="px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-[10px] font-bold uppercase tracking-wider border border-emerald-500/30">
                            Gemini Flash
                        </span>
                    </h1>
                    <p class="text-xs text-slate-300 font-medium">Asisten Kesehatan & Pertolongan Pertama Sekolah</p>
                </div>
            </div>

            <!-- Optional Record Quick Selector -->
            @if(count($rekamMedisList) > 0)
                <div class="hidden sm:block">
                    <select x-on:change="sendRecordAnalysis($event.target.value)" class="bg-white/10 text-white text-xs rounded-xl border border-white/20 py-2 px-3 focus:ring-2 focus:ring-indigo-400 focus:outline-none backdrop-blur-md">
                        <option value="" class="bg-slate-900 text-white">-- Analisis Rekam Medis Saya --</option>
                        @foreach($rekamMedisList as $rec)
                            @php
                                $sName = $rec->siswa ? ($rec->siswa->name ?? $rec->siswa->nama_lengkap ?? 'Siswa #'.$rec->siswa_id) : 'Siswa #'.$rec->siswa_id;
                            @endphp
                            <option value="Mohon berikan analisis kesehatan dan saran pertolongan pertama untuk siswa bernama {{ $sName }} dengan keluhan: {{ $rec->keluhan_utama ?? 'Demam/Pusing' }}, suhu tubuh: {{ $rec->suhu ?? 36.5 }}°C, tekanan darah: {{ $rec->tekanan_darah ?? '120/80' }}." class="bg-slate-900 text-white">
                                [{{ $sName }}] {{ Str::limit($rec->keluhan_utama ?? 'Rekam Medis', 30) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>

        <!-- Chat History Scrollable Area -->
        <div id="chat-container" class="flex-1 overflow-y-auto p-6 space-y-5 bg-slate-50/60 scroll-smooth">
            <template x-for="(msg, index) in messages" :key="index">
                <div>
                    <!-- AI Message Bubble -->
                    <template x-if="msg.role === 'ai' || msg.role === 'assistant'">
                        <div class="flex items-start gap-3 max-w-3xl animate-fadeIn">
                            <div class="w-9 h-9 rounded-2xl bg-indigo-600 text-white flex items-center justify-center text-sm font-bold shrink-0 shadow-md">
                                AI
                            </div>
                            <div class="bg-white border border-slate-200/80 rounded-2xl rounded-tl-none p-5 shadow-sm text-slate-800 text-sm leading-relaxed">
                                <div class="prose prose-sm prose-slate max-w-none prose-a:text-indigo-600 prose-a:font-semibold prose-a:no-underline hover:prose-a:underline" x-html="parseMarkdown(msg.text || msg.content)"></div>
                            </div>
                        </div>
                    </template>

                    <!-- User Message Bubble -->
                    <template x-if="msg.role === 'user'">
                        <div class="flex justify-end animate-fadeIn">
                            <div class="max-w-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-2xl rounded-tr-none px-5 py-3.5 shadow-md text-sm font-medium leading-relaxed whitespace-pre-line">
                                <span x-text="msg.text || msg.content"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </template>

            <!-- Loading Indicator -->
            <div x-show="isLoading" class="flex items-center gap-3 animate-pulse">
                <div class="w-9 h-9 rounded-2xl bg-indigo-600 text-white flex items-center justify-center text-sm font-bold shrink-0">
                    AI
                </div>
                <div class="bg-white border border-slate-200 rounded-2xl rounded-tl-none px-4 py-3 shadow-sm flex items-center gap-2">
                    <span class="w-2 h-2 bg-indigo-600 rounded-full animate-bounce"></span>
                    <span class="w-2 h-2 bg-indigo-600 rounded-full animate-bounce [animation-delay:0.2s]"></span>
                    <span class="w-2 h-2 bg-indigo-600 rounded-full animate-bounce [animation-delay:0.4s]"></span>
                    <span class="text-xs font-semibold text-slate-500 ms-1">Menganalisis tanggapan...</span>
                </div>
            </div>
        </div>

        <!-- Topic Chips & Input Area (Fixed Bottom) -->
        <div class="p-4 sm:p-6 bg-white border-t border-slate-200/80 space-y-4">
            <!-- Suggested Topic Chips -->
            <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none text-xs font-semibold">
                <span class="text-slate-400 shrink-0 text-[11px] uppercase tracking-wider font-bold">Topik Saran:</span>

                <button x-on:click="sendMessage('Bagaimana cara penanganan awal kram perut menstruasi bagi siswi di UKS?')"
                    class="shrink-0 px-3 py-1.5 rounded-full bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 transition-all flex items-center gap-1.5">
                    🌸 <span>Kesehatan Wanita</span>
                </button>

                <button x-on:click="sendMessage('Berikan tips pola hidup sehat dan pencegahan anemia untuk remaja sekolah.')"
                    class="shrink-0 px-3 py-1.5 rounded-full bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/80 transition-all flex items-center gap-1.5">
                    🏃 <span>Pola Hidup Sehat</span>
                </button>

                <button x-on:click="sendMessage('Apa prosedur pertolongan pertama jika siswa mengalami demam tinggi diatas 38.5°C di sekolah?')"
                    class="shrink-0 px-3 py-1.5 rounded-full bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200/80 transition-all flex items-center gap-1.5">
                    🩹 <span>Pertolongan Pertama Demam</span>
                </button>

                <button x-on:click="sendMessage('Bagaimana panduan gizi dan menu sarapan sehat untuk meningkatkan konsentrasi belajar siswa?')"
                    class="shrink-0 px-3 py-1.5 rounded-full bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200/80 transition-all flex items-center gap-1.5">
                    🥗 <span>Gizi & Nutrisi Siswa</span>
                </button>
            </div>

            <!-- Input Bar -->
            <form x-on:submit.prevent="sendMessage()" class="relative flex items-center gap-3">
                <input
                    type="text"
                    x-model="inputText"
                    :disabled="isLoading"
                    placeholder="Ketik pertanyaan kesehatan atau pertolongan pertama di sini..."
                    class="w-full rounded-2xl border-slate-200/90 bg-slate-50/80 py-4 pl-5 pr-14 text-sm text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium disabled:opacity-60"
                />

                <button
                    type="submit"
                    :disabled="isLoading || !inputText.trim()"
                    class="absolute right-2.5 p-3 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold transition-all disabled:opacity-40 disabled:cursor-not-allowed shadow-md hover:shadow-lg transform active:scale-95 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9-7-9-7-9 7 9 7zm0 0v-8"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Alpine.js Component Logic -->
    <script>
        function aiChat() {
            return {
                messages: [
                    {
                        role: 'ai',
                        text: 'Halo! Saya ICARE AI Health Assistant 👋. Ada yang bisa saya bantu terkait pertolongan pertama, kesehatan siswa, atau edukasi pola hidup sehat di sekolah?'
                    }
                ],
                inputText: '',
                isLoading: false,

                async sendMessage(customText = null) {
                    const textToSend = customText || this.inputText;
                    if (!textToSend || !textToSend.trim() || this.isLoading) return;

                    // Append user message
                    this.messages.push({
                        role: 'user',
                        text: textToSend.trim()
                    });

                    this.inputText = '';
                    this.isLoading = true;
                    this.scrollToBottom();

                    try {
                        const response = await fetch("{{ route('ai.chat') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "Accept": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                message: textToSend
                            })
                        });

                        const data = await response.json();

                        if (response.ok && data.reply) {
                            this.messages.push({
                                role: 'ai',
                                text: data.reply
                            });
                        } else {
                            this.messages.push({
                                role: 'ai',
                                text: data.message || 'Maaf, terjadi kesalahan dalam memproses tanggapan AI.'
                            });
                        }
                    } catch (error) {
                        console.error("Chat Error:", error);
                        this.messages.push({
                            role: 'ai',
                            text: 'Maaf, terjadi masalah koneksi jaringan. Silakan coba lagi.'
                        });
                    } finally {
                        this.isLoading = false;
                        this.scrollToBottom();
                    }
                },

                sendRecordAnalysis(prompt) {
                    if (prompt) {
                        this.sendMessage(prompt);
                    }
                },

                parseMarkdown(text) {
                    if (!text) return '';
                    if (typeof marked !== 'undefined') {
                        return marked.parse(text);
                    }
                    return text;
                },

                scrollToBottom() {
                    this.$nextTick(() => {
                        const container = document.getElementById('chat-container');
                        if (container) {
                            container.scrollTop = container.scrollHeight;
                        }
                    });
                }
            }
        }
    </script>
</x-app-layout>
