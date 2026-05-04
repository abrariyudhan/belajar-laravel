<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransactionController extends Controller
{
    // GET /transactions — Tampilkan semua transaksi milik user
    public function index()
    {
        $transactions = Transaction::where('user_id', auth()->id())
            ->orderBy('date', 'desc')
            ->get();

        return Inertia::render('Transactions/Index', [
            'transactions' => $transactions,
        ]);
    }

    // GET /transactions/create — Tampilkan form tambah transaksi
    public function create()
    {
        return Inertia::render('Transactions/Create');
    }

    // POST /transactions — Simpan transaksi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type'        => 'required|in:income,expense',
            'amount'      => 'required|numeric|min:1',
            'category'    => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'date'        => 'required|date',
        ]);

        // Tambahkan user_id dari user yang sedang login
        $validated['user_id'] = auth()->id();

        Transaction::create($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan!');
    }

    // GET /transactions/{id}/edit — Tampilkan form edit
    public function edit(Transaction $transaction)
    {
        // Pastikan hanya pemiliknya yang bisa edit
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        return Inertia::render('Transactions/Edit', [
            'transaction' => $transaction,
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
            'category'    => 'required|string|max:100',
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