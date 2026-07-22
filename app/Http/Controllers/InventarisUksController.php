<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\InventarisUks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventarisUksController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $sekolahId = $user->sekolah_id ?? 1;

        $items = InventarisUks::where('sekolah_id', $sekolahId)
            ->latest()
            ->paginate(15);

        return view('pages.inventory', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'tanggal_kedaluwarsa' => 'nullable|date',
        ]);

        $user = Auth::user();

        InventarisUks::create([
            'sekolah_id' => $user->sekolah_id ?? 1,
            'nama_barang' => $request->input('nama_barang'),
            'kategori' => $request->input('kategori'),
            'stok' => $request->input('stok'),
            'tanggal_kedaluwarsa' => $request->input('tanggal_kedaluwarsa'),
        ]);

        return redirect()->route('uks.inventory')->with('success', 'Barang inventaris UKS berhasil ditambahkan.');
    }

    public function update(Request $request, InventarisUks $inventory)
    {
        $request->validate([
            'stok' => 'required|integer|min:0',
        ]);

        $inventory->update([
            'stok' => $request->input('stok'),
        ]);

        return redirect()->route('uks.inventory')->with('success', 'Stok inventaris berhasil diperbarui.');
    }

    public function destroy(InventarisUks $inventory)
    {
        $inventory->delete();
        return redirect()->route('uks.inventory')->with('success', 'Barang inventaris telah dihapus.');
    }
}
