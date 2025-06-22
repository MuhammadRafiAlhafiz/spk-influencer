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
         Schema::create('hasil_perhitungans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('influencer_id')->constrained('influencers')->onDelete('cascade');
            $table->float('nilai_cc'); // Closeness Coefficient
            $table->integer('ranking')->nullable(); // Bisa otomatis dihitung
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_perhitungans');
    }
};
