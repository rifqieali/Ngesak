<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-bold text-3xl text-slate-800 tracking-tight">
                {{ __('Dashboard Keuangan') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('transactions.create') }}" class="inline-flex items-center px-5 py-2.5 bg-teal-500 rounded-2xl font-semibold text-sm text-white hover:bg-teal-600 hover:scale-[1.02] active:scale-[0.98] transition-all shadow-sm shadow-teal-200">
                    <svg class="w-5 h-5 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Transaksi
                </a>
                <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-slate-200 rounded-2xl font-semibold text-sm text-slate-700 shadow-sm hover:bg-slate-50 hover:scale-[1.02] active:scale-[0.98] transition-all">
                    + Kategori
                </a>
            </div>
        </div>
    </x-slot>

    <div class="pb-12 pt-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Unified "Glance" Section -->
            <div class="bg-gradient-to-br from-teal-500 to-teal-700 rounded-[2rem] p-8 text-white shadow-lg shadow-teal-200/50 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-12 opacity-10 pointer-events-none">
                    <svg class="w-64 h-64 transform rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.11-1.36-3.11-2.92v-.46h2.79v.4c0 .83.98 1.15 1.76 1.15 1.05 0 1.83-.55 1.83-1.42 0-2.31-4.88-1.28-4.88-4.7 0-1.57 1.25-2.71 3.01-3.03V5.16h2.67v1.94c1.78.34 3.03 1.34 3.03 2.92v.46h-2.79v-.4c0-.79-.86-1.15-1.72-1.15-1.07 0-1.76.51-1.76 1.38 0 2.27 4.88 1.18 4.88 4.67 0 1.7-1.35 2.87-3.04 3.11z"/></svg>
                </div>
                
                <div class="relative z-10">
                    <p class="text-teal-100 font-medium tracking-wide text-sm uppercase">Saldo Bersih</p>
                    <h3 class="text-4xl sm:text-5xl font-bold mt-2 tracking-tight">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                    
                    <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 mt-8">
                        <div class="flex-1 bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20">
                            <div class="flex items-center gap-3 mb-1">
                                <div class="w-8 h-8 rounded-full bg-teal-400/20 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-teal-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                                </div>
                                <p class="text-teal-100 text-xs font-medium uppercase tracking-wider">Total Penghasilan</p>
                            </div>
                            <p class="font-bold text-xl ml-11">
                                Rp {{ number_format($totalPenghasilan, 0, ',', '.') }}
                            </p>
                        </div>
                        
                        <div class="flex-1 bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20">
                            <div class="flex items-center gap-3 mb-1">
                                <div class="w-8 h-8 rounded-full bg-rose-400/20 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-rose-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                                </div>
                                <p class="text-teal-100 text-xs font-medium uppercase tracking-wider">Total Pengeluaran</p>
                            </div>
                            <p class="font-bold text-xl ml-11">
                                Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions List -->
            <div class="space-y-4">
                <div class="flex justify-between items-center px-2">
                    <h3 class="font-semibold text-slate-700 text-lg">Transaksi Terbaru</h3>
                    <a href="{{ route('transactions.index') }}" class="text-sm font-semibold text-teal-600 hover:text-teal-700 transition-colors">Lihat Semua &rarr;</a>
                </div>
                
                @forelse($recentTransactions as $tx)
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

                        <!-- Amount -->
                        <div class="flex items-center justify-end sm:flex-col sm:items-end gap-3 sm:gap-2">
                            <span class="font-bold text-lg {{ $isIncome ? 'text-teal-600' : 'text-slate-800' }}">
                                {{ $isIncome ? '+' : '-' }}Rp {{ number_format($tx->amount, 0, ',', '.') }}
                            </span>
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

        </div>
    </div>
</x-app-layout>
