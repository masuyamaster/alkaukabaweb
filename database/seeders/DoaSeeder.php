<?php

namespace Database\Seeders;

use App\Models\DoaCategory;
use App\Models\DoaItem;
use Illuminate\Database\Seeder;

class DoaSeeder extends Seeder
{
    /**
     * Kategori diurutkan sesuai prioritas dari catatan Notion fitur ini:
     * Dzikir Pagi & Petang adalah fokus utama, disusul dzikir setelah
     * shalat, lalu doa harian & doa pilihan.
     */
    private const CATEGORIES = [
        ['slug' => 'morning-dhikr', 'name' => 'Dzikir Pagi', 'order' => 1],
        ['slug' => 'evening-dhikr', 'name' => 'Dzikir Petang', 'order' => 2],
        ['slug' => 'dhikr-after-salah', 'name' => 'Dzikir Setelah Shalat', 'order' => 3],
        ['slug' => 'daily-dua', 'name' => 'Doa Harian', 'order' => 4],
        ['slug' => 'selected-dua', 'name' => 'Doa Pilihan', 'order' => 5],
    ];

    /**
     * Sumber data: fixture JSON di ./data/doa-dzikir, diambil dari API publik
     * MIT-licensed fitrahive/dua-dhikr (https://github.com/fitrahive/dua-dhikr,
     * konten Hisnul Muslim berbahasa Indonesia). Disimpan sebagai file lokal
     * (bukan fetch API tiap seed) supaya seeding reproducible & tidak
     * bergantung pada API pihak ketiga yang bisa down/rate-limit.
     */
    public function run(): void
    {
        foreach (self::CATEGORIES as $categoryData) {
            $category = DoaCategory::updateOrCreate(
                ['slug' => $categoryData['slug']],
                ['name' => $categoryData['name'], 'order' => $categoryData['order']],
            );

            $path = __DIR__."/data/doa-dzikir/{$categoryData['slug']}.json";
            $items = json_decode(file_get_contents($path), true);

            foreach ($items as $index => $item) {
                DoaItem::updateOrCreate(
                    ['doa_category_id' => $category->id, 'title' => $item['title']],
                    [
                        'arabic' => $item['arabic'],
                        'latin' => $item['latin'],
                        'translation' => $item['translation'],
                        'notes' => $item['notes'] ?? null,
                        'fawaid' => $item['fawaid'] ?? null,
                        'source' => $item['source'] ?? null,
                        'order' => $index + 1,
                    ],
                );
            }
        }
    }
}
