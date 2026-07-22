<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalSkrining;
use App\Models\Sekolah;

class JadwalSkriningController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'admin_super') {
            $jadwal_skrining = JadwalSkrining::with('sekolah')->latest()->get();
        } else {
            $jadwal_skrining = JadwalSkrining::with('sekolah')
                ->where('sekolah_id', $user->sekolah_id)
                ->latest()
                ->get();
        }
        
        return view('jadwal_skrining.index', compact('jadwal_skrining'));
    }

    public function create()
    {
        $sekolahs = [];
        if (auth()->user()->role === 'admin_super') {
            $sekolahs = Sekolah::all();
        }
        return view('jadwal_skrining.create', compact('sekolahs'));
    }

    public function store(Request $request)
    {
        $rules = [
            'jenis_skrining' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'status' => 'required|string|in:pending,berjalan,selesai',
        ];

        if (auth()->user()->role === 'admin_super') {
            $rules['sekolah_id'] = 'required|exists:sekolahs,id';
        }

        $validated = $request->validate($rules);

        if (auth()->user()->role !== 'admin_super') {
            $validated['sekolah_id'] = auth()->user()->sekolah_id;
        }

        JadwalSkrining::create($validated);

        return redirect()->route('jadwal_skrining.index')->with('success', 'Jadwal Skrining berhasil ditambahkan.');
    }

    public function edit(JadwalSkrining $jadwal_skrining)
    {
        $sekolahs = [];
        if (auth()->user()->role === 'admin_super') {
            $sekolahs = Sekolah::all();
        } else {
            if ($jadwal_skrining->sekolah_id !== auth()->user()->sekolah_id) {
                abort(403);
            }
        }
        return view('jadwal_skrining.edit', compact('jadwal_skrining', 'sekolahs'));
    }

    public function update(Request $request, JadwalSkrining $jadwal_skrining)
    {
        if (auth()->user()->role !== 'admin_super' && $jadwal_skrining->sekolah_id !== auth()->user()->sekolah_id) {
            abort(403);
        }

        $rules = [
            'jenis_skrining' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'status' => 'required|string|in:pending,berjalan,selesai',
        ];

        if (auth()->user()->role === 'admin_super') {
            $rules['sekolah_id'] = 'required|exists:sekolahs,id';
        }

        $validated = $request->validate($rules);
        $jadwal_skrining->update($validated);

        return redirect()->route('jadwal_skrining.index')->with('success', 'Jadwal Skrining berhasil diperbarui.');
    }

    public function destroy(JadwalSkrining $jadwal_skrining)
    {
        if (auth()->user()->role !== 'admin_super' && $jadwal_skrining->sekolah_id !== auth()->user()->sekolah_id) {
            abort(403);
        }

        $jadwal_skrining->delete();

        return redirect()->route('jadwal_skrining.index')->with('success', 'Jadwal Skrining berhasil dihapus.');
    }
}
