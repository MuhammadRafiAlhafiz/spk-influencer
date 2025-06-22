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
        Schema::create('kriterias', function (Blueprint $table) {
            $table->id();
            $table->string('nama');              // Contoh: Engagement Rate
            $table->enum('jenis', ['benefit', 'cost']);
            $table->float('bobot_l');            // lower
            $table->float('bobot_m');            // middle
            $table->float('bobot_u');            // upper
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('krtiterias');
    }
};
