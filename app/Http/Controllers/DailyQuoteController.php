<?php

namespace App\Http\Controllers;

use App\Models\DailyQuoteRef;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DailyQuoteController extends Controller
{
    /**
     * Fallback statis kalau belum ada data di daily_quote_refs, atau API
     * eksternal (equran.id / api.myquran.com) sedang gagal diakses — supaya
     * fitur tidak pernah error total di app.
     */
    private const FALLBACK = [
        'type' => 'ayat',
        'arabic' => 'فَإِنَّ مَعَ الْعُسْرِ يُسْرًا',
        'latin' => 'Fa inna ma\'al-\'usri yusra',
        'translation' => 'Maka sesungguhnya bersama kesulitan ada kemudahan.',
        'source' => 'QS. Al-Insyirah: 5',
    ];

    /**
     * Ayat/hadits harian, berganti tiap hari berdasarkan hari-dalam-tahun
     * (day-of-year) supaya semua user melihat kutipan yang sama di hari
     * yang sama dan tetap konsisten walau app dibuka berkali-kali.
     */
    public function today(): JsonResponse
    {
        $today = now()->toDateString();

        $quote = Cache::remember("daily-quote:{$today}", now()->endOfDay(), function () {
            return $this->resolveTodayQuote();
        });

        return response()->json(['data' => $quote]);
    }

    private function resolveTodayQuote(): array
    {
        $refs = DailyQuoteRef::orderBy('order')->get(['type', 'ref']);

        if ($refs->isEmpty()) {
            return self::FALLBACK;
        }

        $index = (now()->dayOfYear - 1) % $refs->count();
        $ref = $refs[$index];

        $resolved = $ref->type === 'hadits'
            ? $this->resolveHadits($ref->ref)
            : $this->resolveAyat($ref->ref);

        return $resolved ?? self::FALLBACK;
    }

    private function resolveAyat(string $ref): ?array
    {
        [$surah, $ayah] = array_pad(explode(':', $ref, 2), 2, null);

        if (! $surah || ! $ayah) {
            Log::warning('DailyQuote: ref ayat tidak valid', ['ref' => $ref]);

            return null;
        }

        try {
            $response = Http::timeout(5)->get("https://equran.id/api/v2/surat/{$surah}");

            if (! $response->successful()) {
                Log::warning('DailyQuote: equran.id gagal', ['ref' => $ref, 'status' => $response->status()]);

                return null;
            }

            $data = $response->json('data');
            $ayat = collect($data['ayat'] ?? [])->firstWhere('nomorAyat', (int) $ayah);

            if (! $ayat) {
                Log::warning('DailyQuote: ayat tidak ditemukan di response equran.id', ['ref' => $ref]);

                return null;
            }

            return [
                'type' => 'ayat',
                'arabic' => $ayat['teksArab'],
                'latin' => $ayat['teksLatin'],
                'translation' => $ayat['teksIndonesia'],
                'source' => "QS. {$data['namaLatin']}: {$ayah}",
            ];
        } catch (\Throwable $e) {
            Log::error('DailyQuote: exception saat fetch equran.id', ['ref' => $ref, 'message' => $e->getMessage()]);

            return null;
        }
    }

    private function resolveHadits(string $ref): ?array
    {
        try {
            $response = Http::timeout(5)->get("https://api.myquran.com/v2/hadits/arbain/{$ref}");

            if (! $response->successful() || ! $response->json('status')) {
                Log::warning('DailyQuote: api.myquran.com gagal', ['ref' => $ref, 'status' => $response->status()]);

                return null;
            }

            $data = $response->json('data');

            return [
                'type' => 'hadits',
                'arabic' => $data['arab'],
                'latin' => null,
                'translation' => $data['indo'],
                'source' => "HR. (Arbain Nawawi No. {$ref}) — {$data['judul']}",
            ];
        } catch (\Throwable $e) {
            Log::error('DailyQuote: exception saat fetch api.myquran.com', ['ref' => $ref, 'message' => $e->getMessage()]);

            return null;
        }
    }
}
