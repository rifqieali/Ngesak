<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('transactions.index') }}" class="inline-flex items-center justify-center w-[44px] h-[44px] text-graphite hover:bg-fog rounded-pill transition" aria-label="Kembali ke riwayat transaksi">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h2 class="font-bold text-[30px] leading-[1.2]">
                <span class="text-ember">Tambah</span>
                <span class="text-graphite">Transaksi Baru</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-8 pb-24">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-paper overflow-hidden rounded-pill border border-fog p-8 sm:p-10">

                @if($categories->isEmpty())
                    <div class="p-5 bg-fog border border-fog text-graphite rounded-pill text-[16px] font-medium mb-8" role="alert">
                        Anda belum memiliki Kategori. Silakan <a href="{{ route('categories.create') }}" class="underline font-bold hover:text-ember">buat Kategori baru</a> terlebih dahulu sebelum mencatat transaksi.
                    </div>
                @endif

                <form action="{{ route('transactions.store') }}" method="POST" class="space-y-6"
                    x-data="{
                        type: '{{ old('type', $types[0] ?? 'penghasilan') }}',
                        categoryId: '{{ old('category_id') }}',
                        categories: {{ json_encode($categories->map->only(['id', 'name', 'type'])->values()) }},
                        get filteredCategories() {
                            return this.categories.filter(c => c.type === this.type);
                        }
                    }">
                    @csrf

                    <div>
                        <label for="transaction_date" class="block text-[16px] font-semibold text-graphite">{{ __('Tanggal Transaksi') }}</label>
                        <input id="transaction_date" name="transaction_date" type="date" class="input-pill mt-2" value="{{ old('transaction_date', date('Y-m-d')) }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('transaction_date')" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="type" class="block text-[16px] font-semibold text-graphite">{{ __('Tipe Transaksi') }}</label>
                            <select id="type" name="type" x-model="type" @change="categoryId = ''" class="input-pill mt-2">
                                @foreach($types as $typeOption)
                                    <option value="{{ $typeOption }}">
                                        {{ ucfirst($typeOption) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('type')" />
                        </div>

                        <div>
                            <label for="category_id" class="block text-[16px] font-semibold text-graphite">{{ __('Kategori') }}</label>
                            <select id="category_id" name="category_id" x-model="categoryId" class="input-pill mt-2" required>
                                <option value="">Pilih Kategori</option>
                                <template x-for="category in filteredCategories" :key="category.id">
                                    <option :value="category.id" x-text="category.name"></option>
                                </template>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                        </div>
                    </div>

                    <div>
                        <label for="wallet_id" class="block text-[16px] font-semibold text-graphite">{{ __('Posisi Kas (Opsional)') }}</label>
                        <select id="wallet_id" name="wallet_id" class="input-pill mt-2">
                            <option value="">Pilih Posisi Kas</option>
                            @foreach($wallets as $wallet)
                                <option value="{{ $wallet->id }}" {{ old('wallet_id') == $wallet->id ? 'selected' : '' }}>
                                    {{ $wallet->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('wallet_id')" />
                    </div>

                    <div>
                        <label for="amount" class="block text-[16px] font-semibold text-graphite">{{ __('Jumlah (Rp)') }}</label>
                        <div class="relative mt-2">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-5">
                                <span class="text-graphite/60 font-medium text-[16px]">Rp</span>
                            </div>
                            <input id="amount" name="amount" type="number" step="0.01" min="0.01" class="input-pill pl-12" value="{{ old('amount') }}" required placeholder="0" />
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                    </div>

                    <div>
                        <label for="notes" class="block text-[16px] font-semibold text-graphite">{{ __('Catatan (Opsional)') }}</label>
                        <textarea id="notes" name="notes" rows="3" class="input-pill mt-2 resize-none" placeholder="Keterangan tambahan transaksi...">{{ old('notes') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-6 mt-6 border-t border-fog">
                        <a href="{{ route('transactions.index') }}" class="text-[16px] font-semibold text-graphite/70 hover:text-graphite transition min-h-[44px] inline-flex items-center">
                            Batal
                        </a>
                        <button type="submit" class="btn-brand min-h-[44px] disabled:opacity-50 disabled:cursor-not-allowed" {{ $categories->isEmpty() ? 'disabled' : '' }}>
                            Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
