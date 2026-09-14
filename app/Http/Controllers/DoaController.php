<?php

namespace App\Http\Controllers;

use App\Models\DoaCategory;
use Illuminate\Http\JsonResponse;

class DoaController extends Controller
{
    /**
     * Daftar kategori doa/dzikir beserta jumlah item, diurutkan sesuai
     * prioritas (Dzikir Pagi & Petang di atas).
     */
    public function categories(): JsonResponse
    {
        $categories = DoaCategory::withCount('items')
            ->orderBy('order')
            ->get(['id', 'slug', 'name', 'order']);

        return response()->json(['data' => $categories]);
    }

    /**
     * Daftar item doa/dzikir dalam satu kategori (berdasarkan slug).
     */
    public function items(string $slug): JsonResponse
    {
        $category = DoaCategory::where('slug', $slug)->firstOrFail();

        return response()->json([
            'data' => [
                'category' => ['id' => $category->id, 'slug' => $category->slug, 'name' => $category->name],
                'items' => $category->items,
            ],
        ]);
    }
}
