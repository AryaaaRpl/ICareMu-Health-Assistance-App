<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use Illuminate\Http\Request;

class RiwayatKunjunganSiswaController extends Controller
{
    public function index()
    {
        // Ambil data riwayat kunjungan siswa dari database
        $riwayatKunjungan = RekamMedis::where('siswa_id', auth()->id())
            ->with('admin') // Biar tau siapa yang nanganin
            ->orderBy('created_at', 'desc')
            ->get();

        return view('siswa.riwayat-kunjungan', compact('riwayatKunjungan'));
    }
}
