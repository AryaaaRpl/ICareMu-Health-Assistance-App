<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiHealthAssistantService
{
    /**
     * Analyze student symptoms and medical record using Google Gemini API.
     */
    public function analyzeSymptom(?string $keluhan, int|float|string|null $umur = 14, int|float|string|null $suhu = 36.5, ?string $tekananDarah = '120/80'): array
    {
        $apiKey = env('GEMINI_API_KEY') ?: config('services.gemini.api_key') ?: env('OPENROUTER_API_KEY');
        $model = config('services.gemini.model') ?: 'gemini-1.5-flash';
        if ($model === 'gemini-flash-lite-latest') {
            $model = 'gemini-1.5-flash';
        }

        if (empty($apiKey)) {
            return [
                'success' => false,
                'message' => 'API Key Gemini belum dikonfigurasi di file .env (GEMINI_API_KEY).',
                'analysis' => null,
            ];
        }

        $systemPrompt = <<<PROMPT
Anda adalah "Perawat UKS ICareMu", asisten kesehatan sekolah Muhammadiyah yang empati dan profesional.
Tugas Anda:
1. Analisis Ringkas Risiko & Gejala (Fisik maupun Mental/Emosional).
2. Tindakan Pertolongan Pertama di UKS.
3. Jika terdapat tanda kelelahan mental, stres, atau overthinking, validasi perasaan siswa dengan nilai keislaman yang menenangkan dan wajib sertakan tautan rujukan ke menu [Edukasi ISMUBA](/dashboard/ismuba).
4. Kriteria Rujukan ke Petugas UKS / Dokter / Kontak Orang Tua.
PROMPT;

        $userPrompt = sprintf(
            "Data Rekam Medis Siswa:\n- Keluhan Utama: %s\n- Perkiraan Umur: %s tahun\n- Suhu Tubuh: %s °C\n- Tekanan Darah: %s\n\nMohon analisis gejala ini dan berikan panduan pertolongan pertama.",
            $keluhan ?: 'Siswa mengeluhkan tidak enak badan',
            $umur ?: 14,
            $suhu ?: 36.5,
            $tekananDarah ?: '120/80'
        );

        try {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . trim((string) $apiKey);

            $response = Http::withoutVerifying()
                ->timeout(30)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, [
                    'system_instruction' => [
                        'parts' => [
                            ['text' => $systemPrompt],
                        ],
                    ],
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => [
                                ['text' => $userPrompt],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature' => 0.5,
                        'maxOutputTokens' => 800,
                    ],
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $analysisText = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Tidak dapat memperoleh respons dari AI.';

                return [
                    'success' => true,
                    'message' => 'Analisis AI berhasil dibuat.',
                    'analysis' => $analysisText,
                ];
            }

            Log::error('Gemini API Response Error: ' . $response->body());

            return [
                'success' => false,
                'message' => 'Gagal mendapatkan analisis dari Gemini AI (HTTP status: ' . $response->status() . ').',
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
     * Analyze user freeform text message using Google Gemini API.
     */
    public function analyzeText(string $message): string
    {
        $apiKey = env('GEMINI_API_KEY') ?: config('services.gemini.api_key') ?: env('OPENROUTER_API_KEY');
        $model = config('services.gemini.model') ?: 'gemini-3.5-flash-lite';

        if (empty($apiKey)) {
            return "Maaf, API Key Gemini belum dikonfigurasi di lingkungan server (GEMINI_API_KEY). Silakan periksa file .env Anda.";
        }

        $systemPrompt = <<<PROMPT
Anda adalah "Perawat UKS ICareMu", seorang asisten kesehatan sekolah di lingkungan sekolah Muhammadiyah yang empati, ramah, dan peka secara budaya serta spiritual.

Tugas utama Anda:
1. **Klasifikasi Gejala**:
   - **Murni Fisik**: Berikan saran pertolongan pertama (first-aid) yang aman dan praktis, serta ingatkan siswa untuk menemui petugas UKS di sekolah jika gejala berlanjut.
   - **Mental / Emosional / Psikologis** (seperti: stres, cemas/anxiety, lelah mental, tekanan belajar, pusing/insomnia akibat overthinking, merasa sedih/down):
     - **Validasi Perasaan & Jembatan ISMUBA**: Validasi perasaan siswa dengan respons hangat berlandaskan nilai-nilai keislaman yang menenangkan (misal: ingatkan untuk menarik napas dalam, beristirahat, mengingat bahwa merasa lelah itu wajar, dan mendekatkan diri kepada Allah).
     - **Rujukan Edukasi ISMUBA**: Wajib berikan ajakan bertindak (Call-to-Action) secara eksplisit untuk membaca artikel penyejuk hati di menu Edukasi ISMUBA.
     - **Format Link**: Sertakan tautan Markdown persis seperti ini: [Edukasi ISMUBA](/dashboard/ismuba).

Contoh kalimat rujukan:
"Sepertinya kamu sedang kelelahan secara mental. Untuk menenangkan pikiran dan memperkuat hatimu, yuk baca artikel penyejuk hati di menu [Edukasi ISMUBA](/dashboard/ismuba)."

Selalu gunakan bahasa Indonesia yang santun, hangat, terstruktur, dan mudah dipahami oleh siswa sekolah.
Gunakan formatting Markdown yang rapi. Gunakan emoji secukupnya untuk membuat pesan terasa lebih ramah dan menenangkan (misal: 🩺, 🌿, 🛏️). Buatlah penjelasan terstruktur menggunakan bullet points atau numbered lists agar mudah dibaca cepat (scannable) oleh petugas UKS.
PROMPT;

        try {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . trim((string) $apiKey);

            $response = Http::withoutVerifying()
                ->timeout(35)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, [
                    'system_instruction' => [
                        'parts' => [
                            ['text' => $systemPrompt],
                        ],
                    ],
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => [
                                ['text' => $message],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature' => 0.6,
                        'maxOutputTokens' => 1000,
                    ],
                ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? "Maaf, tidak dapat memproses tanggapan dari AI saat ini.";
            }

            Log::error('Gemini Chat Error: ' . $response->body());
            return "Maaf, terjadi kendala koneksi ke server Gemini AI (HTTP Status: " . $response->status() . "). Silakan coba beberapa saat lagi.";
        } catch (Exception $e) {
            Log::error('AiHealthAssistantService Exception: ' . $e->getMessage());
            return "Maaf, terjadi kesalahan pada sistem AI Health Assistant: " . $e->getMessage();
        }
    }
}
