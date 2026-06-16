<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Tambahkan role 'masyarakat' serta kolom profil (nomor HP & RT/RW)
     * agar warga bisa mendaftar dan datanya dipakai ulang saat membuat pengaduan.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['superadmin', 'admin', 'masyarakat'])
                ->default('masyarakat')
                ->change();

            $table->string('nomor_hp', 20)->nullable()->after('email');
            $table->string('rt_rw', 10)->nullable()->after('nomor_hp');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nomor_hp', 'rt_rw']);
            $table->enum('role', ['superadmin', 'admin'])
                ->default('admin')
                ->change();
        });
    }
};
