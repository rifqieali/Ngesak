<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::where('user_id', auth()->id())
            ->with(['category', 'wallet'])
            ->latest('transaction_date')
            ->latest('id')
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('user_id', auth()->id())->get();
        $wallets = Wallet::where('user_id', auth()->id())->orderBy('name')->get();
        $types = ['pengeluaran', 'penghasilan', 'tagihan', 'hutang', 'tabungan', 'investasi'];

        return view('transactions.create', compact('categories', 'wallets', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->where(function ($query) {
                    $query->where('user_id', auth()->id());
                }),
            ],
            'type' => ['required', Rule::in(['pengeluaran', 'penghasilan', 'tagihan', 'hutang', 'tabungan', 'investasi'])],
            'wallet_id' => [
                'nullable',
                Rule::exists('wallets', 'id')->where(function ($query) {
                    $query->where('user_id', auth()->id());
                }),
            ],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'transaction_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        $validated['user_id'] = auth()->id();

        Transaction::create($validated);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $categories = Category::where('user_id', auth()->id())->get();
        $wallets = Wallet::where('user_id', auth()->id())->orderBy('name')->get();
        $types = ['pengeluaran', 'penghasilan', 'tagihan', 'hutang', 'tabungan', 'investasi'];

        return view('transactions.edit', compact('transaction', 'categories', 'wallets', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->where(function ($query) {
                    $query->where('user_id', auth()->id());
                }),
            ],
            'type' => ['required', Rule::in(['pengeluaran', 'penghasilan', 'tagihan', 'hutang', 'tabungan', 'investasi'])],
            'wallet_id' => [
                'nullable',
                Rule::exists('wallets', 'id')->where(function ($query) {
                    $query->where('user_id', auth()->id());
                }),
            ],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'transaction_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
