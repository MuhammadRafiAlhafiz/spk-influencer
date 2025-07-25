<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('influencers', function (Blueprint $table) {
            $table->id();
            $table->string('kode_responden')->nullable();
            $table->string('nama_alternatif');
            $table->string('platform_alternatif');
            $table->string('kategori_alternatif');
            $table->integer('followers');
            $table->integer('likes');
            $table->integer('comments');
            $table->integer('biaya_alternatif');
            $table->string('relevansi_alternatif');
            $table->double('engagement_alternatif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('influencers');
    }
};
