<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-[30px] leading-[1.2]">
            <span class="text-ember">Edit</span>
            <span class="text-graphite">Kategori</span>
        </h2>
    </x-slot>

    <div class="py-8 pb-24">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-paper overflow-hidden rounded-pill border border-fog p-8">
                <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" :value="__('Nama Kategori')" />
                        <x-text-input id="name" name="name" type="text" class="input-pill mt-2" :value="old('name', $category->name)" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="type" :value="__('Tipe Kategori')" />
                        <select id="type" name="type" class="input-pill mt-2">
                            @foreach($types as $type)
                                <option value="{{ $type }}" {{ old('type', $category->type) === $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('type')" />
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-6 border-t border-fog">
                        <a href="{{ route('categories.index') }}" class="text-[16px] font-semibold text-graphite/70 hover:text-graphite transition min-h-[44px] inline-flex items-center">
                            Batal
                        </a>
                        <x-primary-button>
                            Perbarui Kategori
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
