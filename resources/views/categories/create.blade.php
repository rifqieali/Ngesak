<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-[30px] leading-[1.2]">
            <span class="text-ember">Tambah</span>
            <span class="text-graphite">Kategori Baru</span>
        </h2>
    </x-slot>

    <div class="py-8 pb-24">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-paper overflow-hidden rounded-pill border border-fog p-8">
                <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Nama Kategori')" />
                        <x-text-input id="name" name="name" type="text" class="input-pill mt-2" :value="old('name')" required autofocus placeholder="Contoh: Makan dan Minum, Tagihan Listrik" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="type" :value="__('Tipe Kategori')" />
                        <select id="type" name="type" class="input-pill mt-2">
                            @foreach($types as $type)
                                <option value="{{ $type }}" {{ old('type') === $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('type')" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Deskripsi (Opsional)')" />
                        <textarea id="description" name="description" rows="2" class="input-pill mt-2 resize-none" placeholder="Contoh: Belanja bahan makanan, makan di luar">{{ old('description') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-6 border-t border-fog">
                        <a href="{{ route('categories.index') }}" class="text-[16px] font-semibold text-graphite/70 hover:text-graphite transition min-h-[44px] inline-flex items-center">
                            Batal
                        </a>
                        <x-primary-button>
                            Simpan Kategori
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
