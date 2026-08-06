<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Tenant\TenantContext;
use App\Models\ArtikelIsmuba;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class IsmubaController extends Controller
{
    /**
     * Display a listing of ISMUBA articles and available Halo Asatidz teachers.
     */
    public function index(): View
    {
        $user = auth()->user();

        if (in_array($user->role, ['super_admin', 'admin_super', 'admin_uks', 'petugas_uks', 'guru_ismuba'])) {
            $artikels = ArtikelIsmuba::latest()->get();
        } else {
            $artikels = ArtikelIsmuba::where('status', 'published')->latest()->get();
        }

        $asatidz = User::where('role', 'guru_ismuba')->get();

        return view('ismuba.index', compact('artikels', 'asatidz'));
    }

    /**
     * Display the specified article.
     */
    public function show(ArtikelIsmuba $article): View
    {
        $relatedArticles = ArtikelIsmuba::where('id', '!=', $article->id)
            ->where('kategori', $article->kategori)
            ->where('status', 'published')
            ->take(3)
            ->get();

        if ($relatedArticles->isEmpty()) {
            $relatedArticles = ArtikelIsmuba::where('id', '!=', $article->id)
                ->where('status', 'published')
                ->take(3)
                ->get();
        }

        return view('ismuba.show', compact('article', 'relatedArticles'));
    }

    /**
     * Store a newly created article in storage (Admin / Guru ISMUBA).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:100'],
            'konten' => ['required', 'string'],
            'thumbnail' => ['nullable', 'string', 'max:500'],
            'cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'status' => ['nullable', Rule::in(['draft', 'published'])],
        ]);

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('ismuba_covers', 'public');
            $validated['thumbnail'] = '/storage/' . $path;
        }

        unset($validated['cover']);

        $validated['slug'] = Str::slug($validated['judul']) . '-' . Str::random(5);
        $validated['status'] = $validated['status'] ?? 'published';
        $validated['sekolah_id'] = TenantContext::getTenantId() ?? auth()->user()->sekolah_id ?? Sekolah::value('id') ?? 1;

        ArtikelIsmuba::create($validated);

        return redirect()->route('ismuba.index')
            ->with('success', 'Artikel ISMUBA berhasil ditambahkan.');
    }

    /**
     * Update the specified article in storage (Admin / Guru ISMUBA).
     */
    public function update(Request $request, ArtikelIsmuba $article): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:100'],
            'konten' => ['required', 'string'],
            'thumbnail' => ['nullable', 'string', 'max:500'],
            'cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'status' => ['required', Rule::in(['draft', 'published'])],
        ]);

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('ismuba_covers', 'public');
            $validated['thumbnail'] = '/storage/' . $path;
        }

        unset($validated['cover']);

        if ($article->judul !== $validated['judul']) {
            $validated['slug'] = Str::slug($validated['judul']) . '-' . Str::random(5);
        }

        $article->update($validated);

        return redirect()->route('ismuba.index')
            ->with('success', 'Artikel ISMUBA berhasil diperbarui.');
    }

    /**
     * Remove the specified article from storage (Admin / Guru ISMUBA).
     */
    public function destroy(ArtikelIsmuba $article): RedirectResponse
    {
        $article->delete();

        return redirect()->route('ismuba.index')
            ->with('success', 'Artikel ISMUBA berhasil dihapus.');
    }
}
