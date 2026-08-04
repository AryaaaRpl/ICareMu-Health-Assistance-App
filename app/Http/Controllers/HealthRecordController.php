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
        $riwayatKesehatan = SkriningRecord::with('admin')
            ->where('siswa_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('siswa.health-record', compact('riwayatKesehatan'));
    }
}
