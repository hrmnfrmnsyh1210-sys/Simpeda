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
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->timestamp('foto_diambil_pada')->nullable()->after('alamat_koordinat');
            $table->decimal('foto_exif_latitude', 10, 8)->nullable()->after('foto_diambil_pada');
            $table->decimal('foto_exif_longitude', 11, 8)->nullable()->after('foto_exif_latitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->dropColumn(['foto_diambil_pada', 'foto_exif_latitude', 'foto_exif_longitude']);
        });
    }
};
