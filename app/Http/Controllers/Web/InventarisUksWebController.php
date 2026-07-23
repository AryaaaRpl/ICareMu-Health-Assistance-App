<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\InventarisUks;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventarisUksWebController extends Controller
{
    /**
     * Display a listing of inventory items for the current tenant.
     */
    public function index(): View
    {
        $inventaris = InventarisUks::latest()->get();

        return view('inventaris.index', compact('inventaris'));
    }

    /**
     * Store a newly created inventory item.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_barang' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:100'],
            'jumlah' => ['required', 'integer', 'min:0'],
            'satuan' => ['required', 'string', 'max:50'],
            'kondisi' => ['required', 'string', 'max:100'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $validated['stok'] = $validated['jumlah'];

        InventarisUks::create($validated);

        return redirect()->back()->with('success', 'Data Inventaris UKS berhasil disimpan.');
    }
}
