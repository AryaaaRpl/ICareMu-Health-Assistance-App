<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AiConversation;
use App\Models\AiMessage;
use App\Models\RekamMedis;
use App\Services\AiHealthAssistantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AiAssistantController extends Controller
{
    /**
     * Display the AI Assistant chat interface with eager-loaded user conversations.
     */
    public function index(): View
    {
        $userId = auth()->id();

        // Strictly filter conversations by authenticated user ID (IDOR Prevention)
        $conversations = AiConversation::where('user_id', $userId)
            ->with(['messages' => function ($query) {
                $query->orderBy('created_at', 'asc');
            }])
            ->latest()
            ->get();

        // Scope medical records if logged in user is a student
        $user = auth()->user();
        $query = RekamMedis::with('siswa');
        if ($user && $user->role === 'siswa') {
            $query->where('siswa_id', $userId);
        }

        $rekamMedisList = class_exists(RekamMedis::class)
            ? $query->latest()->get()
            : collect();

        return view('ai.index', compact('conversations', 'rekamMedisList'));
    }

    /**
     * Fetch user conversation history (API / JSON Endpoint).
     */
    public function getHistory(): JsonResponse
    {
        $userId = auth()->id();

        // Strictly scope to current authenticated user
        $conversations = AiConversation::where('user_id', $userId)
            ->with(['messages' => function ($query) {
                $query->orderBy('created_at', 'asc');
            }])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'conversations' => $conversations,
        ]);
    }

    /**
     * Process interactive chat message, persist user prompt & AI response securely.
     */
    public function chat(Request $request, AiHealthAssistantService $aiService): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
            'conversation_id' => ['nullable', 'integer'],
        ]);

        $userId = auth()->id();
        $conversation = null;

        // 1. Check if conversation_id was supplied and ensure ownership (IDOR Guard)
        if (!empty($validated['conversation_id'])) {
            $conversation = AiConversation::where('id', $validated['conversation_id'])
                ->where('user_id', $userId)
                ->first();
        }

        // 2. If no valid conversation found for this user, find latest or create new
        if (!$conversation) {
            $conversation = AiConversation::create([
                'user_id' => $userId,
                'title' => Str::limit($validated['message'], 40, '...'),
            ]);
        }

        // 3. Save User Prompt with role = 'user'
        $userMessage = $conversation->messages()->create([
            'role' => 'user',
            'content' => $validated['message'],
        ]);

        // 4. Call AI Assistant Service (Gemini / DeepSeek API)
        $reply = $aiService->analyzeText($validated['message']);

        // 5. Save AI Response with role = 'assistant'
        $aiMessage = $conversation->messages()->create([
            'role' => 'assistant',
            'content' => $reply,
        ]);

        return response()->json([
            'success' => true,
            'conversation_id' => $conversation->id,
            'user_message' => $userMessage,
            'reply' => $reply,
            'assistant_message' => $aiMessage,
        ]);
    }

    /**
     * Alias method for sendMessage.
     */
    public function sendMessage(Request $request, AiHealthAssistantService $aiService): JsonResponse
    {
        return $this->chat($request, $aiService);
    }

    /**
     * Legacy analyze method for RekamMedis record selection.
     */
    public function analyze(Request $request, AiHealthAssistantService $aiService): RedirectResponse
    {
        $validated = $request->validate([
            'rekam_medis_id' => ['required'],
        ]);

        $user = auth()->user();
        $query = RekamMedis::with('siswa');

        if ($user && $user->role === 'siswa') {
            $query->where('siswa_id', $user->id);
        }

        $record = $query->find($validated['rekam_medis_id']);

        if (!$record) {
            return redirect()->route('ai.index')->with('error', 'Data Rekam Medis tidak ditemukan.');
        }

        $keluhan = $record->keluhan_utama ?? $record->catatan_medis ?? 'Demam dan pusing di ruang UKS';
        $suhu = $record->suhu ?? 37.0;
        $tekananDarah = $record->tekanan_darah ?? '120/80';
        $umur = 14;

        $result = $aiService->analyzeSymptom(
            keluhan: $keluhan,
            umur: $umur,
            suhu: $suhu,
            tekananDarah: $tekananDarah
        );

        return redirect()->route('ai.index')
            ->with('ai_result', $result)
            ->with('selected_record', $record);
    }
}
