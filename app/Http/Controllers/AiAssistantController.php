<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\RiwayatKonsultasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AiAssistantController extends Controller
{
    public function showAiAssistant(Request $request)
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        $history = $siswa
            ? RiwayatKonsultasi::where('siswa_id', $siswa->id)->latest()->take(10)->get()
            : collect();

        return view('pages.ai-assistant', compact('history', 'siswa'));
    }

    public function showEdukasiIsmuba(Request $request)
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        $ismubaHistory = $siswa
            ? RiwayatKonsultasi::where('siswa_id', $siswa->id)
                ->where('jenis_konsultasi', 'ISMUBA')
                ->latest()
                ->take(5)
                ->get()
            : collect();

        return view('pages.edukasi-ismuba', compact('ismubaHistory', 'siswa'));
    }

    public function ask(Request $request)
    {
        $request->validate([
            'jenis_konsultasi' => 'required|string|in:Kesehatan,ISMUBA,Fikih Wanita,Mental Health',
            'isi_pertanyaan' => 'required|string|min:3',
        ]);

        $user = Auth::user();
        $siswa = $user->siswa;

        $question = $request->input('isi_pertanyaan');
        $type = $request->input('jenis_konsultasi');

        // AI Response Logic / Consultation Advice Generator
        $answer = match ($type) {
            'ISMUBA', 'Fikih Wanita' => "Berdasarkan tuntunan fikih dan nilai ISMUBA Muhammadiyah, " .
                "menjaga kebersihan (thaharah) dan kesehatan reproduksi merupakan bagian dari iman. " .
                "Untuk masalah spesifik, Anda juga dapat berkonsultasi langsung di layanan Halo Asatidz UKS.",
            'Mental Health' => "Terima kasih sudah berbagi cerita. Menjaga kesehatan mental sangat penting. " .
                "Cobalah istirahat cukup, lakukan teknik pernapasan relaksasi, dan jika merasa kewalahan, temui konselor atau guru BK sekolah.",
            default => "Terima kasih atas pertanyaannya. Berdasarkan informasi medis dasar, selalu pastikan minum air putih cukup, " .
                "istirahat teratur, dan segera kunjungi ruang UKS jika gejala berlanjut.",
        };

        if ($siswa) {
            RiwayatKonsultasi::create([
                'sekolah_id' => $siswa->sekolah_id,
                'siswa_id' => $siswa->id,
                'jenis_konsultasi' => $type,
                'isi_pertanyaan' => $question,
                'jawaban' => $answer,
            ]);
        }

        return redirect()->back()->with('ai_response', [
            'question' => $question,
            'answer' => $answer,
        ]);
    }
}
