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
    public function index(Request $request): View
    {
        $query = InventarisUks::query();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->query('kategori'));
        }

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $inventaris = $query->latest()->paginate(10);

        // Ambil kategori unik untuk dropdown filter
        $categories = InventarisUks::select('kategori')->distinct()->pluck('kategori')->filter();

        return view('inventaris.index', compact('inventaris', 'categories'));
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
