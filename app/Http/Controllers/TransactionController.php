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
            // Ambil semua kategori dari database sorted by id
            'categories' => Category::orderBy('id')
                ->get()
        ]);
    }

    // POST /transactions — Simpan transaksi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'type' => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        // Simpan transaksi
        \App\Models\Transaction::create([
            'user_id' => auth()->id(),
            'category_id' => $validated['category_id'],
            'amount' => $validated['amount'],
            'type' => $validated['type'],
            'date' => $validated['date'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan!');
    }

    // GET /transactions/{id}/edit — Tampilkan form edit
    public function edit(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        return Inertia::render('Transactions/Edit', [
            'transaction' => $transaction,
            'categories' => Category::orderBy('id')
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
