<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\SkriningRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HealthRecordController extends Controller
{
    /**
     * Display authenticated student's health screening & medical action history.
     */
    public function index(): View
    {
        $riwayatKesehatan = SkriningRecord::where('siswa_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('siswa.health-record', compact('riwayatKesehatan'));
    }
}
