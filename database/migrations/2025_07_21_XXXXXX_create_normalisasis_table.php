<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('normalisasis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_responden')->nullable();
            $table->unsignedBigInteger('alternatif_id');
            $table->double('engagement_normalisasi');
            $table->double('biaya_normalisasi');
            $table->double('relevansi_normalisasi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('normalisasis');
    }
};
