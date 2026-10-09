<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-5">
            <h2 class="font-bold text-[30px] leading-[1.2] tracking-tight">
                <span class="text-ember">Dashboard</span>
                <span class="text-graphite">Keuangan</span>
            </h2>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('transactions.create') }}" class="btn-brand inline-flex items-center min-h-[44px] pe-[18px]">
                    Tambah Transaksi
                    <svg class="w-4 h-4 ms-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
                </a>
                <a href="{{ route('categories.create') }}" class="inline-flex items-center px-5 py-3 bg-paper border border-fog rounded-pill font-semibold text-[16px] text-graphite hover:bg-fog transition-[color,background-color,border-color,transform] duration-150 ease-out active:scale-[0.96] min-h-[44px]">
                    Tambah Kategori
                </a>
            </div>
        </div>
    </x-slot>

    <div class="pb-24 pt-6">
        <div class="max-w-page mx-auto px-4 sm:px-6 lg:px-8 space-y-24">

            <x-periode-filter :years="$years" :bulan="$bulan" :tahun="$tahun" :action="route('dashboard')" />

            <section aria-labelledby="ringkasan" class="bg-fog rounded-pill p-8">
                <h3 id="ringkasan" class="sr-only">Ringkasan keuangan</h3>
                <p class="text-[14px] font-medium text-graphite/70">Saldo Bersih · {{ $periodeLabel }}</p>
                <p class="text-[30px] font-bold leading-[1.2] text-graphite mt-2 tabular-nums">Rp {{ number_format($saldo, 0, ',', '.') }}</p>

                <div class="flex flex-col sm:flex-row gap-5 mt-8">
                    <div class="flex-1 bg-paper rounded-pill p-8 border border-fog">
                        <p class="text-[12px] font-semibold text-graphite/70">Total Pemasukan</p>
                        <p class="font-bold text-[22px] leading-[1.2] text-verdant mt-2 tabular-nums">
                            Rp {{ number_format($totalPenghasilan, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="flex-1 bg-paper rounded-pill p-8 border border-fog">
                        <p class="text-[12px] font-semibold text-graphite/70">Total Pengeluaran</p>
                        <p class="font-bold text-[22px] leading-[1.2] text-signal mt-2 tabular-nums">
                            Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </section>

            <section aria-labelledby="terbaru" class="space-y-5">
                <div class="flex justify-between items-center">
                    <h3 id="terbaru" class="font-bold text-graphite text-[20px]">Transaksi Terbaru</h3>
                    <a href="{{ route('transactions.index') }}" class="text-[16px] font-semibold text-graphite hover:text-ember transition-colors duration-150 ease-out min-h-[44px] inline-flex items-center">Lihat Semua</a>
                </div>

                @forelse($recentTransactions as $tx)
                    @php
                        $isIncome = $tx->type === 'penghasilan';
                    @endphp
                    <article class="bg-paper border-b border-fog py-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-[background-color] duration-100 ease-out hover:bg-fog">
                        <div class="flex items-center gap-4">
                            <span class="w-2.5 h-2.5 rounded-full shrink-0 {{ $isIncome ? 'bg-verdant' : 'bg-signal' }}" aria-hidden="true"></span>
                            <div>
                                <h4 class="font-medium text-graphite text-[17px] leading-[1.6] flex items-center gap-2 flex-wrap">
                                    {{ $tx->category->name ?? 'Tanpa Kategori' }}
                                    <span class="tag-pill inline-flex items-center text-[12px] font-semibold bg-fog {{ $isIncome ? 'text-verdant' : 'text-signal' }}">
                                        {{ $tx->type }}
                                    </span>
                                    @if($tx->wallet)
                                        <span class="tag-pill inline-flex items-center text-[12px] font-semibold bg-fog text-graphite/70">
                                            {{ $tx->wallet->name }}
                                        </span>
                                    @endif
                                </h4>
                                <p class="text-[14px] text-graphite/70 mt-0.5">{{ $tx->notes ?: 'Tidak ada catatan' }}</p>
                                <p class="text-[12px] text-graphite/60 mt-1 font-medium">{{ \Carbon\Carbon::parse($tx->transaction_date)->format('d M Y') }}</p>
                            </div>
                        </div>

                        <p class="font-bold text-[18px] tabular-nums {{ $isIncome ? 'text-verdant' : 'text-signal' }}">
                            {{ $isIncome ? '+' : '-' }}Rp {{ number_format($tx->amount, 0, ',', '.') }}
                        </p>
                    </article>
                @empty
                    <div class="bg-paper rounded-pill p-8 text-center border border-fog">
                        <div class="w-16 h-16 bg-fog text-graphite/60 rounded-pill flex items-center justify-center mx-auto mb-4 text-[20px] font-bold" aria-hidden="true">
                            N
                        </div>
                        <h4 class="text-[20px] font-bold text-graphite">Belum Ada Transaksi</h4>
                        @if($isFiltered)
                            <p class="text-graphite/70 mt-2 max-w-sm mx-auto text-[16px]">Tidak ada transaksi pada {{ $periodeLabel }}.</p>
                        @else
                            <p class="text-graphite/70 mt-2 max-w-sm mx-auto text-[16px]">Catat transaksi pengeluaran atau penghasilan pertama Anda untuk mulai memantau keuangan.</p>
                        @endif
                        <a href="{{ route('transactions.create') }}" class="btn-brand inline-flex items-center mt-6 min-h-[44px] pe-[18px]">
                            Tambah Transaksi
                            <svg class="w-4 h-4 ms-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
                        </a>
                    </div>
                @endforelse
            </section>

        </div>
    </div>
</x-app-layout>
