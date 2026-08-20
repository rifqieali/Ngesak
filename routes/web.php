<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    $userId = auth()->id();

    $totalPenghasilan = Transaction::where('user_id', $userId)
        ->where('type', 'penghasilan')
        ->sum('amount');

    $totalPengeluaran = Transaction::where('user_id', $userId)
        ->where('type', 'pengeluaran')
        ->sum('amount');

    $saldo = $totalPenghasilan - $totalPengeluaran;

    $recentTransactions = Transaction::where('user_id', $userId)
        ->with('category')
        ->latest('transaction_date')
        ->latest('id')
        ->take(5)
        ->get();

    return view('dashboard', compact('totalPenghasilan', 'totalPengeluaran', 'saldo', 'recentTransactions'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('categories', CategoryController::class);
    Route::resource('transactions', TransactionController::class);
});

require __DIR__.'/auth.php';
