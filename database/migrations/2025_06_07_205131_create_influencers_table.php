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
        Schema::create('influencers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_alternatif');
            $table->string('platform_alternatif'); // Instagram, TikTok, dll
            $table->string('kategori_alternatif'); // Fashion, Beauty, dll
            $table->decimal('engagement_alternatif', 5, 2)->nullable(); // Contoh: 3.15 (%)
            $table->bigInteger('biaya_alternatif')->nullable(); // Contoh: 500000
            $table->string('relevansi_alternatif')->nullable(); // Contoh: Sangat Baik, Baik, Cukup
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('influencers');
    }
};
