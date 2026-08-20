<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-bold text-3xl text-slate-800 tracking-tight">
                {{ __('Riwayat Transaksi') }}
            </h2>
            <a href="{{ route('transactions.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 rounded-2xl font-bold text-sm text-white hover:from-teal-400 hover:to-teal-500 hover:scale-[1.02] active:scale-[0.98] transition-all shadow-lg shadow-teal-200 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Transaksi
            </a>
        </div>
    </x-slot>

    <div class="pb-12 pt-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="p-4 bg-teal-50/80 backdrop-blur-sm border border-teal-100 text-teal-800 rounded-2xl text-sm font-semibold flex items-center gap-3 shadow-sm" x-data="{ show: true }" x-show="show" x-transition.opacity.duration.500ms>
                    <div class="w-8 h-8 rounded-full bg-teal-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span>{{ session('success') }}</span>
                    <button @click="show = false" class="ml-auto text-teal-400 hover:text-teal-600 p-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif

            <!-- Hero Card: Wallet Summary -->
            @php
                $pageIncome = $transactions->where('type', 'penghasilan')->sum('amount');
                $pageExpense = $transactions->where('type', '!=', 'penghasilan')->sum('amount');
            @endphp
            <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 rounded-[2.5rem] p-8 sm:p-10 text-white shadow-2xl shadow-slate-900/20 relative overflow-hidden group">
                <!-- Decorative Glows -->
                <div class="absolute top-0 right-0 w-[30rem] h-[30rem] bg-teal-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 group-hover:bg-teal-500/20 transition-colors duration-700 pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-[20rem] h-[20rem] bg-rose-500/10 rounded-full blur-3xl translate-y-1/3 -translate-x-1/3 pointer-events-none"></div>
                
                <div class="absolute top-0 right-0 p-12 opacity-5 pointer-events-none mix-blend-overlay">
                    <svg class="w-64 h-64 transform rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.11-1.36-3.11-2.92v-.46h2.79v.4c0 .83.98 1.15 1.76 1.15 1.05 0 1.83-.55 1.83-1.42 0-2.31-4.88-1.28-4.88-4.7 0-1.57 1.25-2.71 3.01-3.03V5.16h2.67v1.94c1.78.34 3.03 1.34 3.03 2.92v.46h-2.79v-.4c0-.79-.86-1.15-1.72-1.15-1.07 0-1.76.51-1.76 1.38 0 2.27 4.88 1.18 4.88 4.67 0 1.7-1.35 2.87-3.04 3.11z"/></svg>
                </div>

                <div class="relative z-10">
                    <p class="text-slate-400 font-bold tracking-widest text-xs uppercase mb-3">Total Halaman Ini</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl text-slate-300 font-medium">Rp</span>
                        <h3 class="text-5xl sm:text-6xl font-black tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-300">{{ number_format($pageIncome - $pageExpense, 0, ',', '.') }}</h3>
                    </div>
                    
                    <div class="flex items-center gap-8 mt-10">
                        <div class="bg-white/5 backdrop-blur-md rounded-2xl p-4 border border-white/10 flex-1">
                            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mb-1.5">Pemasukan</p>
                            <p class="font-bold text-xl text-teal-400 flex items-center gap-1.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                                {{ number_format($pageIncome, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="bg-white/5 backdrop-blur-md rounded-2xl p-4 border border-white/10 flex-1">
                            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mb-1.5">Pengeluaran</p>
                            <p class="font-bold text-xl text-rose-400 flex items-center gap-1.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                                {{ number_format($pageExpense, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction List -->
            <div class="space-y-5">
                <div class="flex items-center justify-between px-2">
                    <h3 class="font-bold text-slate-800 text-xl tracking-tight">Riwayat Terbaru</h3>
                </div>
                
                <div class="space-y-3">
                    @forelse($transactions as $tx)
                        @php
                            $isIncome = $tx->type === 'penghasilan';
                        @endphp
                        <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:shadow-lg hover:shadow-slate-200/50 hover:-translate-y-1 transition-all duration-300 group cursor-pointer relative overflow-hidden">
                            
                            <!-- Subtle Background Accent on Hover -->
                            <div class="absolute inset-0 bg-gradient-to-r {{ $isIncome ? 'from-teal-50' : 'from-rose-50' }} to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>

                            <div class="flex items-center gap-5 relative z-10">
                                <!-- Icon -->
                                <div class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0 {{ $isIncome ? 'bg-teal-100 text-teal-600' : 'bg-rose-100 text-rose-500' }} shadow-sm">
                                    @if($isIncome)
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    @else
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                    @endif
                                </div>
                                
                                <!-- Details -->
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h4 class="font-bold text-slate-800 text-lg leading-tight">
                                            {{ $tx->category->name ?? 'Tanpa Kategori' }}
                                        </h4>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-bold uppercase tracking-wider {{ $isIncome ? 'bg-teal-50 text-teal-600 ring-1 ring-teal-500/20' : 'bg-rose-50 text-rose-600 ring-1 ring-rose-500/20' }}">
                                            {{ $tx->type }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-slate-500 line-clamp-1 max-w-[200px] sm:max-w-sm">{{ $tx->notes ?: 'Tidak ada catatan' }}</p>
                                    <p class="text-xs text-slate-400 mt-1.5 font-medium flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        {{ \Carbon\Carbon::parse($tx->transaction_date)->format('d M Y') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Amount and Actions -->
                            <div class="flex items-center justify-between sm:flex-col sm:items-end gap-3 sm:gap-2 relative z-10">
                                <span class="font-black text-xl tracking-tight {{ $isIncome ? 'text-teal-600' : 'text-slate-800' }}">
                                    {{ $isIncome ? '+' : '-' }}Rp {{ number_format($tx->amount, 0, ',', '.') }}
                                </span>
                                
                                <!-- Actions -->
                                <div class="flex items-center gap-2 sm:opacity-0 sm:translate-x-4 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300 ease-out">
                                    <a href="{{ route('transactions.edit', $tx) }}" class="p-2.5 bg-white text-slate-400 hover:text-teal-600 hover:bg-teal-50 hover:shadow-sm rounded-xl border border-slate-100 transition-all" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </a>
                                    <form action="{{ route('transactions.destroy', $tx) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2.5 bg-white text-slate-400 hover:text-rose-600 hover:bg-rose-50 hover:shadow-sm rounded-xl border border-slate-100 transition-all" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-[2.5rem] p-12 text-center border border-slate-100 shadow-sm relative overflow-hidden">
                            <div class="absolute inset-0 bg-slate-50/50"></div>
                            <div class="relative z-10">
                                <div class="w-20 h-20 bg-white shadow-sm text-slate-300 rounded-full flex items-center justify-center mx-auto mb-5">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 14l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h4 class="text-xl font-bold text-slate-800 tracking-tight">Belum Ada Transaksi</h4>
                                <p class="text-slate-500 mt-2 max-w-sm mx-auto text-sm leading-relaxed">Catat transaksi pengeluaran atau penghasilan pertama Anda untuk mulai memantau arus kas.</p>
                                <a href="{{ route('transactions.create') }}" class="inline-flex items-center px-6 py-3 mt-8 bg-teal-50 text-teal-700 rounded-2xl font-bold text-sm hover:bg-teal-100 hover:scale-[1.02] active:scale-[0.98] transition-all">
                                    <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Tambah Transaksi
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            @if($transactions->hasPages())
                <div class="pt-6">
                    {{ $transactions->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
