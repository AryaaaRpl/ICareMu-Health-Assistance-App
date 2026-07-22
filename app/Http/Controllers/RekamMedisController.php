<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CalculateImtAction;

use App\Models\RekamMedis;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekamMedisController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $sekolahId = $user->sekolah_id ?? 1;

        $search = $request->query('search');

        $query = RekamMedis::with(['siswa', 'creator'])
            ->where('sekolah_id', $sekolahId);

        if ($user->role === 'siswa' && $user->siswa) {
            $query->where('siswa_id', $user->siswa->id);
        }

        if ($search) {
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', "%{$search}%")
                  ->orWhere('nisn', 'LIKE', "%{$search}%");
            });
        }

        $records = $query->latest('tanggal_periksa')->paginate(15);
        $siswas = Siswa::where('sekolah_id', $sekolahId)->get();

        return view('pages.health-record', compact('records', 'siswas', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal_periksa' => 'required|date',
            'tinggi_badan' => 'required|numeric|min:30|max:250',
            'berat_badan' => 'required|numeric|min:5|max:300',
            'catatan_medis' => 'nullable|string',
        ]);

        $user = Auth::user();

        $action = new CalculateImtAction();
        $imtResult = $action->execute(
            (float) $request->input('tinggi_badan'),
            (float) $request->input('berat_badan')
        );

        $siswa = Siswa::findOrFail($request->input('siswa_id'));

        RekamMedis::create([
            'siswa_id' => $siswa->id,
            'sekolah_id' => $siswa->sekolah_id,
            'created_by' => $user->id,
            'tanggal_periksa' => $request->input('tanggal_periksa'),
            'tinggi_badan' => $request->input('tinggi_badan'),
            'berat_badan' => $request->input('berat_badan'),
            'imt_score' => $imtResult['imt'],
            'status_risiko' => $imtResult['status_risiko'],
            'catatan_medis' => $request->input('catatan_medis'),
            'status_verifikasi' => 'Terverifikasi',
        ]);

        return redirect()->route('health.record')->with('success', 'Rekam medis berhasil ditambahkan.');
    }
}
