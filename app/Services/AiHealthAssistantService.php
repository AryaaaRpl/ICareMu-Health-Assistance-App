<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiHealthAssistantService
{
    /**
     * Analyze student symptoms and medical record using DeepSeek model via OpenRouter API.
     */
    public function analyzeSymptom(?string $keluhan, int|float|string|null $umur = 14, int|float|string|null $suhu = 36.5, ?string $tekananDarah = '120/80'): array
    {
        $apiKey = env('OPENROUTER_API_KEY') ?: config('services.openrouter.api_key');

        if (empty($apiKey)) {
            return [
                'success' => false,
                'message' => 'API Key OpenRouter belum dikonfigurasi di file .env (OPENROUTER_API_KEY).',
                'analysis' => null,
            ];
        }

        $systemPrompt = "Anda adalah ICARE AI Health Assistant, seorang asisten kesehatan sekolah (UKS) yang empati, ramah, dan berpengalaman di Indonesia. " .
            "Tugas Anda adalah memberikan rekomendasi pertolongan pertama (first-aid) yang aman, praktis, dan berorientasi pada pertolongan pertama di sekolah. " .
            "Format jawaban Anda dengan bahasa Indonesia yang jelas, empati, dan terstruktur menggunakan poin-poin markdown:\n" .
            "1. Analisis Ringkas Risiko & Gejala\n" .
            "2. Tindakan Pertolongan Pertama di UKS\n" .
            "3. Rekomendasi Istirahat / Obat UKS\n" .
            "4. Kriteria Rujukan ke Puskesmas / Kontak Orang Tua\n" .
            "Jaga agar respon singkat, tepat sasaran, dan mengutamakan keselamatan siswa.";

        $userPrompt = sprintf(
            "Data Rekam Medis Siswa:\n- Keluhan Utama: %s\n- Perkiraan Umur: %s tahun\n- Suhu Tubuh: %s °C\n- Tekanan Darah: %s\n\nMohon analisis gejala ini dan berikan panduan pertolongan pertama.",
            $keluhan ?: 'Siswa mengeluhkan tidak enak badan',
            $umur ?: 14,
            $suhu ?: 36.5,
            $tekananDarah ?: '120/80'
        );

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . trim((string) $apiKey),
                'HTTP-Referer' => config('app.url', 'http://localhost'),
                'X-Title' => 'ICareMu UKS Health Assistant',
                'Content-Type' => 'application/json',
            ])->timeout(30)->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'deepseek/deepseek-chat',
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userPrompt],
                ],
                'temperature' => 0.5,
                'max_tokens' => 800,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $analysisText = $data['choices'][0]['message']['content'] ?? 'Tidak dapat memperoleh respons dari AI.';

                return [
                    'success' => true,
                    'message' => 'Analisis AI berhasil dibuat.',
                    'analysis' => $analysisText,
                ];
            }

            Log::error('OpenRouter API Response Error: ' . $response->body());

            return [
                'success' => false,
                'message' => 'Gagal mendapatkan analisis dari OpenRouter AI (HTTP status: ' . $response->status() . ').',
                'analysis' => null,
            ];
        } catch (Exception $e) {
            Log::error('AiHealthAssistantService Exception: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat menghubungi layanan AI: ' . $e->getMessage(),
                'analysis' => null,
            ];
        }
    }

    /**
     * Analyze user freeform text message using DeepSeek V4 Flash via OpenRouter API.
     */
    public function analyzeText(string $message): string
    {
        $apiKey = env('OPENROUTER_API_KEY') ?: config('services.openrouter.api_key');

        if (empty($apiKey)) {
            return "Maaf, API Key OpenRouter belum dikonfigurasi di lingkungan server (OPENROUTER_API_KEY). Silakan periksa file .env Anda.";
        }

        $systemPrompt = "Anda adalah ICARE AI Health Assistant, seorang asisten kesehatan sekolah (UKS) yang empati, ramah, dan berpengalaman di Indonesia. " .
            "Berikan jawaban pertolongan pertama, edukasi pola hidup sehat, kesehatan wanita/remaja, konsultasi kesehatan sekolah, atau saran praktis yang aman dalam bahasa Indonesia. " .
            "Formatlah jawaban Anda dengan jelas, terstruktur, empati, dan mudah dipahami oleh siswa maupun petugas UKS.";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . trim((string) $apiKey),
                'HTTP-Referer' => config('app.url', 'http://localhost'),
                'X-Title' => 'ICareMu UKS Chatbot Assistant',
                'Content-Type' => 'application/json',
            ])->timeout(35)->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'deepseek/deepseek-chat',
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $message],
                ],
                'temperature' => 0.6,
                'max_tokens' => 1000,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['choices'][0]['message']['content'] ?? "Maaf, tidak dapat memproses tanggapan dari AI saat ini.";
            }

            Log::error('OpenRouter Chat Error: ' . $response->body());
            return "Maaf, terjadi kendala koneksi ke server AI OpenRouter (HTTP Status: " . $response->status() . "). Silakan coba beberapa saat lagi.";
        } catch (Exception $e) {
            Log::error('AiHealthAssistantService Exception: ' . $e->getMessage());
            return "Maaf, terjadi kesalahan pada sistem AI Health Assistant: " . $e->getMessage();
        }
    }
}
