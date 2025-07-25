<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('responden', function (Blueprint $table) {
            $table->id();
            $table->string('kode_responden')->unique();
            $table->string('nama_responden');
            $table->string('email_responden');
            $table->string('platform_responden');
            $table->string('kategori_responden');
            $table->integer('followers');
            $table->integer('likes');
            $table->integer('comments');
            $table->integer('biaya_responden');
            $table->enum('relevansi_responden', ['Sangat Baik', 'Baik', 'Cukup', 'Kurang']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('responden');
    }
};
