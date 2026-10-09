<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-5">
            <h2 class="font-bold text-[30px] leading-[1.2]">
                <span class="text-ember">Riwayat</span>
                <span class="text-graphite">Transaksi</span>
            </h2>
            <a href="{{ route('transactions.create') }}" class="btn-brand inline-flex items-center min-h-[44px]">
                Tambah Transaksi
                <svg class="w-4 h-4 ms-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
            </a>
        </div>
    </x-slot>

    <div class="pb-24 pt-6">
        <div class="max-w-page mx-auto px-4 sm:px-6 lg:px-8 space-y-24">

            @if(session('success'))
                <div class="p-5 bg-fog border border-fog text-graphite rounded-pill text-[16px] font-medium flex items-center gap-3" role="status">
                    <span class="w-8 h-8 rounded-full bg-verdant flex items-center justify-center shrink-0" aria-hidden="true">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg>
                    </span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if($errors->any())
                <div class="p-5 bg-paper border border-signal rounded-pill text-[16px] font-medium text-signal" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            @php
                $pageIncome = $transactions->where('type', 'penghasilan')->sum('amount');
                $pageExpense = $transactions->where('type', '!=', 'penghasilan')->sum('amount');
            @endphp
            <section aria-label="Ringkasan halaman ini" class="bg-fog rounded-pill p-8">
                <p class="text-[14px] font-medium text-graphite/70">Total Halaman Ini</p>
                <p class="text-[30px] font-bold leading-[1.2] text-graphite mt-2">Rp {{ number_format($pageIncome - $pageExpense, 0, ',', '.') }}</p>
                <div class="flex flex-col sm:flex-row gap-5 mt-8">
                    <div class="flex-1 bg-paper rounded-pill p-8 border border-fog">
                        <p class="text-[12px] font-semibold text-graphite/70">Pemasukan</p>
                        <p class="font-bold text-[20px] text-verdant mt-2">{{ number_format($pageIncome, 0, ',', '.') }}</p>
                    </div>
                    <div class="flex-1 bg-paper rounded-pill p-8 border border-fog">
                        <p class="text-[12px] font-semibold text-graphite/70">Pengeluaran</p>
                        <p class="font-bold text-[20px] text-signal mt-2">{{ number_format($pageExpense, 0, ',', '.') }}</p>
                    </div>
                </div>
            </section>

            <section aria-label="Daftar transaksi" class="space-y-5">
                <h3 class="font-bold text-graphite text-[20px]">Riwayat Terbaru</h3>

                <div class="space-y-0">
                    @forelse($transactions as $tx)
                        @php
                            $isIncome = $tx->type === 'penghasilan';
                        @endphp
                        <article class="bg-paper border-b border-fog py-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <span class="w-2.5 h-2.5 rounded-full shrink-0 {{ $isIncome ? 'bg-verdant' : 'bg-signal' }}" aria-hidden="true"></span>
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h4 class="font-medium text-graphite text-[17px] leading-[1.6]">
                                            {{ $tx->category->name ?? 'Tanpa Kategori' }}
                                        </h4>
                                        <span class="tag-pill inline-flex items-center text-[12px] font-semibold bg-fog {{ $isIncome ? 'text-verdant' : 'text-signal' }}">
                                            {{ $tx->type }}
                                        </span>
                                    </div>
                                    <p class="text-[14px] text-graphite/70">{{ $tx->notes ?: 'Tidak ada catatan' }}</p>
                                    <p class="text-[12px] text-graphite/60 mt-1 font-medium">
                                        {{ \Carbon\Carbon::parse($tx->transaction_date)->format('d M Y') }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between sm:justify-end gap-4">
                                <span class="font-bold text-[18px] {{ $isIncome ? 'text-verdant' : 'text-graphite' }}">
                                    {{ $isIncome ? '+' : '-' }}Rp {{ number_format($tx->amount, 0, ',', '.') }}
                                </span>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('transactions.edit', $tx) }}" class="inline-flex items-center justify-center min-w-[44px] min-h-[44px] px-4 bg-paper text-graphite hover:bg-fog rounded-pill border border-fog transition text-[14px] font-semibold" aria-label="Edit transaksi {{ $tx->category->name ?? $tx->id }}">
                                        Edit
                                    </a>
                                    <form action="{{ route('transactions.destroy', $tx) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center min-w-[44px] min-h-[44px] px-4 bg-paper text-signal hover:bg-fog rounded-pill border border-fog transition text-[14px] font-semibold" aria-label="Hapus transaksi {{ $tx->category->name ?? $tx->id }}">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="bg-paper rounded-pill p-12 text-center border border-fog">
                            <div class="w-16 h-16 bg-fog text-graphite/60 rounded-pill flex items-center justify-center mx-auto mb-4 text-[20px] font-bold" aria-hidden="true">N</div>
                            <h4 class="text-[20px] font-bold text-graphite">Belum Ada Transaksi</h4>
                            <p class="text-graphite/70 mt-2 max-w-sm mx-auto text-[16px]">Catat transaksi pengeluaran atau penghasilan pertama Anda untuk mulai memantau arus kas.</p>
                            <a href="{{ route('transactions.create') }}" class="btn-brand inline-flex items-center mt-6 min-h-[44px]">
                                Tambah Transaksi
                                <svg class="w-4 h-4 ms-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
                            </a>
                        </div>
                    @endforelse
                </div>
            </section>

            @if($transactions->hasPages())
                <div class="pt-6">
                    {{ $transactions->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
