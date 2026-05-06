<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    // Tampilkan daftar kategori
    public function index()
    {
        return Inertia::render('Categories/Index', [
            'categories' => auth()->user()->categories()->get(),
        ]);
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'type'  => 'required|in:income,expense',
            'color' => 'required|string|max:7', // Untuk hex code seperti #ffffff
        ]);

        auth()->user()->categories()->create($validated);

        return redirect()->back()->with('success', 'Kategori berhasil dibuat!');
    }

    // Hapus kategori
    public function destroy(Category $category)
    {
        if ($category->user_id !== auth()->id()) {
            abort(403);
        }

        $category->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}