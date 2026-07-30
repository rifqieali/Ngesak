<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-slate-800 tracking-tight">
                {{ __('Daftar Kategori') }}
            </h2>
            <a href="{{ route('categories.create') }}" class="inline-flex items-center px-5 py-2.5 bg-teal-500 rounded-2xl font-semibold text-sm text-white hover:bg-teal-600 hover:scale-[1.02] active:scale-[0.98] transition-all shadow-sm shadow-teal-200">
                + Tambah Kategori
            </a>
        </div>
    </x-slot>

    <div class="pb-12 pt-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-teal-50 border border-teal-100 text-teal-800 rounded-2xl text-sm font-medium flex items-center gap-3 shadow-sm">
                    <div class="w-8 h-8 rounded-full bg-teal-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Tag/Pill Grid -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-100">
                <div class="flex flex-wrap gap-4">
                    @forelse($categories as $category)
                        @php
                            $isIncome = $category->type === 'penghasilan';
                            $baseColor = $isIncome ? 'bg-teal-50 border-teal-100 text-teal-700' : 'bg-rose-50 border-rose-100 text-rose-700';
                            $iconColor = $isIncome ? 'text-teal-500' : 'text-rose-500';
                        @endphp
                        <div class="group relative flex items-center gap-3 px-5 py-3 rounded-full border {{ $baseColor }} hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 pr-20 cursor-default">
                            <svg class="w-4 h-4 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($isIncome)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"/>
                                @endif
                            </svg>
                            <span class="font-bold tracking-wide">{{ $category->name }}</span>
                            
                            <!-- Hidden Actions -->
                            <div class="absolute right-2 flex items-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('categories.edit', $category) }}" class="p-1.5 text-slate-400 hover:text-teal-600 rounded-full hover:bg-white transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline-block m-0" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-500 rounded-full hover:bg-white transition-colors flex items-center justify-center" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="w-full text-center py-12">
                            <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4 border border-dashed border-slate-200">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-slate-700">Belum Ada Kategori</h4>
                            <p class="text-slate-500 mt-2 max-w-sm mx-auto text-sm">Buat kategori pertama Anda untuk mengelompokkan transaksi.</p>
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
