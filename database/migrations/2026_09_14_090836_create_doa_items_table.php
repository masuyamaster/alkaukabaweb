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
        Schema::create('doa_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doa_category_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('arabic');
            $table->text('latin');
            $table->text('translation');
            $table->text('notes')->nullable();
            $table->text('fawaid')->nullable();
            $table->string('source')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doa_items');
    }
};
