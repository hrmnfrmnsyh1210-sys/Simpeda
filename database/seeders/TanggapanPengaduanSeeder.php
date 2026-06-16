<?php

namespace Database\Seeders;

use App\Models\Pengaduan;
use App\Models\TanggapanPengaduan;
use App\Models\User;
use Illuminate\Database\Seeder;

class TanggapanPengaduanSeeder extends Seeder
{
    public function run(): void
    {
        $pengaduans = Pengaduan::limit(3)->get();
        $admin = User::where('role', 'admin')->first() ?? User::first();

        if ($pengaduans->isEmpty() || !$admin) {
            return;
        }

        foreach ($pengaduans as $pengaduan) {
            TanggapanPengaduan::create([
                'pengaduan_id' => $pengaduan->id,
                'user_id'      => $admin->id,
                'pengirim'     => 'Petugas',
                'nama_pengirim' => $admin->name,
                'isi'          => 'Terima kasih atas laporannya. Pengaduan Anda sedang kami tinjau.',
                'is_internal'  => false,
            ]);

            TanggapanPengaduan::create([
                'pengaduan_id' => $pengaduan->id,
                'user_id'      => null,
                'pengirim'     => 'Pelapor',
                'nama_pengirim' => $pengaduan->nama_pelapor,
                'isi'          => 'Mohon segera ditindaklanjuti, kondisi sudah cukup mengganggu.',
                'is_internal'  => false,
            ]);
        }
    }
}
