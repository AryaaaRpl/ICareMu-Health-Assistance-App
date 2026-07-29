<x-app-layout>
    <!-- Wrapper utama, kita set full height dikurangi margin biar fit layar -->
    <div x-data="aiChat(
            @js($conversations->first()?->id), 
            @js($conversations->first()?->messages ?? [])
        )" 
        class="flex flex-col h-[85vh] bg-slate-50/50 rounded-2xl overflow-hidden shadow-sm border border-slate-200">
        
        <!-- Header Chat (Minimalist) -->
        <div class="bg-white border-b border-slate-100 px-6 py-4 flex items-center justify-between shrink-0 z-10">
            <div class="flex items-center gap-4">
                <!-- Icon Header -->
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-[17px] font-bold text-slate-800 leading-tight">AI Health Assistant</h2>
                    <p class="text-[10px] font-bold text-blue-600 uppercase tracking-wider mt-0.5">TANYA JAWAB KESEHATAN DASAR</p>
                </div>
            </div>
            <!-- Info Icon -->
            <button class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </button>
        </div>

        <!-- Chat Area (Scrollable) -->
        <div id="chat-container" class="flex-1 overflow-y-auto p-6 space-y-6">
            
            <!-- Default Welcome Message -->
            <template x-if="messages.length === 0">
                <div class="flex items-start gap-3 max-w-3xl">
                    <div class="w-8 h-8 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="bg-white border border-slate-200 p-4 rounded-2xl rounded-tl-sm text-slate-700 text-[14px] leading-relaxed shadow-sm">
                        Halo! 👋 Saya ICARE. Jangan ragu untuk bertanya tentang kesehatan, mulai dari keluhan ringan, kesehatan reproduksi, kesehatan mental, hingga tips hidup sehat.<br><br>Yuk, ceritakan apa yang sedang kamu rasakan!
                    </div>
                </div>
            </template>

            <!-- Looping Messages -->
            <template x-for="msg in messages" :key="msg.id || Math.random()">
                <div class="w-full flex" :class="msg.role === 'user' ? 'justify-end' : 'justify-start'">
                    
                    <!-- AI Bubble -->
                    <template x-if="msg.role === 'assistant' || msg.role === 'ai'">
                        <div class="flex items-start gap-3 w-full max-w-3xl">
                            <!-- Avatar Bot Kecil -->
                            <div class="w-8 h-8 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center shrink-0 mt-1">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <!-- Bubble Putih Bot + Markdown Parser yang lu perbaiki sebelumnya -->
                            <div class="bg-white border border-slate-200 p-4 md:p-5 rounded-2xl rounded-tl-sm text-slate-700 text-[14px] leading-relaxed shadow-sm [&>h3]:font-bold [&>h3]:text-slate-900 [&>h3]:mb-2 [&>ul]:list-disc [&>ul]:ml-5 [&>p]:mb-3 last:[&>p]:mb-0" x-html="msg.content"></div>
                        </div>
                    </template>

                    <!-- User Bubble -->
                    <template x-if="msg.role === 'user'">
                        <div class="flex items-start justify-end gap-3 w-full max-w-3xl">
                            <!-- Bubble Putih User (Sesuai Design) -->
                            <div class="bg-white border border-slate-200 p-4 rounded-2xl rounded-tr-sm text-slate-700 text-[14px] leading-relaxed shadow-sm" x-text="msg.content"></div>
                            <!-- Avatar User Kecil -->
                            <div class="w-8 h-8 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center shrink-0 mt-1">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                        </div>
                    </template>

                </div>
            </template>

            <!-- Loading Indicator -->
            <template x-if="isLoading">
                <div class="flex items-start gap-3 max-w-3xl">
                    <div class="w-8 h-8 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center shrink-0 mt-1">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="bg-white border border-slate-200 px-5 py-4 rounded-2xl rounded-tl-sm shadow-sm flex items-center gap-1.5 h-[52px]">
                        <div class="w-2 h-2 bg-blue-400 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-blue-400 rounded-full animate-bounce" style="animation-delay: 0.15s"></div>
                        <div class="w-2 h-2 bg-blue-400 rounded-full animate-bounce" style="animation-delay: 0.3s"></div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Input Area & Quick Replies -->
        <div class="bg-white border-t border-slate-100 p-4 shrink-0 relative z-10">
            <!-- Suggestion Chips (Tengah) -->
            <div class="flex items-center justify-center gap-2 mb-4 overflow-x-auto pb-1 no-scrollbar">
                <template x-for="chip in ['Kesehatan Wanita', 'Pola Hidup Sehat', 'Cek Kesehatan', 'Kesehatan Mental']">
                    <button 
                        @click="newMessage = chip; sendMessage()" 
                        :disabled="isLoading"
                        class="px-4 py-1.5 rounded-full bg-blue-50 text-blue-600 text-[11px] font-bold whitespace-nowrap hover:bg-blue-100 transition-colors disabled:opacity-50"
                        x-text="chip"
                    ></button>
                </template>
            </div>

            <!-- Input Box Pill (Tengah) -->
            <div class="max-w-2xl mx-auto relative flex items-center">
                <input 
                    type="text" 
                    x-model="newMessage" 
                    @keydown.enter="sendMessage()"
                    :disabled="isLoading"
                    placeholder="Ceritakan keluhan Anda..." 
                    class="w-full pl-6 pr-14 py-3 bg-white border border-slate-200 rounded-full text-[14px] text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400 transition-all disabled:bg-slate-50"
                >
                <button 
                    @click="sendMessage()"
                    :disabled="isLoading || newMessage.trim() === ''"
                    class="absolute right-2 top-1/2 -translate-y-1/2 w-9 h-9 bg-blue-500 hover:bg-blue-600 disabled:bg-slate-300 disabled:cursor-not-allowed text-white rounded-full flex items-center justify-center transition-colors"
                >
                    <svg class="w-4 h-4 ml-[-2px]" fill="currentColor" viewBox="0 0 24 24"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Alpine.js Logic (Tetap sama persis dengan yang sebelumnya) -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('aiChat', (initialConversationId, initialMessages) => ({
                conversationId: initialConversationId,
                messages: initialMessages || [],
                newMessage: '',
                isLoading: false,

                init() {
                    this.scrollToBottom();
                },

                async sendMessage() {
                    if (this.newMessage.trim() === '' || this.isLoading) return;

                    const userText = this.newMessage;
                    
                    this.messages.push({ role: 'user', content: userText });
                    this.newMessage = '';
                    this.isLoading = true;
                    this.scrollToBottom();

                    try {
                        const response = await fetch('{{ route("api.chat.send") }}', { 
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                message: userText,
                                conversation_id: this.conversationId
                            })
                        });

                        const data = await response.json();
                        
                        if (data.success) {
                            this.conversationId = data.conversation_id; 
                            this.messages.push({ role: 'assistant', content: data.reply });
                        } else {
                            throw new Error('Respons gagal');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        this.messages.push({ role: 'assistant', content: '⚠️ Maaf, AI sedang mengalami gangguan koneksi. Silakan coba lagi.' });
                    } finally {
                        this.isLoading = false;
                        this.scrollToBottom();
                    }
                },

                scrollToBottom() {
                    setTimeout(() => {
                        const container = document.getElementById('chat-container');
                        if (container) {
                            container.scrollTop = container.scrollHeight;
                        }
                    }, 100);
                }
            }));
        });
    </script>
</x-app-layout>