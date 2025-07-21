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
            $table->id(); // primary key auto increment
            $table->string('kode_kriteria')->unique(); // satu kali saja, dibuat unique
            $table->string('nama_kriteria');  // Contoh: Engagement Rate
            $table->decimal('bobot_kriteria', 8, 2); // tipe numeric agar mudah hitung fuzzy
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriterias');
    }
};
