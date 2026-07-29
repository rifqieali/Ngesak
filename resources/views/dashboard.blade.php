<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Dashboard Keuangan') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('transactions.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                    + Tambah Transaksi
                </a>
                <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    + Kategori
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Penghasilan -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Penghasilan</p>
                        <h3 class="text-2xl font-bold text-emerald-600 mt-1">
                            Rp {{ number_format($totalPenghasilan, 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="p-3 bg-emerald-50 rounded-xl text-emerald-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m0-16l-4 4m4-4l4 4"/>
                        </svg>
                    </div>
                </div>

                <!-- Total Pengeluaran -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Pengeluaran</p>
                        <h3 class="text-2xl font-bold text-rose-600 mt-1">
                            Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="p-3 bg-rose-50 rounded-xl text-rose-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20V4m0 16l4-4m-4 4l-4-4"/>
                        </svg>
                    </div>
                </div>

                <!-- Saldo Bersih -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Saldo Bersih</p>
                        <h3 class="text-2xl font-bold {{ $saldo >= 0 ? 'text-indigo-600' : 'text-rose-600' }} mt-1">
                            Rp {{ number_format($saldo, 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="p-3 bg-indigo-50 rounded-xl text-indigo-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions Table -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Transaksi Terbaru</h3>
                    <a href="{{ route('transactions.index') }}" class="text-sm text-indigo-600 font-semibold hover:text-indigo-800">
                        Lihat Semua &rarr;
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3">Kategori</th>
                                <th class="px-6 py-3">Tipe</th>
                                <th class="px-6 py-3">Catatan</th>
                                <th class="px-6 py-3 text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($recentTransactions as $tx)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($tx->transaction_date)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">
                                        {{ $tx->category->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase {{ $tx->type === 'penghasilan' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                            {{ $tx->type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ $tx->notes ?: '-' }}
                                    </td>
                                    <td class="px-6 py-4 font-bold text-right whitespace-nowrap {{ $tx->type === 'penghasilan' ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $tx->type === 'penghasilan' ? '+' : '-' }} Rp {{ number_format($tx->amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada transaksi. <a href="{{ route('transactions.create') }}" class="text-indigo-600 hover:underline">Tambah transaksi pertama Anda</a>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
