<x-app.layout active="ai-assistant" title="AI Health Assistant — iCareMu">
    <div class="flex items-center justify-between border-b border-slate-200/80 pb-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-blue-50 text-[#186EF9] flex items-center justify-center font-bold text-xl">
                💬
            </div>
            <div>
                <h1 class="font-heading text-xl font-extrabold text-slate-900 tracking-tight">AI Health Assistant</h1>
                <p class="text-xs text-slate-500 font-medium">TANYA JAWAB KESEHATAN DASAR</p>
            </div>
        </div>
    </div>

    <!-- Chat Messages Window Container -->
    <div class="max-w-4xl mx-auto space-y-6 min-h-[500px] flex flex-col justify-between">
        <div class="space-y-4">
            <!-- Bot Message 1 -->
            <div class="flex gap-3">
                <div class="w-8 h-8 rounded-full bg-blue-50 text-[#186EF9] flex items-center justify-center font-bold text-xs shrink-0">🤖</div>
                <div class="bg-white p-4 rounded-3xl rounded-tl-none border border-slate-200/60 shadow-sm max-w-lg text-sm text-slate-700 space-y-2">
                    <p>Halo! 😊 Saya ICARE. Jangan ragu untuk bertanya tentang kesehatan, mulai dari keluhan ringan, kesehatan reproduksi, kesehatan mental, hingga tips hidup sehat.</p>
                    <p>Yuk, ceritakan apa yang sedang kamu rasakan!</p>
                </div>
            </div>

            <!-- User Message 1 -->
            <div class="flex justify-end gap-3">
                <div class="bg-white p-4 rounded-3xl rounded-tr-none border border-slate-200/60 shadow-sm text-sm text-slate-700">
                    Kesehatan Wanita
                </div>
                <div class="w-8 h-8 rounded-full bg-blue-100 text-[#186EF9] flex items-center justify-center font-bold text-xs shrink-0">👤</div>
            </div>

            <!-- Bot Suggested Prompt Bubble -->
            <div class="flex gap-3">
                <div class="w-8 h-8 rounded-full bg-blue-50 text-[#186EF9] flex items-center justify-center font-bold text-xs shrink-0">🤖</div>
                <div class="bg-white p-4 rounded-3xl rounded-tl-none border border-slate-200/60 shadow-sm max-w-lg text-xs text-slate-700 space-y-1.5">
                    <p class="font-bold text-slate-900 mb-2">Saya sedang mengalami nyeri haid. Apa yang sebaiknya saya lakukan?</p>
                    <p class="text-slate-600">🩸 Saya sedang mengalami nyeri haid. Apa yang sebaiknya saya lakukan?</p>
                    <p class="text-slate-600">📅 Menstruasi saya terlambat. Apakah ini normal?</p>
                    <p class="text-slate-600">🔄 Mengapa siklus haid saya tidak teratur?</p>
                    <p class="text-slate-600">🌸 Apa itu menstruasi pertama (menarche)?</p>
                </div>
            </div>

            <!-- User Choice -->
            <div class="flex justify-end gap-3">
                <div class="bg-white p-4 rounded-3xl rounded-tr-none border border-slate-200/60 shadow-sm text-sm text-slate-700">
                    🩸 Saya sedang mengalami nyeri haid. Apa yang sebaiknya saya lakukan?
                </div>
                <div class="w-8 h-8 rounded-full bg-blue-100 text-[#186EF9] flex items-center justify-center font-bold text-xs shrink-0">👤</div>
            </div>

            <!-- Bot Comprehensive Response -->
            <div class="flex gap-3">
                <div class="w-8 h-8 rounded-full bg-blue-50 text-[#186EF9] flex items-center justify-center font-bold text-xs shrink-0">🤖</div>
                <div class="bg-white p-5 rounded-3xl rounded-tl-none border border-slate-200/60 shadow-sm max-w-xl text-sm text-slate-700 space-y-3">
                    <div class="font-bold text-slate-900">ICARE AI Health Assistant</div>
                    <p>Halo! 😊 Terima kasih sudah bercerita. Nyeri haid merupakan kondisi yang cukup umum dialami saat menstruasi, dan pada banyak kasus dapat ditangani dengan perawatan sederhana di rumah.</p>
                    <p class="font-semibold text-slate-800">Kamu bisa mencoba beberapa hal berikut:</p>
                    <ul class="list-disc pl-5 space-y-1 text-xs text-slate-600">
                        <li>🌸 Beristirahat sejenak.</li>
                        <li>♨ Mengompres hangat pada bagian bawah perut.</li>
                        <li>💧 Minum air putih yang cukup.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Chat Input Bar -->
        <div class="space-y-3 pt-4">
            <div class="flex flex-wrap justify-center gap-2 text-xs">
                <span class="px-4 py-1.5 rounded-full bg-blue-50 text-[#186EF9] font-semibold cursor-pointer">Kesehatan Wanita</span>
                <span class="px-4 py-1.5 rounded-full bg-blue-50 text-[#186EF9] font-semibold cursor-pointer">Pola Hidup Sehat</span>
                <span class="px-4 py-1.5 rounded-full bg-blue-50 text-[#186EF9] font-semibold cursor-pointer">Cek Kesehatan</span>
                <span class="px-4 py-1.5 rounded-full bg-blue-50 text-[#186EF9] font-semibold cursor-pointer">Kesehatan Mental</span>
            </div>

            <div class="relative max-w-2xl mx-auto">
                <input type="text" placeholder="Ceritakan keluhan Anda..." class="w-full pl-6 pr-14 py-4 rounded-full bg-white border border-slate-200/80 shadow-sm text-sm focus:outline-none focus:border-[#186EF9]">
                <button class="w-10 h-10 rounded-full bg-[#186EF9] hover:bg-blue-600 text-white flex items-center justify-center absolute right-2 top-2 transition-all">
                    ➔
                </button>
            </div>
        </div>
    </div>
</x-app.layout>
