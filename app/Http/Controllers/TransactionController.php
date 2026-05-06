<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransactionController extends Controller
{
    // GET /transactions — Tampilkan semua transaksi milik user
    public function index()
    {
        $transactions = Transaction::with('category') // Load data kategori (name, color)
            ->where('user_id', auth()->id())
            ->orderBy('date', 'desc')
            ->get();

        return Inertia::render('Transactions/Index', [
            'transactions' => $transactions,
        ]);
    }

    // GET /transactions/create — Tampilkan form tambah transaksi
    public function create()
    {
        return Inertia::render('Transactions/Create', [
            // Ambil semua kategori milik user yang sedang login
            'categories' => Category::where('user_id', auth()->id())
                ->orderBy('type')
                ->orderBy('name')
                ->get()
        ]);
    }

    // POST /transactions — Simpan transaksi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type'        => 'required|in:income,expense',
            'amount'      => 'required|numeric|min:1',
            'category_id' => 'nullable|exists:categories,id',
            'custom_category_name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'date'        => 'required|date',
        ]);

        // Jika user membuat kategori baru
        if ($validated['custom_category_name']) {
            $category = Category::create([
                'user_id' => auth()->id(),
                'name' => $validated['custom_category_name'],
                'type' => $validated['type'],
                'color' => '#' . substr(md5(rand()), 0, 6), // Random color
            ]);
            $validated['category_id'] = $category->id;
        } else {
            // category_id harus ada jika tidak ada custom_category_name
            if (!$validated['category_id']) {
                return back()->withErrors(['category_id' => 'Pilih kategori atau buat kategori baru.']);
            }
        }

        // Tambahkan user_id dari user yang sedang login
        $validated['user_id'] = auth()->id();

        // Hapus custom_category_name dari validated data sebelum create
        unset($validated['custom_category_name']);

        Transaction::create($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan!');
    }

    // GET /transactions/{id}/edit — Tampilkan form edit
    public function edit(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        return Inertia::render('Transactions/Edit', [
            'transaction' => $transaction,
            'categories' => Category::where('user_id', auth()->id())
                ->orderBy('type')
                ->orderBy('name')
                ->get()
        ]);
    }

    // PUT /transactions/{id} — Simpan perubahan
    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'type'        => 'required|in:income,expense',
            'amount'      => 'required|numeric|min:1',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:255',
            'date'        => 'required|date',
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil diupdate!');
    }

    // DELETE /transactions/{id} — Hapus transaksi
    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus!');
    }
}
