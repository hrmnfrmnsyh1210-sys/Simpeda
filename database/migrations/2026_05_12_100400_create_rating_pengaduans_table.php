<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rating_pengaduans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaduan_id')->constrained('pengaduans')->cascadeOnDelete();
            $table->string('nama_pelapor', 100);
            $table->unsignedTinyInteger('bintang');
            $table->text('ulasan')->nullable();
            $table->timestamps();

            $table->unique('pengaduan_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rating_pengaduans');
    }
};
