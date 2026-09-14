<?php

namespace Database\Seeders;

use App\Models\DailyQuoteRef;
use Illuminate\Database\Seeder;

class DailyQuoteRefSeeder extends Seeder
{
    /**
     * Kurasi ~30 ayat pendek/inspiratif (format "surah:ayah", divalidasi
     * lewat equran.id). Bisa ditambah/diedit langsung di tabel
     * daily_quote_refs tanpa perlu deploy ulang kode.
     */
    private const AYAT_REFS = [
        '94:5', '94:6', '94:8',
        '2:286', '2:153', '2:216', '2:155', '2:45', '2:186', '2:277',
        '3:139', '3:159', '3:200',
        '13:28',
        '65:3',
        '39:53',
        '9:40',
        '29:2',
        '49:13', '49:12',
        '17:23', '17:32',
        '31:14',
        '4:36',
        '16:97',
        '20:114',
        '5:2',
        '21:35',
        '41:33',
        '24:55',
    ];

    /**
     * Hadits Arbain Nawawi no. 1-42 (via api.myquran.com), koleksi hadits
     * pendek yang sudah baku dipakai luas untuk konten harian.
     */
    private const HADITS_COUNT = 42;

    public function run(): void
    {
        $order = 1;
        $ayatRefs = self::AYAT_REFS;
        $haditsRefs = range(1, self::HADITS_COUNT);

        // Selang-seling ayat/hadits supaya variasi jenis konten tiap hari,
        // lanjut habiskan sisa list yang lebih panjang (hadits, 42 item).
        while ($ayatRefs || $haditsRefs) {
            if ($ayatRefs) {
                DailyQuoteRef::create([
                    'type' => 'ayat',
                    'ref' => array_shift($ayatRefs),
                    'order' => $order++,
                ]);
            }

            if ($haditsRefs) {
                DailyQuoteRef::create([
                    'type' => 'hadits',
                    'ref' => (string) array_shift($haditsRefs),
                    'order' => $order++,
                ]);
            }
        }
    }
}
