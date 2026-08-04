<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\AiConversation;
use App\Models\AiMessage;
use App\Services\AiHealthAssistantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    /**
     * Fetch conversations & messages strictly for the currently authenticated user.
     * Prevents IDOR data leakage.
     */
    public function getHistory(): JsonResponse
    {
        $userId = auth()->id();

        // Strict data isolation: filter by authenticated user ID only
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
     * Securely store user message, execute AI call, and record AI response.
     */
    public function sendMessage(Request $request, AiHealthAssistantService $aiService): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
            'conversation_id' => ['nullable', 'integer'],
        ]);

        // Security Enforcement: ALWAYS use auth()->id() as single source of truth
        $userId = auth()->id();
        $conversation = null;

        // 1. Verify ownership if conversation_id was provided (IDOR Guard)
        if (!empty($validated['conversation_id'])) {
            $conversation = AiConversation::where('id', $validated['conversation_id'])
                ->where('user_id', $userId)
                ->first();
        }

        // 2. Create new conversation tied exclusively to authenticated user if needed
        if (!$conversation) {
            $conversation = AiConversation::create([
                'user_id' => $userId, // Never trust client-submitted user_id
                'title' => Str::limit($validated['message'], 40, '...'),
            ]);
        }

        // 3. Store user prompt in database
        $userMessage = $conversation->messages()->create([
            'role' => 'user',
            'content' => $validated['message'],
        ]);

        // =========================================================================
        // 4. AI API INTEGRATION STEP (Google Gemini / DeepSeek Health Assistant)
        // =========================================================================
        $aiResponseText = $aiService->analyzeText($validated['message']);

        $parsedAiResponse = Str::markdown($aiResponseText);

        // 5. Store AI assistant response in database
        $assistantMessage = $conversation->messages()->create([
            'role' => 'assistant',
            'content' => $parsedAiResponse,
        ]);

        return response()->json([
            'success' => true,
            'conversation_id' => $conversation->id,
            'user_message' => $userMessage,
            'reply' => $parsedAiResponse,
            'assistant_message' => $assistantMessage,
        ]);
    }
}
