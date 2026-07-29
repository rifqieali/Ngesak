<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Riwayat Transaksi') }}
            </h2>
            <a href="{{ route('transactions.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Transaksi
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-medium flex items-center gap-2 shadow-sm">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/80 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                                <th class="px-6 py-4 font-semibold">Tanggal</th>
                                <th class="px-6 py-4 font-semibold">Kategori</th>
                                <th class="px-6 py-4 font-semibold">Tipe</th>
                                <th class="px-6 py-4 font-semibold">Catatan</th>
                                <th class="px-6 py-4 font-semibold text-right">Jumlah</th>
                                <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($transactions as $tx)
                                <tr class="hover:bg-gray-50/60 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($tx->transaction_date)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 font-medium whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full {{ $tx->type === 'penghasilan' ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                            {{ $tx->category->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $badgeClasses = match($tx->type) {
                                                'penghasilan' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'pengeluaran' => 'bg-rose-50 text-rose-700 border-rose-200',
                                                'tagihan' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                'hutang' => 'bg-orange-50 text-orange-700 border-orange-200',
                                                'tabungan' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'investasi' => 'bg-purple-50 text-purple-700 border-purple-200',
                                                default => 'bg-gray-50 text-gray-700 border-gray-200',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase border {{ $badgeClasses }}">
                                            {{ $tx->type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 max-w-xs truncate">
                                        {{ $tx->notes ?: '-' }}
                                    </td>
                                    <td class="px-6 py-4 font-bold text-right whitespace-nowrap {{ $tx->type === 'penghasilan' ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $tx->type === 'penghasilan' ? '+' : '-' }} Rp {{ number_format($tx->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                        <a href="{{ route('transactions.edit', $tx) }}" class="inline-flex items-center px-3 py-1 bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200 rounded-lg font-medium text-xs transition-colors">
                                            Edit
                                        </a>
                                        <form action="{{ route('transactions.destroy', $tx) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1 bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 rounded-lg font-medium text-xs transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        <div class="max-w-sm mx-auto space-y-3">
                                            <div class="w-12 h-12 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <p class="font-medium text-gray-700">Belum Ada Transaksi</p>
                                            <p class="text-xs text-gray-500">Catat transaksi pengeluaran atau penghasilan pertama Anda untuk mulai memantau keuangan.</p>
                                            <a href="{{ route('transactions.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-sm">
                                                + Tambah Transaksi
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($transactions->hasPages())
                    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $transactions->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
