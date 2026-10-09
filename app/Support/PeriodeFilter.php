<?php

namespace App\Support;

use App\Models\Transaction;
use Carbon\Carbon;

class PeriodeFilter
{
    public const BULAN = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    /**
     * Resolve the active period from the request.
     *
     * Returns ['tahun' => ?int, 'bulan' => ?int, 'years' => Collection<int>,
     * 'label' => string, 'isFiltered' => bool].
     * Null tahun means all time. Null bulan means the whole year.
     * Without query params the default is the latest year with data.
     */
    public static function resolve(int $userId): array
    {
        $dates = Transaction::where('user_id', $userId)->pluck('transaction_date');

        $years = $dates
            ->map(fn ($d) => (int) Carbon::parse($d)->format('Y'))
            ->unique()->sortDesc()->values();

        $latest = $dates->sortDesc()->first();
        $latestYear = $latest ? (int) Carbon::parse($latest)->format('Y') : now()->year;

        $rawTahun = request('tahun');
        if ($rawTahun === '') {
            $tahun = null;
        } elseif (is_numeric($rawTahun)) {
            $tahun = (int) $rawTahun;
        } else {
            $tahun = $latestYear;
        }

        $rawBulan = request('bulan');
        $bulan = is_numeric($rawBulan) && $rawBulan >= 1 && $rawBulan <= 12
            ? (int) $rawBulan
            : null;

        if ($tahun && $bulan) {
            $label = self::BULAN[$bulan].' '.$tahun;
        } elseif ($tahun) {
            $label = 'Tahun '.$tahun;
        } else {
            $label = 'Semua periode';
        }

        return [
            'tahun' => $tahun,
            'bulan' => $bulan,
            'years' => $years,
            'label' => $label,
            'isFiltered' => $rawTahun !== null || ($rawBulan !== null && $rawBulan !== ''),
        ];
    }
}
