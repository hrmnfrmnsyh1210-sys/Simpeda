<?php

namespace Database\Seeders;

use App\Models\Pengumuman;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PengumumanSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'superadmin')->first();

        $data = [
            [
                'judul' => 'Selamat Datang di SiMPeDa',
                'ringkasan' => 'Sistem Manajemen Pengaduan Desa untuk warga yang lebih responsif.',
                'isi' => 'SiMPeDa memudahkan masyarakat menyampaikan pengaduan terkait pelayanan publik secara online. Sampaikan keluhan Anda kapan saja, di mana saja.',
                'status' => 'Publish',
                'tanggal_terbit' => now()->subDays(7),
            ],
            [
                'judul' => 'Pemeliharaan Sistem 20 Mei 2026',
                'ringkasan' => 'Akan ada pemeliharaan terjadwal pada 20 Mei 2026 pukul 23.00 WIB.',
                'isi' => 'Mohon maaf atas ketidaknyamanan, sistem tidak dapat diakses selama 1 jam saat pemeliharaan berlangsung.',
                'status' => 'Publish',
                'tanggal_terbit' => now()->subDays(2),
            ],
            [
                'judul' => 'Tips Membuat Laporan yang Efektif',
                'ringkasan' => 'Agar laporan Anda cepat ditindaklanjuti, ikuti panduan singkat berikut.',
                'isi' => '1) Jelaskan lokasi secara spesifik. 2) Sertakan foto bila memungkinkan. 3) Pilih kategori yang sesuai. 4) Cantumkan nomor kontak aktif.',
                'status' => 'Draft',
                'tanggal_terbit' => null,
            ],
        ];

        foreach ($data as $row) {
            $row['slug']    = Str::slug($row['judul']);
            $row['user_id'] = $user?->id;
            Pengumuman::updateOrCreate(['slug' => $row['slug']], $row);
        }
    }
}
