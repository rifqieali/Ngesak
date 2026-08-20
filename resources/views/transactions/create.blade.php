<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('transactions.index') }}" class="p-2 text-slate-400 hover:text-teal-600 hover:bg-teal-50 rounded-xl transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h2 class="font-bold text-2xl text-slate-800 tracking-tight">
                {{ __('Tambah Transaksi Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 backdrop-blur-xl overflow-hidden shadow-xl shadow-slate-200/40 rounded-3xl border border-slate-100 p-8 sm:p-10 relative">
                <!-- Decorative background elements -->
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-teal-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

                @if($categories->isEmpty())
                    <div class="relative p-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-2xl text-sm font-medium mb-8 flex gap-3 shadow-sm">
                        <svg class="w-5 h-5 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span>Anda belum memiliki Kategori. Silakan <a href="{{ route('categories.create') }}" class="underline font-bold hover:text-amber-900 transition-colors">buat Kategori baru</a> terlebih dahulu sebelum mencatat transaksi.</span>
                    </div>
                @endif

                <form action="{{ route('transactions.store') }}" method="POST" class="space-y-6 relative z-10"
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
                        <label for="transaction_date" class="block text-sm font-semibold text-slate-700">{{ __('Tanggal Transaksi') }}</label>
                        <input id="transaction_date" name="transaction_date" type="date" class="mt-2 block w-full rounded-2xl border-slate-200 text-slate-700 focus:border-teal-500 focus:ring-teal-500/20 shadow-sm transition-colors" value="{{ old('transaction_date', date('Y-m-d')) }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('transaction_date')" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="type" class="block text-sm font-semibold text-slate-700">{{ __('Tipe Transaksi') }}</label>
                            <select id="type" name="type" x-model="type" @change="categoryId = ''" class="mt-2 block w-full rounded-2xl border-slate-200 text-slate-700 focus:border-teal-500 focus:ring-teal-500/20 shadow-sm transition-colors">
                                @foreach($types as $typeOption)
                                    <option value="{{ $typeOption }}">
                                        {{ ucfirst($typeOption) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('type')" />
                        </div>

                        <div>
                            <label for="category_id" class="block text-sm font-semibold text-slate-700">{{ __('Kategori') }}</label>
                            <select id="category_id" name="category_id" x-model="categoryId" class="mt-2 block w-full rounded-2xl border-slate-200 text-slate-700 focus:border-teal-500 focus:ring-teal-500/20 shadow-sm transition-colors" required>
                                <option value="">-- Pilih Kategori --</option>
                                <template x-for="category in filteredCategories" :key="category.id">
                                    <option :value="category.id" x-text="category.name"></option>
                                </template>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                        </div>
                    </div>

                    <div>
                        <label for="amount" class="block text-sm font-semibold text-slate-700">{{ __('Jumlah (Rp)') }}</label>
                        <div class="relative mt-2 rounded-2xl shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <span class="text-slate-400 font-medium sm:text-sm">Rp</span>
                            </div>
                            <input id="amount" name="amount" type="number" step="0.01" min="0.01" class="block w-full rounded-2xl border-slate-200 pl-12 text-slate-700 focus:border-teal-500 focus:ring-teal-500/20 transition-colors" value="{{ old('amount') }}" required placeholder="0.00" />
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-semibold text-slate-700">{{ __('Catatan (Opsional)') }}</label>
                        <textarea id="notes" name="notes" rows="3" class="mt-2 block w-full rounded-2xl border-slate-200 text-slate-700 focus:border-teal-500 focus:ring-teal-500/20 shadow-sm transition-colors resize-none" placeholder="Keterangan tambahan transaksi...">{{ old('notes') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-6 mt-6 border-t border-slate-100">
                        <a href="{{ route('transactions.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-800 transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-teal-500 rounded-2xl font-bold text-white hover:bg-teal-600 hover:scale-[1.02] active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all shadow-lg shadow-teal-200 disabled:opacity-50 disabled:cursor-not-allowed" {{ $categories->isEmpty() ? 'disabled' : '' }}>
                            Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
