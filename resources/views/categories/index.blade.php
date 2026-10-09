<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-5">
            <h2 class="font-bold text-[30px] leading-[1.2]">
                <span class="text-ember">Daftar</span>
                <span class="text-graphite">Kategori</span>
            </h2>
            <a href="{{ route('categories.create') }}" class="btn-brand inline-flex items-center min-h-[44px] pe-[18px]">
                Tambah Kategori
                <svg class="w-4 h-4 ms-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
            </a>
        </div>
    </x-slot>

    <div class="pb-24 pt-6">
        <div class="max-w-page mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-5 bg-fog border border-fog text-graphite rounded-pill text-[16px] font-medium flex items-center gap-3" role="status">
                    <span class="w-8 h-8 rounded-full bg-verdant flex items-center justify-center shrink-0" aria-hidden="true">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg>
                    </span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-paper rounded-pill p-8 border border-fog">
                <div class="flex flex-wrap gap-5">
                    @forelse($categories as $category)
                        @php
                            $isIncome = $category->type === 'penghasilan';
                        @endphp
                        <div class="group relative flex items-center gap-3 px-5 py-3 rounded-pill border border-fog bg-paper hover:bg-fog transition min-h-[44px]">
                            <span class="w-2.5 h-2.5 rounded-full shrink-0 {{ $isIncome ? 'bg-verdant' : 'bg-signal' }}" aria-hidden="true"></span>
                            <span class="font-semibold text-[16px] text-graphite">{{ $category->name }}</span>
                            <span class="text-[12px] font-semibold {{ $isIncome ? 'text-verdant' : 'text-signal' }}">{{ $category->type }}</span>

                            <span class="flex items-center gap-1 ms-2">
                                <a href="{{ route('categories.edit', $category) }}" class="inline-flex items-center justify-center min-w-[44px] min-h-[44px] text-graphite/70 hover:text-graphite hover:bg-paper rounded-pill transition text-[14px] font-semibold" aria-label="Edit kategori {{ $category->name }}">
                                    Edit
                                </a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline-block m-0" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center min-w-[44px] min-h-[44px] text-signal/80 hover:text-signal hover:bg-paper rounded-pill transition text-[14px] font-semibold" aria-label="Hapus kategori {{ $category->name }}">
                                        Hapus
                                    </button>
                                </form>
                            </span>
                        </div>
                    @empty
                        <div class="w-full text-center py-12">
                            <div class="w-16 h-16 bg-fog text-graphite/60 rounded-pill flex items-center justify-center mx-auto mb-4 text-[20px] font-bold" aria-hidden="true">N</div>
                            <h4 class="text-[20px] font-bold text-graphite">Belum Ada Kategori</h4>
                            <p class="text-graphite/70 mt-2 max-w-sm mx-auto text-[16px]">Buat kategori pertama Anda untuk mengelompokkan transaksi.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            @if($categories->hasPages())
                <div class="pt-4 flex justify-center">
                    {{ $categories->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
