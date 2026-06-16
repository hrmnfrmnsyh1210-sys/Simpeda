<?php

namespace Database\Seeders;

use App\Models\Pengaduan;
use App\Models\RatingPengaduan;
use Illuminate\Database\Seeder;

class RatingPengaduanSeeder extends Seeder
{
    public function run(): void
    {
        $pengaduans = Pengaduan::where('status', 'Selesai')->limit(5)->get();

        if ($pengaduans->isEmpty()) {
            $pengaduans = Pengaduan::latest()->limit(3)->get();
        }

        if ($pengaduans->isEmpty()) {
            return;
        }

        $ulasan = [
            'Pelayanan cepat dan tanggap. Terima kasih!',
            'Cukup memuaskan, semoga terus ditingkatkan.',
            'Lumayan, tapi waktu penanganan agak lama.',
            'Sangat membantu, masalah saya selesai dengan baik.',
            'Petugas ramah dan profesional.',
        ];

        foreach ($pengaduans as $i => $pengaduan) {
            RatingPengaduan::updateOrCreate(
                ['pengaduan_id' => $pengaduan->id],
                [
                    'nama_pelapor' => $pengaduan->nama_pelapor,
                    'bintang'      => rand(3, 5),
                    'ulasan'       => $ulasan[$i % count($ulasan)],
                ]
            );
        }
    }
}
