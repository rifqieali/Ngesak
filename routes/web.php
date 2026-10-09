<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Models\Transaction;
use App\Support\PeriodeFilter;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    $userId = auth()->id();
    $filter = PeriodeFilter::resolve($userId);

    $base = Transaction::where('user_id', $userId)
        ->period($filter['tahun'], $filter['bulan']);

    $totalPenghasilan = (clone $base)
        ->where('type', 'penghasilan')
        ->sum('amount');

    $totalPengeluaran = (clone $base)
        ->where('type', '!=', 'penghasilan')
        ->sum('amount');

    $saldo = $totalPenghasilan - $totalPengeluaran;

    $recentTransactions = (clone $base)
        ->with('category')
        ->latest('transaction_date')
        ->latest('id')
        ->take(5)
        ->get();

    return view('dashboard', array_merge(compact('totalPenghasilan', 'totalPengeluaran', 'saldo', 'recentTransactions'), [
        'tahun' => $filter['tahun'],
        'bulan' => $filter['bulan'],
        'years' => $filter['years'],
        'periodeLabel' => $filter['label'],
        'isFiltered' => $filter['isFiltered'],
    ]));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('categories', CategoryController::class);
    Route::resource('transactions', TransactionController::class);
});

require __DIR__.'/auth.php';
