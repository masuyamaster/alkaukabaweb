<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('daily_quote_refs', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['ayat', 'hadits']);
            // Untuk type=ayat: "surah:ayah" (mis. "2:286"). Untuk type=hadits: nomor hadits Arbain Nawawi (1-42).
            $table->string('ref');
            $table->unsignedInteger('order')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_quote_refs');
    }
};
