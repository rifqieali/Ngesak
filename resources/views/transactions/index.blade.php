<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-bold text-3xl text-slate-800 tracking-tight">
                {{ __('Riwayat Transaksi') }}
            </h2>
            <a href="{{ route('transactions.create') }}" class="inline-flex items-center px-5 py-2.5 bg-teal-500 rounded-2xl font-semibold text-sm text-white hover:bg-teal-600 hover:scale-[1.02] active:scale-[0.98] transition-all shadow-sm shadow-teal-200">
                <svg class="w-5 h-5 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Transaksi
            </a>
        </div>
    </x-slot>

    <div class="pb-12 pt-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="p-4 bg-teal-50 border border-teal-100 text-teal-800 rounded-2xl text-sm font-medium flex items-center gap-3 shadow-sm">
                    <div class="w-8 h-8 rounded-full bg-teal-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Hero Card: Wallet Summary -->
            @php
                $pageIncome = $transactions->where('type', 'penghasilan')->sum('amount');
                $pageExpense = $transactions->where('type', '!=', 'penghasilan')->sum('amount');
            @endphp
            <div class="bg-gradient-to-br from-teal-500 to-teal-700 rounded-[2rem] p-8 text-white shadow-lg shadow-teal-200/50 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-12 opacity-10 pointer-events-none">
                    <svg class="w-64 h-64 transform rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.11-1.36-3.11-2.92v-.46h2.79v.4c0 .83.98 1.15 1.76 1.15 1.05 0 1.83-.55 1.83-1.42 0-2.31-4.88-1.28-4.88-4.7 0-1.57 1.25-2.71 3.01-3.03V5.16h2.67v1.94c1.78.34 3.03 1.34 3.03 2.92v.46h-2.79v-.4c0-.79-.86-1.15-1.72-1.15-1.07 0-1.76.51-1.76 1.38 0 2.27 4.88 1.18 4.88 4.67 0 1.7-1.35 2.87-3.04 3.11z"/></svg>
                </div>
                <div class="relative z-10">
                    <p class="text-teal-100 font-medium tracking-wide text-sm uppercase">Total Halaman Ini</p>
                    <h3 class="text-4xl sm:text-5xl font-bold mt-2 tracking-tight">Rp {{ number_format($pageIncome - $pageExpense, 0, ',', '.') }}</h3>
                    
                    <div class="flex items-center gap-6 mt-8">
                        <div>
                            <p class="text-teal-100 text-xs font-medium uppercase tracking-wider mb-1">Pemasukan</p>
                            <p class="font-semibold text-lg flex items-center gap-1">
                                <svg class="w-4 h-4 text-teal-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                                Rp {{ number_format($pageIncome, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="w-px h-10 bg-teal-400/50"></div>
                        <div>
                            <p class="text-teal-100 text-xs font-medium uppercase tracking-wider mb-1">Pengeluaran</p>
                            <p class="font-semibold text-lg flex items-center gap-1">
                                <svg class="w-4 h-4 text-teal-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                                Rp {{ number_format($pageExpense, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction List -->
            <div class="space-y-4">
                <h3 class="font-semibold text-slate-700 text-lg px-2">Riwayat Terbaru</h3>
                
                @forelse($transactions as $tx)
                    <div class="bg-white rounded-[1.25rem] p-4 sm:p-5 shadow-sm border border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:shadow-md hover:border-slate-200 hover:-translate-y-0.5 transition-all duration-200 group">
                        
                        <div class="flex items-center gap-4">
                            <!-- Icon -->
                            @php
                                $isIncome = $tx->type === 'penghasilan';
                                $iconBg = $isIncome ? 'bg-teal-50 text-teal-600' : 'bg-rose-50 text-rose-500';
                            @endphp
                            <div class="w-12 h-12 rounded-[1rem] flex items-center justify-center shrink-0 {{ $iconBg }}">
                                @if($isIncome)
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                @else
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                @endif
                            </div>
                            
                            <!-- Details -->
                            <div>
                                <h4 class="font-bold text-slate-800 text-base flex items-center gap-2">
                                    {{ $tx->category->name ?? 'Tanpa Kategori' }}
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $isIncome ? 'bg-teal-50 text-teal-600' : 'bg-slate-100 text-slate-500' }}">
                                        {{ $tx->type }}
                                    </span>
                                </h4>
                                <p class="text-sm text-slate-500 mt-0.5 line-clamp-1 max-w-[200px] sm:max-w-xs">{{ $tx->notes ?: 'Tidak ada catatan' }}</p>
                                <p class="text-xs text-slate-400 mt-1 font-medium">{{ \Carbon\Carbon::parse($tx->transaction_date)->format('d M Y') }}</p>
                            </div>
                        </div>

                        <!-- Amount and Actions -->
                        <div class="flex items-center justify-between sm:flex-col sm:items-end gap-3 sm:gap-2">
                            <span class="font-bold text-lg {{ $isIncome ? 'text-teal-600' : 'text-slate-800' }}">
                                {{ $isIncome ? '+' : '-' }}Rp {{ number_format($tx->amount, 0, ',', '.') }}
                            </span>
                            
                            <!-- Actions reveal on hover -->
                            <div class="flex items-center gap-1.5 sm:opacity-0 sm:-translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-200">
                                <a href="{{ route('transactions.edit', $tx) }}" class="p-2 text-slate-400 hover:text-teal-600 hover:bg-teal-50 rounded-xl transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </a>
                                <form action="{{ route('transactions.destroy', $tx) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-xl transition-colors" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="bg-white rounded-3xl p-12 text-center border border-slate-100 border-dashed shadow-sm">
                        <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-bold text-slate-700">Belum Ada Transaksi</h4>
                        <p class="text-slate-500 mt-2 max-w-sm mx-auto text-sm">Catat transaksi pengeluaran atau penghasilan pertama Anda untuk mulai memantau keuangan.</p>
                        <a href="{{ route('transactions.create') }}" class="inline-flex items-center px-5 py-2.5 mt-6 bg-teal-50 text-teal-700 rounded-2xl font-semibold text-sm hover:bg-teal-100 transition-colors">
                            + Tambah Transaksi
                        </a>
                    </div>
                @endforelse
            </div>

            @if($transactions->hasPages())
                <div class="pt-4 flex justify-center">
                    {{ $transactions->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
