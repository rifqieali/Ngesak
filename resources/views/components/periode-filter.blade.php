@props(['years', 'bulan', 'tahun', 'action'])

<form method="GET" action="{{ $action }}" class="bg-fog rounded-pill p-5 flex flex-col sm:flex-row gap-4 sm:items-end">
    <div class="flex-1">
        <label for="tahun" class="block text-[16px] font-semibold text-graphite">Tahun</label>
        <select id="tahun" name="tahun" class="input-pill mt-2 bg-paper">
            <option value="">Semua</option>
            @foreach($years as $year)
                <option value="{{ $year }}" {{ (string) $tahun === (string) $year ? 'selected' : '' }}>
                    {{ $year }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="flex-1">
        <label for="bulan" class="block text-[16px] font-semibold text-graphite">Bulan</label>
        <select id="bulan" name="bulan" class="input-pill mt-2 bg-paper">
            <option value="">Semua</option>
            @foreach(\App\Support\PeriodeFilter::BULAN as $number => $name)
                <option value="{{ $number }}" {{ (int) $bulan === $number ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="flex gap-3">
        <button type="submit" class="btn-brand min-h-[44px]">
            Terapkan
        </button>
        <a href="{{ $action }}" class="inline-flex items-center px-5 py-3 bg-paper border border-fog rounded-pill font-semibold text-[16px] text-graphite hover:bg-fog transition min-h-[44px]">
            Atur Ulang
        </a>
    </div>
</form>
