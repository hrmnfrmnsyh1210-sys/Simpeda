<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_tiket', 20)->unique();
            $table->enum('kategori', [
                'Infrastruktur',
                'Kebersihan',
                'Keamanan',
                'Administrasi',
                'Sosial',
                'Lainnya',
            ]);
            $table->string('nama_pelapor', 100);
            $table->string('nomor_hp', 20);
            $table->string('rt_rw', 10);
            $table->enum('urgensi', ['Rendah', 'Sedang', 'Tinggi']);
            $table->enum('status', ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'])->default('Menunggu');
            $table->text('komentar_petugas')->nullable();
            $table->string('judul', 255);
            $table->text('deskripsi');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};