<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Tambah Transaksi Baru') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6">

                @if($categories->isEmpty())
                    <div class="p-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl text-sm font-medium mb-6">
                        Anda belum memiliki Kategori. Silakan <a href="{{ route('categories.create') }}" class="underline font-bold">buat Kategori baru</a> terlebih dahulu sebelum mencatat transaksi.
                    </div>
                @endif

                <form action="{{ route('transactions.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="transaction_date" :value="__('Tanggal Transaksi')" />
                        <x-text-input id="transaction_date" name="transaction_date" type="date" class="mt-1 block w-full" :value="old('transaction_date', date('Y-m-d'))" required />
                        <x-input-error class="mt-2" :messages="$errors->get('transaction_date')" />
                    </div>

                    <div>
                        <x-input-label for="type" :value="__('Tipe Transaksi')" />
                        <select id="type" name="type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            @foreach($types as $type)
                                <option value="{{ $type }}" {{ old('type') === $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('type')" />
                    </div>

                    <div>
                        <x-input-label for="category_id" :value="__('Kategori')" />
                        <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }} ({{ ucfirst($category->type) }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                    </div>

                    <div>
                        <x-input-label for="amount" :value="__('Jumlah (Rp)')" />
                        <x-text-input id="amount" name="amount" type="number" step="0.01" min="0.01" class="mt-1 block w-full" :value="old('amount')" required placeholder="0.00" />
                        <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                    </div>

                    <div>
                        <x-input-label for="notes" :value="__('Catatan (Opsional)')" />
                        <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Keterangan tambahan transaksi...">{{ old('notes') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('transactions.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                            Batal
                        </a>
                        <x-primary-button :disabled="$categories->isEmpty()">
                            Simpan Transaksi
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
